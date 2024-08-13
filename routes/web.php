<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [ProductController::class, 'index'])->name('products.index');
Route::post('cart/{id}', [CartController::class, 'addToCart'])->name('cart.add');
Route::get('cart', [CartController::class, 'viewCart'])->name('cart.index');
Route::post('order', [CartController::class, 'placeOrder'])->name('order.place');

Route::get('orders', [CartController::class, 'viewOrders'])->middleware('auth')->name('orders.index');
Route::delete('orders/{id}', [CartController::class, 'deleteOrder'])->middleware('auth')->name('orders.delete');
