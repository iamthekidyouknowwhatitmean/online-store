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
    public function index()
    {
        // проверка, существует ли сессия с таким ключом, чтобы при его отсутствии не было ошибок
        $cart = session()->get('cart', []);
        $total = 0;

        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return view('cart.index', [
            'cart' => $cart,
            'products' => Product::class,
            'total' => $total
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Product $product, CartService $cartService)
    {
        $product = Product::findOrFail($product->id);
        if ($product) {
            $cartService->addToGuestCart($product);
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
    public function destroy(Product $product)
    {
        // Взаимодействия с базой данных нет, поэтому пока что работает только на НЕавторизованных пользователях
        // просто удаляем из сессии выбранное пользователем значение
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
        return response()->json(['success' => true]);
    }
}
