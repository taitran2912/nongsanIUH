<?php
    session_start();
    $id = isset($_SESSION["id"]) ? intval($_SESSION["id"]) : 0;
    $role = $_SESSION["role"];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nông Sản Xanh - Sản phẩm nông nghiệp sạch</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">    
    <link rel="stylesheet" href="../../asset/css/styles.css">
    <link rel="stylesheet" href="../../asset/css/products.css">
    <link rel="stylesheet" href="../../asset/css/about-us.css">
    <?php
    if (isset($_GET['action']) && $_GET['action'] === 'detail') {
        echo '<link rel="stylesheet" href="../../asset/css/detail.css">';
    }
    ?>
</head>

<body>
    <!-- Header -->
<header class="sticky-top">
    <!-- Top Bar -->
    <div class="top-bar bg-success text-white py-2">
        <div class="container d-flex justify-content-between align-items-center">
            <div>
                <span><i class="fas fa-phone-alt me-2"></i> 0123 456 789</span>
                <span class="ms-3"><i class="fas fa-envelope me-2"></i> info@nongsanxanh.com</span>
            </div>
            <div>
                <a href="#" class="text-white me-3"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="text-white me-3"><i class="fab fa-instagram"></i></a>
                <a href="#" class="text-white"><i class="fab fa-youtube"></i></a>
                
            </div>
        </div>
    </div>

    <!-- Main Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">

<!--index--><a class="navbar-brand" href="">
                <!--  -->
                <img src="../../image/logo.png" alt="Nông Sản Xanh Logo">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link active<?php  echo (isset($_REQUEST['action']) && $_REQUEST['action'] === 'dashboard') ? 'active' : '';  ?>" href="?action=dashboard">Trang chủ</a>
                    </li>
                    <li class="nav-item">
<!-- san pham -->       <a class="nav-link <?php  echo (isset($_REQUEST['action']) && $_REQUEST['action'] === 'product') ? 'active' : '';  ?>" href="?action=product">
                            Sản phẩm
                        </a>
                        <!-- <ul class="dropdown-menu">
Danh muc
                            <li><a class="dropdown-item" href="#">Rau củ</a></li>
                            <li><a class="dropdown-item" href="#">Trái cây</a></li>
                            <li><a class="dropdown-item" href="#">Gạo & Ngũ cốc</a></li>
                            <li><a class="dropdown-item" href="#">Thực phẩm chế biến</a></li>

                        </ul> -->
                    </li>
                    <li class="nav-item">
<!-- about -->
                        <a class="nav-link <?php  echo (isset($_REQUEST['action']) && $_REQUEST['action'] === 'about') ? 'active' : '';  ?>" href="?action=about">Về chúng tôi</a>
                    </li>
                </ul>
                <div class="d-flex align-items-center">
                <!-- <i class="fa-solid fa-right-to-bracket"></i> -->
                    <?php
                    if ($id ==0) {
                        echo'
                            <a href="?action=login" class="btn btn-outline-success me-2">
                                Đăng nhập
                            </a>
                            <a href="?action=dangky" class="btn btn-outline-success me-2">
                                Đăng ký
                            </a>
                        ';
                    } else {
                        echo '
                            <a href="?action=profile" class="btn btn-outline-success me-2 ';
                        echo (isset($_REQUEST['action']) && $_REQUEST['action'] === 'profile') ? 'active' : '';
                        echo'">
                                <i class="fas fa-user"></i>
                            </a>';
                        echo'
                            <a href="../login/logout.php" class="btn btn-outline-success me-2">
                                Đăng xuất
                            </a>
                    ';
                    }
                    ?>
                    <a href="?action=shopping-cart" class="btn btn-success position-relative <?php  echo (isset($_REQUEST['action']) && $_REQUEST['action'] === 'shopping-cart') ? 'active' : '';  ?>">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            3
                        </span>
                    </a>

                </div>
            </div>
        </div>
    </nav>
</header>

   <nav>
    <?php
        if (isset($_REQUEST["action"])) {
            $val = $_REQUEST["action"];
            switch ($val) {
                case 'login':
                    echo"
                        <script>
                            window.location.href = '../../log.php';
                        </script>
                    ";
                    break;
                case 'dangky':
                    echo"
                        <script>
                            window.location.href = '../../log.php?dangky';
                        </script>
                    ";
                    break;
                case 'profile':
                    include_once("profile.php");
                    break;
                case 'product':
                    include_once("product.php");
                    break;
                case 'shopping-cart':
                    include_once("shopping-cart.php");
                    break;
                case 'about':
                    include_once("about.php");
                    break;
                case 'detail':
                    include_once("detail.php");
                    break;
                case 'dashboard':
                default:
                    include_once("dashboard.php");
            }
        } else {
            include_once("dashboard.php"); 
        }
    ?>
   </nav>

    <!-- Footer -->
    <footer class="footer pt-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="footer-widget">
                        <img src="../../image/logo.png" width="50px" high="50px" class="mb-4" alt="Nông Sản Xanh Logo">
                        <!-- https://via.placeholder.com/200x70?text=Nông+Sản+Xanh -->
                        <p>Chúng tôi cung cấp các sản phẩm nông nghiệp sạch, an toàn và chất lượng cao, được trồng và thu hoạch theo tiêu chuẩn hữu cơ quốc tế.</p>
                        <div class="social-links mt-3">
                            <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                            <a href="#" class="social-link"><i class="fab fa-youtube"></i></a>
                            <a href="#" class="social-link"><i class="fab fa-tiktok"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6">
                    <div class="footer-widget">
                        <h5 class="widget-title">Liên kết nhanh</h5>
                        <ul class="footer-links">
                            <li><a href="?action=dashboard">Trang chủ</a></li>
                            <li><a href="?action=product">Sản phẩm</a></li>
                            <li><a href="?action=about">Về chúng tôi</a></li>

                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="footer-widget">
                        <h5 class="widget-title">Danh mục sản phẩm</h5>
                        <ul class="footer-links">
                            <li><a href="#">Rau củ hữu cơ</a></li>
                            <li><a href="#">Trái cây theo mùa</a></li>
                            <li><a href="#">Gạo & Ngũ cốc</a></li>
                            <li><a href="#">Thực phẩm chế biến</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="footer-widget">
                        <h5 class="widget-title">Thông tin liên hệ</h5>
                        <div class="contact-info">
                            <p><i class="fas fa-map-marker-alt"></i> 123 Đường Nông Nghiệp, Quận 2, TP. Hồ Chí Minh</p>
                            <p><i class="fas fa-phone-alt"></i> 0123 456 789</p>
                            <p><i class="fas fa-envelope"></i> info@nongsanxanh.com</p>
                            <p><i class="fas fa-clock"></i> Thứ 2 - Chủ nhật: 8:00 - 20:00</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom py-3 mt-5">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <p class="mb-0">© 2023 Nông Sản Xanh. Tất cả quyền được bảo lưu.</p>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <p class="mb-0">Thiết kế bởi <a href="#" class="text-success">Nông Sản Xanh</a></p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Back to Top -->
    <a href="#" class="back-to-top"><i class="fas fa-arrow-up"></i></a>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="script.js"></script>
</body>

</html>