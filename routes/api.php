<?php

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Middleware\Authenticate;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\FoodController;
use App\Http\Controllers\Api\Admin\MenuItemController;
use App\Http\Controllers\Customer\CartController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Api\Auth\AuthApiController;
use App\Http\Controllers\Api\Customer\HomeController;
use App\Http\Controllers\Api\Staff\Home_Staff_Controller;

Route::get('/menu-items', [MenuItemController::class, 'index']);
Route::post('/menu-items', [MenuItemController::class, 'store']);


Route::post('/login', [AuthApiController::class, 'login']);
Route::post('/logout', [AuthApiController::class, 'logout']);
Route::post('/login', function(Request $request){
    $user = User::where('email', $request->email)->first();

    if (!$user) {
        return response()->json(['error' => 'Email không tồn tại'], 401);
    }

    if ($user->status !== 'active') {
        return response()->json(['error' => 'Tài khoản bị khóa'], 403);
    }

     if (!Hash::check($request->password, $user->password)) {
            return response()->json(['error' => 'Mật khẩu không đúng'], 401);
        }

    return response()->json([
        'message' => 'Đăng nhập thành công',
        'id' => $user->id,
        'email' => $user->email,
        'name' => $user->name,
        'role' => $user->role
    ]);
});


// Menu (GET)
Route::get('/menu', function() {
    return [
        ['id'=>1,'name'=>'Pizza','price'=>120000],
        ['id'=>2,'name'=>'Cà phê sữa','price'=>25000],
        ['id'=>3,'name'=>'Bún bò','price'=>45000],
    ];
});

// Giỏ hàng )
Route::post('/order', function(Request $request){
    $order = session('order', []);
    $order[] = $request->all(); // thêm món vào order
    session(['order'=>$order]);
    return [
        'status'=>'success',
        'message'=>'Đã thêm món vào giỏ (demo)',
        'order'=>$order
    ];
});

// Cập nhật order (PUT)
Route::put('/order/{id}', function(Request $request, $id){
    $order = session('order', []);
    foreach($order as &$item){
        if($item['food_id'] == $id){
            $item['quantity'] = $request->quantity ?? $item['quantity'];
        }
    }
    session(['order'=>$order]);
    return [
        'status'=>'success',
        'message'=>"Order #$id đã cập nhật (demo)",
        'order'=>$order
    ];
});

// Xóa món khỏi order (DELETE)
Route::delete('/order/{id}', function($id){
    $order = session('order', []);
    $order = array_filter($order, fn($item)=>$item['food_id'] != $id);
    session(['order'=>$order]);
    return [
        'status'=>'success',
        'message'=>"Order #$id đã xóa (demo)",
        'order'=>$order
    ];
});

// Danh sách bàn
Route::get('/tables', function() {
    return [
        ['id'=>1,'name'=>'1','status'=>'Trống'],
        ['id'=>2,'name'=>'2','status'=>'Đang phục vụ'],
        ['id'=>3,'name'=>'3','status'=>'Trống'],
    ];
});

// // Thêm món (POST)
// Route::get('/foods', [FoodController::class, 'index']);
// Route::post('/foods', [FoodController::class, 'store']);


// Route::get('/cart', [CartController::class, 'list']);
// Route::post('/cart', [CartController::class, 'add']);
// Route::put('/cart/{index}', [CartController::class, 'update']);
// Route::delete('/cart/{index}', [CartController::class, 'remove']);
