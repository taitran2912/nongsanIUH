<?php
include_once '../../model/mOrder.php';
class cOrder{
    public function getProduct($id){
        $p = new mOrder();
        $str = " SELECT * FROM order_details od 
                 JOIN products p ON od.product_id = p.id 
                 JOIN product_images pi ON p.id = pi.product_id 
                 WHERE od.order_id = $id
                 GROUP BY p.id 
        ";
        $tbl = $p->checkOrder($str);
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

    public function changeOrder($id , $status){
        $p = new mOrder();
        $str = "UPDATE orders SET status = $status WHERE id = $id";
        $tbl = $p->checkOrder($str);
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

    public function checkOrder($id){
        $p = new mOrder();
        $str = "SELECT 
                    o.*, 
                    u.name, 
                    u.phone,
                    (
                        SELECT COUNT(*) 
                        FROM order_details od   
                        WHERE od.order_id = o.id
                    ) AS totalProducts
                FROM 
                    users u 
                    JOIN orders o ON u.id = o.user_id 
                WHERE 
                    o.id IN (
                        SELECT DISTINCT o2.id 
                        FROM orders o2 
                        JOIN order_details od2 ON o2.id = od2.order_id 
                        JOIN products p2 ON p2.id = od2.product_id 
                        WHERE p2.farm_id = $id  
                        AND o2.status != 0
                );
        ";
        $tbl = $p->checkOrder($str);
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
    public function infOr($id){
        $p = new mOrder();
        $str = "SELECT od.order_id, od.product_id, od.quantity as slBan, p.quantity as slKho 
                from order_details od 
                JOIN products p on od.product_id = p.id 
                where od.order_id = $id";
        $tbl = $p->checkOrder($str);
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

    public function updateQLT($id, $qlt){
        $p = new mOrder();
        $str = "UPDATE products SET quantity = quantity - $qlt WHERE id = $id";
        $tbl = $p->checkOrder($str);
        if ($tbl) {
            if ($p->conn->affected_rows > 0) {  // dùng affected_rows
                return true;
            } else {
                return -1;  // Không có dòng nào bị ảnh hưởng
            }
        } else {
            return false;  // Lỗi truy vấn
        }
    }   
}
class customerCheckOrder{
    public function getOrderInfo($id){
        $p = new mOrder();
        $str = "SELECT o.order_date, o.user_id, o.status, o.total_amount, o.notes, o.Shipping_address,u.name, u.email, u.phone 
                from orders o 
                join users u on o.user_id= u.id     where o.id = $id";
        $tbl = $p->mCCO($str);
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

    public function getOrderDetails($id){
        $p = new mOrder();
        $str = "SELECT * FROM order_details od join products p on od.product_id = p.id join product_images pi on p.id = pi.product_id where od.order_id = $id";
        $tbl = $p->mCCO($str);
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

    public function updateStatus($id){
        $p = new mOrder();
        $str = "UPDATE transactions SET status= 'complete' WHERE order_id = $id";
        $tbl = $p->mCCO($str);
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

    public function deleteCart($id){
        $p = new mOrder();
        $str = "DELETE FROM cart WHERE customer_id = $id";
        $tbl = $p->mCCO($str);
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