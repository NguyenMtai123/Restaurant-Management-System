<?php

namespace App\Http\Controllers\Api\Customer;

use App\Models\About;
use App\Models\Comment;
use App\Models\CartItem;
use App\Models\Category;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
    $user = Auth::user();
    if ($user && $user->role && $user->role->name === 'admin') {
        return redirect()->route('admin.dashboard');
    }


    $categories = Category::all();
    $menuItems = MenuItem::with(['category', 'images'])
        ->withCount(['orderItems as total_sold' => function($query) {
            $query->select(DB::raw("COALESCE(SUM(quantity),0)"));
        }])
        ->get();

    $cartCount = $user
        ? CartItem::whereHas('cart', fn($q) => $q->where('user_id', $user->id))
            ->sum('quantity')
        : 0;

    $testimonials = Comment::with('user')
        ->latest()
        ->take(3)
        ->get();

    // Lấy About đang sử dụng
    $about = About::where('is_used', true)->first();

    return view('customer.home', compact('user','categories','menuItems','cartCount','testimonials','about'));
}

}
