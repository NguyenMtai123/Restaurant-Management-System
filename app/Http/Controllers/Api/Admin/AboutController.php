<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\About;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    // Hiển thị danh sách
    public function index()
    {
        $abouts = About::latest()->paginate(10);
        return view('admin.abouts.index', compact('abouts'));
    }

    // Form tạo
    public function create()
    {
        return view('admin.abouts.create');
    }

    // Lưu mới
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:200',
            'content_contact' => 'required',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'address' => 'nullable|string|max:255',
            'map_embed' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:150',
            'is_used' => 'nullable|boolean'
        ]);

        $data = $request->all();
        $data['is_used'] = $request->has('is_used');

        if ($request->hasFile('image')) {
            $filename = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('images/abouts'), $filename);
            $data['image'] = 'images/abouts/' . $filename;
        }

        About::create($data);

        return redirect()->route('admin.abouts.index')->with('success', 'Thêm About thành công');
    }

    // Form chỉnh sửa
    public function edit(About $about)
    {
        return view('admin.abouts.edit', compact('about'));
    }

    // Cập nhật
   public function update(Request $request, About $about)
{
    $request->validate([
        'title' => 'required|string|max:200',
        'content_contact' => 'required',
        'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        'address' => 'nullable|string|max:255',
        'map_embed' => 'nullable|string',
        'phone' => 'nullable|string|max:20',
        'email' => 'nullable|email|max:150',
        'is_used' => 'nullable'
    ]);

    $data = $request->all();
    $data['is_used'] = $request->boolean('is_used');

    if ($request->hasFile('image')) {
        if ($about->image && file_exists(public_path($about->image))) {
            @unlink(public_path($about->image));
        }
        $filename = time() . '_' . $request->file('image')->getClientOriginalName();
        $request->file('image')->move(public_path('images/abouts'), $filename);
        $data['image'] = 'images/abouts/' . $filename;
    }

    $about->update($data);
    if ($data['is_used']) {
        About::where('id', '<>', $about->id)->update(['is_used' => 0]);
    }

    return redirect()->route('admin.abouts.index')->with('success', 'Cập nhật About thành công');
}



    // Xóa
    public function destroy(About $about)
    {
        if ($about->image && file_exists(public_path($about->image))) {
            @unlink(public_path($about->image));
        }

        $about->delete();
        return redirect()->route('admin.abouts.index')->with('success', 'Xóa About thành công');
    }
}
