<?php

namespace App\Http\Controllers\Auth;

use App\Events\UserRegistered;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController
{
    public function index()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'email' => ['required', 'string', 'email', 'max:255']
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            return back()->with('emailExist', 'Пользователь с таким почтовым адрессом уже зарегистрирован');
        }

        $user = User::create($validated);

        Auth::login($user);
        $request->session()->regenerate();

        UserRegistered::dispatch($user);
        return back();
    }
}
