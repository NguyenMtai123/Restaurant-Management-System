<div class="sidebar">
    <div class="logo-details">
        <i class='fas fa-utensils'></i>
        <div>
            <span class="logo_name">Take Away</span>
            <span class="logo_sub">Express Admin</span>
        </div>
    </div>
    <ul class="nav-links">
        <li class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <a href="{{ route('admin.dashboard') }}">
                <i class='bx bx-grid-alt'></i>
                <span class="link_name">Dashboard</span>
            </a>
        </li>
        <li class="{{ request()->routeIs('admin.menu-items.*') ? 'active' : '' }}">
            <a href="{{ route('admin.menu-items.index') }}">
                <i class='bx bx-box'></i>
                <span class="link_name">Sản phẩm</span>
            </a>
        </li>
        <li class="{{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
            <a href="{{ route('admin.orders.index') }}">
                <i class='bx bx-list-ul'></i>
                <span class="link_name">Đơn hàng</span>
            </a>
        </li>
        <li class="{{ request()->routeIs('admin.posts.*') ? 'active' : '' }}">
            <a href="{{ route('admin.posts.index') }}">
                <i class='bx bx-news'></i>
                <span class="link_name">Bài viết</span>
            </a>
        </li>

        <li class="{{ request()->routeIs('admin.statistic') ? 'active' : '' }}">
            <a href="{{ route('admin.statistic') }}">
                <i class='bx bx-pie-chart-alt-2'></i>
                <span class="link_name">Thống kê</span>
            </a>
        </li>

        {{-- <li class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
            <a href="{{ route('admin.categories.index') }}">
                <i class='bx bx-pie-chart-alt-2'></i>
                <span class="link_name">Danh mục</span>
            </a>
        </li> --}}
        <li class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
            <a href="{{ route('admin.users.index') }}">
                <i class='bx bx-user'></i>
                <span class="link_name">Khách hàng</span>
            </a>
        </li>
        <li class="{{ request()->routeIs('admin.employees.*') ? 'active' : '' }}">
            <a href="{{ route('admin.employees.index') }}">
                <i class='bx bx-id-card'></i>
                <span class="link_name">Nhân viên</span>
            </a>
        </li>
        <li class="{{ request()->routeIs('admin.settings') ? 'active' : '' }}">
            <a href="{{ route('admin.settings') }}">
                <i class='bx bx-cog'></i>
                <span class="link_name">Thiết lập</span>
            </a>
        </li>

    </ul>
    <div class="sidebar-footer">
        <div class="d-grid gap-2">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-outline-danger btn-sm d-flex align-items-center justify-content-center gap-2">
                    <i class='bx bx-log-out'></i> Đăng xuất
                </button>
            </form>
        </div>
    </div>
</div>
