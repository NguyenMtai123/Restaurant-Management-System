<section class="about" id="about">
  <div class="container">
    <div class="section-header">
      <span class="section-subtitle">Về chúng tôi</span>
      <h2 class="section-title">{{ $about->title ?? 'Take Away Express' }}</h2>
      <p class="section-desc">{{ Str::limit($about->content_contact, 50) ?? 'Mang hương vị đến tận nhà bạn' }}</p>
    </div>

    <div class="about-content">
      <div class="about-image">
        <div class="image-frame">
          <img src="https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80" alt="Nhà hàng Take Away"/>
        </div>
        <div class="experience-badge">
          <span class="exp-number">10+</span>
          <span class="exp-text">Năm kinh nghiệm</span>
        </div>
      </div>
      <div class="about-text">
        <h3>Nhà hàng chuyên về dịch vụ mang về với hơn 10 năm kinh nghiệm</h3>
        <p>Tất cả các món ăn đều được chế biến từ nguyên liệu tươi ngon nhất, đảm bảo vệ sinh an toàn thực phẩm. Đầu bếp của chúng tôi là những chuyên gia ẩm thực với nhiều năm kinh nghiệm.</p>
        <p>Với phương châm "Nhanh chóng - Tiện lợi - Chất lượng", chúng tôi cam kết mang đến cho khách hàng những bữa ăn ngon miệng nhất chỉ sau 30 phút đặt hàng.</p>

        <div class="about-list">
          <div class="list-item"><i class="fas fa-check-circle"></i><span>Đầu bếp chuyên nghiệp</span></div>
          <div class="list-item"><i class="fas fa-check-circle"></i><span>Nguyên liệu tươi ngon</span></div>
          <div class="list-item"><i class="fas fa-check-circle"></i><span>Đóng gói vệ sinh</span></div>
          <div class="list-item"><i class="fas fa-check-circle"></i><span>Giao hàng nhanh chóng</span></div>
        </div>

        <a href="#contact" class="btn btn-primary btn-icon">
          <i class="fas fa-phone-alt"></i>
          <span>Liên hệ ngay</span>
        </a>
      </div>
    </div>
  </div>
</section>
