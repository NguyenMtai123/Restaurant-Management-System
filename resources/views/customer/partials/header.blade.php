<header class="header">
    <div class="container">
        <div class="logo">
            <a href="#home">
                <i class="fas fa-utensils"></i>
                <div class="logo-text">
                    <span class="logo-main">Take Away</span>
                    <span class="logo-sub">Express</span>
                </div>
            </a>
        </div>

        <nav class="nav">
            <ul>
                <li><a href="/" class="nav-link active"><i class="fas fa-home"></i> Trang chủ</a></li>
                <li><a href="{{ route('home') }}#about" class="nav-link"><i class="fas fa-info-circle"></i> Giới thiệu</a></li>
                <li><a href="{{ route('home') }}#menu" class="nav-link"><i class="fas fa-utensils"></i> Thực đơn</a></li>
                <li><a href="{{ route('home') }}#deals" class="nav-link"><i class="fas fa-tags"></i> Ưu đãi</a></li>
                <li><a href="{{ route('home') }}#order" class="nav-link"><i class="fas fa-shopping-bag"></i> Đặt hàng</a></li>
                <li><a href="{{ route('home') }}#contact" class="nav-link"><i class="fas fa-phone-alt"></i> Liên hệ</a></li>
            </ul>
        </nav>

        <div class="header-actions">
            @include('customer.partials.header_search')
            @include('customer.partials.header_user')
            <button class="cart-btn" id="cartToggle"><i class="fas fa-shopping-cart"></i><span class="cart-count">0</span></button>
        </div>

        <button class="mobile-menu-toggle" id="mobileMenuToggle">
            <i class="fas fa-bars"></i>
        </button>
    </div>
</header>
