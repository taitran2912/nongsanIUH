<?php
include_once '../../model/mBuyer.php';

class cBuyer{
    public function checkShop($id){
        $p = new mBuyer();
            $tbl = $p->mCheckShop($id);
            if ($tbl) {
                if ($tbl->num_rows > 0) {
                    return $tbl;
                } else {
                    return -1;  // Không có dữ liệu
                }
            } else {
                return false;  // Kết nối thất bại hoặc lỗi truy vấn
            }
    }

    public function getFarm($id){
        $p = new mBuyer();
            $tbl = $p->mfarm($id);
            if ($tbl) {
                if ($tbl->num_rows > 0) {
                    return $tbl;
                } else {
                    return -1;  // Không có dữ liệu
                }
            } else {
                return false;  // Kết nối thất bại hoặc lỗi truy vấn
            }
    }

    public function tinhTongDoanhThu($id){
        $p = new mBuyer();
            $str = "SELECT SUM(od.quantity * p.price) AS doanhThu
                    FROM products p
                    JOIN order_details od ON p.id = od.product_id
                    JOIN orders o ON od.order_id = o.id
                    WHERE p.farm_id = $id
                    AND o.status != 3
                    AND MONTH(o.order_date) = MONTH(CURDATE())
                    AND YEAR(o.order_date) = YEAR(CURDATE());
                    ";
            $tbl = $p->sumDT($str);
            if ($tbl) {
                if ($tbl->num_rows > 0) {
                    return $tbl;
                } else {
                    return -1;  // Không có dữ liệu
                }
            } else {
                return false;  // Kết nối thất bại hoặc lỗi truy vấn
            }
    }

    public function tinhTongDonHang($id){
        $p = new mBuyer();
            $str = "SELECT COUNT(DISTINCT o.id) AS DonHang
                    FROM products p
                    JOIN order_details od ON p.id = od.product_id
                    JOIN orders o ON od.order_id = o.id
                    WHERE p.farm_id = $id
                    AND o.status != 3
                    AND MONTH(o.order_date) = MONTH(CURDATE())
                    AND YEAR(o.order_date) = YEAR(CURDATE());
                    ";
            $tbl = $p->sumDT($str);
            if ($tbl) {
                if ($tbl->num_rows > 0) {
                    return $tbl;
                } else {
                    return -1;  // Không có dữ liệu
                }
            } else {
                return false;  // Kết nối thất bại hoặc lỗi truy vấn
            }
    }
    
    public function tinhTongSanPham($id){
        $p = new mBuyer();
            $str = "SELECT SUM(od.quantity) AS SanPham 
                    FROM products p JOIN order_details od ON p.id = od.product_id 
                    JOIN orders o ON od.order_id = o.id 
                    WHERE p.farm_id = $id
                    AND o.status != 3
                    AND MONTH(o.order_date) = MONTH(CURDATE()) 
                    AND YEAR(o.order_date) = YEAR(CURDATE());
                    ";
            $tbl = $p->sumDT($str);
            if ($tbl) {
                if ($tbl->num_rows > 0) {
                    return $tbl;
                } else {
                    return -1;  // Không có dữ liệu
                }
            } else {
                return false;  // Kết nối thất bại hoặc lỗi truy vấn
            }
    }

    public function dsDonHang($id){
        $p = new mBuyer();
            $str = "SELECT DISTINCT o.*
                    FROM farms f 
                    JOIN products p ON f.id = p.farm_id 
                    JOIN order_details od ON p.id = od.product_id 
                    JOIN orders o ON od.order_id = o.id 
                    WHERE f.id = $id
                    AND MONTH(o.order_date) = MONTH(CURDATE()) 
                    AND YEAR(o.order_date) = YEAR(CURDATE())
                    AND o.status != 3
                    ORDER BY o.order_date DESC
                    ";
            $tbl = $p->sumDT($str);
            if ($tbl) {
                if ($tbl->num_rows > 0) {
                    return $tbl;
                } else {
                    return -1;  // Không có dữ liệu
                }
            } else {
                return false;  // Kết nối thất bại hoặc lỗi truy vấn
            }
    }
    // dsSPGanHet

    public function dsSPGanHet($id){
        $p = new mBuyer();
            $str = "SELECT p.*, c.name as c_name
                    FROM categories c 
                    JOIN products p ON c.id = p.id_categories 
                    JOIN farms f ON p.farm_id = f.id 
                    WHERE f.id = $id && p.quantity <= 50 
                    ORDER BY p.quantity 
                    ASC LIMIT 6;
                    ";
            $tbl = $p->sumDT($str);
            if ($tbl) {
                if ($tbl->num_rows > 0) {
                    return $tbl;
                } else {
                    return -1;  // Không có dữ liệu
                }
            } else {
                return false;  // Kết nối thất bại hoặc lỗi truy vấn
            }
    }
    // updateProductQuantity
    public function updateProductQuantity($id, $quantity){
        $p = new mBuyer();
            $str = "UPDATE products SET quantity = quantity + $quantity WHERE id = $id";
            $tbl = $p->sumDT($str);
            if ($tbl) {
                return true;
            } else {
                return false;  
            }
    }

    public function dsSP($id){
        $p = new mBuyer();
            $str = "SELECT p.*, c.name as c_name
                    FROM categories c 
                    JOIN products p ON c.id = p.id_categories 
                    JOIN farms f ON p.farm_id = f.id 
                    WHERE f.id = $id
                    ORDER BY p.quantity;
                    ";
            $tbl = $p->sumDT($str);
            if ($tbl) {
                if ($tbl->num_rows > 0) {
                    return $tbl;
                } else {
                    return -1;  // Không có dữ liệu
                }
            } else {
                return false;  // Kết nối thất bại hoặc lỗi truy vấn
            }
    }

    public function getAllCategory(){
        $p = new mBuyer();
            $str = "SELECT *
                    FROM categories;
                    ";
            $tbl = $p->sumDT($str);
            if ($tbl) {
                if ($tbl->num_rows > 0) {
                    return $tbl;
                } else {
                    return -1;  // Không có dữ liệu
                }
            } else {
                return false;  // Kết nối thất bại hoặc lỗi truy vấn
            }
    }
    // dsSPnCate?
    public function dsSPnCate($id, $id_cate){
        $p = new mBuyer();
            $str = "SELECT p.*, c.name as c_name
                    FROM categories c 
                    JOIN products p ON c.id = p.id_categories 
                    JOIN farms f ON p.farm_id = f.id 
                    WHERE f.id = $id
                    AND c.id = $id_cate
                    ORDER BY p.quantity;
                    ";
            $tbl = $p->sumDT($str);
            if ($tbl) {
                if ($tbl->num_rows > 0) {
                    return $tbl;
                } else {
                    return -1;  // Không có dữ liệu
                }
            } else {
                return false;  // Kết nối thất bại hoặc lỗi truy vấn
            }
    }
}
?>