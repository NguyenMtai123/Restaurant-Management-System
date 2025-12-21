@extends('admin.layouts.master')
@section('title','Quản lý liên hệ')

@section('content')
<div class="card shadow-sm mb-4">
    <div class="card-body">
        <form method="GET">
            <div class="row g-3">
                <div class="col-md-4">
                    <input type="text" name="keyword" class="form-control" placeholder="Tìm theo tên, email, chủ đề..." value="{{ request('keyword') }}">
                </div>
                <div class="col-md-2">
                    <button class="btn btn-outline-secondary">Tìm kiếm</button>
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
                    <th>Tên</th>
                    <th>Email</th>
                    <th>Chủ đề</th>
                    <th>Trạng thái</th>
                    <th>Ngày gửi</th>
                    <th class="text-end">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($contacts as $contact)
                <tr class="{{ !$contact->is_read ? 'fw-bold' : '' }}">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $contact->name }}</td>
                    <td>{{ $contact->email }}</td>
                    <td>{{ $contact->subject ?? '—' }}</td>
                    <td>
                        @if($contact->is_read)
                            <span class="badge bg-success">Đã đọc</span>
                        @else
                            <span class="badge bg-secondary">Chưa đọc</span>
                        @endif
                    </td>
                    <td>{{ $contact->created_at->format('d/m/Y H:i') }}</td>
                   <td class="text-end">
                        <a href="{{ route('admin.contacts.show', $contact->id) }}" class="btn btn-sm btn-info">
                            <i class="bx bx-show"></i> Xem
                        </a>

                        {{-- Chỉ hiện nút cập nhật trạng thái nếu chưa đọc --}}
                        @if(!$contact->is_read)
                        <a href="{{ route('admin.contacts.toggle-read', $contact->id) }}" class="btn btn-sm btn-warning">
                            <i class="bx bx-check"></i> Đánh dấu đã đọc
                        </a>
                        @endif

                        <form action="{{ route('admin.contacts.destroy', $contact->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Bạn có chắc muốn xóa liên hệ này?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger"><i class="bx bx-trash"></i> Xóa</button>
                        </form>
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-4">Không có liên hệ phù hợp</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer bg-white border-0 py-3">
        {{ $contacts->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
