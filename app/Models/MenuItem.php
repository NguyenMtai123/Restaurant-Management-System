<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'is_available',
    ];

    /**
     * MenuItem thuộc về 1 category
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    /**
     * MenuItem có nhiều hình ảnh
     */
    // public function images()
    // {
    //     return $this->hasMany(MenuItemImage::class, 'menu_item_id');
    // }

    /**
     * MenuItem có thể được nhiều cart item
     */
    public function cartItems()
    {
        return $this->hasMany(CartItem::class, 'item_id');
    }

    /**
     * MenuItem có thể được nhiều order item
     */
    // public function orderItems()
    // {
    //     return $this->hasMany(OrderItem::class, 'menu_item_id');
    // }
}
