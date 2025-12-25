<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'code','name','description','type','value',
        'max_uses','used','min_order',
        'start_date','end_date','is_active'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date'   => 'datetime',
        'is_active'  => 'boolean'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class)
            ->withPivot(['is_used','sent_at','used_at']);
    }

    public function isAvailable(): bool
    {
        return $this->is_active
            && $this->used < $this->max_uses
            && now()->between($this->start_date, $this->end_date);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

}
