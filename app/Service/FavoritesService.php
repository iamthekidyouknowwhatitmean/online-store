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

    public function migrate()
    {
        $favorites = session()->get('favorites', []);
        foreach ($favorites as $key => $product) {
            DB::table('product_favorite')->insert([
                'user_id' => Auth::id(),
                'product_id' => $key,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        session()->forget('favorites');
    }

    private function getGuestFavorites()
    {
        $favorites = session()->get('favorites', []);
        $products = [];
        foreach ($favorites as $key => $favorite) {
            $products[] = Product::find($key);
        }
        return $products;
    }
    private function getUserFavorites()
    {
        $favorites = DB::table('product_favorite')->get()->all();
        $products = [];
        foreach ($favorites as $favorite) {
            $products[] = Product::find($favorite->product_id);
        }
        return $products;
    }

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
