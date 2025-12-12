<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('admin.categories.index', compact('categories'));
    }

    // Form thêm mới
    public function create()
    {
        return view('admin.categories.create');
    }

    // Lưu dữ liệu mới
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:menu_categories,name',
            'description' => 'nullable|string',
        ]);

        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name), // tạo slug tự động
            'description' => $request->description,
        ]);

        return redirect()->route('categories.index')->with('success', 'Thêm danh mục thành công!');
    }
}
