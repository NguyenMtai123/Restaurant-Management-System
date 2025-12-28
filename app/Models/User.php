<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Các thuộc tính có thể gán hàng loạt.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'avatar',
        'role_id', // ✅ đúng
        'status',
        'email_verified_at',
    ];


    /**
     * Các thuộc tính ẩn khi serialize.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Các kiểu dữ liệu cần cast.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed', // Laravel 10+ tự hash khi lưu
    ];

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function coupons()
    {
        return $this->belongsToMany(\App\Models\Coupon::class)
            ->withPivot(['is_used','sent_at','used_at']);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    // Check permission
    public function hasPermission(string $permissionKey): bool
    {
        if (!$this->role) {
            return false;
        }

        return $this->role
            ->permissions()
            ->where('key', $permissionKey)
            ->exists();
    }

}
