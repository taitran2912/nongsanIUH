<?php
if(!isset($_SESSION)) {
    session_start();
}
if(isset($_POST['createFarm'])) {
    include_once '../../controller/cShop.php';
    $cShop = new cShop();
    $shopname = $_POST['shopname'];
    $address = $_POST['address'];
    $description = $_POST['decription'];
    $owner_id = $_SESSION['id'];
    $status = 1; // Assuming status is always 1 for new shops
    
    $result = $cShop->addShop($shopname, $address, $description, $owner_id, $status);
    if ($result) {
        echo "<script>alert('Đăng ký thành công!');</script>";
        echo "<script>window.location.href = '../customer/index.php';</script>";
    } else {
        echo "<script>alert('Đăng ký thất bại!');</script>";
    }

}




?>