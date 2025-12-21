@extends('admin.layouts.master')
@section('title','Chi tiết liên hệ')

@section('content')
<div class="card shadow-sm">
    <div class="card-body">
        <h5 class="mb-3">Thông tin liên hệ</h5>
        <ul class="list-group mb-3">
            <li class="list-group-item"><strong>Tên:</strong> {{ $contact->name }}</li>
            <li class="list-group-item"><strong>Email:</strong> {{ $contact->email }}</li>
            <li class="list-group-item"><strong>Phone:</strong> {{ $contact->phone ?? '—' }}</li>
            <li class="list-group-item"><strong>Chủ đề:</strong> {{ $contact->subject ?? '—' }}</li>
            <li class="list-group-item"><strong>Ngày gửi:</strong> {{ $contact->created_at->format('d/m/Y H:i') }}</li>
            <li class="list-group-item"><strong>Trạng thái:</strong>
                @if($contact->is_read)
                    <span class="badge bg-success">Đã đọc</span>
                @else
                    <span class="badge bg-secondary">Chưa đọc</span>
                @endif
            </li>
        </ul>

        <h5>Nội dung:</h5>
        <p>{{ $contact->message }}</p>

        <a href="{{ route('admin.contacts.index') }}" class="btn btn-light"><i class="bx bx-left-arrow"></i> Quay lại</a>
        <form action="{{ route('admin.contacts.destroy', $contact->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Bạn có chắc muốn xóa liên hệ này?')">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger"><i class="bx bx-trash"></i> Xóa</button>
        </form>
    </div>
</div>
@endsection
