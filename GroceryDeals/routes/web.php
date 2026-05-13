<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DealController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\LanguageController;

// Route parameter constraints for MongoDB ObjectIds
Route::pattern('id', '[a-f0-9]{24}');

/**
 * Routes setup:
 * Maps HTTP requests to specific Controller methods.
 */
Route::get('/', [WelcomeController::class, 'index'])->name('home');

// Add a redirect from /home to / using Route::redirect()
Route::redirect('/home', '/');

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

Route::get('/deals', [DealController::class, 'index'])->name('deals.index');

// Language Route
Route::get('/lang/{lang}', [LanguageController::class, 'switchLanguage'])->name('lang.switch');

// Auth Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Cart Routes protected by auth middleware
Route::middleware('auth')->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{id}', [CartController::class, 'addToCart'])->name('cart.add');
    Route::post('/cart/remove/{id}', [CartController::class, 'removeFromCart'])->name('cart.remove');
    Route::get('/cart/data', [CartController::class, 'getCart'])->name('cart.data');
    Route::post('/cart/clear', [CartController::class, 'clearCart'])->name('cart.clear');
});

// Admin route group
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    // Products CRUD inside admin
    Route::resource('products', ProductController::class)->except(['index', 'show']);
    
    // Deals management
    Route::get('/deals', function () {
        return view('admin.deals.index');
    })->name('admin.deals');

    // User management
    Route::get('/users', function () {
        return view('admin.users.index');
    })->name('admin.users');
});

// URL generation examples
Route::get('/url-examples', function () {
    return [
        'asset' => asset('images/products/default.jpg'),
        'url' => url('/deals'),
        'secure_url' => secure_url('/checkout'),
    ];
});
