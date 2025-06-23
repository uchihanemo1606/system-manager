<head>
    <title>Đăng Nhập</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<div class="login-container">
    <div class="login-title">Đăng Nhập</div>
    <div class="login-logo">
        <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" alt="Logo">
    </div>
    <form id="loginForm" autocomplete="off">
        @csrf
        <div class="form-group">
            <input
                type="text"
                name="username"
                required
                class="form-input"
                placeholder=" "
                autocomplete="username">
            <label class="form-label">Username</label>
        </div>
        <div class="form-group">
            <input
                type="password"
                name="password"
                required
                class="form-input"
                placeholder=" "
                autocomplete="current-password">
            <label class="form-label">Mật khẩu</label>
        </div>
        <div class="form-group">
            <div class="flex items-center justify-between">
                <label class="flex items-center">
                    <input type="checkbox" name="remember" class="mr-2">
                    <span>Nhớ tài khoản</span>
                </label>
                <a class="text-sm text-blue-500 hover:text-blue-700">Quên mật khẩu?</a>
            </div>
        </div>
        <button type="submit" class="login-btn">Đăng Nhập</button>
    </form>
    <div id="error"></div>
</div>
<div class="bg-login">
</div> 
<script src="{{ asset('js/login.js') }}"></script>