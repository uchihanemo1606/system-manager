<?php
session_start();

// Tạo CSRF token nếu chưa có
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Kiểm tra submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $csrfToken = $_POST['csrf_token'] ?? '';

    if ($csrfToken !== $_SESSION['csrf_token']) {
        $_SESSION['login_error'] = "CSRF token không hợp lệ!";
        header("Location: login_form.php");
        exit;
    }

    // Ví dụ kiểm tra cứng
    if ($username === 'admin' && $password === '123456') {
        $_SESSION['user'] = $username;
        header("Location: dashboard.php");
    } else {
        $_SESSION['login_error'] = "Sai tên đăng nhập hoặc mật khẩu!";
        header("Location: login_form.php");
    }
}
