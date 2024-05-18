<?php

use Illuminate\Support\Facades\Route;

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    \App\Http\Middleware\IsAdmin::class,
])->prefix('admin')
  ->name('admin.')
  ->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('products',[\App\Http\Controllers\Admin\ProductController::class, 'index'])->name('products');
    Route::get('categories',[\App\Http\Controllers\Admin\CategoryController::class, 'index'])->name('categories');
});
