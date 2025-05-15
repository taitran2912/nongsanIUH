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
            $str = "SELECT * FROM products p JOIN product_images pi on p.id = pi.product_id";
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
            
}
?>