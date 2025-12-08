<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AuthApiController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Customer\CartController;
use App\Http\Controllers\Api\Customer\HomeController;
use App\Http\Controllers\Api\Admin\MenuItemController;

Route::get('/', function () {
    return view('welcome');
});


Route::middleware(['auth'])->group(function() {
    Route::get('/customer/home', [HomeController::class, 'index'])->name('customer.home');
});

Route::prefix('admin')->middleware('auth')->group(function() {
    Route::get('/foods/create', [MenuItemController::class, 'create'])->name('admin.foods.create');
    Route::get('/dashboard', function () {
    return view('admin.dashboard');})->name('admin.dashboard');
});


Route::get('/staff/dashboard', function () {
    return 'Staff Dashboard';
})->name('staff.dashboard');

Route::get('/login', [AuthApiController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthApiController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthApiController::class, 'logout'])->name('logout');

// Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.post');

 Route::middleware('auth')->group(function () {
    Route::get('/cart', [CartController::class, 'index']);
    Route::post('/cart/add', [CartController::class, 'add']);
    Route::post('/cart/remove', [CartController::class, 'remove']);
    Route::post('/cart/update', [CartController::class, 'update']);
});
