<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý nhà hàng</title>

    <!-- Bootstrap CSS + Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>🍽️ Quản lý nhà hàng</h2>
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createRestaurantModal">
            <i class="bi bi-plus-circle me-1"></i> Thêm nhà hàng
        </button>
    </div>

    <!-- ALERT -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- TABLE -->
    <div class="card shadow-sm rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle mb-0">
                    <thead class="table-light text-center">
                        <tr>
                            <th>ID</th>
                            <th class="text-start">Tên nhà hàng</th>
                            <th class="text-start">Địa chỉ</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($restaurants as $restaurant)
                        <tr class="text-center">
                            <td>{{ $restaurant->id }}</td>
                            <td class="text-start">{{ $restaurant->name }}</td>
                            <td class="text-start">{{ $restaurant->address }}</td>
                            <td>
                                <!-- Sửa -->
                                <button class="btn btn-primary btn-sm me-1" data-bs-toggle="modal" data-bs-target="#editRestaurantModal-{{ $restaurant->id }}">
                                    <i class="bi bi-pencil-square"></i>
                                </button>

                                <!-- Xóa -->
                                <form action="{{ route('admin.restaurants.destroy', $restaurant) }}" method="POST" class="d-inline" onsubmit="return confirm('Xác nhận xóa?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>

                        <!-- Modal Edit -->
                        <div class="modal fade" id="editRestaurantModal-{{ $restaurant->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Sửa nhà hàng: {{ $restaurant->name }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('admin.restaurants.update', $restaurant) }}" method="POST">
                                            @csrf
                                            @method('PUT')

                                            <div class="mb-3">
                                                <label for="name-{{ $restaurant->id }}" class="form-label">Tên nhà hàng</label>
                                                <input type="text" class="form-control" id="name-{{ $restaurant->id }}" name="name" value="{{ $restaurant->name }}" required>
                                            </div>

                                            <div class="mb-3">
                                                <label for="address-{{ $restaurant->id }}" class="form-label">Địa chỉ</label>
                                                <input type="text" class="form-control" id="address-{{ $restaurant->id }}" name="address" value="{{ $restaurant->address }}" required>
                                            </div>

                                            <div class="text-end">
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="bi bi-save me-1"></i> Cập nhật
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">Chưa có nhà hàng nào</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<!-- Modal Thêm -->
<div class="modal fade" id="createRestaurantModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Thêm nhà hàng mới</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.restaurants.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Tên nhà hàng</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Địa chỉ</label>
                        <input type="text" class="form-control" id="address" name="address" required>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-save me-1"></i> Thêm
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
