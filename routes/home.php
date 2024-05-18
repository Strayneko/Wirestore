<?php

use Illuminate\Support\Facades\Route;

Route::name('home.')->controller(\App\Http\Controllers\HomeController::class)->group(function (){
    Route::get('/', 'index')->name('index');
    Route::get('/product/{product}', 'view')->name('product');
});
