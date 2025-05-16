<?php

?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang người bán</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Chart.js -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../../asset/css/seller-dashboard.css">
</head>

<body>
    <div class="seller-dashboard">
        <!-- Sidebar -->
        <nav id="sidebar" class="sidebar">
            <div class="sidebar-header">
                <img src="../../image/logo.png" alt="Nông Sản Xanh Logo" class="logo">
                <h3>Người Bán</h3>
                <button id="sidebarCollapseBtn" class="d-md-none">
                    <i class="fas fa-bars"></i>
                </button>
            </div>

            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="?action=dashboard" class="nav-link <?php echo (!isset($_GET['action']) || $_GET['action'] == 'dashboard') ? 'active' : ''; ?>">
                        <i class="fas fa-tachometer-alt"></i> Tổng quan
                    </a>
                </li>
                <li class="nav-item">
                    <a href="?action=product" class="nav-link <?php echo (isset($_GET['action']) && $_GET['action'] == 'product') ? 'active' : ''; ?>">
                        <i class="fas fa-box"></i> Sản phẩm
                    </a>
                </li>
                <li class="nav-item">
                    <a href="?action=order" class="nav-link <?php echo (isset($_GET['action']) && $_GET['action'] == 'order') ? 'active' : ''; ?>">
                        <i class="fas fa-shopping-cart"></i> Đơn hàng
                    </a>
                </li>
                <li class="nav-item">
                    <a href="?action=customer" class="nav-link <?php echo (isset($_GET['action']) && $_GET['action'] == 'customer') ? 'active' : ''; ?>">
                        <i class="fas fa-users"></i> Khách hàng
                    </a>
                </li>
                <li class="nav-item">
                    <a href="?action=statis" class="nav-link <?php echo (isset($_GET['action']) && $_GET['action'] == 'statis') ? 'active' : ''; ?>">
                        <i class="fas fa-chart-line"></i> Thống kê
                    </a>
                </li>
                <li class="nav-item">
                    <a href="?action=review" class="nav-link <?php echo (isset($_GET['action']) && $_GET['action'] == 'review') ? 'active' : ''; ?>">
                        <i class="fas fa-star"></i> Đánh giá
                    </a>
                </li>
                <li class="nav-item">
                    <a href="?action=setting" class="nav-link <?php echo (isset($_GET['action']) && $_GET['action'] == 'setting') ? 'active' : ''; ?>">
                        <i class="fas fa-cog"></i> Cài đặt
                    </a>
                </li>
                <li class="nav-item mt-5">
                    <a href="../logout.php" class="nav-link text-danger">
                        <i class="fas fa-sign-out-alt"></i> Đăng xuất
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Top Navbar -->
            <?php include_once 'nav.php'; ?>

            <!-- Content Area -->
            <div class="content-area p-4">
                <?php
                // Xác định trang cần hiển thị dựa trên tham số action
                $action = isset($_GET['action']) ? $_GET['action'] : 'dashboard';
                
                // Kiểm tra và tải trang tương ứng
                switch ($action) {
                    case 'dashboard':
                        include_once 'dashboard.php';
                        break;
                    case 'product':
                        include_once 'product.php';
                        break;
                    case 'order':
                        include_once 'order.php';
                        break;
                    case 'customer':
                        include_once 'customer.php';
                        break;
                    case 'statis':
                        include_once 'statis.php';
                        break;
                    case 'review':
                        include_once 'review.php';
                        break;
                    case 'setting':
                        include_once 'setting.php';
                        break;
                    default:
                        include_once 'dashboard.php';
                        break;
                }
                ?>
            </div>
        </div>
    </div>

    <!-- Back to Top Button -->
    <a href="#" class="back-to-top">
        <i class="fas fa-arrow-up"></i>
    </a>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
    <!-- Custom JS -->
    <script src="../../asset/js/seller-dashboard.js"></script>
</body>

</html>