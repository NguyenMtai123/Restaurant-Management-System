@extends('admin.layouts.master')
@section('title','Chỉnh sửa About')

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.abouts.update', $about->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Tiêu đề</label>
                <input type="text" name="title" class="form-control" required value="{{ old('title', $about->title) }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Nội dung liên hệ</label>
                <textarea name="content_contact" class="form-control" rows="5" required>{{ old('content_contact', $about->content_contact) }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Ảnh</label>
                @if($about->image)
                    <div class="mb-2">
                        <img src="{{ asset($about->image) }}" alt="Ảnh About" style="max-width:150px;">
                    </div>
                @endif
                <input type="file" name="image" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Địa chỉ</label>
                <input type="text" name="address" class="form-control" value="{{ old('address', $about->address) }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Map embed (iframe)</label>
                <textarea name="map_embed" class="form-control" rows="2">{{ old('map_embed', $about->map_embed) }}</textarea>
            </div>

            <div class="row">
                <div class="mb-3 col-md-6">
                    <label class="form-label">Số điện thoại</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone', $about->phone) }}">
                </div>

                <div class="mb-3 col-md-6">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $about->email) }}">
                </div>
            </div>

            <div class="form-check mb-3">
                <input type="hidden" name="is_used" value="0">
                    <input type="checkbox" name="is_used" value="1" class="form-check-input" id="is_used"
                        {{ old('is_used', $about->is_used) == 1 ? 'checked' : '' }}>

                <label class="form-check-label" for="is_used">Sử dụng About này</label>
            </div>


            <button type="submit" class="btn btn-primary">Cập nhật</button>
            <a href="{{ route('admin.abouts.index') }}" class="btn btn-light">Hủy</a>
        </form>
    </div>
</div>
@endsection
