@extends('customer.layouts.app')

@section('content')
<div class="invoice-container" style="max-width: 800px; margin: 50px auto; padding: 30px; background: #fff; border-radius: 10px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
    <h2 style="text-align:center; margin-bottom: 20px;">Hóa đơn thanh toán #{{ $order->order_number }}</h2>
    <p style="text-align:center; font-weight:bold; color: {{ $order->status == 'paid' ? '#198754' : '#ffc107' }};">
        Trạng thái: {{ ucfirst($order->status) }}
    </p>

    <div style="display:flex; justify-content:space-between; margin-bottom: 20px;">
        <div>
            <p><strong>Khách hàng:</strong> {{ $order->user->name }}</p>
            <p><strong>Email:</strong> {{ $order->user->email }}</p>
            <p><strong>Địa chỉ:</strong> {{ $order->address ?? $order->user->address ?? 'Chưa cập nhật' }}</p>
            <p><strong>SĐT:</strong> {{ $order->user->phone ?? 'Chưa cập nhật' }}</p>
        </div>
        <div>
            <p><strong>Ngày đặt:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
            <p><strong>Phương thức:</strong> {{ $order->payments->last()?->method ?? 'Chưa thanh toán' }}</p>
        </div>
    </div>


    <table style="width:100%; border-collapse:collapse; margin-bottom:20px;">
        <thead style="background:#f8f9fa;">
            <tr>
                <th style="padding:10px; border:1px solid #dee2e6;">Món</th>
                <th style="padding:10px; border:1px solid #dee2e6;">Số lượng</th>
                <th style="padding:10px; border:1px solid #dee2e6;">Giá</th>
                <th style="padding:10px; border:1px solid #dee2e6;">Thành tiền</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->orderItems as $item)
            <tr>
                <td style="padding:10px; border:1px solid #dee2e6;">{{ $item->menuItem->name }}</td>
                <td style="padding:10px; border:1px solid #dee2e6; text-align:center;">{{ $item->quantity }}</td>
                <td style="padding:10px; border:1px solid #dee2e6; text-align:right;">{{ number_format($item->unit_price, 0, ',', '.') }} đ</td>
                <td style="padding:10px; border:1px solid #dee2e6; text-align:right;">{{ number_format($item->quantity * $item->unit_price, 0, ',', '.') }} đ</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div style="text-align:right; margin-bottom:20px;">
        <p>Tạm tính: <strong>{{ number_format($order->subtotal, 0, ',', '.') }} đ</strong></p>

        @if($order->discount_amount && $order->discount_amount > 0)
            <p>Giảm giá ({{ $order->coupon?->code ?? 'Mã giảm giá' }}):
                <strong>-{{ number_format($order->discount_amount, 0, ',', '.') }} đ</strong>
            </p>
        @endif

        <p>Phí vận chuyển (VAT 10%): <strong>{{ number_format($order->tax, 0, ',', '.') }} đ</strong></p>

        <p style="font-size:1.2rem;">
            <strong>
                Tổng cộng:
                {{ number_format($order->subtotal + $order->tax - ($order->discount_amount ?? 0), 0, ',', '.') }} đ
            </strong>
        </p>
    </div>


    <div style="text-align:center;">
        <a href="/customer/home" style="display:inline-block; padding:10px 20px; background:#0d6efd; color:#fff; border-radius:5px; text-decoration:none;">Quay về trang chủ</a>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Thanh toán thành công 🎉',
            html: `<p>{{ session('success') }}</p>`,
            confirmButtonText: 'OK'
        });
    @elseif(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Thanh toán thất bại ❌',
            html: `<p>{{ session('error') }}</p>`,
            confirmButtonText: 'OK'
        });
    @endif
});

document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener("click", function(e){
        e.preventDefault();
        const href = this.getAttribute("href");

        if(href === "#") return;

        // Kiểm tra xem section có tồn tại không
        const target = document.querySelector(href);
        if(target){
            // Section có trên trang → scroll bình thường
            window.scrollTo({
                top: target.offsetTop - 100,
                behavior: "smooth"
            });
        } else {
            // Section không có → chuyển về home và scroll sau khi load
            window.location.href = "{{ route('home') }}" + href;
        }
    });
});

</script>
@endsection
