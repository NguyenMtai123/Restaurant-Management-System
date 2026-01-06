<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['user_id','parent_id','content_menu','rating','is_approved'];

    public function menuItem()
    {
        return $this->belongsTo(MenuItem::class, 'commentable_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function replies()
    {
        return $this->hasMany(Comment::class,'parent_id');
    }
}
