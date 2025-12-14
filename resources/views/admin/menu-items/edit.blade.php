<!-- Bootstrap 5 + Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

<div class="container mt-4">

    <!-- FORM SỬA MÓN ĂN -->
    <div class="card shadow-lg border-0 rounded-4 mb-4">
        <div class="card-header text-white" style="background:linear-gradient(135deg,#ffc107,#ff9800)">
            <h4 class="mb-0"><i class="bi bi-pencil-square me-2"></i> Sửa món ăn</h4>
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
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Danh mục</label>
                            <select name="category_id" class="form-select" required>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ $menu_item->category_id == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Tên -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Tên món</label>
                            <input type="text"
                                   name="name"
                                   class="form-control"
                                   value="{{ $menu_item->name }}"
                                   required>
                        </div>

                        <!-- Slug -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Slug</label>
                            <input type="text"
                                   name="slug"
                                   class="form-control"
                                   value="{{ $menu_item->slug }}">
                        </div>

                        <!-- Giá -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Giá (VNĐ)</label>
                            <div class="input-group">
                                <span class="input-group-text">₫</span>
                                <input type="number"
                                       name="price"
                                       class="form-control"
                                       value="{{ $menu_item->price }}"
                                       required>
                            </div>
                        </div>

                        <!-- Trạng thái -->
                        <div class="form-check form-switch mt-3">
                            <input class="form-check-input"
                                   type="checkbox"
                                   name="is_available"
                                   value="1"
                                   {{ $menu_item->is_available ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold">Đang bán</label>
                        </div>
                    </div>

                    <!-- RIGHT: Mô tả + upload ảnh -->
                    <div class="col-md-6">
                        <!-- Mô tả -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Mô tả</label>
                            <textarea name="description"
                                      class="form-control"
                                      rows="5">{{ $menu_item->description }}</textarea>
                        </div>

                        <!-- Upload ảnh mới -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Thêm ảnh mới</label>
                            <input type="file"
                                   name="images[]"
                                   class="form-control"
                                   multiple
                                   id="imageInput">

                            <!-- Preview -->
                            <div class="row mt-3 g-2" id="previewImages"></div>
                        </div>
                    </div>

                </div>

                <hr>

                <!-- ACTION -->
                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.menu-items.index') }}"
                       class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-1"></i> Quay lại
                    </a>

                    <button type="submit" class="btn btn-success px-4">
                        <i class="bi bi-save me-1"></i> Cập nhật
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- DANH SÁCH ẢNH -->
    <div class="card shadow-lg border-0 rounded-4">
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

</div>

<!-- JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
                        <img src="${e.target.result}" class="img-fluid rounded mb-2" style="height:150px;object-fit:cover">
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
                    <img src="${e.target.result}" class="img-fluid rounded mb-2" style="height:150px;object-fit:cover">
                    <button type="button" class="btn btn-sm btn-outline-danger mt-2 btn-remove-new-image" data-index="${index}">Xóa</button>
                </div>
            </div>
        `;
        $('#imageList').append(html);

        // Xóa khỏi preview và mảng newFiles
        newFiles[index] = null;
        renderPreview();

        // Nếu tất cả ảnh được thêm hoặc xóa → reset input file
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
            // Xóa highlight cũ
            $('#imageList .border').removeClass('border-success');
            $('#imageList .btn-set-featured')
                .removeClass('btn-success')
                .addClass('btn-outline-success')
                .text('Chọn hiển thị');

            // Highlight ảnh mới
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

    // reset input nếu mảng trống
    if(newFiles.every(f => f === null)){
        $('#imageInput').val('');
        newFiles = [];
    }
});
</script>
