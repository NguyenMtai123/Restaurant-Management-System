@extends('customer.layouts.app')

@section('title', $menuItem->name)

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

    <style>
        .star-rating {
            display: flex;
            gap: 6px;
            font-size: 26px;
            cursor: pointer;
        }

        .star-rating i {
            color: #ddd;
            transition: .2s;
        }

        .star-rating i.active,
        .star-rating i.hover {
            color: #ffc107;
        }

        .menu-detail {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, .06);
            padding: 24px;
        }
        .menu-image {
            width: 100%;
            height: 320px;
            /* QUAN TRỌNG */
            object-fit: cover;
            border-radius: 14px;
        }

        /* Thumbnail */
        .thumb-img {
            width: 64px;
            height: 64px;
            object-fit: cover;
            cursor: pointer;
            border-radius: 10px;
            opacity: .6;
            transition: .2s;
            border: 2px solid transparent;
        }

        .thumb-img.active,
        .thumb-img:hover {
            opacity: 1;
            border-color: #198754;
        }

        /* Giá */
        .menu-price {
            font-size: 26px;
            font-weight: 700;
            color: #e63946;
        }

        /* Nút */
        .btn-cart {
            padding: 10px 20px;
            font-size: 15px;
            border-radius: 10px;
        }

        /* Đánh giá */
        .comment-card {
            border-left: 4px solid #198754;
            background: #f9f9f9;
        }

        /* Mobile */
        @media (max-width: 768px) {
            .menu-image {
                height: 260px;
            }
        }
    </style>
@endpush

