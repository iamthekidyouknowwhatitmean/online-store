<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Service\FavoritesService;

class ProductFavoriteController
{
    public function __construct(private FavoritesService $favoritesService) {}
    public function index()
    {
        // $favorites = User::find(Auth::id())->favoriteProducts;
        $favorites = $this->favoritesService->getFavorites();
        // dd($favorites);
        return view('favorite', [
            'favorites' => $favorites
        ]);
    }
    public function store(Product $product)
    {
        $this->favoritesService->storeFavorites($product);

        return back();
    }
    public function remove(Product $product)
    {
        $this->favoritesService->removeGuestFavorites($product);
    }
}
