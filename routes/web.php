<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\ReviewController;

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
Route::middleware(['auth'])->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
    Route::post('/cart/add/{product}', [CartController::class, 'store'])->name('cart.add'); // Add this line
    Route::delete('/cart/{cart}', [CartController::class, 'destroy'])->name('cart.remove');
    Route::put('/cart/{product}', [CartController::class, 'update'])->name('cart.update');
    Route::get('/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
});

// Product Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/products', [App\Http\Controllers\ProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [App\Http\Controllers\ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [App\Http\Controllers\ProductController::class, 'store'])->name('products.store');
    Route::get('/products/search', [App\Http\Controllers\ProductController::class, 'search'])->name('products.search');
    Route::get('/products/{product}', [App\Http\Controllers\ProductController::class, 'show'])->name('products.show');
    Route::get('/products/{product}/edit', [App\Http\Controllers\ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [App\Http\Controllers\ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [App\Http\Controllers\ProductController::class, 'destroy'])->name('products.destroy');
});

// Transaction Routes
Route::post('/transactions', [App\Http\Controllers\TransactionController::class, 'store'])->name('transactions.store');
Route::patch('/transactions/{transaction}/status', [App\Http\Controllers\TransactionController::class, 'updateStatus'])->name('transactions.update-status')->middleware('auth');

// Review Routes
Route::get('/reviews', [App\Http\Controllers\ReviewController::class, 'index'])->name('reviews.index');
Route::get('/products/{product}/review', [ReviewController::class, 'create'])->name('reviews.create');
Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
Route::get('/reviews/{review}/edit', [App\Http\Controllers\ReviewController::class, 'edit'])->name('reviews.edit');
Route::put('/reviews/{review}', [App\Http\Controllers\ReviewController::class, 'update'])->name('reviews.update');
Route::delete('/reviews/{review}', [App\Http\Controllers\ReviewController::class, 'destroy'])->name('reviews.destroy');

// Admin Routes - Consolidated into single group
// Inside the admin group
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function() {
    // Transactions
    Route::get('/transactions', [\App\Http\Controllers\Admin\TransactionController::class, 'index'])
        ->name('admin.transactions');
    Route::put('/transactions/{transaction}/update-status', 
        [\App\Http\Controllers\Admin\TransactionController::class, 'updateStatus'])
        ->name('admin.transactions.update-status');

    // Orders
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('admin.orders.index');
    Route::get('/orders/data', [AdminOrderController::class, 'data'])->name('admin.orders.data');
    Route::put('/orders/{transaction}/status', [AdminOrderController::class, 'updateStatus'])
        ->name('admin.orders.updateStatus');
    
    // Products - IMPORTANT: Define import routes OUTSIDE the resource
    // Corrected GET route to use showImportForm
    Route::get('/products/import', [\App\Http\Controllers\Admin\ProductController::class, 'showImportForm'])
        ->name('admin.products.import');
    Route::post('/products/import', [\App\Http\Controllers\Admin\ProductController::class, 'import'])
        ->name('admin.products.import.store');
        
    // This must come AFTER the import routes
    Route::resource('products', \App\Http\Controllers\Admin\ProductController::class)->except(['show']);
    
    // Add these user routes
    Route::get('/users', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('admin.users.index');
    Route::put('/users/{user}/status', [\App\Http\Controllers\Admin\UserController::class, 'updateStatus'])->name('admin.users.update-status');
    
    // Add these review routes
    Route::get('/reviews', [\App\Http\Controllers\Admin\ReviewController::class, 'index'])->name('admin.reviews.index');
    Route::get('/reviews/{review}/edit', [\App\Http\Controllers\Admin\ReviewController::class, 'edit'])->name('admin.reviews.edit');
    Route::put('/reviews/{review}', [\App\Http\Controllers\Admin\ReviewController::class, 'update'])->name('admin.reviews.update');
    Route::delete('/reviews/{review}', [\App\Http\Controllers\Admin\ReviewController::class, 'destroy'])->name('admin.reviews.destroy');
    // Remove this line from admin group - it's already handled in user routes
    // Route::get('/my-orders', [OrderController::class, 'userOrders'])->name('orders.user_index');
    Route::get('/reviews/unreviewed', [\App\Http\Controllers\Admin\ReviewController::class, 'unreviewed'])
        ->name('admin.reviews.unreviewed');
});

// User Orders Routes (simplified)
// Make sure these are the only order-related routes
Route::middleware(['auth'])->group(function () {
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::delete('/orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');
});

// Admin Orders Routes (simplified)
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function() {
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('admin.orders.index');
    Route::get('/orders/data', [AdminOrderController::class, 'data'])->name('admin.orders.data');
    Route::put('/orders/{transaction}/status', [AdminOrderController::class, 'updateStatus'])
        ->name('admin.orders.updateStatus');
});

Route::prefix('admin')->group(function() {
    Route::get('/dashboard/sales-data', [Admin\DashboardController::class, 'salesData']);
    Route::get('/dashboard/product-data', [Admin\DashboardController::class, 'productData']);
    Route::get('/admin/dashboard/data', [Admin\DashboardController::class, 'data'])
        ->name('admin.dashboard.data');
});

Route::get('/reviews/unreviewed', [ReviewController::class, 'unreviewed'])
    ->name('reviews.unreviewed')
    ->middleware('auth');

// Inside admin routes group
Route::delete('/users/{user}', [\App\Http\Controllers\Admin\UserController::class, 'destroy'])
    ->name('admin.users.destroy');

// Inside admin routes group
Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class)
    ->except(['show'])
    ->names([
        'index' => 'admin.categories.index',
        'create' => 'admin.categories.create',
        'store' => 'admin.categories.store',
        'edit' => 'admin.categories.edit',
        'update' => 'admin.categories.update',
        'destroy' => 'admin.categories.destroy'
    ]);
