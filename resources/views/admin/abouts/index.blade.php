@extends('admin.layouts.master')
@section('title','Quản lý About')

@section('content')
<div class="card mb-4 shadow-sm" style="border-radius:12px;">
    <div class="card-body d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Danh sách About</h5>
        <a href="{{ route('admin.abouts.create') }}" class="btn btn-primary">
            <i class="bx bx-plus"></i> Thêm About
        </a>
    </div>
</div>

<div class="card shadow-sm" style="border-radius:12px;">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-light">
                <tr>
                    <th class="ps-4">#</th>
                    <th>Tiêu đề</th>
                    <th>Trạng thái</th>
                    <th>Ngày tạo</th>
                    <th class="text-end pe-4">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($abouts as $about)
                <tr class="{{ $about->is_used ? 'table-success' : '' }}">
                    <td class="ps-4 fw-bold text-muted">{{ $loop->iteration }}</td>
                    <td>{{ $about->title }}</td>
                    <td>
                        @if($about->is_used)
                            <span class="badge bg-success">Đang sử dụng</span>
                        @else
                            <span class="badge bg-secondary">Chưa sử dụng</span>
                        @endif
                    </td>
                    <td>{{ $about->created_at->format('d/m/Y H:i') }}</td>
                    <td class="text-end">
                        <a href="{{ route('admin.abouts.edit', $about->id) }}" class="btn btn-sm btn-warning" title="Sửa About">
                            <i class="bx bx-edit"></i>
                        </a>
                        <form action="{{ route('admin.abouts.destroy', $about->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Bạn có chắc muốn xóa About này?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" title="Xóa About"><i class="bx bx-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-4">Chưa có About</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($abouts->hasPages())
    <div class="card-footer bg-white border-0 py-3 d-flex justify-content-end">
        {{ $abouts->links('pagination::bootstrap-5') }}
    </div>
    @endif
</div>
@endsection
