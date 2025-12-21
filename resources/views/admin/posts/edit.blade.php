@extends('admin.layouts.master')
@section('title','Sửa bài viết')

@section('content')
<div class="card shadow-sm">
    <div class="card-body">
        <form method="POST"
              action="{{ route('admin.posts.update', $post->id) }}"
              enctype="multipart/form-data">
            @csrf
            @method('PUT') {{-- Quan trọng: PUT để update --}}

           <div class="row">
                <div class="mb-3 col-md-9">
                    <label>Tiêu đề</label>
                    <input type="text" name="title" class="form-control"
                           value="{{ old('title', $post->title) }}" required>
                </div>

                <div class="mb-3 col-md-3">
                    <label>Danh mục</label>
                    <select name="post_category_id" class="form-select" required>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}"
                                {{ old('post_category_id', $post->post_category_id) == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
           </div>

            <div class="mb-3">
                <label>Mô tả ngắn</label>
                <textarea name="excerpt" class="form-control" rows="2">{{ old('excerpt', $post->excerpt) }}</textarea>
            </div>

            <div class="mb-3">
                <label>Nội dung</label>
                <textarea id="editor" name="content_post" class="form-control">{{ old('content_post', $post->content_post) }}</textarea>
            </div>

            <div class="mb-3">
                <label>Ảnh đại diện</label>
                <input type="file" name="thumbnail" class="form-control">
                @if($post->thumbnail)
                    <img src="{{ asset($post->thumbnail) }}" class="mt-2" style="width:100px;height:70px;object-fit:cover">
                @endif
            </div>

            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" name="is_published" value="1"
                       {{ $post->is_published ? 'checked' : '' }}>
                <label class="form-check-label">Đăng bài</label>
            </div>

            <button class="btn btn-primary">Cập nhật</button>
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
