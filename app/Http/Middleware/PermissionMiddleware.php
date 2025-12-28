<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PermissionMiddleware
{
    public function handle(Request $request, Closure $next, $permission)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Nếu user có quyền (permission) thì cho phép đi tiếp
        if ($user->hasPermission($permission)) {
            return $next($request);
        }

        // Nếu không có quyền
        abort(403, 'Bạn không có quyền truy cập.');
    }
}