@section('content')
    <div class="container my-5">

        <!-- CHI TIẾT MÓN -->
        <div class="menu-detail mb-5">
            <div class="row g-4 align-items-start">
                <div class="col-md-5">
                    <div id="menuCarousel" class="carousel slide mb-3" data-bs-ride="false">
                        <div class="carousel-inner">
                            @foreach ($menuItem->images as $k => $img)
                                <div class="carousel-item {{ $k === 0 ? 'active' : '' }}">
                                    <img src="{{ $img->url }}" class="menu-image">
                                </div>
                            @endforeach
                        </div>

                        @if ($menuItem->images->count() > 1)
                            <button class="carousel-control-prev" type="button" data-bs-target="#menuCarousel"
                                data-bs-slide="prev">
                                <span class="carousel-control-prev-icon"></span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#menuCarousel"
                                data-bs-slide="next">
                                <span class="carousel-control-next-icon"></span>
                            </button>
                        @endif
                    </div>

                    <div class="d-flex gap-2 justify-content-center flex-wrap">
                        @foreach ($menuItem->images as $k => $img)
                            <img src="{{ $img->url }}" class="thumb-img {{ $k === 0 ? 'active' : '' }}"
                                onclick="changeImage({{ $k }}, '{{ $img->url }}')">
                        @endforeach
                    </div>
                </div>

                <!-- THÔNG TIN -->
                <div class="col-md-7">
                    <h3 class="fw-bold mb-2">{{ $menuItem->name }}</h3>

                    <span class="badge bg-secondary mb-2">
                        {{ $menuItem->category->name }}
                    </span>

                    <p class="text-muted mt-2">
                        {{ $menuItem->description }}
                    </p>

                    <div class="menu-price mb-2">
                        {{ number_format($menuItem->price) }} đ
                    </div>

                    <!-- Rating -->
                    <div class="mb-3">
                        @for ($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star {{ $i <= round($avgRating) ? 'text-warning' : 'text-secondary' }}"></i>
                        @endfor
                        <small class="text-muted ms-2">
                            ({{ $totalComments }} đánh giá)
                        </small>

                    </div>

                    <!-- Actions -->
                    <div class="d-flex gap-3 mt-4 flex-wrap row">
                        <div class="col-md-6">
                            <button class="btn btn-success btn-cart add-to-cart" data-id="{{ $menuItem->id }}">
                                <i class="fas fa-cart-plus me-1"></i> Thêm giỏ
                            </button>
                        </div>

                        <div class="col-md-6">
                            <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-cart">
                                Quay lại
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ĐÁNH GIÁ -->
        <div class="row g-4">
            <!-- LIST -->
            <div class="col-md-6">
                <h5 class="mb-3">Đánh giá khách hàng</h5>

                <div id="commentList">
                    @forelse($comments as $c)
                        <div class="card comment-card mb-3 p-3">
                            <div class="d-flex justify-content-between">
                                <strong>{{ $c->user->name }}</strong>
                                <small class="text-muted">{{ $c->created_at->format('d/m/Y') }}</small>
                            </div>

                            <div class="mb-1">
                                @for ($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star {{ $i <= $c->rating ? 'text-warning' : 'text-secondary' }}"></i>
                                @endfor
                            </div>

                            <p class="mb-0">{{ $c->content_menu }}</p>
                        </div>
                    @empty
                        <p class="text-muted">Chưa có đánh giá.</p>
                    @endforelse
                </div>
            </div>

            <!-- FORM -->
            <div class="col-md-6">
                @auth
                    <div class="card p-4 shadow-sm">
                        <h5 class="mb-3">Viết đánh giá</h5>

                        <form id="commentForm" method="POST" action="{{ route('customer.menu.comment', $menuItem) }}">
                            @csrf

                            <textarea class="form-control mb-3" name="content_menu" rows="4" placeholder="Cảm nhận của bạn..." required></textarea>

                            <div class="mb-3">
                                <div class="star-rating" id="starRating">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star" data-value="{{ $i }}"></i>
                                    @endfor
                                </div>
                                <input type="hidden" name="rating" id="ratingInput">
                            </div>

                            <button class="btn btn-success w-100">
                                Gửi đánh giá
                            </button>
                        </form>
                    </div>
                @else
                    <p>Bạn cần <a href="{{ route('login') }}">đăng nhập</a> để đánh giá.</p>
                @endauth
            </div>
        </div>

    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function changeImage(index, src) {
            const carousel = document.querySelector('#menuCarousel');
            const bsCarousel = bootstrap.Carousel.getOrCreateInstance(carousel);
            bsCarousel.to(index);

            document.querySelectorAll('.thumb-img').forEach(t => t.classList.remove('active'));
            document.querySelectorAll('.thumb-img')[index].classList.add('active');
        }
    </script>
    <script>
        const stars = document.querySelectorAll('#starRating i');
        const ratingInput = document.getElementById('ratingInput');
        const form = document.getElementById('commentForm');

        // Mặc định 5 sao
        ratingInput.value = 5;
        highlight(5);

        stars.forEach(star => {
            star.addEventListener('mouseenter', () => highlight(star.dataset.value));
            star.addEventListener('mouseleave', () => highlight(ratingInput.value || 5));
            star.addEventListener('click', () => {
                ratingInput.value = star.dataset.value;
                highlight(star.dataset.value);
            });
        });

        function highlight(value) {
            value = value || 5; // nếu rỗng -> 5
            stars.forEach(star => {
                star.classList.toggle('active', star.dataset.value <= value);
            });
        }

        form.addEventListener('submit', function(e) {
            e.preventDefault();

            const content = this.content_menu.value.trim();
            const rating = ratingInput.value || 5; // nếu user ko chọn -> 5

            fetch("{{ route('customer.menu.comment', $menuItem) }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        content_menu: content,
                        rating: rating
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        prependComment(data.comment);
                        form.reset();
                        ratingInput.value = 5; // reset về mặc định
                        highlight(5);
                    }
                });
        });

        function prependComment(c) {
            const list = document.getElementById('commentList');

            // Xóa thông báo "Chưa có đánh giá." nếu có
            const emptyMsg = list.querySelector('p.text-muted');
            if (emptyMsg) emptyMsg.remove();

            const stars = Array.from({
                    length: 5
                }, (_, i) =>
                `<i class="fas fa-star ${i < c.rating ? 'text-warning' : 'text-secondary'}"></i>`
            ).join('');

            // Thêm comment mới lên đầu
            list.insertAdjacentHTML('afterbegin', `
        <div class="card comment-card mb-3 p-3">
            <div class="d-flex justify-content-between">
                <strong>${c.user}</strong>
                <small class="text-muted">${c.created_at}</small>
            </div>
            <div class="mb-1">${stars}</div>
            <p class="mb-0">${c.content}</p>
        </div>
    `);

            // Giữ tối đa 2 comment
            const comments = list.querySelectorAll('.comment-card');
            if (comments.length > 2) {
                comments[comments.length - 1].remove();
            }
        }

        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener("click", function(e) {
                e.preventDefault();
                const href = this.getAttribute("href");
                if (!href || href === "#") return;

                const target = document.querySelector(href);
                if (target) {
                    window.scrollTo({
                        top: target.offsetTop - 100,
                        behavior: "smooth"
                    });
                } else {
                    window.location.href = "{{ route('home') }}" + href;
                }
            });
        });
    </script>
@endpush
