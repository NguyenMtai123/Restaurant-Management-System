<?php

namespace App\Http\Controllers\APi\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    // ================= DANH SÁCH + TÌM KIẾM + LỌC =================
    public function index(Request $request)
    {
        $query = Post::with('category');

        // 🔍 Tìm kiếm theo tiêu đề
        if ($request->filled('keyword')) {
            $query->where('title', 'like', '%' . $request->keyword . '%');
        }

        // 📂 Lọc theo danh mục
        if ($request->filled('category_id') && $request->category_id != 'all') {
            $query->where('post_category_id', $request->category_id);
        }

        $posts = $query->latest()->paginate(5)->withQueryString();
        $categories = PostCategory::where('is_active', true)->get();

        return view('admin.posts.index', compact('posts', 'categories'));
    }

    // ================= FORM TẠO =================
    public function create()
    {
        $categories = PostCategory::where('is_active', true)->get();
        return view('admin.posts.create', compact('categories'));
    }

    // ================= LƯU =================
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|max:200',
            'excerpt' => 'nullable',
            'content_post' => 'required',
            'thumbnail' => 'nullable|image',
            'post_category_id' => 'required|exists:post_categories,id',
            'is_published' => 'boolean',
        ]);

        $data['code'] = 'POST' . time();
        $data['slug'] = Str::slug($data['title']);
        $data['published_at'] = $request->is_published ? now() : null;

        // Upload ảnh
        if ($request->hasFile('thumbnail')) {
            $name = time() . '_' . $request->thumbnail->getClientOriginalName();
            $request->thumbnail->move(public_path('images/posts'), $name);
            $data['thumbnail'] = 'images/posts/' . $name;
        }

        Post::create($data);

        return redirect()->route('admin.posts.index')
            ->with('success', 'Thêm bài viết thành công');
    }
    // ================= FORM SỬA =================
    public function edit(Post $post)
    {
        $categories = PostCategory::where('is_active', true)->get();
        return view('admin.posts.edit', compact('post', 'categories'));
    }

    // ================= CẬP NHẬT =================
    public function update(Request $request, Post $post)
    {
        $data = $request->validate([
            'title' => 'required|max:200',
            'excerpt' => 'nullable',
            'content_post' => 'required',
            'thumbnail' => 'nullable|image',
            'post_category_id' => 'required|exists:post_categories,id',
            'is_published' => 'boolean',
        ]);

        $data['slug'] = Str::slug($data['title']);
        $data['published_at'] = $request->is_published ? now() : null;

        // Upload ảnh mới nếu có
        if ($request->hasFile('thumbnail')) {
            // Xóa ảnh cũ nếu có
            if ($post->thumbnail && file_exists(public_path($post->thumbnail))) {
                @unlink(public_path($post->thumbnail));
            }

            $name = time() . '_' . $request->thumbnail->getClientOriginalName();
            $request->thumbnail->move(public_path('images/posts'), $name);
            $data['thumbnail'] = 'images/posts/' . $name;
        }

        $post->update($data);

        return redirect()->route('admin.posts.index')
            ->with('success', 'Cập nhật bài viết thành công');
    }
     public function destroy(Post $post)
    {
        // Xóa ảnh nếu có
        if ($post->thumbnail && file_exists(public_path($post->thumbnail))) {
            @unlink(public_path($post->thumbnail));
        }

        $post->delete();

        return redirect()->route('admin.posts.index')
            ->with('success', 'Xóa bài viết thành công');
    }
}
