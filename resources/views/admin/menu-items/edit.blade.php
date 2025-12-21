@extends('admin.layouts.master')

@section('title', 'Quản lý sản phẩm - Take Away Express')
@section('page-title', 'Sản phẩm')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/products.css') }}">
@endpush

@section('content')
<div class="card shadow-lg border-0 overflow-hidden">
    <!-- HEADER -->
    <div class="card-header">
        <h4 class="mb-0"><i class="bi bi-pencil-square me-2"></i> Cập nhật món ăn</h4>
    </div>

    <div class="card-body">
        <form action="{{ route('admin.menu-items.update', $menu_item->id) }}"
              method="POST"
              enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row g-4">

                <!-- LEFT: Thông tin cơ bản -->
                <div class="col-md-6">
                    <!-- Danh mục -->
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label class="form-label fw-semibold">Danh mục</label>
                            <select name="category_id" class="form-select" required>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ $menu_item->category_id == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-6">
                            <label class="form-label fw-semibold">Mã sản phẩm</label>
                            <input type="text" class="form-control" name="code" value="{{ $menu_item->code }}" readonly>
                        </div>
                    </div>

                    <!-- Tên -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Tên món</label>
                        <input type="text"
                               name="name"
                               class="form-control"
                               value="{{ old('name', $menu_item->name) }}"
                               >
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Slug -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Slug</label>
                        <input type="text"
                               name="slug"
                               class="form-control"
                               value="{{ old('slug', $menu_item->slug) }}">
                        @error('slug')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Giá -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Giá (VNĐ)</label>
                        <div class="input-group">
                            <span class="input-group-text">₫</span>
                            <input type="number"
                                   name="price"
                                   class="form-control"
                                   value="{{ old('price', $menu_item->price) }}"
                                   >
                        </div>
                        @error('price')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Trạng thái -->
                    <div class="form-check form-switch mt-3">
                        <input class="form-check-input"
                               type="checkbox"
                               name="is_available"
                               value="1"
                               {{ old('is_available', $menu_item->is_available) ? 'checked' : '' }}>
                        <label class="form-check-label fw-semibold">Đang bán</label>
                        @error('is_available')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <!-- RIGHT: Mô tả + upload ảnh -->
                <div class="col-md-6">
                    <!-- Mô tả -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Mô tả</label>
                        <textarea name="description"
                                  class="form-control"
                                  rows="5">{{ old('description', $menu_item->description) }}</textarea>
                        @error('description')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Upload ảnh mới -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Thêm ảnh mới</label>
                        <input type="file"
                               name="images[]"
                               class="form-control"
                               multiple
                               id="imageInput">
                        @error('images')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror

                        <!-- Preview -->
                        <div class="row mt-3 g-2" id="previewImages"></div>
                    </div>
                </div>

            </div>

            <hr>

            <!-- ACTION -->
            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.menu-items.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Quay lại
                </a>

                <button type="submit" class="btn btn-primary px-4">
                    <i class="bi bi-save me-1"></i> Cập nhật
                </button>
            </div>
        </form>
    </div>
</div>

<!-- DANH SÁCH ẢNH -->
<div class="card shadow-lg border-0 rounded-4 mt-3">
    <div class="card-header bg-light">
        <h5 class="mb-0"><i class="bi bi-images me-1"></i> Ảnh món ăn</h5>
    </div>
    <div class="card-body">
        <div class="row g-3" id="imageList">
            @foreach($menu_item->images as $img)
                <div class="col-6 col-md-3 text-center" id="img-{{ $img->id }}">
                    <div class="border p-2 rounded {{ $img->is_featured ? 'border-success' : '' }}">
                        <img src="{{ asset($img->image_path) }}"
                             class="img-fluid rounded mb-2"
                             style="height:150px;object-fit:cover">

                        <div class="d-flex flex-column gap-1">
                            <!-- FEATURED -->
                            <button type="button"
                                    class="btn btn-sm {{ $img->is_featured ? 'btn-success' : 'btn-outline-success' }} btn-set-featured">
                                {{ $img->is_featured ? 'Đang hiển thị' : 'Chọn hiển thị' }}
                            </button>

                            <!-- DELETE -->
                            <button type="button"
                                    class="btn btn-sm btn-outline-danger btn-delete-image">
                                Xóa
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let newFiles = []; // Lưu các file mới đã chọn

