<?php

namespace App\Service;

use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
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

    public function removeFromCart(Product $product)
    {
        if (Auth::check()) {
            return $this->removeFromUserCart($product);
        }
        return $this->removeFromGuestCart($product);
    }

    public function addToCart(Product $product)
    {
        if (Auth::check()) {
            return $this->addToUserCart($product);
        }
        return $this->addToGuestCart($product);
    }

    public function migrateGuestCartToUser()
    {
        $cart = session()->get('cart', []);
        if (!empty($cart)) {
            foreach ($cart as $key => $product) {
                Cart::create([
                    'user_id' => Auth::user()->id,
                    'product_id' => $key,
                    'quantity' => $product['quantity']
                ]);
            }
            session()->forget('cart');
        }
    }

    public function getTotal()
    {
        $cart = $this->getCart();
        $total = 0;

        if (Auth::check()) {
            // Для авторизованного пользователя
            foreach ($cart as $cartItem) {
                $total += $cartItem->product->price * $cartItem->quantity;
            }
        } else {
            // Для гостя (сессия)
            foreach ($cart as $cartItem) {
                $total += $cartItem['price'] * $cartItem['quantity'];
            }
        }

        return $total;
    }

    private function removeFromUserCart(Product $product)
    {
        Cart::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->delete();
    }

    private function removeFromGuestCart(Product $product)
    {
        $cart = session()->get('cart');

        if (isset($cart[$product->id])) {
            unset($cart[$product->id]);
            session()->put('cart', $cart);
        }
        // if ($cart[$product['id']]['quantity'] > 1) {
        //     $cart[$product['id']]['quantity']--;
        // } else {
        //     unset($cart[$product['id']]);
        // }
        if (empty($cart)) {
            session()->forget('cart');
        } else {
            session()->put('cart', $cart);
        }
    }

    private function addToGuestCart(Product $product)
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

    private function addToUserCart(Product $product)
    {
        Cart::create(
            [
                'user_id' => Auth::user()->id,
                'product_id' => $product->id,
                'quantity' => 1
            ]
        );
    }

    private function getUserCart()
    {
        return Auth::user()->cartProducts()->with('product')->get();
    }

    private function getGuestCart()
    {
        return session()->get('cart', []);
    }
}
