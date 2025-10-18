<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('checkout');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_email' => 'required|email',
            'address' => 'required|string|max:150',
            'comment' => 'nullable|string|max:500',
        ]);
        $cart = session()->get('cart');
        $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
        $order = Order::create([
            ...$validated,
            'total_price' => $total
        ]);

        // Добавляем товары
        foreach ($cart as $productId => $item) {
            $order->items()->create([
                'product_id' => $productId,
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }

        // Очищаем корзину
        session()->forget('cart');
    }
}
