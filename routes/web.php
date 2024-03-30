<?php

use Illuminate\Support\Facades\Route;

require_once 'admin.php';

Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');
