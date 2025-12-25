<footer class="footer">
    <div class="container">
        <div class="footer-content">
            <!-- Column 1: Logo + Giới thiệu -->
            <div class="footer-column">
                <div class="footer-logo">
                    <i class="fas fa-utensils"></i>
                    <div class="logo-text">
                        <span class="logo-main">Take Away</span>
                        <span class="logo-sub">Express</span>
                    </div>
                </div>
                <p>Nhà hàng chuyên phục vụ đồ ăn mang về chất lượng cao với dịch vụ nhanh chóng, tiện lợi.</p>
               <div class="footer-newsletter">
                    <h4>Đăng ký nhận mã</h4>
                    <a href="{{ route('register') }}" class="btn btn-primary">
                        <i class="fas fa-paper-plane"></i> Đăng ký
                    </a>
                </div>

            </div>

            <!-- Column 2: Liên kết nhanh -->
            <div class="footer-column">
                <h3>Liên kết nhanh</h3>
                <ul>
                    <li><a href="#home"><i class="fas fa-chevron-right"></i> Trang chủ</a></li>
                    <li><a href="#about"><i class="fas fa-chevron-right"></i> Giới thiệu</a></li>
                    <li><a href="#menu"><i class="fas fa-chevron-right"></i> Thực đơn</a></li>
                    <li><a href="#deals"><i class="fas fa-chevron-right"></i> Ưu đãi</a></li>
                    <li><a href="#order"><i class="fas fa-chevron-right"></i> Đặt hàng</a></li>
                </ul>
            </div>

            <!-- Column 3: Chính sách -->
            <div class="footer-column">
                <h3>Chính sách</h3>
                <ul>
                    <li>
                        <a href="{{ route('policy.privacy') }}">
                            <i class="fas fa-chevron-right"></i> Chính sách bảo mật
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('policy.terms') }}">
                            <i class="fas fa-chevron-right"></i> Điều khoản dịch vụ
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('policy.shipping') }}">
                            <i class="fas fa-chevron-right"></i> Chính sách giao hàng
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('policy.refund') }}">
                            <i class="fas fa-chevron-right"></i> Chính sách hoàn tiền
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('policy.faq') }}">
                            <i class="fas fa-chevron-right"></i> Câu hỏi thường gặp
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Column 4: Tải ứng dụng -->
            <div class="footer-column">
                <h3>Tải ứng dụng</h3>
                <p>Tải ứng dụng để đặt hàng dễ dàng hơn và nhận nhiều ưu đãi.</p>
                <div class="app-buttons">
                    <a href="#" class="app-btn"><i class="fab fa-apple"></i><div><span>Tải trên</span><strong>App Store</strong></div></a>
                    <a href="#" class="app-btn"><i class="fab fa-google-play"></i><div><span>Tải trên</span><strong>Google Play</strong></div></a>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; 2023 <strong>Take Away Express</strong>. Tất cả các quyền được bảo lưu.</p>
            <div class="payment-methods">
                <i class="fab fa-cc-visa"></i>
                <i class="fab fa-cc-mastercard"></i>
                <i class="fab fa-cc-paypal"></i>
                <i class="fab fa-cc-apple-pay"></i>
            </div>
        </div>
    </div>
</footer>
