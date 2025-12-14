<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Restaurant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RestaurantController extends Controller
{
    public function index()
    {
        $restaurants = Restaurant::latest()->get();
        return view('admin.restaurants.index', compact('restaurants'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
        ]);

        Restaurant::create($request->all());

        return redirect()->route('admin.restaurants.index')->with('success','Thêm nhà hàng thành công');
    }

    public function update(Request $request, Restaurant $restaurant)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
        ]);

        $restaurant->update($request->all());

        return redirect()->route('admin.restaurants.index')->with('success','Cập nhật nhà hàng thành công');
    }

    public function destroy(Restaurant $restaurant)
    {
        $restaurant->delete();
        return redirect()->route('admin.restaurants.index')->with('success','Xóa nhà hàng thành công');
    }
}
