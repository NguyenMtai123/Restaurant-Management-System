<?php

namespace App\Http\Controllers\Api\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Home_Staff_Controller extends Controller
{
    public function dashboard()
    {
        return response()->json(['message' => 'Staff Dashboard']);
    }
}
