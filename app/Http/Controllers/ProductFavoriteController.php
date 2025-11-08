<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductFavoriteController
{
    public function index()
    {
        $favorites = User::find(Auth::id())->favoriteProducts;
        return view('favorite', [
            'favorites' => $favorites
        ]);
    }
    public function store(Product $product)
    {
        $userId = Auth::id();

        DB::table('product_favorite')->insert([
            'user_id' => $userId,
            'product_id' => $product->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back();
    }
}
