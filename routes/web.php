<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\APi\Admin\PostController;
use App\Http\Controllers\Api\Admin\RoleController;
use App\Http\Controllers\Api\Admin\UserController;
use App\Http\Controllers\Web\Auth\LoginController;
use App\Http\Controllers\Api\Admin\AboutController;
use App\Http\Controllers\Api\Admin\OrderController;
use App\Http\Controllers\Api\Admin\CouponController;
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
use App\Http\Controllers\Api\Customer\PolicyController;
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
    Route::post('/apply-coupon', [CheckoutController::class, 'applyCoupon'])->name('cart.applyCoupon');


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

Route::prefix('policy')->group(function () {
    Route::get('/faq', [PolicyController::class, 'faq'])->name('policy.faq');
    Route::get('/terms', [PolicyController::class, 'termsOfService'])->name('policy.terms');
    Route::get('/refund', [PolicyController::class, 'refundPolicy'])->name('policy.refund');
    Route::get('/shipping', [PolicyController::class, 'shippingPolicy'])->name('policy.shipping');
    Route::get('/privacy', [PolicyController::class, 'privacyPolicy'])->name('policy.privacy');
});


// ---------------------------
// ADMIN ROUTES
// ---------------------------

Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {

    // Dashboard & Thống kê → staff + admin
    Route::get('/dashboard', [DashboardController::class,'index'])
        ->name('dashboard')
        ->middleware('permission:view_dashboard');
    Route::get('/statistic', [StatisticsController::class,'index'])
        ->name('statistic')
        ->middleware('permission:view_statistics');
    Route::get('/statistics/export-pdf', [StatisticsController::class,'exportPdf'])
        ->name('statistics.export.pdf')
        ->middleware('permission:view_statistics');


    // Quản lý người dùng → admin only
    Route::resource('users', UserController::class)
        ->middleware('permission:manage_users');

    // Quản lý đơn hàng
    Route::get('orders', [OrderController::class,'index'])
        ->name('orders.index')
        ->middleware('permission:manage_orders');

    Route::get('orders/{order}', [OrderController::class,'show'])
        ->name('orders.show')
        ->middleware('permission:manage_orders');
    Route::put('orders/{order}/status', [OrderController::class,'updateStatus'])
        ->name('orders.updateStatus')
        ->middleware('permission:manage_orders');

    Route::post('orders/{order}/cancel', [OrderController::class,'cancel'])
        ->name('orders.cancel')
        ->middleware('permission:manage_orders');

    Route::get('/orders-export/pdf', [OrderController::class,'exportPdf'])
        ->name('orders.export.pdf')
        ->middleware('permission:manage_orders');

    // Menu & Hình ảnh
    Route::resource('menu-items', MenuItemController::class)
        ->middleware('permission:manage_menu');

    Route::get('menu-items/{menuItem}/images', [MenuItemImageController::class,'index'])
        ->middleware('permission:manage_menu');
    Route::post('menu-items/{menuItem}/images', [MenuItemImageController::class,'store'])
        ->middleware('permission:manage_menu');
    Route::delete('menu-item-images/{image}', [MenuItemImageController::class,'destroy'])
        ->middleware('permission:manage_menu');
    Route::post('menu-item-images/{image}/set-featured', [MenuItemImageController::class,'setFeatured'])
        ->middleware('permission:manage_menu');

    // Categories
    Route::resource('categories', CategoryController::class)
        ->middleware('permission:manage_menu');

    // Coupons
    Route::resource('coupons', CouponController::class)
        ->middleware('permission:manage_coupons');

    Route::get('coupons/{coupon}/send', [CouponController::class,'sendForm'])
        ->name('coupons.send.form')
        ->middleware('permission:manage_coupons');

    Route::post('coupons/{coupon}/send', [CouponController::class,'sendToUsers'])
        ->name('coupons.send')
        ->middleware('permission:manage_coupons');

    Route::post('coupons/send-multiple', [CouponController::class,'sendMultiple'])
        ->name('coupons.sendMultiple')
        ->middleware('permission:manage_coupons');

    // Posts & Categories
    Route::resource('posts', PostController::class)
        ->middleware('permission:manage_posts');

    Route::resource('post-categories', PostCategoryController::class)
        ->middleware('permission:manage_posts');

    // Employees
    Route::resource('employees', EmployeeController::class)
        ->parameters(['employees' => 'employee'])
        ->middleware('permission:manage_employees');

    Route::resource('roles', RoleController::class)->middleware('permission:manage_roles');
    Route::post('roles/{role}/permissions', [RoleController::class, 'updatePermissions']
    )->name('roles.permissions')
    ->middleware('permission:manage_roles');


    // Contacts
    Route::resource('contacts', ContactController::class)
        ->only(['index','show','destroy'])
        ->middleware('permission:manage_contacts');

    Route::get('contacts/{contact}/toggle-read', [ContactController::class,'toggleRead'])
        ->name('contacts.toggle-read')
        ->middleware('permission:manage_contacts');

    // Abouts
    Route::resource('abouts', AboutController::class)
        ->middleware('permission:about_settings');

    Route::post('abouts/{about}/set-used', [AboutController::class,'setUsed'])
        ->name('abouts.set-used')
        ->middleware('permission:about_settings');

    // Settings
    Route::get('settings', [SettingController::class,'index'])
        ->name('settings')
        ->middleware('permission:manage_settings');

    // Profile
    Route::put('profile', [ProfileController::class,'update'])
        ->name('profile.update');
    Route::put('profile/password', [ProfileController::class,'password'])
        ->name('profile.password');

});


// Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {

//     Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
//     Route::get('/statistic', [StatisticsController::class, 'index'])->name('statistic');
//     Route::get( '/statistics/export-pdf', [StatisticsController::class, 'exportPdf'])->name('statistics.export.pdf');

//     Route::resource('coupons', CouponController::class);
//     Route::get('coupons/{coupon}/send', [CouponController::class,'sendForm'])
//         ->name('coupons.send.form');
//     Route::post('coupons/{coupon}/send', [CouponController::class,'sendToUsers'])
//         ->name('coupons.send');

//         Route::post(
//         'coupons/send-multiple',
//         [CouponController::class,'sendMultiple']
//     )->name('coupons.sendMultiple');

//     Route::resource('roles', RoleController::class);

//     // Menu items
//     Route::resource('menu-items', MenuItemController::class);

//     Route::get('menu-items/{menuItem}/images', [MenuItemImageController::class, 'index']);
//     Route::post('menu-items/{menuItem}/images', [MenuItemImageController::class, 'store']);
//     Route::delete('menu-item-images/{image}', [MenuItemImageController::class, 'destroy']);
//     Route::post('menu-item-images/{image}/set-featured', [MenuItemImageController::class, 'setFeatured']);

//     // Categories
//     Route::resource('categories', CategoryController::class);

//     // Users
//     Route::prefix('users')->group(function () {
//         Route::get('/', [UserController::class, 'index'])->name('users.index');
//         Route::get('/create', [UserController::class, 'create'])->name('users.create');
//         Route::post('/store', [UserController::class, 'store'])->name('users.store');
//         Route::get('/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
//         Route::put('/{user}', [UserController::class, 'update'])->name('users.update');
//         Route::delete('/{user}', [UserController::class, 'destroy'])->name('users.destroy');
//     });

//     // Orders
//     Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
//     Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');
//     Route::put('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
//     Route::post('orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
//     Route::get('/orders-export/pdf', [OrderController::class, 'exportPdf'])->name('orders.export.pdf');
//     Route::get('customers/{user}', [UserController::class, 'show'])
//     ->name('admin.users.show');
//     Route::resource('posts', PostController::class);
//     Route::resource('post-categories', PostCategoryController::class);

//     Route::resource('employees', EmployeeController::class)
//         ->parameters(['employees' => 'employee']);
//     Route::resource('contacts', ContactController::class)
//          ->only(['index','show','destroy']);

//     Route::get('contacts/{contact}/toggle-read', [ContactController::class,'toggleRead'])
//          ->name('contacts.toggle-read');
//     Route::resource('abouts', AboutController::class);

//     // Route riêng để bật is_used (nếu muốn tách ra)
//     Route::post('abouts/{about}/set-used', [AboutController::class, 'setUsed'])->name('abouts.set-used');
//     Route::get('settings', [SettingController::class, 'index'])->name('settings');
//      Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::put('profile/password', [ProfileController::class, 'password'])->name('profile.password');


// });

// // ---------------------------
// // STAFF ROUTES (ví dụ)
// // ---------------------------
// Route::middleware(['auth', 'role:staff'])->group(function () {
//     Route::get('/staff/dashboard', function () {
//         return 'Staff Dashboard';
//     })->name('staff.dashboard');
// });

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
