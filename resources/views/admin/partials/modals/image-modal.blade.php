<div class="modal fade" id="imageModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Quản lý hình ảnh</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    {{-- FORM UPLOAD --}}
                    <form id="uploadImagesForm" enctype="multipart/form-data">
                        @csrf
                        <input type="file" name="images[]" multiple class="form-control mb-3">
                        <button class="btn btn-primary btn-sm">Upload</button>
                    </form>

                    <hr>

                    {{-- DANH SÁCH ẢNH --}}
                    <div class="row g-3" id="imageList"></div>
                </div>
            </div>
        </div>
    </div>
