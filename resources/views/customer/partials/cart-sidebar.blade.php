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
        <span>Phí vận chuyển:</span>
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
      <button class="btn btn-primary checkout-btn" id="checkoutBtn">
        <i class="fas fa-credit-card"></i>
        <span>Thanh toán</span>
      </button>
      <a href="#menu" class="btn btn-outline continue-btn">
        <i class="fas fa-utensils"></i>
        <span>Tiếp tục mua hàng</span>
      </a>
    </div>
  </div>
</div>
<div class="cart-overlay" id="cartOverlay"></div>
<script>
document.getElementById('checkoutBtn').addEventListener('click', function() {
    // Thêm feedback cho người dùng biết đang xử lý
    this.disabled = true;
    this.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Đang xử lý...';

    fetch('/checkout', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        // Thêm body rỗng để đảm bảo request hợp lệ hơn, mặc dù không cần dữ liệu cụ thể
        body: JSON.stringify({ order_type: 'take-away' })
    })
    .then(res => {
        // Luôn kiểm tra res.ok trước khi gọi res.json()
        if (!res.ok) {
            // Nếu response status là 4xx hoặc 5xx, đọc lỗi từ server
            return res.json().then(err => { throw new Error(err.error || 'Lỗi mạng hoặc server'); });
        }
        return res.json();
    })
    .then(data => {
        if(data.success) {
            alert(data.message); // hoặc show toast
           window.location.href = '/payment/' + data.order.id;
        } else {
            // Trường hợp server trả về success: false với thông báo lỗi tùy chỉnh
            alert(data.error || 'Có lỗi xảy ra');
        }
    })
    .catch(err => {
        console.error(err);
        alert('Lỗi: ' + err.message);
    })
    .finally(() => {
        // Đảm bảo nút được kích hoạt lại nếu có lỗi
        this.disabled = false;
        this.innerHTML = '<i class="fas fa-credit-card"></i><span>Thanh toán</span>';
    });
});
</script>
