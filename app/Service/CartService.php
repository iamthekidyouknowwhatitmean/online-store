<?php

namespace App\Service;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartService
{

    public function getCart()
    {
        if (Auth::check()) {
            return $this->getUserCart();
        }
        return $this->getGuestCart();
    }
    public function addToGuestCart(Product $product)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity']++;
        } else {
            $cart[$product->id] = [
                "title" => $product->title,
                "quantity" => 1,
                "price" => $product->price,
                'discount_percentage' => $product->discount_percentage
            ];
        }
        $cart = session()->put('cart', $cart);
    }

    public function addToUserCart()
    {
        $cart = session()->get('cart', []);
        if (!empty($cart)) {
            foreach ($cart as $key => $product) {
                Cart::create([
                    'product_id' => $key,
                    'quantity' => $product['quantity']
                ]);
            }
            session()->forget('cart');
        }
    }

    private function getUserCart() {
        return Auth::user()->cartProducts()
    }

    private function getGuestCart()
    {
        return session()->get('cart', []);
    }
}
