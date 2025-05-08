<?php

session_start();

if(!isset($_SESSION["role"]) || $_SESSION["role"] != 2){
    echo"<script>alert('Bạn không có quyền truy cập')</script>";
    header("refresh:0;url='../../index.php'");
  }   
$id=isset($_SESSION["id"]) ? intval($_SESSION["id"]) : 0;
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>ADMIN</title>

    <link href="../../asset/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../asset/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="../../asset/css/plugins/toastr/toastr.min.css" rel="stylesheet">
    <link href="../../asset/css/animate.css" rel="stylesheet">
    <link href="../../asset/css/style.css" rel="stylesheet">

    <?php
    if (isset($_GET['action']) && $_GET['action'] === 'quan-ly-san-pham') {
        echo '<link rel="stylesheet" href="../../asset/css/quan-ly-san-pham.css">';
    }
    ?>
</head>

<body>
    <div id="wrapper">
        <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav metismenu" id="side-menu">
                    <li class="nav-header">
                        <div class="dropdown profile-element"> 
                            <a class="<?php echo (isset($_REQUEST['action']) && $_REQUEST['action'] === 'dashboard') ? 'active' : ''; ?>" href="?action=dashbroad">
                                <img src="../../image/logo.png" style="width: 20px;" alt="">
                            </a>
                        </div>
                        <div class="logo-element">
                            <a href="?action=dashbroad" class="<?php echo (isset($_REQUEST['action']) && $_REQUEST['action'] === 'dashboard') ? 'active' : ''; ?>">Logo 2</a>
                        </div>
                    </li>
                    <li class="active">
                        <a href=""><i class="fa fa-th-large"></i><span class="">Quản lý hồ sơ</span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li><a href="?action=quan-ly-nguoi-ban" class="<?php echo (isset($_REQUEST['action']) && $_REQUEST['action'] === 'quan-ly-nguoi-ban') ? 'active' : ''; ?>">Quản lý người bán</a></li>
                            <li><a href="?action=quan-ly-nguoi-dung" class="<?php echo (isset($_REQUEST['action']) && $_REQUEST['action'] === 'quan-ly-nguoi-dung') ? 'active' : ''; ?>">Quản lý người dùng</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="?action=quan-ly-san-pham"><i class="fa fa-diamond <?php echo (isset($_REQUEST['action']) && $_REQUEST['action'] === 'quan-ly-san-pham') ? 'active' : ''; ?>"></i> <span class="nav-label">Quản lý sản phẩm</span></a>
                    </li>
                    <li>
                        <a href="?action=quan-ly-don-hang"><i class="fa fa-diamond <?php echo (isset($_REQUEST['action']) && $_REQUEST['action'] === 'quan-ly-don-hang') ? 'active' : ''; ?>"></i> <span class="nav-label">Quản lý đơn hàng</span></a>
                    </li>
                </ul>
            </div>
        </nav>

        <div id="page-wrapper" class="gray-bg dashbard-1">
            <div class="row border-bottom">
                <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                    <div class="navbar-header">
                        <a class="navbar-minimalize minimalize-styl-2 btn btn-primary" href="#"><i class="fa fa-bars"></i></a>
                    </div>
                    <ul class="nav navbar-top-links navbar-right">
                        <li>
                            <a href="../login/logout.php">
                                <i class="fa fa-sign-out"></i> Log out
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
            <div class="row  border-bottom white-bg dashboard-header">
                <?php
                    if (isset($_REQUEST["action"])) {
                        $val = $_REQUEST["action"];
                        switch ($val) {
                            case 'quan-ly-nguoi-ban':
                                include_once("quan-ly-nguoi-ban.php");
                                break;
                            case 'quan-ly-nguoi-dung':
                                include_once("quan-ly-nguoi-dung.php");
                                break;
                            case 'quan-ly-san-pham':
                                include_once("quan-ly-san-pham.php");
                                break;
                            case 'quan-ly-don-hang':
                                include_once("quan-ly-don-hang.php");
                                break;
                            case 'xem-san-pham':
                                include_once("xem-san-pham.php");
                                break;
                            case 'duyet-nguoi-ban':
                                include_once("duyet-nguoi-ban.php");
                                break;
                            case 'dashboard':
                            default:
                                include_once("dashboard.php");
                        }
                    } else {
                        include_once("dashboard.php"); 
                    }
                ?>  
            </div>
        </div>
    </div>


    <!-- Mainly scripts -->
    <script src="../../asset/js/jquery-3.1.1.min.js"></script>
    <script src="../../asset/js/bootstrap.min.js"></script>
    <script src="../../asset/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="../../asset/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="../../asset/js/inspinia.js"></script>
    <script src="../../asset/js/plugins/pace/pace.min.js"></script>

    <!-- Toastr -->
    <script src="../../asset/js/plugins/toastr/toastr.min.js"></script>

    <!-- <script>
        $(document).ready(function() {
            setTimeout(function() {
                toastr.options = {
                    closeButton: true,
                    progressBar: true,
                    showMethod: 'slideDown',
                    timeOut: 4000
                };
                toastr.success('Responsive Admin Theme', 'Welcome to INSPINIA');
            }, 1300);
        });
    </script> -->
</body>
</html>
