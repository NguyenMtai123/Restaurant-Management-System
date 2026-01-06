<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\MenuItem;
use App\Models\MenuItemImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MenuItemImageController extends Controller
{
    public function index(MenuItem $menuItem)
    {
        $images = $menuItem->images()->orderByDesc('is_featured')->get();
        return view('admin.menu-items._images', compact('images'));
    }

    public function store(Request $request, MenuItem $menuItem)
    {
        $request->validate([
            'images.*' => 'required|image|mimes:jpg,jpeg,png,gif|max:4096'
        ]);

        foreach ($request->file('images') as $index => $file) {

            $name = time() . '_' . uniqid() . '_' .
                preg_replace('/\s+/', '_', $file->getClientOriginalName());

            $file->move(public_path('images/menu'), $name);

            $menuItem->images()->create([
                'image_path' => 'images/menu/' . $name,
                'is_featured' => $menuItem->images()->count() == 0 && $index == 0
            ]);
        }

        return response()->json(['success' => true]);
    }

    public function destroy(MenuItemImage $image)
    {
        if (file_exists(public_path($image->image_path))) {
            @unlink(public_path($image->image_path));
        }

        $image->delete();

        return response()->json(['success' => true]);
    }

        public function setFeatured(MenuItemImage $image)
        {
            MenuItemImage::where('menu_item_id', $image->menu_item_id)
                ->update(['is_featured' => false]);

            $image->update(['is_featured' => true]);

            return response()->json([
                'success' => true,
                'image_id' => $image->id,
                'image_path' => asset($image->image_path),
                'menu_item_id' => $image->menu_item_id
            ]);
        }

}
