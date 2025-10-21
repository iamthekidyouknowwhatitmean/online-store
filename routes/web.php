<?php

use App\Exports\OrdersExport;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

use Maatwebsite\Excel\Facades\Excel;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/products', [ProductController::class, 'index']);

Route::get('/cart', [CartController::class, 'index']);
Route::post('/cart/{product}', [CartController::class, 'store']);
Route::delete('/cart/{product}', [CartController::class, 'destroy']);
Route::patch('/cart/{product}', [CartController::class, 'update']);

Route::get('/checkout', [OrderController::class, 'index']);
Route::post('/checkout', [OrderController::class, 'store']);


Route::match(['GET', 'POST'], '/payments/callback', [OrderController::class, 'callback']);

Route::get('/orders/export', function () {
    return (new OrdersExport)->store('orders.xlsx');
});
