<head>
    <title>Quên mật khẩu</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
</head>
<div class="login-container">
    <div class="login-title">Quên mật khẩu</div>
    <div class="login-logo">
        <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" alt="Logo">
    </div>

    {{-- Bước 1: Gửi OTP --}}
    <form id="step1" autocomplete="off">
        @csrf
        <div class="form-group">
            <label>Email:</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>
        <button type="submit" class="login-btn">Gửi mã OTP</button>
    </form>

    {{-- Bước 2: Nhập OTP --}}
    <form id="step2" style="display:none;" autocomplete="off">
        @csrf
        <div class="form-group">
            <label>Nhập mã OTP đã gửi về email:</label>
            <input type="text" name="otp" id="otp" class="form-control" required>
        </div>
        <button type="submit" class="login-btn">Xác thực OTP</button>
    </form>

    {{-- Bước 3: Đặt lại mật khẩu --}}
    <form id="step3" style="display:none;" autocomplete="off">
        @csrf
        <div class="form-group">
            <label>Mật khẩu mới:</label>
            <input type="password" name="password" id="password" class="form-control" required minlength="6">
        </div>
        <div class="form-group">
            <label>Xác nhận mật khẩu:</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required minlength="6">
        </div>
        <button type="submit" class="login-btn">Đặt lại mật khẩu</button>
    </form>

    <div id="error" class="mt-3 text-danger text-center"></div>
    <div id="success" class="mt-3 text-success text-center"></div>
    <a href="/login" class="d-block text-center mt-3">Quay lại đăng nhập</a>
</div>

<div class="bg-login"></div>

<script src="{{ asset('js/forgot_password.js') }}"></script>
