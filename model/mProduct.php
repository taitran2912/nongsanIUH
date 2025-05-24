<?php
include_once 'connect.php';
class mProduct
{
    public function getAllProduct()
    {
        $p = new clsketnoi();
        $conn = $p->moKetNoi();
        $conn->set_charset('utf8');
        if($conn){
             // tránh SQL injection
            $str = "SELECT * FROM products p JOIN product_images pi on p.id = pi.product_id WHERE p.status = 0";
            $tbl = $conn->query($str);
            $p->dongKetNoi($conn);
            return $tbl;
        } else {
            return false;
        }
    }

    public function getAllCategorie()
    {
        $p = new clsketnoi();
        $conn = $p->moKetNoi();
        $conn->set_charset('utf8');
        if($conn){
             // tránh SQL injection
            $str = "SELECT * FROM categories;";
            $tbl = $conn->query($str);
            $p->dongKetNoi($conn);
            return $tbl;
        } else {
            return false;
        }
    }

    public function getProductByCategory($idCate)
    {
        $p = new clsketnoi();
        $conn = $p->moKetNoi();
        $conn->set_charset('utf8');
        if($conn){
             // tránh SQL injection
            $str = "SELECT * FROM products p JOIN product_images pi on p.id = pi.product_id WHERE p.id_categories = $idCate";
            $tbl = $conn->query($str);
            $p->dongKetNoi($conn);
            return $tbl;
        } else {
            return false;
        }
    }

    public function mAddCart($idProduct, $idUser)
    {
        $p = new clsketnoi();
        $conn = $p->moKetNoi();
        $conn->set_charset('utf8');

        if ($conn) {
            // Kiểm tra xem đã có sản phẩm trong giỏ chưa
            $check_sql = "SELECT quantity FROM cart WHERE customer_id = ? AND product_id = ?";
            $stmt = $conn->prepare($check_sql);
            $stmt->bind_param("ii", $idUser, $idProduct);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                // Sản phẩm đã tồn tại -> tăng số lượng
                $update_sql = "UPDATE cart SET quantity = quantity + 1 WHERE customer_id = ? AND product_id = ?";
                $stmt = $conn->prepare($update_sql);
                $stmt->bind_param("ii", $idUser, $idProduct);
                $tbl = $stmt->execute();
            } else {
                // Sản phẩm chưa có -> thêm mới
                $insert_sql = "INSERT INTO cart (customer_id, product_id, quantity) VALUES (?, ?, 1)";
                $stmt = $conn->prepare($insert_sql);
                $stmt->bind_param("ii", $idUser, $idProduct);
                $tbl = $stmt->execute();
            }

            $stmt->close();
            $p->dongKetNoi($conn);

            return $tbl;
        } else {
            return false;
        }
    }

    
    public function getProduct($farm_id)
    {
        $p = new clsketnoi();
        $conn = $p->moKetNoi();
        $conn->set_charset('utf8');
        if($conn){
             // tránh SQL injection
            $str = "SELECT * 
            FROM products p 
            JOIN product_images pi on p.id = pi.product_id 
            WHERE p.farm_id = $farm_id
            AND p.status = 0";
            $tbl = $conn->query($str);
            $p->dongKetNoi($conn);
            return $tbl;
        } else {
            return false;
        }
    }

    public function getByCategory($idCate, $farm_id)
    {
        $p = new clsketnoi();
        $conn = $p->moKetNoi();
        $conn->set_charset('utf8');
        if($conn){
             // tránh SQL injection
            $str = "SELECT * 
            FROM products p 
            JOIN product_images pi on p.id = pi.product_id 
            WHERE p.farm_id = $farm_id
            AND p.id_categories = $idCate
            AND p.status = 0";
            $tbl = $conn->query($str);
            $p->dongKetNoi($conn);
            return $tbl;
        } else {
            return false;
        }
    }
            
}
?>