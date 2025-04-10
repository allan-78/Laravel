<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::resource('orders', OrderController::class)->only(['index', 'destroy']);

Auth::routes(['verify' => true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'index'])->name('profile');
Route::get('/profile/edit', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
Route::put('/profile/update', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');

// Cart Routes
Route::get('/cart', [App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
Route::post('/cart/{product}', [App\Http\Controllers\CartController::class, 'store'])->name('cart.store');
Route::put('/cart/{item}', [App\Http\Controllers\CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/{item}', [App\Http\Controllers\CartController::class, 'destroy'])->name('cart.destroy');

// Product Routes
Route::get('/products', [App\Http\Controllers\ProductController::class, 'index'])->name('products.index');
Route::get('/products/search', [App\Http\Controllers\ProductController::class, 'search'])->name('products.search');
Route::get('/products/{product}', [App\Http\Controllers\ProductController::class, 'show'])->name('products.show');

// Checkout Route
Route::get('/checkout', [App\Http\Controllers\CartController::class, 'checkout'])->name('checkout');

// Transaction Routes
Route::post('/transactions', [App\Http\Controllers\TransactionController::class, 'store'])->name('transactions.store');

// Review Routes
Route::get('/reviews', [App\Http\Controllers\ReviewController::class, 'index'])->name('reviews.index');
Route::get('/products/{product}/review', [App\Http\Controllers\ReviewController::class, 'create'])->name('products.review');
Route::post('/reviews', [App\Http\Controllers\ReviewController::class, 'store'])->name('reviews.store');
Route::get('/reviews/{review}/edit', [App\Http\Controllers\ReviewController::class, 'edit'])->name('reviews.edit');
Route::put('/reviews/{review}', [App\Http\Controllers\ReviewController::class, 'update'])->name('reviews.update');
Route::delete('/reviews/{review}', [App\Http\Controllers\ReviewController::class, 'destroy'])->name('reviews.destroy');
