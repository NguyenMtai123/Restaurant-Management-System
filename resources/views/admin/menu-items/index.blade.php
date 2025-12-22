@extends('admin.layouts.master')

@section('title', 'Quản lý sản phẩm - Take Away Express')
@section('page-title', 'Sản phẩm')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/products.css') }}">
@endpush

@section('content')
    <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
        <div class="card-body p-3">
                  <form method="GET" action="{{ route('admin.menu-items.index') }}">
                    <div class="row align-items-center g-3">

                        {{-- SEARCH --}}
                        <div class="col-md-4">
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0">
                                    <i class='bx bx-search text-muted'></i>
                                </span>
                                <input
                                    type="text"
                                    name="keyword"
                                    class="form-control border-start-0 ps-0"
                                    placeholder="Tìm tên món ăn..."
                                    value="{{ request('keyword') }}"
                                >
                            </div>
                        </div>

                        {{-- CATEGORY --}}
                        <div class="col-md-3">
                            <select name="category_id" class="form-select">
                                <option value="all">Tất cả danh mục</option>
                                @foreach($categories as $cat)
                                    <option
                                        value="{{ $cat->id }}"
                                        {{ request('category_id') == $cat->id ? 'selected' : '' }}
                                    >
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- ACTION --}}
                        <div class="col-md-5 text-md-end">
                            <button class="btn btn-outline-secondary me-2">
                                <i class='bx bx-filter'></i> Lọc
                            </button>
                            <a href="{{ route('admin.menu-items.create') }}" class="btn btn-primary">
                                <i class='bx bx-plus'></i> Thêm món mới
                            </a>
                        </div>

                    </div>
                </form>
        </div>
    </div>
    <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-body p-0">
                    <div class="table-responsive">
                       <table class="table table-hover align-middle mb-0 product-table">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4" style="width: 50px;">#</th>
                                    <th>Sản phẩm</th>
                                    <th>Danh mục</th>
                                    <th>Giá bán</th>
                                    <th>Trạng thái</th>
                                    <th class="text-end pe-4">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                               @forelse($menuItems as $product)
                                    <tr>
                                        {{-- STT --}}
                                        <td class="ps-4 fw-bold text-muted">
                                            #{{ $menuItems->firstItem() + $loop->index }}
                                        </td>
                                        {{-- SẢN PHẨM --}}
                                        <td>
                                            <div class="product-img-group d-flex align-items-center gap-2">
                                                <img
                                                    src="{{ $product->featuredImage
                                                        ? asset($product->featuredImage->image_path)
                                                        : asset('images/no-image.png') }}"
                                                    class="product-thumb open-image-modal"
                                                    style="width:50px;height:50px;object-fit:cover;cursor:pointer"
                                                    data-id="{{ $product->id }}"
                                                    title="Click để quản lý ảnh"
                                                >
                                                <div class="product-info">
                                                    <h6 class="mb-0">{{ $product->name }}</h6>
                                                    <small class="text-muted">ID: {{ $product->code }}</small>
                                                </div>
                                            </div>
                                        </td>

                                        {{-- DANH MỤC --}}
                                        <td>
                                            <span class="badge bg-light text-dark border">
                                                {{ $product->category->name ?? '---' }}
                                            </span>
                                        </td>

                                        {{-- GIÁ --}}
                                        <td class="fw-bold">
                                            {{ number_format($product->price) }} đ
                                        </td>

                                        {{-- TRẠNG THÁI --}}
                                        <td>
                                        @php
                                                $statusClass = $product->is_available ? 'badge-stock' : 'badge-out';
                                                $statusText  = $product->is_available ? 'Còn hàng' : 'Hết hàng';
                                            @endphp

                                            <span class="badge rounded-pill {{ $statusClass }}">
                                                {{ $statusText }}
                                            </span>
                                        </td>

                                        {{-- ACTION --}}
                                        <td class="text-end pe-4">
                                            <a href="{{ route('admin.menu-items.edit', $product->id) }}"
                                            class="btn btn-sm btn-warning">
                                                <i class="bx bx-edit"></i>
                                            </a>
                                            <a href="{{ route('admin.menu-items.show', $product->id) }}"
                                            class="btn btn-primary btn-sm">
                                               <i class="bx bx-show"></i>
                                            </a>

                                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $product->id }}">
                                                <i class="bx bx-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <!-- Modal Xóa sản phẩm -->
                                    <div class="modal fade" id="deleteModal-{{ $product->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <form action="{{ route('admin.menu-items.destroy', $product->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <div class="modal-header">
                                                        <h5 class="modal-title text-danger">Xóa sản phẩm</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Bạn có chắc chắn muốn xóa sản phẩm <strong>{{ $product->name }}</strong> không?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Hủy</button>
                                                        <button type="submit" class="btn btn-danger">Xóa</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                               @empty
                                    {{-- 🔔 THÔNG BÁO KHÔNG CÓ KẾT QUẢ --}}
                                    <tr>
                                        <td colspan="6" class="text-center py-5">
                                            <p class="mb-0 fw-semibold">Không tìm thấy sản phẩm phù hợp</p>
                                            <small class="text-muted">
                                                Vui lòng thử từ khóa khác hoặc thay đổi bộ lọc
                                            </small>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white border-0 py-3">
                    <div class="d-flex justify-content-between align-items-center">

                        {{-- Thông tin --}}
                        <div class="text-muted small">
                            Hiển thị
                            <strong>{{ $menuItems->firstItem() }}</strong>
                            –
                            <strong>{{ $menuItems->lastItem() }}</strong>
                            /
                            <strong>{{ $menuItems->total() }}</strong> sản phẩm
                        </div>

                        {{-- Pagination --}}
                        {{ $menuItems->links('pagination::bootstrap-5') }}

                    </div>
                </div>

        </div>
     @include('admin.partials.modals.image-modal')
@endsection
@push('scripts')
<script src="{{ asset('js/products.js') }}"></script>
<script>
    document.querySelector('select[name="category_id"]').addEventListener('change', function () {
        this.form.submit();
    });
</script>

<script>
let currentMenuItemId = null;
let modal;

$(document).ready(function () {

    modal = new bootstrap.Modal(document.getElementById('imageModal'), {
        backdrop: 'static',
        keyboard: false
    });

    // CLICK ẢNH → MỞ MODAL
    $(document).on('click', '.open-image-modal', function () {
        currentMenuItemId = $(this).data('id');

        if (!currentMenuItemId) {
            alert('Không xác định được món ăn');
            return;
        }

        modal.show();
        loadImages();
    });

    // UPLOAD
    $('#uploadImagesForm').on('submit', function (e) {
        e.preventDefault();

        let formData = new FormData(this);

        $.ajax({
            url: `/admin/menu-items/${currentMenuItemId}/images`,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,

            success: function () {
                $('#uploadImagesForm')[0].reset();
                loadImages();
                showAlert('success', 'Upload ảnh thành công');
            },

            error: function () {
                showAlert('error', 'Upload ảnh thất bại');
            }
        });
    });
});

// LOAD ẢNH
function loadImages() {
    $('#imageList').html('<div class="text-center">Đang tải...</div>');

    $('#imageList').load(`/admin/menu-items/${currentMenuItemId}/images`);
}

// SET FEATURED
$(document).on('click', '.btn-set-featured', function () {
    const imageId = $(this).data('id');

    $.post(`/admin/menu-item-images/${imageId}/set-featured`, {
        _token: '{{ csrf_token() }}'
    }, function (res) {

        if (res.success) {
            loadImages();

            const imgTag = $('img.open-image-modal[data-id="' + res.menu_item_id + '"]');
            imgTag.attr('src', res.image_path);

            showAlert('success', 'Đã đặt ảnh mặc định');
        } else {
            showAlert('error', 'Không thể đặt ảnh mặc định');
        }

    }).fail(() => {
        showAlert('error', 'Lỗi hệ thống khi cập nhật ảnh');
    });
});



// DELETE IMAGE
$(document).on('click', '.btn-delete-image', function () {
    $.ajax({
        url: `/admin/menu-item-images/${$(this).data('id')}`,
        type: 'DELETE',
        data: {_token: '{{ csrf_token() }}'},

        success: function () {
            loadImages();
            showAlert('warning', 'Đã xóa ảnh');
        },

        error: function () {
            showAlert('error', 'Xóa ảnh thất bại');
        }
    });
});

</script>
@endpush
