<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

// Homepage redirect logic based on authentication
Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('products.index')
        : redirect()->route('auth');
});

// Livewire Auth: load the wrapper Blade view for <livewire:auth-form />
Route::get('/auth', function () {
    return view('livewire.livewire-auth');
})->name('auth');

// Redirect default auth route names to Livewire-based route
Route::get('/login', fn () => redirect()->route('auth'))->name('login');
Route::get('/register', fn () => redirect()->route('auth'))->name('register');

// Disable default Laravel UI auth routes
Auth::routes(['register' => false, 'login' => false]);

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::get('/products', fn () => view('livewire.product-crud'))->name('products.index');
    Route::get('/home', [HomeController::class, 'index'])->name('home');
});
