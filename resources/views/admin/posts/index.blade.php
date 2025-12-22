@extends('admin.layouts.master')
@section('title','Quản lý bài viết')

@section('content')
<div class="card shadow-sm mb-4">
    <div class="card-body">
        <form method="GET">
            <div class="row g-3 align-items-center">

                {{-- SEARCH --}}
                <div class="col-md-4">
                    <input type="text"
                           name="keyword"
                           class="form-control"
                           placeholder="Tìm tiêu đề..."
                           value="{{ request('keyword') }}">
                </div>

                {{-- CATEGORY --}}
                <div class="col-md-3">
                    <select name="category_id" class="form-select" onchange="this.form.submit()">
                        <option value="all">Tất cả danh mục</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}"
                                {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>

                </div>

                {{-- ACTION --}}
                <div class="col-md-5 text-end">
                    <button class="btn btn-outline-secondary">
                        <i class="bx bx-filter"></i> Lọc
                    </button>
                    <a href="{{ route('admin.posts.create') }}" class="btn btn-primary">
                        <i class="bx bx-plus"></i> Thêm bài viết
                    </a>
                </div>

            </div>
        </form>
    </div>
</div>

<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-light">
                <tr>
                    <th>#</th>
                    <th>Tiêu đề</th>
                    <th>Danh mục</th>
                    <th>Trạng thái</th>
                    <th class="text-end">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($posts as $post)
                    <tr>
                        <td>#{{ $post->id }}</td>
                        <td>
                            <strong>{{ $post->title }}</strong>
                            <br>
                            <small class="text-muted">{{ $post->code }}</small>
                        </td>
                        <td>{{ $post->category->name }}</td>
                        <td>
                            <span class="badge {{ $post->is_published ? 'bg-success' : 'bg-secondary' }}">
                                {{ $post->is_published ? 'Đã đăng' : 'Nháp' }}
                            </span>
                        </td>
                        <td class="text-end">
                            <a href="{{ route('admin.posts.edit', $post->id) }}" class="btn btn-sm btn-warning">
                                <i class="bx bx-edit"></i>
                            </a>

                            <!-- Nút xóa -->
                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $post->id }}">
                                <i class="bx bx-trash"></i>
                            </button>

                            <!-- Modal Xóa -->
                            <div class="modal fade" id="deleteModal-{{ $post->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <form action="{{ route('admin.posts.destroy', $post->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')

                                            <div class="modal-header">
                                                <h5 class="modal-title text-danger">Xóa bài viết</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>

                                            <div class="modal-body text-center">
                                                <i class="bx bx-trash fs-1 text-danger mb-2"></i>
                                                <p class="mb-0">
                                                    Bạn có chắc chắn muốn xóa bài viết
                                                    <strong>{{ $post->title }}</strong> không?
                                                </p>
                                            </div>

                                            <div class="modal-footer justify-content-center">
                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Hủy</button>
                                                <button type="submit" class="btn btn-danger">Xóa</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-4">
                            Không có bài viết
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
     <div class="card-footer bg-white border-0 py-3">
            <div class="d-flex justify-content-between align-items-center">
                <small class="text-muted">
                    Hiển thị {{ $posts->firstItem() }} –
                            {{ $posts->lastItem() }} / {{ $posts->total() }} bài viết
                </small>

                        {{ $posts->links('pagination::bootstrap-5') }}
            </div>
    </div>
</div>
@endsection
