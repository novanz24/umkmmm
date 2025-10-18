<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// User
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;

// Admin
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;

// Public
Route::get('/', [CatalogController::class, 'index'])->name('home');
Route::get('/products/{product}', [CatalogController::class, 'show'])->name('products.show');

// User area (auth)
Route::middleware('auth')->group(function () {
    // Cart
    Route::get('/cart', [CartController::class,'index'])->name('cart.index');
    Route::post('/cart/items', [CartController::class,'add'])->name('cart.items.add');
    Route::patch('/cart/items/{item}', [CartController::class,'update'])->name('cart.items.update');
    Route::delete('/cart/items/{item}', [CartController::class,'destroy'])->name('cart.items.destroy');

    // Checkout & Orders
    Route::get('/checkout', [CheckoutController::class,'form'])->name('checkout.form');
    Route::post('/checkout', [CheckoutController::class,'store'])->name('checkout.store');

    Route::get('/orders', [OrderController::class,'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class,'show'])->name('orders.show');
});

// Admin (auth + gate)
Route::middleware(['auth','can:admin-area'])
    ->prefix('admin')->name('admin.')->group(function () {
        Route::resource('products', AdminProductController::class);
        Route::resource('categories', AdminCategoryController::class)->only(['index','store','update','destroy']);
        Route::get('orders', [AdminOrderController::class,'index'])->name('orders.index');
        Route::patch('orders/{order}/status', [AdminOrderController::class,'updateStatus'])->name('orders.updateStatus');
    });

// Dashboard Breeze
Route::get('/dashboard', fn () => Inertia::render('Dashboard'))
    ->middleware(['auth','verified'])->name('dashboard');

require __DIR__.'/auth.php';
