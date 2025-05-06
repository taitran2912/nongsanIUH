<?php
class SanPham {
    private $conn;
    private $table_name = "san_pham";

    public $id;
    public $name;
    public $description;
    public $price;
    public $quantity;
    public $hinh_anh;
    

    public function __construct($db) {
        $this->conn = $db;
    }

    // Lấy tất cả sản phẩm
    public function getAllSanPham() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY id ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Lấy thông tin một sản phẩm theo ID
    public function getSanPhamById() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if($row) {
            $this->ten = $row['name'];
            $this->mo_ta = $row['description'];
            $this->gia = $row['price'];
            $this->so_luong = $row['quantity'];
            $this->hinh_anh = $row['hinh_anh'];
            return true;
        }
        return false;
    }
}
?>