<?php
namespace App\Http\Controllers\Api\Admin;

use App\Models\User;
use App\Models\Coupon;
use App\Mail\CouponMail;
use App\Models\CouponEmail;
use Illuminate\Http\Request;
use App\Mail\MultiCouponMail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::latest()->paginate(5);
        return view('admin.coupons.index', compact('coupons'));
    }

    public function store(Request $request)
    {
        Coupon::create($request->validate([
            'code' => 'required|unique:coupons',
            'name' => 'required',
            'description' => 'nullable|string',
            'type' => 'required',
            'value' => 'required|integer',
            'max_uses' => 'required|integer',
            'min_order' => 'nullable|numeric',
            'start_date' => 'required',
            'end_date' => 'required',
            'is_active' => 'boolean'
        ]));

        return redirect()->route('admin.coupons.index')
            ->with('success','Tạo mã thành công');
    }


    public function update(Request $request, Coupon $coupon)
    {
        $coupon->update($request->all());
        return back()->with('success','Cập nhật thành công');
    }

    public function destroy(Coupon $coupon)
    {
        $coupon->delete();
        return back()->with('success','Đã xóa mã');
    }

    public function sendMultiple(Request $request)
    {
        $request->validate([
            'coupons' => 'required|array',
            'users'   => 'required|array',
        ]);

        $coupons = Coupon::whereIn('id',$request->coupons)->get();
        $users   = User::whereIn('id',$request->users)->get();

        foreach ($users as $user) {

            $sendCoupons = collect();

            foreach ($coupons as $coupon) {

                if ($coupon->users()
                    ->where('user_id',$user->id)
                    ->exists()) {
                    continue;
                }

                $coupon->users()->attach($user->id,[
                    'sent_at' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $sendCoupons->push($coupon);
            }

            if ($sendCoupons->isNotEmpty()) {
                Mail::to($user->email)
                    ->send(new MultiCouponMail($sendCoupons,$user));
            }
        }

        return back()->with('success','Đã gửi nhiều mã (1 mail / user)');
    }

}
