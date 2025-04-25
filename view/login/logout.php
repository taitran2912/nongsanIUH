<?php
session_start(); // Bắt đầu session

// Hủy toàn bộ session
session_unset();
session_destroy();

// Chuyển hướng về trang đăng nhập (hoặc trang chủ)
header("Location: login.php"); // thay 'login.php' bằng trang bạn muốn chuyển tới
exit;
?>
