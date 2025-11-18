<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ProductFavoriteController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

// На данный момент просто выводит список всех элементов в таблице Product
Route::get('/products', [ProductController::class, 'index'])->name('products.index');

/* 
Отправка POST запроса на данную страницу, чтобы в таблице product_likes сохранялась информация о том КТО лайкает и ЧТО лайкает
*/
Route::post('/product/{product}', [ProductFavoriteController::class, 'store'])->name('product.store');
Route::get('/favorites', [ProductFavoriteController::class, 'index'])->name('favorites');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/{product}', [CartController::class, 'store'])->name('cart.store');
Route::delete('/cart/{product}', [CartController::class, 'destroy']);
Route::patch('/cart/{product}', [CartController::class, 'update']);

Route::get('/checkout', [OrderController::class, 'index']);
Route::post('/checkout', [OrderController::class, 'store']);
Route::match(['GET', 'POST'], '/payments/callback', [OrderController::class, 'callback']);

Route::get('/register', [RegisterController::class, 'index'])->name('register.index');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

Route::get('/login', [LoginController::class, 'index'])->name('login.index');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.authenticate');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/news/details/{info}', [NewsController::class, 'show'])->name('news.details');
