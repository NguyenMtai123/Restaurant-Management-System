
<div class="container">
    <h2>Danh sách danh mục món</h2>

    <a href="{{ route('categories.create') }}" class="btn btn-success mb-3">Thêm danh mục mới</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên</th>
                <th>Slug</th>
                <th>Mô tả</th>
                <th>Ngày tạo</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $cat)
            <tr>
                <td>{{ $cat->id }}</td>
                <td>{{ $cat->name }}</td>
                <td>{{ $cat->slug }}</td>
                <td>{{ $cat->description }}</td>
                <td>{{ $cat->created_at->format('d/m/Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
