@php
    $admin = Auth::user();
@endphp
<nav>
    <div class="sidebar-button">
        <i class='bx bx-menu sidebarBtn'></i>
        <span class="dashboard">Dashboard</span>
    </div>

    <div class="current-date-box ms-auto me-3 d-none d-md-block">
        <span class="text-muted small fw-bold" id="currentDateDisplay"></span>
    </div>

    <div class="profile-details">
        <div class="position-relative" id="notifDropdownBtn" style="cursor: pointer;">
            <i class='bx bx-bell' style="font-size: 24px;"></i>
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger border border-light p-1">
                <span class="visually-hidden">New alerts</span>
            </span>
        </div>

        <div class="notification-dropdown" id="notifDropdown">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="m-0 fw-bold">Thông báo mới</h6>
                <small class="text-primary" style="cursor: pointer;">Đánh dấu đã đọc</small>
            </div>
            <div class="notification-list">
                <div class="notification-item">
                    <div class="notif-icon"><i class="fas fa-receipt"></i></div>
                    <div>
                        <p class="mb-0 small fw-bold">Đơn hàng mới #1234</p>
                        <small class="text-muted">Vừa xong</small>
                    </div>
                </div>
                <div class="notification-item">
                    <div class="notif-icon text-warning"><i class="fas fa-user-plus"></i></div>
                    <div>
                        <p class="mb-0 small fw-bold">Khách hàng mới đăng ký</p>
                        <small class="text-muted">5 phút trước</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="dropdown">
            <a href="#" class="d-flex align-items-center link-dark text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="{{ $admin->avatar
                    ? asset('images/avatars/'.$admin->avatar)
                    : 'https://ui-avatars.com/api/?name='.urlencode($admin->name).'&background=ff6b35&color=fff' }}"
                    alt="Avatar" class="user-avatar me-2">
                <span class="d-none d-md-block fw-semibold">{{ $admin->name }}</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end shadow border-0 text-small" aria-labelledby="dropdownUser1">
                <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#profileModal">Hồ sơ</a></li>
                <li><a class="dropdown-item" href="{{ route('admin.settings') }}">Cài đặt</a></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <button type="button" class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#logoutModal">
                        Đăng xuất
                    </button>
                </li>

            </ul>
        </div>
    </div>
</nav>
