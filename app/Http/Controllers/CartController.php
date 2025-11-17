<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Service\CartService;
use Illuminate\Http\Request;

class CartController
{
    /**
     * Display a listing of the resource.
     */
    public function index(CartService $cartService)
    {
        return view('cart.index', [
            'cart' => $cartService->getCart(),
            'products' => Product::class,
            'total' => $cartService->getTotal()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Product $product, CartService $cartService)
    {
        $product = Product::findOrFail($product->id);
        if ($product) {
            $cartService->addToCart($product);
        }
        return back()->with('success', 'Товар успешно добавлен!');
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $cart = session()->get('cart');
        $cart[$product->id]['quantity'] = max(1, (int) $request->input('quantity', 1));
        session()->put('cart', $cart);

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product, CartService $cartService)
    {
        $cartService->removeFromCart($product);

        return response()->json(['success' => true]);
    }
}
