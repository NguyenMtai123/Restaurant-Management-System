@extends('customer.layouts.app')

@section('content')
    <div class="payment-container"
        style="max-width: 500px; margin: 50px auto; padding: 30px; background-color: #fff; border-radius: 10px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
        <h2 style="text-align: center; margin-bottom: 20px;">Thanh toán đơn #{{ $order->order_number }}</h2>
        <p style="text-align: center; font-size: 18px; margin-bottom: 30px;">Tổng tiền:
            <strong>{{ number_format($order->total_amount) }} đ</strong>
        </p>

        <form id="paymentForm" method="POST" action="{{ route('payment.pay', $order->id) }}">
            @csrf
            <div style="margin-bottom: 20px;">
                <label for="paymentMethod" style="font-weight: bold;">Chọn phương thức thanh toán:</label>
                <select name="method" id="paymentMethod" required
                    style="width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #ccc;">
                    <option value="cash">Tiền mặt</option>
                    <option value="online">Thanh toán online</option>
                </select>
            </div>

            <button type="submit" id="submitBtn"
                style="width: 100%; padding: 12px; background-color: #1a202c; color: #fff; font-weight: bold; border: none; border-radius: 5px; cursor: pointer; position: relative;">
                <span id="btnText">Xác nhận thanh toán</span>
                <span id="btnLoader"
                    style="display:none; position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%);">
                    <svg xmlns="http://www.w3.org/2000/svg" style="margin: auto; background: none; display: block;"
                        width="24px" height="24px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
                        <circle cx="50" cy="50" r="32" stroke-width="8" stroke="#fff"
                            stroke-dasharray="50.26548245743669 50.26548245743669" fill="none" stroke-linecap="round">
                            <animateTransform attributeName="transform" type="rotate" repeatCount="indefinite"
                                dur="1s" values="0 50 50;360 50 50" keyTimes="0;1"></animateTransform>
                        </circle>
                    </svg>
                </span>
            </button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.getElementById('paymentForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const method = document.getElementById('paymentMethod').value;
            const btn = document.getElementById('submitBtn');
            const btnText = document.getElementById('btnText');
            const btnLoader = document.getElementById('btnLoader');

            btnText.style.display = 'none';
            btnLoader.style.display = 'inline-block';
            btn.disabled = true;

            fetch("{{ route('payment.pay', $order->id) }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        method
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success && data.redirect) {
                        // Thanh toán online → redirect VNPay
                        window.location.href = data.redirect;
                    } else if (data.success) {
                        // Thanh toán thành công → show thông báo
                        Swal.fire({
                            icon: 'success',
                            title: 'Thanh toán thành công 🎉',
                            html: `<p>Mã đơn: <strong>{{ $order->order_number }}</strong></p>
                       <p>Tổng tiền: <strong>{{ number_format($order->total_amount) }} đ</strong></p>
                       <p>Phương thức: <strong>${method.replace('_', ' ')}</strong></p>`,
                            confirmButtonText: 'Xem đơn hàng'
                        }).then(() => {
                            window.location.href = '/orders/{{ $order->id }}';
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Thanh toán thất bại ❌',
                            text: data.error || 'Có lỗi xảy ra'
                        });
                        btnText.style.display = 'inline';
                        btnLoader.style.display = 'none';
                        btn.disabled = false;
                    }
                })
                .catch(() => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Có lỗi xảy ra ❌',
                        text: 'Vui lòng thử lại!'
                    });
                    btnText.style.display = 'inline';
                    btnLoader.style.display = 'none';
                    btn.disabled = false;
                });
        });

        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener("click", function(e) {
                e.preventDefault();
                const href = this.getAttribute("href");

                if (href === "#") return;

                // Kiểm tra xem section có tồn tại không
                const target = document.querySelector(href);
                if (target) {
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
