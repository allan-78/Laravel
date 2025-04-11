<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProductController;

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth', 'admin']], function() {
    Route::delete('product-images/{image}', [ProductController::class, 'destroyImage'])->name('product-images.destroy');
});