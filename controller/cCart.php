<?php
include_once("../../model/mCart.php");
class cCart{
    public function getCart($id){
        $p = new mCart();
        $str = "SELECT p.name, p.price, p.unit, c.quantity, f.id as shop_id ,f.shopname, pi.img 
                FROM cart c 
                JOIN products p ON c.product_id = p.id 
                JOIN farms f ON p.farm_id = f.id 
                JOIN product_images pi ON pi.product_id = p.id WHERE c.customer_id = $id;";
        $tbl = $p->mCart($str);
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
    public function updateCartQuantity($userId, $productId, $quantity) {
        $p = new mCart();
        $str = "UPDATE cart SET quantity = $quantity 
                WHERE customer_id = $userId AND product_id = $productId;";
        $result = $p->mCart($str);
        if ($result) {
            return true;  // Cập nhật thành công
        } else {
            return false;  // Cập nhật thất bại
        }
    }
}
?>