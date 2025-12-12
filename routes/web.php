<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Admin\UserController;
use App\Http\Controllers\Web\Auth\LoginController;
use App\Http\Controllers\Api\Admin\OrderController;
use App\Http\Controllers\Api\Customer\CartController;
use App\Http\Controllers\Api\Customer\HomeController;
use App\Http\Controllers\Web\Auth\RegisterController;
use App\Http\Controllers\Api\Admin\CategoryController;
use App\Http\Controllers\Api\Admin\MenuItemController;
use App\Http\Controllers\Api\Customer\PaymentController;
use App\Http\Controllers\Api\Customer\CheckoutController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/customer/home', [HomeController::class, 'index'])->name('customer.home');
});

Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/foods/create', [MenuItemController::class, 'create'])->name('admin.foods.create');
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});

Route::get('/staff/dashboard', function () {
    return 'Staff Dashboard';
})->name('staff.dashboard');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// WEB REGISTER
Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.post');

Route::middleware('auth')->group(function () {
    Route::get('/cart', [CartController::class, 'index']);
    Route::post('/cart/add', [CartController::class, 'add']);
    Route::post('/cart/remove', [CartController::class, 'remove']);
    Route::post('/cart/update', [CartController::class, 'update']);
});

Route::middleware('auth')->group(function () {
    // Hiển thị form thanh toán
    Route::get('/payment/{order}', [PaymentController::class, 'showPaymentForm']);
    Route::post('/checkout', [CheckoutController::class, 'store']);
    Route::get('/orders/{id}', [CheckoutController::class, 'show'])->name('orders.show');
    Route::post('/payment/{order}', [PaymentController::class, 'pay'])->name('payment.pay');
});

Route::prefix('admin/categories')->group(function () {
    Route::get('/', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/store', [CategoryController::class, 'store'])->name('categories.store');
});

Route::prefix('admin/orders')->group(function () {
    Route::get('/', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::post('/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
});

Route::prefix('admin/users')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('users.index');
    Route::get('/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/store', [UserController::class, 'store'])->name('users.store');
    Route::get('/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/{user}', [UserController::class, 'destroy'])->name('users.destroy');
});
