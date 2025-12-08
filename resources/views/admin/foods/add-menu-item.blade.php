<!-- Thêm link Bootstrap 5 -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Thêm Món Ăn</h4>
        </div>
        <div class="card-body">
            <form id="addMenuItemForm" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label for="category_id" class="form-label">Danh mục</label>
                    <select name="category_id" id="category_id" class="form-select" required>
                        <option value="">-- Chọn danh mục --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="name" class="form-label">Tên món</label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Nhập tên món" required>
                </div>

                <div class="mb-3">
                    <label for="slug" class="form-label">Slug (tùy chọn)</label>
                    <input type="text" name="slug" id="slug" class="form-control" placeholder="Nhập slug hoặc để trống">
                </div>

                <div class="mb-3">
                    <label for="price" class="form-label">Giá</label>
                    <input type="number" name="price" id="price" class="form-control" placeholder="Nhập giá" required>
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">Ảnh món ăn</label>
                    <input type="file" name="image" id="image" class="form-control">
                </div>

                <button type="submit" class="btn btn-success">Thêm món</button>
            </form>
        </div>
    </div>
</div>

<!-- Axios + JS -->
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
document.getElementById('addMenuItemForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);

    axios.post('/api/menu-items', formData, { headers: {'Content-Type': 'multipart/form-data'} })
        .then(res => {
            alert(res.data.message);
            this.reset(); // reset form sau khi thêm thành công
        })
        .catch(err => {
            if(err.response && err.response.data && err.response.data.errors){
                let messages = [];
                for(const key in err.response.data.errors){
                    messages.push(err.response.data.errors[key].join(', '));
                }
                alert('Lỗi:\n' + messages.join('\n'));
            } else {
                console.error(err.response.data);
                alert('Có lỗi xảy ra. Kiểm tra console.');
            }
        });
});
</script>
