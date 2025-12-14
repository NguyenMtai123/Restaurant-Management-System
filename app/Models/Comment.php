<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['user_id','parent_id','content_menu','rating','is_approved'];

    // Polymorphic: bình luận cho menu_item hoặc restaurant
    public function commentable()
    {
        return $this->morphTo();
    }

    // Relation: người tạo comment
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Bình luận con (reply)
    public function replies()
    {
        return $this->hasMany(Comment::class,'parent_id');
    }
}
