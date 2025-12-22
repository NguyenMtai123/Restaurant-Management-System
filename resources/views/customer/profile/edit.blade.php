@extends('customer.layouts.app')

@section('title', 'Chỉnh sửa thông tin cá nhân')

@section('content')
<div class="profile-container">
    <h2>Chỉnh sửa thông tin cá nhân</h2>

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="avatar-section">
            <label>Ảnh đại diện</label>
            <img id="avatarPreview"
                src="{{ $user->avatar ? asset('images/avatars/'.$user->avatar) : asset('images/default-avatar.png') }}"
                alt="Avatar" style="cursor:pointer;">
            <input type="file" id="avatar" name="avatar" style="display:none;">
            @error('avatar') <small class="error">{{ $message }}</small> @enderror
        </div>


        <div class="form-group">
            <label for="name">Họ và tên</label>
            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}">
            @error('name') <small class="error">{{ $message }}</small> @enderror
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" value="{{ $user->email }}" disabled>
        </div>

        <div class="form-group">
            <label for="phone">Số điện thoại</label>
            <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
            @error('phone') <small class="error">{{ $message }}</small> @enderror
        </div>

        <div class="form-group">
            <label for="address">Địa chỉ</label>
            <textarea id="address" name="address">{{ old('address', $user->address) }}</textarea>
            @error('address') <small class="error">{{ $message }}</small> @enderror
        </div>

        <button type="submit">Cập nhật thông tin</button>
    </form>
</div>

<style>
/* Container */
.profile-container {
    max-width: 700px;
    margin: 50px auto;
    padding: 30px;
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    font-family: 'Poppins', sans-serif;
}

/* Heading */
.profile-container h2 {
    text-align: center;
    margin-bottom: 25px;
    color: #FF6B35;
}

/* Avatar section */
.avatar-section {
    text-align: center;
    margin-bottom: 20px;
}
.avatar-section img {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid #FF6B35;
    display: block;
    margin: 0 auto 10px;
    transition: transform 0.3s;
}
.avatar-section img:hover {
    transform: scale(1.05);
}
.avatar-section input[type="file"] {
    display: block;
    margin: 0 auto;
}

/* Form groups */
.form-group {
    margin-bottom: 15px;
}
.form-group label {
    display: block;
    font-weight: 600;
    margin-bottom: 5px;
}
.form-group input,
.form-group textarea {
    width: 100%;
    padding: 10px 12px;
    border: 1px solid #ccc;
    border-radius: 6px;
    font-size: 16px;
    transition: border 0.3s, box-shadow 0.3s;
}
.form-group input:focus,
.form-group textarea:focus {
    border-color: #FF6B35;
    box-shadow: 0 0 5px rgba(255, 107, 53, 0.5);
    outline: none;
}
textarea {
    resize: vertical;
}

/* Error messages */
.error {
    color: red;
    font-size: 14px;
}

/* Button */
button {
    width: 100%;
    padding: 12px;
    font-size: 18px;
    background-color: #FF6B35;
    color: #fff;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    transition: background-color 0.3s;
}
button:hover {
    background-color: #ff824c;
}
</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Cập nhật thành công 🎉',
            html: `<p>{{ session('success') }}</p>`,
            confirmButtonText: 'OK'
        });
    @elseif(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Cập nhật thất bại ❌',
            html: `<p>{{ session('error') }}</p>`,
            confirmButtonText: 'OK'
        });
    @endif
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const avatarImg = document.getElementById('avatarPreview');
    const avatarInput = document.getElementById('avatar');

    // Nhấn vào hình sẽ mở input file
    avatarImg.addEventListener('click', () => avatarInput.click());

    // Khi chọn file, show preview
    avatarInput.addEventListener('change', (e) => {
        const file = e.target.files[0];
        if(file) {
            const reader = new FileReader();
            reader.onload = function(ev) {
                avatarImg.src = ev.target.result;
            }
            reader.readAsDataURL(file);
        }
    });
});

</script>
@endsection
