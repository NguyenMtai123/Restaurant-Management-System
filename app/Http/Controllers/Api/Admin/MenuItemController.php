<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Category;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;

class MenuItemController extends Controller
{
    public function index()
    {
        $menuItems = MenuItem::with('category', 'featuredImage')->latest()->paginate(20);
        return view('admin.menu-items.index', compact('menuItems'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.menu-items.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:menu_categories,id',
            'name' => 'required|string|max:100',
            'slug' => 'nullable|string|max:150|unique:menu_items,slug',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'is_available' => 'nullable|boolean',
            'images.*' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:4096'
        ]);

        $data = $request->only(['category_id','name','description','price']);
        $data['is_available'] = $request->has('is_available') ? (bool)$request->is_available : true;

        // slug
        if (empty($request->slug)) {
            $slug = Str::slug($request->name);
            $count = MenuItem::where('slug', 'like', $slug . '%')->count();
            $data['slug'] = $count ? ($slug . '-' . ($count + 1)) : $slug;
        } else {
            $data['slug'] = $request->slug;
        }

        $menuItem = MenuItem::create($data);

        // Nếu có ảnh upload qua form create (images[])
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $idx => $file) {
                $name = time() . '_' . uniqid() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
                $file->move(public_path('images/menu'), $name);

                $menuItem->images()->create([
                    'image_path' => 'images/menu/' . $name,
                    'is_featured' => ($idx === 0) ? true : false, // ảnh đầu làm featured nếu chưa có
                ]);
            }
        }

        // Nếu request Ajax -> trả về JSON
        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Đã thêm món', 'data' => $menuItem], 201);
        }

        return redirect()->route('admin.menu-items.index')->with('success', 'Thêm món thành công');
    }

    public function show(MenuItem $menu_item)
    {
        $menu_item->load('images', 'category');
        return view('admin.menu-items.show', ['menuItem' => $menu_item]);
    }

    public function edit(MenuItem $menu_item)
    {
        $categories = Category::all();
        $menu_item->load('images');
        return view('admin.menu-items.edit', compact('menu_item', 'categories'));
    }

    public function update(Request $request, MenuItem $menu_item)
    {
        $request->validate([
            'category_id' => 'required|exists:menu_categories,id',
            'name' => 'required|string|max:100',
            'slug' => 'nullable|string|max:150|unique:menu_items,slug,' . $menu_item->id,
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'is_available' => 'nullable|boolean',
            'images.*' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:4096'
        ]);

        $data = $request->only(['category_id','name','description','price']);
        $data['is_available'] = $request->has('is_available') ? (bool)$request->is_available : true;

        if (empty($request->slug)) {
            $slug = Str::slug($request->name);
            $count = MenuItem::where('slug', 'like', $slug . '%')->where('id','<>',$menu_item->id)->count();
            $data['slug'] = $count ? ($slug . '-' . ($count + 1)) : $slug;
        } else {
            $data['slug'] = $request->slug;
        }

        $menu_item->update($data);

        // Nếu upload ảnh trực tiếp kèm form update -> chuyển sang MenuItemImageController.upload
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $name = time() . '_' . uniqid() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
                $file->move(public_path('images/menu'), $name);

                $menu_item->images()->create([
                    'image_path' => 'images/menu/' . $name,
                    'is_featured' => false,
                ]);
            }
        }

        if ($request->ajax()) {
            return response()->json(['success'=>true,'message'=>'Cập nhật thành công','data'=>$menu_item]);
        }

        return redirect()->route('admin.menu-items.index')->with('success','Cập nhật thành công');
    }

    public function destroy(Request $request, MenuItem $menu_item)
    {
        // xóa file ảnh vật lý
        foreach ($menu_item->images as $img) {
            if (file_exists(public_path($img->image_path))) {
                @unlink(public_path($img->image_path));
            }
            $img->delete();
        }

        $menu_item->delete();

        if ($request->ajax()) {
            return response()->json(['success'=>true,'message'=>'Đã xóa món']);
        }

        return redirect()->route('admin.menu-items.index')->with('success','Đã xóa món');
    }
}
