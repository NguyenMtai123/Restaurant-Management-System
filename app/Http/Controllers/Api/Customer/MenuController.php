<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MenuController extends Controller
{
    // Xem chi tiết món ăn
    public function show($slug)
    {
        $menuItem = MenuItem::with(['category', 'images', 'comments.user'])
            ->where('slug', $slug)
            ->firstOrFail();

        // Lấy đánh giá đã duyệt
        $comments = $menuItem->comments()->where('is_approved', true)->latest()->get();

        // Trung bình đánh giá
        $avgRating = $comments->avg('rating');

        return view('customer.menu.show', compact('menuItem', 'comments', 'avgRating'));
    }

    // Thêm bình luận / đánh giá
    public function comment(Request $request, MenuItem $menuItem)
    {
        $request->validate([
            'content_menu' => 'required|string|max:1000',
            'rating' => 'nullable|integer|min:1|max:5'
        ]);

        $user = Auth::user();
        if (!$user) {
            return redirect()->back()->with('error', 'Bạn cần đăng nhập để bình luận.');
        }

        $menuItem->comments()->create([
            'user_id' => $user->id,
            'content_menu' => $request->content_menu,
            'rating' => $request->rating,
            'commentable_id' => $menuItem->id,
            'is_approved' => true, // hoặc false nếu cần duyệt admin
        ]);

        return redirect()->back()->with('success', 'Bình luận đã được gửi thành công!');
    }
}
