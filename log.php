<?php
    session_start();
    ob_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="asset/css/bootstrap.min.css" rel="stylesheet">
    <link href="asset/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="asset/css/animate.css" rel="stylesheet">
    <link href="asset/css/style.css" rel="stylesheet">
</head>
<body class="gray-bg">
    <div class="middle-box text-center loginscreen animated fadeInDown">
        <div>
            <?php
                if (isset($_POST["btnDN"])) {
                    include_once("controller/ctrlLogin.php");
                    $p = new ctrlLogin();
                    $kq = $p->getUser($_POST["txtEmail"], $_POST["txtPass"]);

                    if ($kq == 1) {
                        echo "<script>
                            alert('Đăng nhập thành công!');
                            window.location.href = 'view/customer/index.php';
                        </script>";
                        exit;
                    } elseif ($kq == 2) {
                        echo "<script>
                            alert('Đăng nhập thành công!');
                            window.location.href = 'view/admin/index.php';
                        </script>";
                        exit;
                    } else {
                        echo "<script>alert('Đăng nhập thất bại!');</script>";
                    }
                }
            ?>

            <?php
                if (isset($_GET["dangky"])) {
                    include_once("view/login/dangky.php");
                } else if (isset($_GET["quen"])) {
                    include_once("view/login/quen.php");
                } else if (isset($_GET["login"])) {
                    include_once("view/login/login.php");
                    echo '
                        <a href="?quenmk"><small>Quên mật khẩu.</small></a>
                        <p class="text-muted text-center"><small>Bạn chưa có tài khoản?</small></p>
                        <a class="btn btn-sm btn-white btn-block" href="?dangky">Tạo tài khoản.</a>
                    ';
                } else {
                    include_once("view/login/login.php");
                    echo '
                        <a href="?quenmk"><small>Quên mật khẩu.</small></a>
                        <p class="text-muted text-center"><small>Bạn chưa có tài khoản?</small></p>
                        <a class="btn btn-sm btn-white btn-block" href="?dangky">Tạo tài khoản.</a>
                    ';
                }
            ?>
        </div>
    </div>
    <script src="asset/js/jquery-3.1.1.min.js"></script>
    <script src="asset/js/bootstrap.min.js"></script>
</body>
</html>