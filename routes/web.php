<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\APi\Admin\PostController;
use App\Http\Controllers\Api\Admin\UserController;
use App\Http\Controllers\Web\Auth\LoginController;
use App\Http\Controllers\Api\Admin\AboutController;
use App\Http\Controllers\Api\Admin\OrderController;
use App\Http\Controllers\Api\Admin\ContactController;
use App\Http\Controllers\Api\Admin\ProfileController;
use App\Http\Controllers\Api\Admin\SettingController;
use App\Http\Controllers\Api\Customer\CartController;
use App\Http\Controllers\Api\Customer\HomeController;
use App\Http\Controllers\Api\Customer\MenuController;
use App\Http\Controllers\Web\Auth\RegisterController;
use App\Http\Controllers\Api\Admin\CategoryController;
use App\Http\Controllers\Api\Admin\EmployeeController;
use App\Http\Controllers\Api\Admin\MenuItemController;
use App\Http\Controllers\Api\Admin\DashboardController;
use App\Http\Controllers\Api\Admin\StatisticsController;
use App\Http\Controllers\Api\Customer\PaymentController;
use App\Http\Controllers\Api\Customer\CheckoutController;
use App\Http\Controllers\Api\Customer\HisOrderController;
use App\Http\Controllers\Api\Admin\PostCategoryController;
use App\Http\Controllers\Web\Auth\ResetPasswordController;
use App\Http\Controllers\Api\Admin\MenuItemImageController;
use App\Http\Controllers\Api\Customer\ContactCusController;
use App\Http\Controllers\Web\Auth\ForgotPasswordController;
use App\Http\Controllers\Api\Customer\ProfileUserController;

// ---------------------------
// GUEST ROUTES (Login/Register)
// ---------------------------
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Register & OTP
Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.post');

Route::get('/register/verify-otp', [RegisterController::class, 'showOtpForm'])->name('register.show-otp');
Route::post('/register/verify-otp', [RegisterController::class, 'verifyOtp'])->name('register.verify-otp');


Route::middleware(['auth', 'role:customer'])->group(function () {
    Route::get('/customer/home', [HomeController::class, 'index'])->name('customer.home');
    // Menu + chi tiết món ăn + comment

    Route::post('/menu/{menuItem}/comment', [MenuController::class, 'comment'])->name('customer.menu.comment');
    Route::post('/menu/{menuItem}/comment-ajax',
    [MenuController::class, 'commentAjax']
    )->name('customer.menu.comment.ajax');


    // Giỏ hàng
    // Route::get('/cart', [CartController::class, 'index']);
    // Route::post('/cart/add', [CartController::class, 'add']);
    // Route::post('/cart/remove', [CartController::class, 'remove']);
    // Route::post('/cart/update', [CartController::class, 'update']);
    Route::get('/orders/history', [HisOrderController::class, 'history'])->name('orders.history');
    Route::get('/orders/history/{order}', [HisOrderController::class, 'show'])->name('orders.history.show');

    // Thanh toán
    Route::get('/orders/{id}', [CheckoutController::class, 'show'])->name('orders.show');
     Route::get('/payment/{orderId}', [PaymentController::class, 'showPaymentForm'])->name('payment.form');
    Route::post('/payment/{orderId}', [PaymentController::class, 'pay'])->name('payment.pay');
    Route::get('/vnpay-payment', [PaymentController::class, 'vnpay_payment'])->name('vnpay_payment');
    Route::get('/vnpay-return', [PaymentController::class, 'vnpay_return'])->name('vnpay.return');

    Route::get('/profile', [ProfileUserController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileUserController::class, 'update'])->name('profile.update');

});


Route::post('/contact', [ContactCusController::class, 'store'])->name('customer.contact.store');
Route::get('/menu/{slug}', [MenuController::class, 'show'])->name('customer.menu.show');
Route::post('/checkout', [CheckoutController::class, 'store']);
Route::prefix('cart')->group(function () {
    Route::get('/', [CartController::class, 'index']);
    Route::post('/add', [CartController::class, 'add']);
    Route::post('/update', [CartController::class, 'update']);
    Route::post('/remove', [CartController::class, 'remove']);
});

// ---------------------------
// ADMIN ROUTES
// ---------------------------
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/statistic', [StatisticsController::class, 'index'])->name('statistic');
    Route::get( '/statistics/export-pdf', [StatisticsController::class, 'exportPdf'])->name('statistics.export.pdf');

    // Menu items
    Route::resource('menu-items', MenuItemController::class);

    Route::get('menu-items/{menuItem}/images', [MenuItemImageController::class, 'index']);
    Route::post('menu-items/{menuItem}/images', [MenuItemImageController::class, 'store']);
    Route::delete('menu-item-images/{image}', [MenuItemImageController::class, 'destroy']);
    Route::post('menu-item-images/{image}/set-featured', [MenuItemImageController::class, 'setFeatured']);

    // Categories
    Route::resource('categories', CategoryController::class);

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
    Route::get('/orders-export/pdf', [OrderController::class, 'exportPdf'])->name('orders.export.pdf');
    Route::get('customers/{user}', [UserController::class, 'show'])
    ->name('admin.users.show');
    Route::resource('posts', PostController::class);
    Route::resource('post-categories', PostCategoryController::class);

    Route::resource('employees', EmployeeController::class)
        ->parameters(['employees' => 'employee']);
    Route::resource('contacts', ContactController::class)
         ->only(['index','show','destroy']);

    Route::get('contacts/{contact}/toggle-read', [ContactController::class,'toggleRead'])
         ->name('contacts.toggle-read');
    Route::resource('abouts', AboutController::class);

    // Route riêng để bật is_used (nếu muốn tách ra)
    Route::post('abouts/{about}/set-used', [AboutController::class, 'setUsed'])->name('abouts.set-used');
    Route::get('settings', [SettingController::class, 'index'])->name('settings');
     Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('profile/password', [ProfileController::class, 'password'])->name('profile.password');


});

// ---------------------------
// STAFF ROUTES (ví dụ)
// ---------------------------
Route::middleware(['auth', 'role:staff'])->group(function () {
    Route::get('/staff/dashboard', function () {
        return 'Staff Dashboard';
    })->name('staff.dashboard');
});

// Route gốc `/` → tự động vào home
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])
    ->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])
    ->name('password.email');

// Form nhập mật khẩu mới
Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])
    ->name('password.reset');
Route::post('/reset-password', [ResetPasswordController::class, 'reset'])
    ->name('password.update');
