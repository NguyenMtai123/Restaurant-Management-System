<div class="cart-sidebar" id="cartSidebar">
  <div class="cart-header">
    <h3><i class="fas fa-shopping-cart"></i> Giỏ hàng của bạn</h3>
    <button class="close-cart" id="closeCart">&times;</button>
  </div>
  <div class="cart-body">
    <div class="cart-items" id="cartItems">
      <div class="empty-cart">
        <i class="fas fa-shopping-basket"></i>
        <p>Giỏ hàng của bạn đang trống</p>
        <a href="#menu" class="btn btn-primary">Xem thực đơn</a>
      </div>
    </div>
    <div class="cart-summary">
        <div class="summary-row">
            <span>Tạm tính:</span>
            <span class="cart-subtotal">0 đ</span>
        </div>
        <div class="summary-row">
            <span>Phí vận chuyển (VAT 10%):</span>
            <span class="cart-shipping">0 đ</span>
        </div>
        <div class="summary-row total">
            <span>Tổng tiền:</span>
            <span class="cart-total">0 đ</span>
        </div>
      <div class="coupon-section">
        <input type="text" placeholder="Nhập mã giảm giá" id="couponInput"/>
        <button class="btn btn-outline" id="applyCoupon">Áp dụng</button>
      </div>
    </div>
    <div class="cart-footer">
      <button
    type="button"
    class="btn btn-primary checkout-btn"
    id="checkoutBtn">
    <i class="fas fa-credit-card"></i>
    <span>Đặt hàng</span>
</button>
      <a href="#menu" class="btn btn-outline continue-btn">
        <i class="fas fa-utensils"></i>
        <span>Tiếp tục mua hàng</span>
      </a>
    </div>
  </div>
</div>
<div class="cart-overlay" id="cartOverlay"></div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
const Toast = Swal.mixin({
    toast: true,
    position: 'top-start',
    showConfirmButton: false,
    timer: 2500,
    timerProgressBar: true,
    showCloseButton: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
});

function showSuccess(msg){
    Toast.fire({
        icon: 'success',
        title: msg
    });
}

function showError(msg){
    Toast.fire({
        icon: 'error',
        title: msg
    });
}

function showInfo(msg){
    Toast.fire({
        icon: 'info',
        title: msg
    });
}
</script>

<script>
document.getElementById('checkoutBtn').addEventListener('click', function () {
    const btn = this;

    // 1. Xác nhận đặt hàng
    Swal.fire({
        title: 'Xác nhận đặt hàng?',
        text: 'Bạn có chắc chắn muốn đặt hàng không?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Đặt hàng',
        cancelButtonText: 'Hủy',
        confirmButtonColor: '#0d6efd',
        cancelButtonColor: '#6c757d'
    }).then(result => {
        if (!result.isConfirmed) return;

        // 2. Loading
        btn.disabled = true;
        btn.innerHTML = `<i class="fas fa-spinner fa-spin"></i> Đang xử lý...`;

        fetch('/checkout', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ order_type: 'take-away' })
        })
        .then(res => {
            if (!res.ok) {
                return res.json().then(err => {
                    throw new Error(err.error || 'Lỗi server');
                });
            }
            return res.json();
        })
        .then(data => {
            if (!data.success) {
                throw new Error(data.error || 'Đặt hàng thất bại');
            }

            // 3. THÔNG BÁO THÀNH CÔNG (MODAL)
            Swal.fire({
                icon: 'success',
                title: 'Đặt hàng thành công 🎉',
                html: `
                    <p><b>Mã đơn:</b> ${data.order.order_number}</p>
                    <p><b>Tổng tiền:</b> ${Number(data.order.total_amount).toLocaleString()} đ</p>
                `,
                confirmButtonText: 'Thanh toán ngay'
            }).then(() => {
                window.location.href = '/payment/' + data.order.id;
            });
        })
        .catch(err => {
            Swal.fire({
                icon: 'error',
                title: 'Đặt hàng thất bại ❌',
                text: err.message,
                confirmButtonText: 'Thử lại'
            });
        })
        .finally(() => {
            btn.disabled = false;
            btn.innerHTML = `
                <i class="fas fa-credit-card"></i>
                <span>Đặt hàng</span>
            `;
        });
    });
});

document.getElementById('applyCoupon').addEventListener('click', function(){
    const btn = this;
    const code = document.getElementById('couponInput').value.trim();

    if(!code){
        showInfo('Vui lòng nhập mã giảm giá');
        return;
    }

    btn.disabled = true;
    btn.innerHTML = `<i class="fas fa-spinner fa-spin"></i>`;

    fetch('/apply-coupon', {
        method: 'POST',
        headers: {
            'Content-Type':'application/json',
            'X-CSRF-TOKEN':'{{ csrf_token() }}'
        },
        body: JSON.stringify({ coupon_code: code })
    })
    .then(res => res.json())
    .then(data => {
        if(data.success){
            showSuccess(`${data.message} (-${Number(data.discount_amount).toLocaleString()} đ)`);

            const subtotalEl = document.querySelector('.cart-subtotal');
            const subtotal = Number(subtotalEl.innerText.replace(/\D/g,''));

            const shipping = data.shipping_discount ? 0 : subtotal * 0.1;

            document.querySelector('.cart-shipping').innerText =
                shipping.toLocaleString() + ' đ';

            const total = subtotal + shipping - data.discount_amount;
            document.querySelector('.cart-total').innerText =
                total.toLocaleString() + ' đ';
        } else {
            showError(data.error || 'Áp dụng mã thất bại');
        }
    })
    .catch(() => {
        showError('Không thể kết nối server');
    })
    .finally(() => {
        btn.disabled = false;
        btn.innerHTML = 'Áp dụng';
    });
});

</script>