// CHỌN ẢNH MỚI
$('#imageInput').on('change', function () {
    newFiles = [...this.files]; // copy vào mảng JS
    renderPreview();
});

// HIỂN THỊ PREVIEW ẢNH MỚI
function renderPreview() {
    const preview = $('#previewImages');
    preview.html('');
    newFiles.forEach((file, index) => {
        const reader = new FileReader();
        reader.onload = e => {
            preview.append(`
                <div class="col-md-3 text-center" id="preview-${index}">
                    <div class="border p-2 rounded shadow-sm position-relative">
                        <img src="${e.target.result}" class="img-fluid rounded mb-2" style="height:50px;object-fit:cover">
                        <button type="button" class="btn btn-sm btn-primary btn-add-image w-100" data-index="${index}">➕ Thêm</button>
                    </div>
                </div>
            `);
        };
        reader.readAsDataURL(file);
    });
}

// THÊM ẢNH VÀO DANH SÁCH
$(document).on('click', '.btn-add-image', function () {
    const index = $(this).data('index');
    const file = newFiles[index];
    const reader = new FileReader();

    reader.onload = e => {
        const html = `
            <div class="col-md-3 text-center" id="img-new-${index}">
                <div class="border p-2 rounded shadow-sm">
                    <img src="${e.target.result}" class="img-fluid rounded mb-2" style="height:175px;object-fit:cover">
                    <button type="button" class="btn btn-sm btn-outline-danger mt-2 btn-remove-new-image" data-index="${index}">Xóa</button>
                </div>
            </div>
        `;
        $('#imageList').append(html);

        // Xóa khỏi preview và mảng newFiles
        newFiles[index] = null;
        renderPreview();

        if(newFiles.every(f => f === null)){
            $('#imageInput').val('');
            newFiles = [];
        }
    };
    reader.readAsDataURL(file);
});

// SET FEATURED
$(document).on('click', '.btn-set-featured', function () {
    const btn = $(this);
    const container = btn.closest('.col-6, .col-md-3');
    const id = container.attr('id').replace('img-', '');

    $.post(`/admin/menu-item-images/${id}/set-featured`, { _token: '{{ csrf_token() }}' }, function (res) {
        if(res.success){
            $('#imageList .border').removeClass('border-success');
            $('#imageList .btn-set-featured')
                .removeClass('btn-success')
                .addClass('btn-outline-success')
                .text('Chọn hiển thị');

            container.find('.border').addClass('border-success');
            btn.removeClass('btn-outline-success').addClass('btn-success').text('Đang hiển thị');
        } else {
            alert('Cập nhật ảnh mặc định thất bại');
        }
    });
});

// DELETE IMAGE
$(document).on('click', '.btn-delete-image', function () {
    const container = $(this).closest('.col-6, .col-md-3');
    const id = container.attr('id').replace('img-', '');

    if(confirm('Bạn có chắc muốn xóa ảnh này?')){
        $.ajax({
            url: `/admin/menu-item-images/${id}`,
            type: 'DELETE',
            data: {_token: '{{ csrf_token() }}'},
            success: function(res){
                if(res.success){
                    container.remove();
                }
            }
        });
    }
});

// XÓA ẢNH MỚI TRONG DANH SÁCH
$(document).on('click', '.btn-remove-new-image', function () {
    const index = $(this).data('index');
    $('#img-new-' + index).remove();
    newFiles[index] = null;

    if(newFiles.every(f => f === null)){
        $('#imageInput').val('');
        newFiles = [];
    }
});
</script>
@endpush
