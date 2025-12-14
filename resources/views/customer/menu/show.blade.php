<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
</head>
<div class="container my-5">
    <div class="row">
        <!-- Hình ảnh chính + gallery -->
        <div class="col-md-6">
            <div id="menuItemCarousel" class="carousel slide mb-3" data-bs-ride="carousel">
                <div class="carousel-inner">
                 @foreach($menuItem->images as $key => $img)
                    <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                        <img src="{{ $img->url }}" class="d-block w-50 rounded" alt="{{ $menuItem->name }}">
                    </div>
                @endforeach
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#menuItemCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon bg-dark rounded-circle p-2"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#menuItemCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon bg-dark rounded-circle p-2"></span>
                </button>
            </div>
            <div class="d-flex flex-wrap gap-2">
                @foreach($menuItem->images as $key => $img)
                    <img src="{{ $img->url }}" class="img-thumbnail" style="width:80px; cursor:pointer;"
                        onclick="document.querySelector('#menuItemCarousel .carousel-item.active img').src=this.src;">
                @endforeach
            </div>
        </div>

        <!-- Thông tin món -->
        <div class="col-md-6">
            <h2 class="fw-bold">{{ $menuItem->name }}</h2>
            <p class="text-muted">{{ $menuItem->description }}</p>
            <h3 class="text-danger fw-bold">{{ number_format($menuItem->price) }} đ</h3>
            <p><strong>Danh mục:</strong> {{ $menuItem->category->name }}</p>
            <p>
                <strong>Đánh giá trung bình:</strong>
                @if($avgRating)
                    {{ number_format($avgRating,1) }}
                    <span class="text-warning">
                        @for($i=1;$i<=5;$i++)
                            <i class="fas fa-star {{ $i <= round($avgRating) ? 'text-warning' : 'text-secondary' }}"></i>
                        @endfor
                    </span>
                @else
                    Chưa có đánh giá
                @endif
            </p>
            <div class="d-flex gap-2 mt-3">
                <form action="#" method="POST">
                    @csrf
                    <button class="btn btn-success btn-lg"><i class="fas fa-shopping-cart me-1"></i> Thêm vào giỏ</button>
                </form>
                <a href="{{ route('customer.home') }}" class="btn btn-outline-secondary btn-lg"><i class="fas fa-arrow-left me-1"></i> Quay lại</a>
            </div>
        </div>
    </div>

    <!-- Bình luận -->
   <!-- Bình luận và gửi đánh giá tách thành 2 cột -->
<div class="row mt-5">
    <!-- Cột đánh giá hiện tại -->
    <div class="col-md-6">
        <h4 class="mb-4">Đánh giá của khách hàng ({{ $comments->count() }})</h4>

        @forelse($comments as $comment)
            <div class="card mb-3 p-3 shadow-sm">
                <div class="d-flex justify-content-between align-items-center">
                    <strong>{{ $comment->user->name }}</strong>
                    <small class="text-muted">{{ $comment->created_at->format('d/m/Y H:i') }}</small>
                </div>
                <div class="mb-2">
                    @for($i=1;$i<=5;$i++)
                        <i class="fas fa-star {{ $i <= $comment->rating ? 'text-warning' : 'text-secondary' }}"></i>
                    @endfor
                </div>
                <p>{{ $comment->content_menu }}</p>
            </div>
        @empty
            <p class="text-muted">Chưa có đánh giá nào cho món ăn này.</p>
        @endforelse
    </div>

    <!-- Cột gửi đánh giá -->
    <div class="col-md-6">
        @auth
        <div class="card p-4 shadow-sm">
            <h5 class="mb-3">Viết đánh giá</h5>
            <form action="{{ route('customer.menu.comment', $menuItem) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Nội dung</label>
                    <textarea name="content_menu" class="form-control" rows="5" required></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Đánh giá</label>
                    <select name="rating" class="form-select" required>
                        <option value="">Chọn</option>
                        @for($i=1;$i<=5;$i++)
                            <option value="{{ $i }}">{{ $i }} ⭐</option>
                        @endfor
                    </select>
                </div>
                <button class="btn btn-success"><i class="fas fa-paper-plane me-1"></i> Gửi đánh giá</button>
            </form>
        </div>
        @else
            <p class="mt-3 text-muted">Bạn cần <a href="{{ route('login') }}">đăng nhập</a> để bình luận.</p>
        @endauth
    </div>
</div>

</div>

<!-- Bootstrap JS + FontAwesome -->
<script>
    // Thay ảnh carousel khi click thumbnail
    document.querySelectorAll('.img-thumbnail').forEach(thumb => {
        thumb.addEventListener('click', function() {
            const activeImg = document.querySelector('#menuItemCarousel .carousel-item.active img');
            activeImg.src = this.src;
        });
    });
</script>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
