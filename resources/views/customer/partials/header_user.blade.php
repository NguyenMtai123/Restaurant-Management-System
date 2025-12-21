<div class="user-actions">
    <button class="user-btn" id="userToggle"><i class="fas fa-user"></i></button>
    <div class="user-dropdown" id="userDropdown">
        <h4>Tài khoản</h4>
        @auth
            <a href="{{ route('profile.edit') }}" class="dropdown-item">
                <i class="fas fa-user-circle"></i> {{ auth()->user()->name }}
            </a>
            <a href="{{ route('logout') }}" class="dropdown-item"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt"></i> Đăng xuất
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
        @else
            <a href="{{ route('login') }}" class="dropdown-item"><i class="fas fa-user-circle"></i> Đăng nhập</a>
            <a href="{{ route('register') }}" class="dropdown-item"><i class="fas fa-user-plus"></i> Đăng ký</a>
        @endauth
        <a href="{{ route('orders.history') }}" class="dropdown-item"><i class="fas fa-history"></i> Lịch sử đơn hàng</a>
    </div>
</div>
