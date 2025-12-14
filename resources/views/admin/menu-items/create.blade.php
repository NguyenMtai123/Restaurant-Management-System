<!-- Bootstrap 5 + Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

<div class="container mt-4">
    <div class="card shadow-lg border-0 rounded-4 overflow-hidden">

        <!-- HEADER -->
        <div class="card-header text-white py-3"
             style="background:linear-gradient(135deg,#0d6efd,#6610f2)">
            <h4 class="mb-0">
                <i class="bi bi-plus-circle me-2"></i> Thêm món ăn mới
            </h4>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.menu-items.store') }}"
                  method="POST"
                  enctype="multipart/form-data">
                @csrf

                <div class="row g-4">

                    <!-- LEFT -->
                    <div class="col-md-6">

                        <!-- Danh mục -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Danh mục</label>
                            <select name="category_id" class="form-select" required>
                                <option value="">-- Chọn danh mục --</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <!-- Tên -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Tên món</label>
                            <input type="text"
                                   name="name"
                                   class="form-control"
                                   placeholder="VD: Cơm gà xối mỡ"
                                   value="{{ old('name') }}"
                                   required>
                        </div>

                        <!-- Slug -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Slug</label>
                            <input type="text"
                                   name="slug"
                                   class="form-control"
                                   placeholder="Tuỳ chọn"
                                   value="{{ old('slug') }}">
                        </div>

                        <!-- Giá -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Giá (VNĐ)</label>
                            <div class="input-group">
                                <span class="input-group-text">₫</span>
                                <input type="number"
                                       name="price"
                                       class="form-control"
                                       placeholder="50000"
                                       value="{{ old('price') }}"
                                       required>
                            </div>
                        </div>

                        <!-- Trạng thái -->
                        <div class="form-check form-switch mt-4">
                            <input class="form-check-input"
                                   type="checkbox"
                                   name="is_available"
                                   value="1"
                                   checked>
                            <label class="form-check-label fw-semibold">
                                Đang bán
                            </label>
                        </div>

                    </div>

                    <!-- RIGHT -->
                    <div class="col-md-6">

                        <!-- Mô tả -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Mô tả</label>
                            <textarea name="description"
                                      class="form-control"
                                      rows="5"
                                      placeholder="Mô tả món ăn...">{{ old('description') }}</textarea>
                        </div>

                        <!-- Upload ảnh -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Ảnh món ăn</label>
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
                       class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-1"></i> Quay lại
                    </a>

                    <button type="submit"
                            class="btn btn-success px-4">
                        <i class="bi bi-save me-1"></i> Lưu món ăn
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('imageInput').addEventListener('change', function () {
    const preview = document.getElementById('previewImages');
    preview.innerHTML = '';

    [...this.files].forEach(file => {
        const reader = new FileReader();
        reader.onload = e => {
            preview.innerHTML += `
                <div class="col-4">
                    <div class="border rounded-3 overflow-hidden shadow-sm">
                        <img src="${e.target.result}"
                             class="w-100"
                             style="height:100px;object-fit:cover">
                    </div>
                </div>
            `;
        };
        reader.readAsDataURL(file);
    });
});
</script>
