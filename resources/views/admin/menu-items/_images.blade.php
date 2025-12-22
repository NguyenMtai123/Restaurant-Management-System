@if($images->isEmpty())
    <div class="text-center text-muted">Chưa có ảnh</div>
@endif

@foreach($images as $img)
<div class="col-md-3 text-center">
    <div class="border p-2 rounded position-relative">

        <img src="{{ asset($img->image_path) }}"
             class="img-fluid mb-2"
             style="height:150px;object-fit:cover">

        @if($img->is_featured)
            <span class="badge bg-success position-absolute top-0 start-0 m-1">
                Mặc định
            </span>
        @endif

        <div class="d-flex justify-content-center gap-2 mt-2">
            <button class="btn btn-sm btn-outline-success btn-set-featured"
                    data-id="{{ $img->id }}">
                Chọn
            </button>

            <button class="btn btn-sm btn-outline-danger btn-delete-image"
                    data-id="{{ $img->id }}">
                Xóa
            </button>
        </div>

    </div>
</div>
@endforeach
