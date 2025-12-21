<section class="contact" id="contact">
  <div class="container">
    <div class="section-header">
      <span class="section-subtitle">Liên hệ</span>
      <h2 class="section-title">Liên hệ với chúng tôi</h2>
      <p class="section-desc">Chúng tôi luôn sẵn sàng hỗ trợ bạn</p>
    </div>

    <div class="contact-content">
      <!-- Thông tin liên hệ -->
      <div class="contact-info">
        <h3>Thông tin liên hệ</h3>

        <div class="contact-item">
          <div class="contact-icon"><i class="fas fa-map-marker-alt"></i></div>
          <div class="contact-details">
            <h4>Địa chỉ</h4>
            <p>{{ $about->address ?? 'Chưa cập nhật' }}</p>
          </div>
        </div>

        <div class="contact-item">
          <div class="contact-icon"><i class="fas fa-phone"></i></div>
          <div class="contact-details">
            <h4>Điện thoại</h4>
            <p>{{ $about->phone ?? 'Chưa cập nhật' }}</p>
          </div>
        </div>

        <div class="contact-item">
          <div class="contact-icon"><i class="fas fa-envelope"></i></div>
          <div class="contact-details">
            <h4>Email</h4>
            <p>{{ $about->email ?? 'Chưa cập nhật' }}</p>
          </div>
        </div>

        <div class="contact-item">
          <div class="contact-icon"><i class="fas fa-clock"></i></div>
          <div class="contact-details">
            <h4>Giờ mở cửa</h4>
            <p>Thứ 2 - Chủ nhật: 9:00 - 22:00</p>
          </div>
        </div>

        {{-- @if($about->map_embed)
        <div class="contact-map mt-3">
          {!! $about->map_embed !!}
        </div>
        @endif --}}

        <div class="social-media mt-3">
          <h4>Theo dõi chúng tôi</h4>
          <div class="social-links">
            <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
            <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
            <a href="#" class="social-link"><i class="fab fa-tiktok"></i></a>
            <a href="#" class="social-link"><i class="fab fa-youtube"></i></a>
          </div>
        </div>
      </div>

      <!-- Form liên hệ -->
      <div class="contact-form">
        <h3>Gửi tin nhắn cho chúng tôi</h3>
        <form id="contactForm">
          @csrf
          <div class="form-row">
            <div class="form-group">
              <label for="name">Họ và tên</label>
              <input type="text" id="name" name="name" placeholder="Nhập họ và tên" required />
            </div>
            <div class="form-group">
              <label for="phone">Số điện thoại</label>
              <input type="tel" id="phone" name="phone" placeholder="Nhập số điện thoại" required />
            </div>
          </div>

          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Nhập địa chỉ email" required />
          </div>

          <div class="form-group">
            <label for="subject">Chủ đề</label>
            <select id="subject" name="subject">
              <option value="">Chọn chủ đề</option>
              <option value="order">Đặt hàng</option>
              <option value="feedback">Phản hồi</option>
              <option value="complaint">Khiếu nại</option>
              <option value="other">Khác</option>
            </select>
          </div>

          <div class="form-group">
            <label for="message">Nội dung tin nhắn</label>
            <textarea id="message" name="message" placeholder="Nhập nội dung tin nhắn" rows="5" required></textarea>
          </div>

          <button type="submit" class="btn btn-primary">
            <i class="fas fa-paper-plane"></i> Gửi tin nhắn
          </button>
        </form>
      </div>
    </div>
  </div>
</section>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.getElementById('contactForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const data = {
        name: document.getElementById('name').value,
        phone: document.getElementById('phone').value,
        email: document.getElementById('email').value,
        subject: document.getElementById('subject').value,
        message: document.getElementById('message').value,
    };

    fetch("{{ route('customer.contact.store') }}", {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(res => res.json())
    .then(res => {
        if (res.success) {
            Swal.fire({
                icon: 'success',
                title: 'Gửi thành công!',
                text: res.message,
            });

            // Reset form
            document.getElementById('contactForm').reset();
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Lỗi!',
                text: res.message || 'Có lỗi xảy ra, vui lòng thử lại.'
            });
        }
    })
    .catch(err => {
        Swal.fire({
            icon: 'error',
            title: 'Có lỗi xảy ra',
            text: 'Vui lòng thử lại!'
        });
        console.error(err);
    });
});
</script>
