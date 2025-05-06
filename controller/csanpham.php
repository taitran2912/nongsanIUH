<?php
require_once 'models/msanpham.php';
require_once 'models/mketnoi.php';

class SanPhamController {
    private $sanPham;
    private $db;

    public function __construct() {
        $database = new Database();
        $db = $database->getConnection();
        $this->sanPham = new SanPham($db);
    }

    // Hiển thị danh sách sản phẩm
    public function index() {
        $result = $this->sanPham->getAllSanPham();
        include 'views/san_pham/index.php';
    }

    // Hiển thị chi tiết sản phẩm
    public function view($id) {
        $this->sanPham->id = $id;
        $this->sanPham->getSanPhamById();
        include 'views/san_pham/view.php';
    }
}
?>