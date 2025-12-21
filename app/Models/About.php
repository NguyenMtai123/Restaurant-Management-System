<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content_contact',
        'image',
        'address',
        'map_embed',
        'phone',
        'email',
        'is_used'
    ];
    protected $casts = [
        'is_used' => 'boolean'
    ];
}
