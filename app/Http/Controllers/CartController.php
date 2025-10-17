<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cart = session()->get('cart');
        $sum = 0;
        foreach ($cart as $item) {
            $sum += $item['price'] * $item['quantity'];
        }
        return view('cart', [
            'cart' => $cart,
            'products' => Product::class,
            'sum' => $sum
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Product $product)
    {
        // Пока что для неавторизованного пользователя
        $product = Product::findOrFail($product->id);
        $cart = session()->get('cart', []);

        // Check if the item is in the cart and increment the quantity
        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity']++;
        } else {
            // If not in the cart, add it with quantity as 1
            $cart[$product->id] = [
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->price
            ];
        }
        session()->put('cart', $cart);

        return back()->with('success', 'Товар успешно добавлен!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cart $cart)
    {
        //
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
    public function destroy(Request $request, Product $product)
    {
        // Взаимодействия с базой данных нет, поэтому пока что работает только на НЕавторизованных пользователях
        // просто удаляем из сессии выбранное пользователем значение
        $cart = session()->get('cart');
        if ($cart[$product['id']]['quantity'] > 1) {
            $cart[$product['id']]['quantity']--;
        } else {
            unset($cart[$product['id']]);
        }

        session()->put('cart', $cart);
        return back();
    }
}
