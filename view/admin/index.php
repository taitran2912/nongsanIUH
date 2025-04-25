<?php
// Bắt đầu session
session_start();

// Gán giá
if(!isset($_SESSION["role"]) || $_SESSION["role"] != 2){
    echo"<script>alert('Bạn không có quyền truy cập')</script>";
    header("refresh:0;url='../../index.php'");
  }   
  $idTaiKhoan=isset($_SESSION["id"]) ? intval($_SESSION["id"]) : 0;
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
</head>

<body>
    <div id="wrapper">
        <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav metismenu" id="side-menu">
                    <li class="nav-header">
                        <div class="dropdown profile-element"> 
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <span class="block m-t-xs"> 
                                    <strong class="font-bold">David Williams</strong>
                                </span>
                            </a>
                        </div>
                        <!-- <div class="logo-element">
                            IN+
                        </div> -->
                    </li>
                    <li class="active">
                        <a href="index.html"><i class="fa fa-th-large"></i> <span class="nav-label">Dashboards</span> <span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li class="active"><a href="index.html">Dashboard v.1</a></li>
                            <li><a href="dashboard_2.html">Dashboard v.2</a></li>
                            <li><a href="dashboard_3.html">Dashboard v.3</a></li>
                            <li><a href="dashboard_4_1.html">Dashboard v.4</a></li>
                            <li><a href="dashboard_5.html">Dashboard v.5 </a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="layouts.html"><i class="fa fa-diamond"></i> <span class="nav-label">Layouts</span></a>
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
                            <a href="login.html">
                                <i class="fa fa-sign-out"></i> Log out
                            </a>
                        </li>
                    </ul>
                </nav>
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

    <script>
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
    </script>
</body>
</html>
