<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CouponEmail extends Model
{
    protected $fillable = ['coupon_id','email','sent_at'];

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }
}
