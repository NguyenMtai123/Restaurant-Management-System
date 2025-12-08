<?php

namespace App\Http\Controllers\Api\Customer;

use App\Models\CartItem;
use App\Models\Category;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $categories = Category::all();
        $menuItems = MenuItem::with('category')->get();

        $cartCount = $user
            ? CartItem::whereHas('cart', fn($q) => $q->where('user_id', $user->id))
                ->sum('quantity')
            : 0;

        return view('customer.home', compact('user','categories','menuItems','cartCount'));
    }



}
