<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\OrderController;

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth', 'admin']], function() {
    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Users
    Route::resource('users', UserController::class);
    
    // Products
    Route::resource('products', ProductController::class);
    
    // Categories
    Route::resource('categories', CategoryController::class);
    
    // Reviews
    Route::resource('reviews', ReviewController::class);
    
    // Orders
    Route::resource('orders', OrderController::class);
});