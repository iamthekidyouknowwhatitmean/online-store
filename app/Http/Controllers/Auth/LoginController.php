<?php

namespace App\Http\Controllers\Auth;

use App\Service\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController
{
    public function index()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request, CartService $cartService)
    {
        $credentials = $request->validate([
            'password' => ['required'],
            'email' => ['required', 'string', 'email', 'max:255']
        ]);


        if (Auth::attempt($credentials)) {
            $cartService->migrateGuestCartToUser();
            $request->session()->regenerate();

            return redirect('/');
        }

        return back()->with('msg', 'Упс! У вас некоректные данные');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
