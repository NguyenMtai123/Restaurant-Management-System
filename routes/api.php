<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AuthApiController;
use App\Http\Controllers\Api\Customer\CartController;
use App\Http\Controllers\Api\Auth\RegisterApiController;
use App\Http\Controllers\Api\Customer\PaymentController;

Route::prefix('cart')->group(function () {
    Route::get('/', [CartController::class, 'index']);
    Route::post('/add', [CartController::class, 'add']);
    Route::post('/remove', [CartController::class, 'remove']);
    Route::post('/update', [CartController::class, 'update']);
});

Route::post('/login', [AuthApiController::class, 'login']);
Route::post('/register', [RegisterApiController::class, 'register']);

// Phải có Sanctum middleware
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthApiController::class, 'logout']);
    Route::get('/user', function(Request $request){
        return $request->user();
    });
});
Route::post('/api/payment/{order}', [PaymentController::class, 'pay'])
    ->middleware('auth:sanctum'); // nếu dùng API token
