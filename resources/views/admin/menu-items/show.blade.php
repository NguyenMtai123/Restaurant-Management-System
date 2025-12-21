@extends('admin.layouts.master')

@section('title', 'Quản lý sản phẩm - Take Away Express')
@section('page-title', 'Sản phẩm')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/products.css') }}">

@endpush

@section('content')
   <div class="container mt-4">
    <!-- HEADER -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-2">
        <h4 class="mb-2 mb-md-0">Chi tiết món ăn</h4>
        <div class="btn-group">
            <a href="{{ route('admin.menu-items.edit', $menuItem->id) }}"
               class="btn btn-warning">
               <i class="bi bi-pencil-square me-1"></i> Sửa
            </a>
            <a href="{{ route('admin.menu-items.index') }}"
               class="btn btn-secondary">
               <i class="bi bi-arrow-left me-1"></i> Quay lại
            </a>
        </div>
    </div>

    <div class="row g-4">
        <!-- ẢNH -->
        <div class="col-lg-5 col-md-6">
            <div class="card shadow-sm rounded-4">
                <div class="card-body text-center">
                    {{-- ẢNH HIỂN THỊ --}}
                    <img
                        src="{{ $menuItem->featuredImage
                            ? asset($menuItem->featuredImage->image_path)
                            : asset('images/no-image.png') }}"
                        class="img-fluid rounded mb-3"
                        style="max-height:300px;object-fit:cover;transition: transform .3s;"
                        onmouseover="this.style.transform='scale(1.05)';"
                        onmouseout="this.style.transform='scale(1)';">

                    {{-- GALLERY --}}
                    <div class="row g-2 justify-content-center mt-2">
                        @foreach($menuItem->images as $img)
                            <div class="col-3">
                                <img src="{{ asset($img->image_path) }}"
                                     class="img-thumbnail rounded hover-scale"
                                     style="height:70px;object-fit:cover;cursor:pointer;"
                                     title="Ảnh món ăn">
                            </div>
                        @endforeach
                    </div>

                    @if($menuItem->images->count() == 0)
                        <div class="text-muted mt-2">Chưa có ảnh</div>
                    @endif
                </div>
            </div>
        </div>

        <!-- THÔNG TIN -->
        <div class="col-lg-7 col-md-6">
            <div class="card shadow-sm rounded-4">
                <div class="card-body">

                    <table class="table table-borderless table-striped">
                        <tbody>
                            <tr>
                                <th width="35%">Mã sản phẩm</th>
                                <td>{{ $menuItem->code }}</td>
                            </tr>
                            <tr>
                                <th>Tên món</th>
                                <td class="fw-semibold">{{ $menuItem->name }}</td>
                            </tr>
                            <tr>
                                <th>Slug</th>
                                <td>{{ $menuItem->slug }}</td>
                            </tr>
                            <tr>
                                <th>Danh mục</th>
                                <td>{{ $menuItem->category->name ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Giá</th>
                                <td><strong class="text-primary">{{ number_format($menuItem->price) }} đ</strong></td>
                            </tr>
                            <tr>
                                <th>Trạng thái</th>
                                <td>
                                    @if($menuItem->is_available)
                                        <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>Đang bán</span>
                                    @else
                                        <span class="badge bg-secondary"><i class="bi bi-x-circle me-1"></i>Ngừng bán</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Ngày tạo</th>
                                <td>{{ $menuItem->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                            <tr>
                                <th>Cập nhật</th>
                                <td>{{ $menuItem->updated_at->format('d/m/Y H:i') }}</td>
                            </tr>
                            <tr>
                                <th>Mô tả</th>
                                <td>{{ $menuItem->description ?: '—' }}</td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
<style>
.hover-scale {
    transition: transform 0.3s;
}
.hover-scale:hover {
    transform: scale(1.1);
}
</style>


@endsection

@push('scripts')
@endpush
