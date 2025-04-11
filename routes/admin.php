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
    Route::get('products/data', [ProductController::class, 'getProducts'])->name('products.data');
    Route::resource('products', ProductController::class);
    Route::get('products/import', [ProductController::class, 'import'])->name('products.import');
    Route::post('products/import', [ProductController::class, 'importStore'])->name('products.import.store');
    
    // Categories
    Route::resource('categories', CategoryController::class);
    
    // Reviews
    Route::resource('reviews', ReviewController::class);
    
    // Product Images
    Route::delete('product-images/{image}', [ProductController::class, 'destroyImage'])->name('product-images.destroy');
    
    // Orders
    Route::get('orders/data', [App\Http\Controllers\Admin\OrderDataController::class, '__invoke'])->name('orders.data');
    Route::resource('orders', OrderController::class);
    Route::put('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.update-status');
});