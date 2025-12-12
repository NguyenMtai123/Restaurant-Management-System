<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // Tên bảng nếu khác mặc định (optional)
    protected $table = 'menu_categories';

    // Các cột có thể fill
    protected $fillable = [
        'name',
        'slug',
        'description', // nếu bạn muốn fill description
    ];

    /**
     * Quan hệ 1-n: 1 category có nhiều menu items
     */
    public function menuItems()
    {
        return $this->hasMany(MenuItem::class, 'category_id', 'id');
    }
}
