<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FoodController extends Controller
{
    private $foods = [];

    public function index()
    {
        return response()->json($this->foods);
    }

    public function store(Request $request)
    {
        return response()->json([
            'message' => 'Đã thêm món (mock data, không có DB)'
        ]);
    }
}
