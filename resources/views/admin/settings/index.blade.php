@extends('admin.layouts.master')

@section('title','Thiết lập')

@section('content')
<div class="container py-4">
    <h3 class="mb-4">Thiết lập hệ thống</h3>

    <div class="row g-4">

        {{-- Card 1: Quản lý danh mục món ăn --}}
        <div class="col-md-6 col-lg-3">
            <a href="{{ route('admin.categories.index') }}" class="text-decoration-none">
                <div class="card shadow-sm border-0 rounded-3 hover-scale">
                    <div class="card-body text-center">
                        <i class='bx bx-food-menu bx-lg mb-3 text-primary'></i>
                        <h5 class="card-title">Danh mục món ăn</h5>
                        <p class="card-text text-muted">Quản lý các loại món ăn trong menu.</p>
                    </div>
                </div>
            </a>
        </div>

        {{-- Card 2: Quản lý danh mục bài viết --}}
        <div class="col-md-6 col-lg-3">
            <a href="{{ route('admin.posts.index') }}" class="text-decoration-none">
                <div class="card shadow-sm border-0 rounded-3 hover-scale">
                    <div class="card-body text-center">
                        <i class='bx bx-news bx-lg mb-3 text-success'></i>
                        <h5 class="card-title">Danh mục bài viết</h5>
                        <p class="card-text text-muted">Quản lý các bài viết, tin tức và thông báo.</p>
                    </div>
                </div>
            </a>
        </div>

        {{-- Card 3: Quản lý liên hệ --}}
        <div class="col-md-6 col-lg-3">
            <a href="{{ route('admin.contacts.index') }}" class="text-decoration-none">
                <div class="card shadow-sm border-0 rounded-3 hover-scale">
                    <div class="card-body text-center">
                        <i class='bx bx-phone bx-lg mb-3 text-warning'></i>
                        <h5 class="card-title">Liên hệ</h5>
                        <p class="card-text text-muted">Xem và quản lý các liên hệ từ khách hàng.</p>
                    </div>
                </div>
            </a>
        </div>

        {{-- Card 4: Giới thiệu --}}
        <div class="col-md-6 col-lg-3">
            <a href="{{ route('admin.abouts.index') }}" class="text-decoration-none">
                <div class="card shadow-sm border-0 rounded-3 hover-scale">
                    <div class="card-body text-center">
                        <i class='bx bx-info-circle bx-lg mb-3 text-danger'></i>
                        <h5 class="card-title">Giới thiệu</h5>
                        <p class="card-text text-muted">Quản lý thông tin giới thiệu về cửa hàng.</p>
                    </div>
                </div>
            </a>
        </div>

    </div>
</div>

{{-- Thêm CSS nhỏ cho hover effect --}}
@push('styles')
<style>
.hover-scale:hover {
    transform: translateY(-5px);
    transition: all 0.3s ease;
    box-shadow: 0 10px 20px rgba(0,0,0,0.1);
}
</style>
@endpush
@endsection
