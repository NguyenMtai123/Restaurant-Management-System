<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MenuController extends Controller
{
    // CHI TIẾT MÓN
    public function show($slug)
    {
        $menuItem = MenuItem::with(['category', 'images'])
            ->where('slug', $slug)
            ->firstOrFail();

        // Đặt ảnh mặc định lên đầu
        $menuItem->images = $menuItem->images->sortByDesc('is_featured')->values();

        $comments = $menuItem->comments()
            ->where('is_approved', true)
            ->latest()
            ->take(2)
            ->with('user')
            ->get();

        $avgRating = round(
            $menuItem->comments()
                ->where('is_approved', true)
                ->avg('rating'),
            1
        );

        $totalComments = $menuItem->comments()
            ->where('is_approved', true)
            ->count();

        return view('customer.menu.show', compact(
            'menuItem',
            'comments',
            'avgRating',
            'totalComments'
        ));
    }


    // AJAX COMMENT
    public function comment(Request $request, MenuItem $menuItem)
    {
        if (!Auth::check()) {
            return response()->json([
                'message' => 'Bạn cần đăng nhập'
            ], 401);
        }

        $request->validate([
            'content_menu' => 'required|string|max:1000',
            'rating' => 'required|integer|min:1|max:5'
        ]);

        $comment = $menuItem->comments()->create([
            'user_id' => Auth::id(),
            'content_menu' => $request->content_menu,
            'rating' => $request->rating,
            'is_approved' => true,
        ]);

        return response()->json([
            'success' => true,
            'comment' => [
                'user' => Auth::user()->name,
                'content' => $comment->content_menu,
                'rating' => $comment->rating,
                'created_at' => now()->diffForHumans(),
            ]
        ]);
    }
}
