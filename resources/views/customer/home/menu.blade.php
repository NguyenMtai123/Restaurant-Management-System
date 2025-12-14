<section class="menu" id="menu">
  <div class="container">
    <div class="section-header">
      <span class="section-subtitle">Thực đơn đa dạng</span>
      <h2 class="section-title">Món ăn nổi bật</h2>
      <p class="section-desc">Khám phá những món ăn đặc biệt của chúng tôi</p>
    </div>

    <div class="menu-controls">
      <div class="menu-categories">
        <button class="category-btn active" data-category="all"><i class="fas fa-th-large"></i><span>Tất cả</span></button>
        @foreach($categories as $category)
        <button class="category-btn" data-category="{{ $category->slug }}"><i class="fas fa-utensils"></i><span>{{ $category->name }}</span></button>
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
            <img src="{{ asset($item->images->where('is_featured', 1)->first()?->url ?? 'images/default.png') }}" alt="{{ $item->name }}">

        </div>
        <div class="menu-content">
            <h4>
                <a href="{{ route('customer.menu.show', $item->slug) }}">{{ $item->name }}</a>
            </h4>
          <p>{{ $item->description }}</p>
          <span class="menu-price">{{ number_format($item->price) }} đ</span>
          <button class="btn btn-primary add-to-cart" data-id="{{ $item->id }}">
            <i class="fas fa-shopping-cart"></i> Thêm vào giỏ
          </button>
        </div>
      </div>
      @endforeach
    </div>

    <div class="menu-footer">
      <button class="btn btn-outline" id="loadMore"><i class="fas fa-redo"></i><span>Xem thêm món ăn</span></button>
    </div>

    <script>
      document.querySelectorAll('.category-btn').forEach(btn => {
        btn.addEventListener('click', () => {
          const category = btn.dataset.category;
          document.querySelectorAll('.menu-item').forEach(item => {
            item.style.display = (category === 'all' || item.dataset.category === category) ? 'block' : 'none';
          });
        });
      });
    </script>
</section>
