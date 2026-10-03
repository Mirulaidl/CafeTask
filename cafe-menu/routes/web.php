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
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('search', [AdminMenuController::class, 'search'])->name('search');
    Route::post('menu', [AdminMenuController::class, 'store'])->name('store');
    Route::get('menu/export', [AdminMenuController::class, 'export'])->name('export');
    Route::get('menu/{menu}/edit', [AdminMenuController::class, 'edit'])->name('edit');
    Route::put('menu/{menu}', [AdminMenuController::class, 'update'])->name('update');
    Route::delete('menu/{menu}', [AdminMenuController::class, 'destroy'])->name('destroy');
});

require __DIR__.'/auth.php';
