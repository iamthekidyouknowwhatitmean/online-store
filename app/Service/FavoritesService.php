<?php

namespace App\Service;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FavoritesService
{
    public function getFavorites()
    {
        if (Auth::check()) {
            return $this->getUserFavorites();
        }
        return $this->getGuestFavorites();
    }

    public function storeFavorites(Product $product)
    {
        if (Auth::check()) {
            return $this->storeUserFavorites($product);
        }
        return $this->storeGuestFavorites($product);
    }

    private function getGuestFavorites()
    {
        return session()->get('favorites', []);
    }
    private function getUserFavorites() {}

    private function storeGuestFavorites(Product $product)
    {
        $favorites = session('favorites', []);

        $favorites[$product->id] = null;

        $favorites = session(['favorites' => $favorites]);
    }
    private function storeUserFavorites(Product $product)
    {

        DB::table('product_favorite')->insert([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function removeGuestFavorites(Product $product)
    {
        $favorites = session('favorites', []);
        if (isset($favorites[$product->id])) {
            unset($favorites[$product->id]);
            session()->put('favorites', $favorites);
        }

        if (empty($favorites)) {
            session()->forget('favorites');
        } else {
            session()->put('favorites', $favorites);
        }
    }
}
