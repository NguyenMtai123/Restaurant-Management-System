<!DOCTYPE html>
<html>
<body style="font-family:Arial;background:#f6f6f6;padding:20px">

<div style="max-width:650px;margin:auto;background:#fff;padding:20px">
    <h2>Xin chào {{ $user->name }}</h2>

    <p>Bạn vừa nhận được các mã ưu đãi sau:</p>

    <table width="100%" cellpadding="8" cellspacing="0" border="1">
    <thead style="background:#eee">
        <tr>
            <th>Mã</th>
            <th>Mô tả</th> <!-- ✅ -->
            <th>Giảm</th>
            <th>Đơn tối thiểu</th>
            <th>Hạn dùng</th>
        </tr>
    </thead>
    <tbody>
    @foreach($coupons as $coupon)
        <tr>
            <td><strong>{{ $coupon->code }}</strong></td>

            <td>
                {{ $coupon->description ?: '—' }} <!-- ✅ -->
            </td>

            <td>
                {{ $coupon->type == 'percent'
                    ? $coupon->value.'%'
                    : number_format($coupon->value).'đ' }}
            </td>

            <td>
                {{ $coupon->min_order
                    ? number_format($coupon->min_order).'đ'
                    : 'Không yêu cầu' }}
            </td>

            <td>{{ $coupon->end_date->format('d/m/Y') }}</td>
        </tr>
    @endforeach
    </tbody>
    </table>


    <p style="margin-top:15px">
        ⚠ Mỗi mã chỉ sử dụng 1 lần và trong thời gian hiệu lực.
    </p>

    <p>Chúc bạn mua sắm vui vẻ 🎉</p>
</div>

</body>
</html>
