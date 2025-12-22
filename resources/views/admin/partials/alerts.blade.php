@if(session('success') || session('error') || session('warning'))
<div class="home-alert-wrapper">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show home-alert" role="alert">
            <i class="bx bx-check-circle"></i>
            <span>{{ session('success') }}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show home-alert" role="alert">
            <i class="bx bx-error-circle"></i>
            <span>{{ session('error') }}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('warning'))
        <div class="alert alert-warning alert-dismissible fade show home-alert" role="alert">
            <i class="bx bx-error"></i>
            <span>{{ session('warning') }}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
</div>
@endif
