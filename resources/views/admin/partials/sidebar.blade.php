<div class="sidebar">
    <div class="logo-details">
        <i class='fas fa-utensils'></i>
        <div>
            <span class="logo_name">Take Away</span>
            <span class="logo_sub">Express Admin</span>
        </div>
    </div>

    <ul class="nav-links">
        @php $user = Auth::user(); @endphp

        @if($user->hasPermission('view_dashboard'))
        <li class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <a href="{{ route('admin.dashboard') }}">
                <i class='bx bx-grid-alt'></i>
                <span class="link_name">Dashboard</span>
            </a>
        </li>
        @endif

        @if($user->hasPermission('manage_menu'))
        <li class="{{ request()->routeIs('admin.menu-items.*') ? 'active' : '' }}">
            <a href="{{ route('admin.menu-items.index') }}">
                <i class='bx bx-box'></i>
                <span class="link_name">Sản phẩm</span>
            </a>
        </li>
        @endif

        @if($user->hasPermission('manage_orders'))
        <li class="{{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
            <a href="{{ route('admin.orders.index') }}">
                <i class='bx bx-list-ul'></i>
                <span class="link_name">Đơn hàng</span>
            </a>
        </li>
        @endif

        @if($user->hasPermission('manage_coupons'))
        <li class="{{ request()->routeIs('admin.coupons.*') ? 'active' : '' }}">
            <a href="{{ route('admin.coupons.index') }}">
                <i class='bx bx-purchase-tag'></i>
                <span class="link_name">Mã giảm giá</span>
            </a>
        </li>
        @endif

        {{-- @if($user->hasPermission('manage_posts'))
        <li class="{{ request()->routeIs('admin.posts.*') ? 'active' : '' }}">
            <a href="{{ route('admin.posts.index') }}">
                <i class='bx bx-news'></i>
                <span class="link_name">Bài viết</span>
            </a>
        </li>
        @endif --}}

        @if($user->hasPermission('view_statistics'))
        <li class="{{ request()->routeIs('admin.statistic') ? 'active' : '' }}">
            <a href="{{ route('admin.statistic') }}">
                <i class='bx bx-pie-chart-alt-2'></i>
                <span class="link_name">Thống kê</span>
            </a>
        </li>

        @endif

        @if($user->hasPermission('manage_users'))
        <li class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
            <a href="{{ route('admin.users.index') }}">
                <i class='bx bx-user'></i>
                <span class="link_name">Khách hàng</span>
            </a>
        </li>
        @endif

        @if($user->hasPermission('manage_employees'))
        <li class="{{ request()->routeIs('admin.employees.*') ? 'active' : '' }}">
            <a href="{{ route('admin.employees.index') }}">
                <i class='bx bx-id-card'></i>
                <span class="link_name">Nhân viên</span>
            </a>
        </li>
        @endif

        @if($user->hasPermission('manage_settings'))
        <li class="{{ request()->routeIs('admin.settings') ? 'active' : '' }}">
            <a href="{{ route('admin.settings') }}">
                <i class='bx bx-cog'></i>
                <span class="link_name">Thiết lập</span>
            </a>
        </li>
        @endif
    </ul>

    <div class="sidebar-footer">
        <div class="d-grid gap-2">
            <button type="button" class="btn btn-outline-danger btn-sm d-flex align-items-center justify-content-center gap-2"
                    data-bs-toggle="modal" data-bs-target="#logoutModal">
                <i class='bx bx-log-out'></i> Đăng xuất
            </button>
        </div>
    </div>
</div>
