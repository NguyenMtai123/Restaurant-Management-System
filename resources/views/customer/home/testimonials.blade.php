<section class="testimonials">
  <div class="container">
    <div class="section-header">
      <span class="section-subtitle">Đánh giá</span>
      <h2 class="section-title">Khách hàng nói gì</h2>
    </div>

    <div class="testimonials-slider">
      @forelse($testimonials as $t)
        <div class="testimonial-card">
          <div class="testimonial-rating">
            @for($i=1; $i<=5; $i++)
              <i class="fas fa-star {{ $i <= $t->rating ? '' : 'fa-star text-secondary' }}"></i>
            @endfor
          </div>
          <p class="testimonial-text">"{{ $t->content_menu }}"</p>
          <div class="testimonial-author">
            <img src="{{ $t->user->avatar_url ?? 'https://randomuser.me/api/portraits/lego/1.jpg' }}"
                 alt="{{ $t->user->name }}"/>
            <div class="author-info">
              <h4>{{ $t->user->name }}</h4>
              <span>{{ $t->user->job_title ?? 'Khách hàng' }}</span>
            </div>
          </div>
        </div>
      @empty
        <p class="text-muted">Chưa có đánh giá nào.</p>
      @endforelse
    </div>
  </div>
</section>
