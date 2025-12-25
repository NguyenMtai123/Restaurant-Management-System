<?php
namespace App\Mail;

use App\Models\Coupon;
use App\Models\User;
use Illuminate\Mail\Mailable;

class CouponMail extends Mailable
{
    public function __construct(
        public Coupon $coupon,
        public User $user
    ) {}

    public function build()
    {
        return $this->subject('🎉 Mã giảm giá dành cho bạn')
            ->view('emails.coupon');
    }
}
