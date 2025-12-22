<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\PostCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostCategoryController extends Controller
{
    // Danh sách category
    public function index()
    {
        $categories = PostCategory::latest()->get();
        return view('admin.post-categories.index', compact('categories'));
    }

    // Lưu category mới
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:post_categories,name',
            'description' => 'nullable|string',
        ]);

        PostCategory::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'is_active' => true,
        ]);

        return redirect()->back()->with('success', 'Thêm danh mục thành công');
    }

    // Cập nhật category
    public function update(Request $request, PostCategory $category)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:post_categories,name,' . $category->id,
            'description' => 'nullable|string',
        ]);

        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
        ]);

        return redirect()->back()->with('success', 'Cập nhật danh mục thành công');
    }

    // Xóa category
    public function destroy(PostCategory $category)
    {
        // Xóa luôn bài viết trong category nếu muốn
        // $category->posts()->delete();

        $category->delete();

        return redirect()->back()->with('success', 'Xóa danh mục thành công');
    }
}
