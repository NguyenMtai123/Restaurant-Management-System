<!DOCTYPE html>
<html lang="vi">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Take Away Express - Đồ Ăn Mang Về Chất Lượng Cao</title>
    <link rel="stylesheet" href="{{ asset('css/home.css') }}" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Roboto:wght@400;500;700;900&display=swap"
      rel="stylesheet"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
    />
     <style>
     .menu-items {
    display: flex;
    flex-wrap: wrap;
    gap: 20px; /* Khoảng cách giữa các món */
    justify-content: center; /* Canh giữa */
    margin-top: 20px;
}

.menu-item {
    background: #fff;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    flex: 1 1 250px; /* Tự động co giãn, min-width 250px */
    max-width: 300px; /* Giới hạn chiều rộng */
    display: flex;
    flex-direction: column;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.menu-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.15);
}

.menu-image img {
    width: 100%;
    height: 180px;
    object-fit: cover;
}

.menu-content {
    padding: 15px;
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.menu-content h4 {
    font-size: 1.1rem;
    margin-bottom: 10px;
}

.menu-content p {
    font-size: 0.9rem;
    color: #555;
    flex: 1;
}

.menu-price {
    font-weight: bold;
    margin-top: 10px;
    display: block;
    color: #e63946;
}

.add-to-cart {
    margin-top: 10px;
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 5px;
}
</style>
  </head>
  <body>
    <!-- Loader -->
    <div class="loader">
      <div class="loader-content">
        <div class="loader-logo">
          <i class="fas fa-utensils"></i>
          <span>Take Away Express</span>
        </div>
        <div class="loader-spinner"></div>
      </div>
    </div>

    <!-- Notification Toast -->
    <div class="toast" id="toast"></div>

    <!-- Promotion Banner -->
    <div class="promotion-banner" id="promotionBanner">
      <div class="container">
        <span class="promotion-text"
          ><i class="fas fa-gift"></i> Ưu đãi đặc biệt: Giảm 20% cho đơn hàng
          đầu tiên | Mã: <strong>WELCOME20</strong></span
        >
        <button class="close-promotion" id="closePromotion">&times;</button>
      </div>
    </div>

    <!-- Header & Navigation -->
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
            <li>
              <a href="#home" class="nav-link active"
                ><i class="fas fa-home"></i> Trang chủ</a
              >
            </li>
            <li>
              <a href="#about" class="nav-link"
                ><i class="fas fa-info-circle"></i> Giới thiệu</a
              >
            </li>
            <li>
              <a href="#menu" class="nav-link"
                ><i class="fas fa-utensils"></i> Thực đơn</a
              >
            </li>
            <li>
              <a href="#deals" class="nav-link"
                ><i class="fas fa-tags"></i> Ưu đãi</a
              >
            </li>
            <li>
              <a href="#order" class="nav-link"
                ><i class="fas fa-shopping-bag"></i> Đặt hàng</a
              >
            </li>
            <li>
              <a href="#contact" class="nav-link"
                ><i class="fas fa-phone-alt"></i> Liên hệ</a
              >
            </li>
          </ul>
        </nav>

        <div class="header-actions">
          <div class="search-container">
            <button class="search-btn" id="searchToggle">
              <i class="fas fa-search"></i>
            </button>
            <div class="search-box" id="searchBox">
              <input
                type="text"
                placeholder="Tìm kiếm món ăn..."
                id="searchInput"
              />
              <button class="search-submit">
                <i class="fas fa-search"></i>
              </button>
            </div>
          </div>

          <a href="tel:+84912345678" class="phone-btn">
            <div class="phone-icon">
              <i class="fas fa-phone"></i>
            </div>
            <div class="phone-info">
              <span class="phone-label">Hotline</span>
              <span class="phone-number">0912 345 678</span>
            </div>
          </a>

          <div class="user-actions">
            <button class="user-btn" id="userToggle">
              <i class="fas fa-user"></i>
            </button>
            <div class="user-dropdown" id="userDropdown">
                <h4>Tài khoản</h4>
                @auth
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-user-circle"></i> {{ auth()->user()->name }}
                    </a>
                    <a href="{{ route('logout') }}" class="dropdown-item"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i> Đăng xuất
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                @else
                    <a href="{{ route('login') }}" class="dropdown-item">
                        <i class="fas fa-user-circle"></i> Đăng nhập
                    </a>
                    <a href="" class="dropdown-item">
                        <i class="fas fa-user-plus"></i> Đăng ký
                    </a>
                @endauth
                <a href="#" class="dropdown-item"><i class="fas fa-history"></i> Lịch sử đơn hàng</a>
                <a href="#" class="dropdown-item"><i class="fas fa-heart"></i> Món yêu thích</a>
            </div>

          </div>

          <button class="cart-btn" id="cartToggle">
            <i class="fas fa-shopping-cart"></i>
            <span class="cart-count">0</span>
          </button>
        </div>

        <button class="mobile-menu-toggle" id="mobileMenuToggle">
          <i class="fas fa-bars"></i>
        </button>
      </div>
    </header>

    <!-- Hero Section -->
    <section class="hero" id="home">
      <div class="container">
        <div class="hero-content">
          <div
            class="hero-badge animate__animated animate__pulse animate__infinite"
          >
            <i class="fas fa-bolt"></i>
            Giao hàng trong 30 phút
          </div>
          <h1 class="animate__animated animate__fadeInUp">
            Đồ ăn ngon, <span class="highlight">mang về ngay!</span>
          </h1>
          <p class="animate__animated animate__fadeInUp animate__delay-1s">
            Nhà hàng Take Away Express chuyên phục vụ các món ăn chất lượng cao
            với dịch vụ mang về tiện lợi. Đặt hàng online và nhận món trong 30
            phút.
          </p>
          <div
            class="hero-stats animate__animated animate__fadeInUp animate__delay-2s"
          >
            <div class="stat">
              <span class="stat-number">2,500+</span>
              <span class="stat-label">Khách hàng hài lòng</span>
            </div>
            <div class="stat">
              <span class="stat-number">500+</span>
              <span class="stat-label">Món ăn đa dạng</span>
            </div>
            <div class="stat">
              <span class="stat-number">30</span>
              <span class="stat-label">Phút giao hàng</span>
            </div>
          </div>
          <div
            class="hero-buttons animate__animated animate__fadeInUp animate__delay-2s"
          >
            <a href="#menu" class="btn btn-primary btn-icon">
              <i class="fas fa-utensils"></i>
              <span>Xem thực đơn</span>
            </a>
            <a href="#order" class="btn btn-secondary btn-icon">
              <i class="fas fa-shopping-bag"></i>
              <span>Đặt ngay</span>
            </a>
            <a
              href="https://youtube.com"
              class="btn btn-outline btn-icon"
              target="_blank"
            >
              <i class="fas fa-play-circle"></i>
              <span>Xem video</span>
            </a>
          </div>
        </div>
        <div class="hero-image">
          <div class="floating-food">
            <div class="food-item" style="top: 10%; left: 5%">
              <img
                src="https://images.unsplash.com/photo-1513104890138-7c749659a591?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&q=80"
                alt="Pizza"
              />
            </div>
            <div class="food-item" style="top: 60%; left: 75%">
              <img
                src="https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&q=80"
                alt="Burger"
              />
            </div>
            <div class="food-item" style="top: 30%; left: 80%">
              <img
                src="https://images.unsplash.com/photo-1579584425555-c3ce17fd4351?ixlib=rb-4.0.3&auto=format&fit=crop&w-300&q=80"
                alt="Sushi"
              />
            </div>
          </div>
          <div class="hero-main-image animate__animated animate__fadeInRight">
            <img
              src="https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1281&q=80"
              alt="Đồ ăn ngon mang về"
            />
          </div>
        </div>
      </div>
    </section>

    <!-- Features Section -->
    <section class="features">
      <div class="container">
        <div class="feature-card">
          <div class="feature-icon">
            <i class="fas fa-shipping-fast"></i>
          </div>
          <h3>Giao hàng nhanh</h3>
          <p>Giao hàng trong 30 phút với phí vận chuyển hợp lý</p>
        </div>
        <div class="feature-card">
          <div class="feature-icon">
            <i class="fas fa-leaf"></i>
          </div>
          <h3>Nguyên liệu tươi</h3>
          <p>100% nguyên liệu tươi ngon, đảm bảo an toàn thực phẩm</p>
        </div>
        <div class="feature-card">
          <div class="feature-icon">
            <i class="fas fa-tags"></i>
          </div>
          <h3>Giá cả hợp lý</h3>
          <p>Giá cả cạnh tranh với nhiều ưu đãi hấp dẫn</p>
        </div>
        <div class="feature-card">
          <div class="feature-icon">
            <i class="fas fa-headset"></i>
          </div>
          <h3>Hỗ trợ 24/7</h3>
          <p>Đội ngũ hỗ trợ luôn sẵn sàng giải đáp thắc mắc</p>
        </div>
      </div>
    </section>

    <!-- About Section -->
    <section class="about" id="about">
      <div class="container">
        <div class="section-header">
          <span class="section-subtitle">Về chúng tôi</span>
          <h2 class="section-title">Take Away Express</h2>
          <p class="section-desc">Mang hương vị đến tận nhà bạn</p>
        </div>

        <div class="about-content">
          <div class="about-image">
            <div class="image-frame">
              <img
                src="https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80"
                alt="Nhà hàng Take Away"
              />
            </div>
            <div class="experience-badge">
              <span class="exp-number">10+</span>
              <span class="exp-text">Năm kinh nghiệm</span>
            </div>
          </div>
          <div class="about-text">
            <h3>
              Nhà hàng chuyên về dịch vụ mang về với hơn 10 năm kinh nghiệm
            </h3>
            <p>
              Tất cả các món ăn đều được chế biến từ nguyên liệu tươi ngon nhất,
              đảm bảo vệ sinh an toàn thực phẩm. Đầu bếp của chúng tôi là những
              chuyên gia ẩm thực với nhiều năm kinh nghiệm.
            </p>
            <p>
              Với phương châm "Nhanh chóng - Tiện lợi - Chất lượng", chúng tôi
              cam kết mang đến cho khách hàng những bữa ăn ngon miệng nhất chỉ
              sau 30 phút đặt hàng.
            </p>

            <div class="about-list">
              <div class="list-item">
                <i class="fas fa-check-circle"></i>
                <span>Đầu bếp chuyên nghiệp</span>
              </div>
              <div class="list-item">
                <i class="fas fa-check-circle"></i>
                <span>Nguyên liệu tươi ngon</span>
              </div>
              <div class="list-item">
                <i class="fas fa-check-circle"></i>
                <span>Đóng gói vệ sinh</span>
              </div>
              <div class="list-item">
                <i class="fas fa-check-circle"></i>
                <span>Giao hàng nhanh chóng</span>
              </div>
            </div>

            <a href="#contact" class="btn btn-primary btn-icon">
              <i class="fas fa-phone-alt"></i>
              <span>Liên hệ ngay</span>
            </a>
          </div>
        </div>
      </div>
    </section>

    <!-- Special Deals Section -->
    <section class="deals" id="deals">
      <div class="container">
        <div class="section-header">
          <span class="section-subtitle">Ưu đãi đặc biệt</span>
          <h2 class="section-title">Khuyến mãi hấp dẫn</h2>
        </div>

        <div class="deals-container">
          <div class="deal-card featured">
            <div class="deal-badge">Hot</div>
            <div class="deal-content">
              <h3>Giảm 20% đơn đầu</h3>
              <p>Giảm ngay 20% cho đơn hàng đầu tiên</p>
              <div class="deal-code">Mã: <strong>WELCOME20</strong></div>
              <div class="deal-timer" id="dealTimer">
                <div class="timer-item">
                  <span class="timer-value" id="days">00</span>
                  <span class="timer-label">Ngày</span>
                </div>
                <div class="timer-item">
                  <span class="timer-value" id="hours">00</span>
                  <span class="timer-label">Giờ</span>
                </div>
                <div class="timer-item">
                  <span class="timer-value" id="minutes">00</span>
                  <span class="timer-label">Phút</span>
                </div>
                <div class="timer-item">
                  <span class="timer-value" id="seconds">00</span>
                  <span class="timer-label">Giây</span>
                </div>
              </div>
            </div>
          </div>

          <div class="deal-card">
            <div class="deal-content">
              <h3>Mua 1 tặng 1</h3>
              <p>Mua 1 pizza size lớn tặng 1 pizza size vừa</p>
              <div class="deal-code">Mã: <strong>BUY1GET1</strong></div>
            </div>
          </div>

          <div class="deal-card">
            <div class="deal-content">
              <h3>Freeship 0đ</h3>
              <p>Miễn phí vận chuyển cho đơn từ 200.000đ</p>
              <div class="deal-code">Mã: <strong>FREESHIP</strong></div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Menu Section -->
    <section class="menu" id="menu">
      <div class="container">
        <div class="section-header">
          <span class="section-subtitle">Thực đơn đa dạng</span>
          <h2 class="section-title">Món ăn nổi bật</h2>
          <p class="section-desc">
            Khám phá những món ăn đặc biệt của chúng tôi
          </p>
        </div>

        <div class="menu-controls">
          <div class="menu-categories">
            <button class="category-btn active" data-category="all">
                <i class="fas fa-th-large"></i>
                <span>Tất cả</span>
            </button>
            @foreach($categories as $category)
                <button class="category-btn" data-category="{{ $category->slug }}">
                    <i class="fas fa-utensils"></i>
                    <span>{{ $category->name }}</span>
                </button>
            @endforeach
        </div>


          <div class="menu-sort">
            <select id="sortSelect">
              <option value="default">Sắp xếp mặc định</option>
              <option value="price-asc">Giá: Thấp đến cao</option>
              <option value="price-desc">Giá: Cao đến thấp</option>
              <option value="name">Tên A-Z</option>
              <option value="popular">Phổ biến nhất</option>
            </select>
          </div>
        </div>

        <div class="menu-items">
            @foreach($menuItems as $item)
                <div class="menu-item" data-category="{{ $item->category->slug }}">
                    <div class="menu-image">
                        <img src="{{ asset('images/menu/' . $item->image) }}" alt="{{ $item->name }}">
                    </div>
                    <div class="menu-content">
                        <h4>{{ $item->name }}</h4>
                        <p>{{ $item->description }}</p>
                        <span class="menu-price">{{ number_format($item->price) }} đ</span>
                        <button class="btn btn-primary add-to-cart" data-id="{{ $item->id }}">
                            <i class="fas fa-shopping-cart"></i> Thêm vào giỏ
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
        <script>
            document.querySelectorAll('.category-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const category = btn.dataset.category;
                document.querySelectorAll('.menu-item').forEach(item => {
                    if(category === 'all' || item.dataset.category === category) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        });

        </script>
        {{-- <div class="menu-items" id="menuItems">
          <!-- Món ăn sẽ được tải động bằng JavaScript -->
        </div> --}}

        <div class="menu-footer">
          <button class="btn btn-outline" id="loadMore">
            <i class="fas fa-redo"></i>
            <span>Xem thêm món ăn</span>
          </button>
        </div>
      </div>
    </section>

    <!-- Testimonials Section -->
    <section class="testimonials">
      <div class="container">
        <div class="section-header">
          <span class="section-subtitle">Đánh giá</span>
          <h2 class="section-title">Khách hàng nói gì</h2>
        </div>

        <div class="testimonials-slider">
          <div class="testimonial-card">
            <div class="testimonial-rating">
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
            </div>
            <p class="testimonial-text">
              "Đồ ăn rất ngon, giao hàng nhanh. Tôi sẽ tiếp tục ủng hộ nhà
              hàng!"
            </p>
            <div class="testimonial-author">
              <img
                src="https://randomuser.me/api/portraits/women/32.jpg"
                alt="Nguyễn Thị Mai"
              />
              <div class="author-info">
                <h4>Nguyễn Thị Mai</h4>
                <span>Nhân viên văn phòng</span>
              </div>
            </div>
          </div>

          <div class="testimonial-card">
            <div class="testimonial-rating">
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star-half-alt"></i>
            </div>
            <p class="testimonial-text">
              "Chất lượng đồ ăn rất tốt, đóng gói cẩn thận. Rất đáng để thử!"
            </p>
            <div class="testimonial-author">
              <img
                src="https://randomuser.me/api/portraits/men/54.jpg"
                alt="Trần Văn Nam"
              />
              <div class="author-info">
                <h4>Trần Văn Nam</h4>
                <span>Doanh nhân</span>
              </div>
            </div>
          </div>

          <div class="testimonial-card">
            <div class="testimonial-rating">
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
            </div>
            <p class="testimonial-text">
              "Đặt hàng dễ dàng, thức ăn còn nóng khi giao đến. Rất hài lòng!"
            </p>
            <div class="testimonial-author">
              <img
                src="https://randomuser.me/api/portraits/women/65.jpg"
                alt="Lê Thị Hoa"
              />
              <div class="author-info">
                <h4>Lê Thị Hoa</h4>
                <span>Giáo viên</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Order Section -->
    <section class="order" id="order">
      <div class="container">
        <div class="order-content">
          <div class="order-text">
            <h2 class="section-title">Đặt hàng ngay</h2>
            <p>
              Chọn phương thức đặt hàng phù hợp với bạn. Chúng tôi luôn sẵn sàng
              phục vụ!
            </p>

            <div class="order-steps">
              <div class="step">
                <div class="step-number">1</div>
                <div class="step-content">
                  <h4>Chọn món</h4>
                  <p>Chọn món ăn yêu thích từ thực đơn đa dạng</p>
                </div>
              </div>
              <div class="step">
                <div class="step-number">2</div>
                <div class="step-content">
                  <h4>Đặt hàng</h4>
                  <p>Điền thông tin và xác nhận đơn hàng</p>
                </div>
              </div>
              <div class="step">
                <div class="step-number">3</div>
                <div class="step-content">
                  <h4>Thưởng thức</h4>
                  <p>Nhận món và thưởng thức bữa ăn ngon</p>
                </div>
              </div>
            </div>
          </div>

          <div class="order-methods">
            <div class="order-method">
              <div class="method-icon">
                <i class="fas fa-phone"></i>
              </div>
              <h3>Đặt qua điện thoại</h3>
              <p>
                Gọi ngay đến số hotline của chúng tôi để đặt hàng nhanh chóng.
              </p>
              <a href="tel:+84912345678" class="btn btn-primary">
                <i class="fas fa-phone"></i>
                Gọi ngay: 0912 345 678
              </a>
            </div>

            <div class="order-method">
              <div class="method-icon">
                <i class="fas fa-mobile-alt"></i>
              </div>
              <h3>Đặt qua ứng dụng</h3>
              <p>Tải ứng dụng của chúng tôi trên App Store hoặc Google Play.</p>
              <div class="app-buttons">
                <a href="#" class="app-btn">
                  <i class="fab fa-apple"></i>
                  <div>
                    <span>Tải trên</span>
                    <strong>App Store</strong>
                  </div>
                </a>
                <a href="#" class="app-btn">
                  <i class="fab fa-google-play"></i>
                  <div>
                    <span>Tải trên</span>
                    <strong>Google Play</strong>
                  </div>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Contact Section -->
    <section class="contact" id="contact">
      <div class="container">
        <div class="section-header">
          <span class="section-subtitle">Liên hệ</span>
          <h2 class="section-title">Liên hệ với chúng tôi</h2>
          <p class="section-desc">Chúng tôi luôn sẵn sàng hỗ trợ bạn</p>
        </div>

        <div class="contact-content">
          <div class="contact-info">
            <h3>Thông tin liên hệ</h3>

            <div class="contact-item">
              <div class="contact-icon">
                <i class="fas fa-map-marker-alt"></i>
              </div>
              <div class="contact-details">
                <h4>Địa chỉ</h4>
                <p>123 Đường ABC, Quận XYZ, TP. Hồ Chí Minh</p>
              </div>
            </div>

            <div class="contact-item">
              <div class="contact-icon">
                <i class="fas fa-phone"></i>
              </div>
              <div class="contact-details">
                <h4>Điện thoại</h4>
                <p>0912 345 678 - 028 1234 5678</p>
              </div>
            </div>

            <div class="contact-item">
              <div class="contact-icon">
                <i class="fas fa-envelope"></i>
              </div>
              <div class="contact-details">
                <h4>Email</h4>
                <p>info@takeawayexpress.vn</p>
              </div>
            </div>

            <div class="contact-item">
              <div class="contact-icon">
                <i class="fas fa-clock"></i>
              </div>
              <div class="contact-details">
                <h4>Giờ mở cửa</h4>
                <p>Thứ 2 - Chủ nhật: 9:00 - 22:00</p>
              </div>
            </div>

            <div class="social-media">
              <h4>Theo dõi chúng tôi</h4>
              <div class="social-links">
                <a href="#" class="social-link">
                  <i class="fab fa-facebook-f"></i>
                </a>
                <a href="#" class="social-link">
                  <i class="fab fa-instagram"></i>
                </a>
                <a href="#" class="social-link">
                  <i class="fab fa-tiktok"></i>
                </a>
                <a href="#" class="social-link">
                  <i class="fab fa-youtube"></i>
                </a>
              </div>
            </div>
          </div>

          <div class="contact-form">
            <h3>Gửi tin nhắn cho chúng tôi</h3>
            <form id="contactForm">
              <div class="form-row">
                <div class="form-group">
                  <label for="name">Họ và tên</label>
                  <input
                    type="text"
                    id="name"
                    placeholder="Nhập họ và tên"
                    required
                  />
                </div>
                <div class="form-group">
                  <label for="phone">Số điện thoại</label>
                  <input
                    type="tel"
                    id="phone"
                    placeholder="Nhập số điện thoại"
                    required
                  />
                </div>
              </div>

              <div class="form-group">
                <label for="email">Email</label>
                <input
                  type="email"
                  id="email"
                  placeholder="Nhập địa chỉ email"
                  required
                />
              </div>

              <div class="form-group">
                <label for="subject">Chủ đề</label>
                <select id="subject">
                  <option value="">Chọn chủ đề</option>
                  <option value="order">Đặt hàng</option>
                  <option value="feedback">Phản hồi</option>
                  <option value="complaint">Khiếu nại</option>
                  <option value="other">Khác</option>
                </select>
              </div>

              <div class="form-group">
                <label for="message">Nội dung tin nhắn</label>
                <textarea
                  id="message"
                  placeholder="Nhập nội dung tin nhắn"
                  rows="5"
                  required
                ></textarea>
              </div>

              <button type="submit" class="btn btn-primary">
                <i class="fas fa-paper-plane"></i>
                Gửi tin nhắn
              </button>
            </form>
          </div>
        </div>
      </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
      <div class="container">
        <div class="footer-content">
          <div class="footer-column">
            <div class="footer-logo">
              <i class="fas fa-utensils"></i>
              <div class="logo-text">
                <span class="logo-main">Take Away</span>
                <span class="logo-sub">Express</span>
              </div>
            </div>
            <p>
              Nhà hàng chuyên phục vụ đồ ăn mang về chất lượng cao với dịch vụ
              nhanh chóng, tiện lợi.
            </p>
            <div class="footer-newsletter">
              <h4>Đăng ký nhận tin</h4>
              <div class="newsletter-form">
                <input type="email" placeholder="Email của bạn" />
                <button type="submit">
                  <i class="fas fa-paper-plane"></i>
                </button>
              </div>
            </div>
          </div>

          <div class="footer-column">
            <h3>Liên kết nhanh</h3>
            <ul>
              <li>
                <a href="#home"
                  ><i class="fas fa-chevron-right"></i> Trang chủ</a
                >
              </li>
              <li>
                <a href="#about"
                  ><i class="fas fa-chevron-right"></i> Giới thiệu</a
                >
              </li>
              <li>
                <a href="#menu"
                  ><i class="fas fa-chevron-right"></i> Thực đơn</a
                >
              </li>
              <li>
                <a href="#deals"><i class="fas fa-chevron-right"></i> Ưu đãi</a>
              </li>
              <li>
                <a href="#order"
                  ><i class="fas fa-chevron-right"></i> Đặt hàng</a
                >
              </li>
            </ul>
          </div>

          <div class="footer-column">
            <h3>Chính sách</h3>
            <ul>
              <li>
                <a href="#"
                  ><i class="fas fa-chevron-right"></i> Chính sách bảo mật</a
                >
              </li>
              <li>
                <a href="#"
                  ><i class="fas fa-chevron-right"></i> Điều khoản dịch vụ</a
                >
              </li>
              <li>
                <a href="#"
                  ><i class="fas fa-chevron-right"></i> Chính sách giao hàng</a
                >
              </li>
              <li>
                <a href="#"
                  ><i class="fas fa-chevron-right"></i> Chính sách hoàn tiền</a
                >
              </li>
              <li>
                <a href="#"
                  ><i class="fas fa-chevron-right"></i> Câu hỏi thường gặp</a
                >
              </li>
            </ul>
          </div>

          <div class="footer-column">
            <h3>Tải ứng dụng</h3>
            <p>Tải ứng dụng để đặt hàng dễ dàng hơn và nhận nhiều ưu đãi.</p>
            <div class="app-buttons">
              <a href="#" class="app-btn">
                <i class="fab fa-apple"></i>
                <div>
                  <span>Tải trên</span>
                  <strong>App Store</strong>
                </div>
              </a>
              <a href="#" class="app-btn">
                <i class="fab fa-google-play"></i>
                <div>
                  <span>Tải trên</span>
                  <strong>Google Play</strong>
                </div>
              </a>
            </div>
          </div>
        </div>

        <div class="footer-bottom">
          <p>
            &copy; 2023 <strong>Take Away Express</strong>. Tất cả các quyền
            được bảo lưu.
          </p>
          <div class="payment-methods">
            <i class="fab fa-cc-visa"></i>
            <i class="fab fa-cc-mastercard"></i>
            <i class="fab fa-cc-paypal"></i>
            <i class="fab fa-cc-apple-pay"></i>
          </div>
        </div>
      </div>
    </footer>

    <!-- Back to Top Button -->
    <button class="back-to-top" id="backToTop">
      <i class="fas fa-chevron-up"></i>
    </button>

    <!-- Cart Sidebar -->
    <div class="cart-sidebar" id="cartSidebar">
      <div class="cart-header">
        <h3><i class="fas fa-shopping-cart"></i> Giỏ hàng của bạn</h3>
        <button class="close-cart" id="closeCart">&times;</button>
      </div>
      <div class="cart-body">
        <div class="cart-items" id="cartItems">
          <!-- Các món trong giỏ hàng sẽ được hiển thị ở đây -->
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
            <input
              type="text"
              placeholder="Nhập mã giảm giá"
              id="couponInput"
            />
            <button class="btn btn-outline" id="applyCoupon">Áp dụng</button>
          </div>
        </div>
        <div class="cart-footer">
          <button class="btn btn-primary checkout-btn" id="checkoutBtn">
            <i class="fas fa-credit-card"></i>
            <span><a href="checkout.html">Thanh toán</a></span>
          </button>
          <a href="#menu" class="btn btn-outline continue-btn">
            <i class="fas fa-utensils"></i>
            <span>Tiếp tục mua hàng</span>
          </a>
        </div>
      </div>
    </div>
    <div class="cart-overlay" id="cartOverlay"></div>

    <!-- Product Quick View Modal -->
    <div class="modal quick-view-modal" id="quickViewModal">
      <div class="modal-content">
        <button class="close-modal">&times;</button>
        <div class="modal-body" id="quickViewContent">
          <!-- Nội dung xem nhanh sẽ được tải động -->
        </div>
      </div>
    </div>
    <div class="modal-overlay" id="quickViewOverlay"></div>

    <!-- Order Online Modal -->
    <div class="modal" id="orderOnlineModal">
      <div class="modal-content">
        <div class="modal-header">
          <h3><i class="fas fa-shopping-bag"></i> Đặt hàng online</h3>
          <button class="close-modal">&times;</button>
        </div>
        <div class="modal-body">
          <p>
            Chức năng đặt hàng online đang được phát triển. Vui lòng đặt hàng
            qua điện thoại hoặc tải ứng dụng của chúng tôi.
          </p>
          <div class="modal-buttons">
            <a href="tel:+84912345678" class="btn btn-primary">
              <i class="fas fa-phone"></i>
              Gọi đặt hàng
            </a>
            <button class="btn btn-secondary close-modal">
              <i class="fas fa-times"></i>
              Đóng
            </button>
          </div>
        </div>
      </div>
    </div>
    <div class="modal-overlay" id="modalOverlay"></div>

    <!-- JavaScript -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const cartItemsContainer = document.getElementById('cartItems');
        // Thêm vào giỏ
        document.querySelectorAll('.add-to-cart').forEach(btn => {
            btn.addEventListener('click', function() {
        const itemId = this.dataset.id;
        fetch('/cart/add', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ item_id: itemId })
        })
        .then(res => res.json())
        .then(cart => {
            updateCartUI(cart);
            showCartMessage('Đã thêm món vào giỏ hàng!', 'success');
        });
    });

    });

    // Cập nhật giao diện giỏ
    function updateCartUI(cart) {
    cartItemsContainer.innerHTML = ''; // xóa nội dung cũ
    if(cart.items.length === 0) {
        cartItemsContainer.innerHTML = `<div class="empty-cart">
            <i class="fas fa-shopping-basket"></i>
            <p>Giỏ hàng của bạn đang trống</p>
            <a href="#menu" class="btn btn-primary">Xem thực đơn</a>
        </div>`;
        document.querySelector('.cart-subtotal').textContent = '0 đ';
        document.querySelector('.cart-total').textContent = '0 đ';
        return;
    }

    let subtotal = 0;
    cart.items.forEach((item) => {
        subtotal += item.quantity * item.menu_item.price;

        const cartItemElement = document.createElement("div");
        cartItemElement.className = "cart-item";
        cartItemElement.dataset.id = item.menu_item.id;

        cartItemElement.innerHTML = `
            <div class="cart-item-image">
                <img src="/images/menu/${item.menu_item.image}" alt="${item.menu_item.name}">
            </div>
            <div class="cart-item-info">
                <div class="cart-item-header">
                    <h4 class="cart-item-name">${item.menu_item.name}</h4>
                    <span class="cart-item-price">${(item.menu_item.price).toLocaleString()} đ</span>
                </div>
                <div class="cart-item-actions">
                    <div class="quantity-control">
                        <button class="quantity-btn decrease-btn" data-id="${item.menu_item.id}">-</button>
                        <span class="cart-item-quantity">${item.quantity}</span>
                        <button class="quantity-btn increase-btn" data-id="${item.menu_item.id}">+</button>
                    </div>
                    <button class="remove-item" data-id="${item.menu_item.id}">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        `;
        cartItemsContainer.appendChild(cartItemElement);
    });

    document.querySelector('.cart-subtotal').textContent = subtotal.toLocaleString() + ' đ';
    document.querySelector('.cart-total').textContent = subtotal.toLocaleString() + ' đ';

    // Gắn sự kiện cho nút + / - / xóa
    cartItemsContainer.querySelectorAll('.increase-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const parent = this.closest('.cart-item');
            const quantityEl = parent.querySelector('.cart-item-quantity');
            let quantity = parseInt(quantityEl.textContent) + 1;
            quantityEl.textContent = quantity;
            updateQuantity(parent.dataset.id, quantity);
        });
    });

    cartItemsContainer.querySelectorAll('.decrease-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const parent = this.closest('.cart-item');
            const quantityEl = parent.querySelector('.cart-item-quantity');
            let quantity = parseInt(quantityEl.textContent);
            if(quantity > 1) {
                quantity -= 1;
                quantityEl.textContent = quantity;
                updateQuantity(parent.dataset.id, quantity);
            }
        });
    });

    cartItemsContainer.querySelectorAll('.remove-item').forEach(btn => {
        btn.addEventListener('click', function() {
            const parent = this.closest('.cart-item');
            removeItem(parent.dataset.id);
        });
    });
    document.querySelector('.cart-count').textContent = cart.items.length;
}
    // Cập nhật số lượng qua AJAX
    function updateQuantity(itemId, quantity) {
        fetch('/cart/update', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ item_id: itemId, quantity: quantity })
        })
        .then(res => res.json())
        .then(cart => updateCartUI(cart));
    }

    // Xóa món
    function removeItem(itemId) {
    fetch('/cart/remove', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ item_id: itemId })
    })
    .then(res => res.json())
    .then(cart => {
        updateCartUI(cart);
        showCartMessage('Đã xóa món khỏi giỏ hàng!', 'success');
    });
}

    function showCartMessage(message, type = 'success') {
    // Tạo div thông báo
    const msg = document.createElement('div');
    msg.className = `cart-message ${type}`; // type: success / error
    msg.textContent = message;

    document.body.appendChild(msg);

    // Hiển thị trong 2 giây rồi ẩn
    setTimeout(() => {
        msg.classList.add('hide');
        setTimeout(() => msg.remove(), 500);
    }, 2000);
}


    // Load giỏ khi mở trang
    fetch('/cart')
    .then(res => res.json())
    .then(cart => updateCartUI(cart));
});
</script>


    <script src="{{ asset('js/home.js') }}"></script>
  </body>
</html>
