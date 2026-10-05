<?php

use App\Http\Controllers\AdminMenuController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('menu.index'));
Route::get('/dashboard', fn () => redirect()->route('menu.index'))->middleware('auth')->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');
    Route::get('/menu/{menu}', [MenuController::class, 'show'])->name('menu.show');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/cart', [App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [App\Http\Controllers\CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/remove/{id}', [App\Http\Controllers\CartController::class, 'remove'])->name('cart.remove');

    Route::post('/order/checkout', [App\Http\Controllers\OrderController::class, 'checkout'])->name('order.checkout');
    Route::get('/orders/my', [App\Http\Controllers\OrderController::class, 'myOrders'])->name('order.my');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('orders', [App\Http\Controllers\OrderController::class, 'index'])->name('orders.index');
    Route::post('orders/{order}/finish', [App\Http\Controllers\OrderController::class, 'finish'])->name('orders.finish');
    Route::get('orders/history', [App\Http\Controllers\OrderController::class, 'history'])->name('orders.history');

    Route::get('search', [AdminMenuController::class, 'search'])->name('search');
    Route::post('menu/import', [AdminMenuController::class, 'import'])->name('import');
    Route::post('menu', [AdminMenuController::class, 'store'])->name('store');
    Route::get('menu/export', [AdminMenuController::class, 'export'])->name('export');
    Route::get('menu/{menu}/edit', [AdminMenuController::class, 'edit'])->name('edit');
    Route::put('menu/{menu}', [AdminMenuController::class, 'update'])->name('update');
    Route::delete('menu/{menu}', [AdminMenuController::class, 'destroy'])->name('destroy');
});

require __DIR__.'/auth.php';
