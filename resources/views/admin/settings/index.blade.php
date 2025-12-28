@extends('admin.layouts.master')

@section('title','Thiết lập')
@php $user = Auth::user(); @endphp

@section('content')
<div class="container py-4">
    <h3 class="mb-4">Thiết lập hệ thống</h3>

    <div class="row g-4">

        {{-- Card 1: Quản lý danh mục món ăn --}}
        @if($user->hasPermission('manage_menu'))
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
        @endif

        {{-- Card 2: Quản lý danh mục bài viết --}}
        @if($user->hasPermission('manage_posts'))
        <div class="col-md-6 col-lg-3">
            <a href="{{ route('admin.post-categories.index') }}" class="text-decoration-none">
                <div class="card shadow-sm border-0 rounded-3 hover-scale">
                    <div class="card-body text-center">
                        <i class='bx bx-news bx-lg mb-3 text-success'></i>
                        <h5 class="card-title">Danh mục bài viết</h5>
                        <p class="card-text text-muted">Quản lý các bài viết, tin tức và thông báo.</p>
                    </div>
                </div>
            </a>
        </div>
        @endif

        @if($user->hasPermission('manage_posts'))
        <div class="col-md-6 col-lg-3">
            <a href="{{ route('admin.posts.index') }}" class="text-decoration-none">
                <div class="card shadow-sm border-0 rounded-3 hover-scale">
                    <div class="card-body text-center">
                        <i class='bx bx-file bx-lg mb-3 text-success'></i>
                        <h5 class="card-title">Bài viết</h5>
                        <p class="card-text text-muted">Quản lý bài viết, tin tức và thông báo.</p>
                    </div>
                </div>
            </a>
        </div>
        @endif

        {{-- Card 3: Quản lý liên hệ --}}
        @if($user->hasPermission('manage_contacts'))
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
        @endif

        {{-- Card 4: Giới thiệu --}}
        @if($user->hasPermission('about_settings'))
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
        @endif

        @if($user->hasPermission('about_settings'))
        <div class="col-md-6 col-lg-3">
            <a href="{{ route('admin.roles.index') }}" class="text-decoration-none">
                <div class="card shadow-sm border-0 rounded-3 hover-scale">
                    <div class="card-body text-center">
                        <i class='bx bx-shield-quarter bx-lg mb-3 text-info'></i>
                        <h5 class="card-title">Vai trò</h5>
                        <p class="card-text text-muted">Quản lý vai trò người dùng trong hệ thống.</p>
                    </div>
                </div>
            </a>
        </div>
        @endif


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
