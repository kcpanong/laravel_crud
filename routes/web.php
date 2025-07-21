<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\ProductCrud;
use App\Http\Controllers\HomeController;

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('products.index')
        : redirect()->route('login');
});

Auth::routes();

Route::middleware('auth')->group(function () {
    Route::get('/products', function () {
		return view('livewire.product-crud');
	})->name('products.index');

    Route::get('/home', [HomeController::class, 'index'])->name('home');
});
