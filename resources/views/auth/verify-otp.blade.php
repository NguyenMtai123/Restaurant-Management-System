@extends('layouts.auth')
@section('content')
<div class="login-form otp-form">
    <h2>Xác nhận email</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <p>Chúng tôi đã gửi mã OTP vào email <strong>{{ $email }}</strong></p>

    <form action="{{ route('register.verify-otp') }}" method="POST" id="otpForm">
        @csrf
        <input type="hidden" name="email" value="{{ $email }}">
        <div class="otp-inputs">
            @for($i = 0; $i < 6; $i++)
                <input type="text" inputmode="numeric" pattern="\d*" maxlength="1" class="otp-box" required>
            @endfor
        </div>
        @error('otp') <span class="text-danger">{{ $message }}</span> @enderror
        <button type="submit">Xác nhận</button>
    </form>
</div>

<style>
.otp-form {
    max-width: 400px;
    margin: 0 auto;
    text-align: center;
}

.otp-inputs {
    display: flex;
    justify-content: space-between;
    margin: 20px 0;
}

.otp-box {
    width: 50px;
    height: 50px;
    font-size: 24px;
    text-align: center;
    border: 2px solid #ccc;
    border-radius: 8px;
    transition: border-color 0.2s;
}

.otp-box:focus {
    border-color: #007bff;
    outline: none;
}
button {
    width: 100%;
    padding: 12px;
    background: #ff8800;
    color: #fff;
    border: none;
    border-radius: 8px;
    font-size: 16px;
    cursor: pointer;
}
button:hover {
    background: #b36e00;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const inputs = document.querySelectorAll('.otp-box');

    inputs.forEach((input, idx) => {
        input.addEventListener('input', () => {
            if (input.value.length > 0 && idx < inputs.length - 1) {
                inputs[idx + 1].focus();
            }
        });

        input.addEventListener('keydown', (e) => {
            if (e.key === 'Backspace' && input.value === '' && idx > 0) {
                inputs[idx - 1].focus();
            }
        });
    });

    const form = document.getElementById('otpForm');
    form.addEventListener('submit', (e) => {
        // Gộp 6 ô thành 1 input ẩn
        e.preventDefault();
        let otp = '';
        inputs.forEach(i => otp += i.value);
        if(otp.length < 6) {
            alert('Vui lòng nhập đủ 6 chữ số OTP');
            return;
        }
        const hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'otp';
        hiddenInput.value = otp;
        form.appendChild(hiddenInput);
        form.submit();
    });
});
</script>
@endsection
