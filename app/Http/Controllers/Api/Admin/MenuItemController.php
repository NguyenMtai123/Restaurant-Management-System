<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Category;
use App\Models\MenuItem;
use Illuminate\Support\Str;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMenuItemRequest;

class MenuItemController extends Controller
{

    public function store(StoreMenuItemRequest $request): JsonResponse
    {
        $data = $request->validated();

        // Upload image
        if ($request->hasFile('image')) {
            $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('images/menu'), $imageName);
            $data['image'] = $imageName;
        }

        // Tạo slug nếu trống hoặc đảm bảo unique
        if (empty($data['slug'])) {
            $slug = Str::slug($data['name']);
            $count = MenuItem::where('slug', $slug)->count();
            if ($count > 0) {
                $slug .= '-' . ($count + 1);
            }
            $data['slug'] = $slug;
        }

        $menuItem = MenuItem::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Món ăn được thêm thành công!',
            'data' => $menuItem
        ], 201);
    }

    // Optional: lấy danh sách menu
    public function index(): JsonResponse
    {
        $menuItems = MenuItem::with('category')->get();
        return response()->json($menuItems);
    }
     public function create()
    {
        $categories = Category::all();
        return view('admin.foods.add-menu-item', compact('categories'));
    }
}
