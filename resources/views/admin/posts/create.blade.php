@extends('admin.layouts.master')
@section('title','Thêm bài viết')

@section('content')
<div class="card shadow-sm">
    <div class="card-body">
        <form method="POST"
            action="{{ route('admin.posts.store') }}"
            enctype="multipart/form-data">
            @csrf

           <div class="row">
                <div class="mb-3 col-md-9">
                    <label>Tiêu đề</label>
                    <input type="text" name="title" class="form-control" required>
                </div>

                <div class="mb-3 col-md-3">
                    <label>Danh mục</label>
                    <select name="post_category_id" class="form-select" required>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
           </div>

            <div class="mb-3">
                <label>Mô tả ngắn</label>
                <textarea name="excerpt" class="form-control" rows="2"></textarea>
            </div>

            <div class="mb-3">
                <label>Nội dung</label>
                <textarea id="editor" name="content_post" class="form-control"></textarea>
            </div>

            <div class="mb-3">
                <label>Ảnh đại diện</label>
                <input type="file" name="thumbnail" class="form-control">
            </div>

            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" name="is_published" value="1">
                <label class="form-check-label">Đăng bài</label>
            </div>

            <button class="btn btn-primary">Lưu bài viết</button>
            <a href="{{ route('admin.posts.index') }}" class="btn btn-light">Quay lại</a>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('editor');
</script>
@endpush
