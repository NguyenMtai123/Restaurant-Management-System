<?php
namespace App\Mail;

use App\Models\User;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Collection;

class MultiCouponMail extends Mailable
{
    public function __construct(
        public Collection $coupons,
        public User $user
    ) {}

    public function build()
    {
        return $this->subject('🎁 Bạn nhận được mã giảm giá')
            ->view('emails.coupons-multi');
    }
}
