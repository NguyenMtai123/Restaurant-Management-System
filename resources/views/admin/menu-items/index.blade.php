<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h4>Quản lý món ăn</h4>
        <a href="{{ route('admin.menu-items.create') }}" class="btn btn-primary">Thêm món</a>
    </div>

    <div class="card-body table-responsive">
        <table class="table table-striped align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Ảnh</th>
                    <th>Tên món</th>
                    <th>Danh mục</th>
                    <th>Giá</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($menuItems as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                   <td>
                        <img
                            src="{{ $item->featuredImage
                                ? asset($item->featuredImage->image_path)
                                : asset('images/no-image.png') }}"
                            class="img-thumbnail open-image-modal"
                            style="width:60px;height:60px;cursor:pointer"
                            data-id="{{ $item->id }}"
                        >
                    </td>


                    <td>{{ $item->name }}</td>
                    <td>{{ $item->category->name ?? '' }}</td>
                    <td>{{ number_format($item->price) }} đ</td>

                    <td>
                        <a href="{{ route('admin.menu-items.edit',$item->id) }}"
                        class="btn btn-warning btn-sm">Sửa</a>
                        <a href="{{ route('admin.menu-items.show', $item->id) }}"
                        class="btn btn-info btn-sm">
                            Xem
                        </a>

                        <form action="{{ route('admin.menu-items.destroy',$item->id) }}"
                            method="POST" class="d-inline"
                            onsubmit="return confirm('Xóa món này?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">Xóa</button>
                        </form>
                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- IMAGE MODAL -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Quản lý ảnh món ăn</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <form id="uploadImagesForm" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="images[]" multiple class="form-control mb-3">
                    <button type="submit" class="btn btn-success">Tải ảnh</button>
                </form>

                <hr>

                <div class="row g-3" id="imageList"></div>

            </div>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
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
            // Reload danh sách trong modal
            loadImages();

            // Cập nhật ảnh mặc định trong bảng chính
            const imgTag = $('img.open-image-modal[data-id="' + res.menu_item_id + '"]');
            imgTag.attr('src', res.image_path);
        } else {
            alert('Cập nhật ảnh mặc định thất bại');
        }
    });
});


// DELETE IMAGE
$(document).on('click', '.btn-delete-image', function () {
    $.ajax({
        url: `/admin/menu-item-images/${$(this).data('id')}`,
        type: 'DELETE',
        data: {_token: '{{ csrf_token() }}'},
        success: loadImages
    });
});
</script>
