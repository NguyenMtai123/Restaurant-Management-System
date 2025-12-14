<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Admin\UserController;
use App\Http\Controllers\Web\Auth\LoginController;
use App\Http\Controllers\Api\Admin\OrderController;
use App\Http\Controllers\Api\Customer\CartController;
use App\Http\Controllers\Api\Customer\HomeController;
use App\Http\Controllers\Api\Customer\MenuController;
use App\Http\Controllers\Web\Auth\RegisterController;
use App\Http\Controllers\Api\Admin\CategoryController;
use App\Http\Controllers\Api\Admin\MenuItemController;
use App\Http\Controllers\Api\Admin\RestaurantController;
use App\Http\Controllers\Api\Customer\PaymentController;
use App\Http\Controllers\Api\Customer\CheckoutController;
use App\Http\Controllers\Api\Admin\MenuItemImageController;

// ---------------------------
// GUEST ROUTES (Login/Register)
// ---------------------------
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.post');

// ---------------------------
// CUSTOMER ROUTES
// ---------------------------
Route::middleware(['auth', 'role:customer'])->group(function () {
    Route::get('/customer/home', [HomeController::class, 'index'])->name('customer.home');

    // Menu + chi tiết món ăn + comment
    Route::get('/menu/{slug}', [MenuController::class, 'show'])->name('customer.menu.show');
    Route::post('/menu/{menuItem}/comment', [MenuController::class, 'comment'])->name('customer.menu.comment');

    // Giỏ hàng
    Route::get('/cart', [CartController::class, 'index']);
    Route::post('/cart/add', [CartController::class, 'add']);
    Route::post('/cart/remove', [CartController::class, 'remove']);
    Route::post('/cart/update', [CartController::class, 'update']);

    // Thanh toán
    Route::get('/payment/{order}', [PaymentController::class, 'showPaymentForm']);
    Route::post('/checkout', [CheckoutController::class, 'store']);
    Route::get('/orders/{id}', [CheckoutController::class, 'show'])->name('orders.show');
    Route::post('/payment/{order}', [PaymentController::class, 'pay'])->name('payment.pay');
});

// ---------------------------
// ADMIN ROUTES
// ---------------------------
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {

    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // Menu items
    Route::resource('menu-items', MenuItemController::class);

    Route::get('menu-items/{menuItem}/images', [MenuItemImageController::class, 'index']);
    Route::post('menu-items/{menuItem}/images', [MenuItemImageController::class, 'store']);
    Route::delete('menu-item-images/{image}', [MenuItemImageController::class, 'destroy']);
    Route::post('menu-item-images/{image}/set-featured', [MenuItemImageController::class, 'setFeatured']);

    // Categories
    Route::resource('categories', CategoryController::class);

    // Restaurants
    Route::resource('restaurants', RestaurantController::class);

    // Users
    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('users.index');
        Route::get('/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/store', [UserController::class, 'store'])->name('users.store');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    });

    // Orders
    Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::put('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::post('orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
});

// ---------------------------
// STAFF ROUTES (ví dụ)
// ---------------------------
Route::middleware(['auth', 'role:staff'])->group(function () {
    Route::get('/staff/dashboard', function () {
        return 'Staff Dashboard';
    })->name('staff.dashboard');
});

// ---------------------------
// HOME PAGE / WELCOME
// ---------------------------
Route::get('/', function () {
    return view('welcome');
});
