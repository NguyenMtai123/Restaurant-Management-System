<?php
namespace App\Models;

use Favorite;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MenuItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'is_available',
    ];

    protected $appends = ['featured_image_url'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function images()
    {
        return $this->hasMany(MenuItemImage::class);
    }

    public function featuredImage()
    {
        return $this->hasOne(MenuItemImage::class)->where('is_featured', true);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'commentable_id', 'id');
    }

    public function getFeaturedImageUrlAttribute()
    {
        // Nếu relation images đã được eager-loaded, dùng collection để tránh query
        if ($this->relationLoaded('images')) {
            $img = $this->images->firstWhere('is_featured', 1);
            if ($img) {
                return $img->url;
            }
        }

        // fallback: nếu relation featuredImage đã được eager-loaded
        if ($this->relationLoaded('featuredImage') && $this->featuredImage) {
            return $this->featuredImage->url;
        }

        // cuối cùng: thử lấy via relation (lazy) hoặc trả ảnh mặc định
        $img = $this->images()->where('is_featured', 1)->first();
        if ($img) {
            return $img->url;
        }

        return asset('images/menu/default.png');
    }

}
