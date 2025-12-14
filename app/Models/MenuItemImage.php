<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MenuItemImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'menu_item_id',
        'image_path',
        'is_featured'
    ];

    // Thêm accessor 'url' vào JSON khi serialize
    protected $appends = ['url'];

    public function menuItem()
    {
        return $this->belongsTo(MenuItem::class);
    }

    public function getUrlAttribute()
    {
        // trả về đường dẫn đầy đủ (asset)
        return asset($this->image_path);
    }
}
