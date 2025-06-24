<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
	return auth()->check()
		? redirect()->route('products.index')
		: redirect()->route('login');
});

Auth::routes();

Route::middleware('auth')->group(function () {
	Route::resource('products', ProductController::class);
	Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
});
