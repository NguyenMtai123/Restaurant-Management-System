@extends('customer.layouts.app')

@section('content')
<h2>Thanh toán đơn #{{ $order->order_number }}</h2>
<p>Tổng tiền: {{ number_format($order->total_amount) }} đ</p>

<form id="paymentForm">
    @csrf
    <label>Chọn phương thức thanh toán:</label>
    <select name="method" id="paymentMethod" required>
        <option value="cash">Tiền mặt</option>
        <option value="credit_card">Thẻ tín dụng</option>
        <option value="bank_transfer">Chuyển khoản</option>
        <option value="online">Thanh toán online</option>
    </select>
    <button type="submit">Xác nhận thanh toán</button>
</form>

<script>
document.getElementById('paymentForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const method = document.getElementById('paymentMethod').value;

    fetch('/payment/{{ $order->id }}', { // web route POST
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ method })
    })
    .then(res => res.json())
    .then(data => {
        if(data.success){
            alert(data.message);
            window.location.href = '/orders/{{ $order->id }}';
        } else {
            alert(data.error || 'Thanh toán lỗi');
        }
    });
});
</script>
@endsection
