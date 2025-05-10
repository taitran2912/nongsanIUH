<?php
include_once("connect.php");
class mProfile{
    public function mProfile($id){
        $p = new clsketnoi();
        $conn = $p->moKetNoi();
        $conn->set_charset('utf8');
        if($conn){
            $id = $conn->real_escape_string($id); // tránh SQL injection
            $str = "SELECT * FROM users WHERE id = '$id'";
            $tbl = $conn->query($str);
            $p->dongKetNoi($conn);
            return $tbl;
        } else {
            return false;
        }
    }
    public function mOrder($id){
        $p = new clsketnoi();
        $conn = $p->moKetNoi();
        $conn->set_charset('utf8');
        if($conn){
            $id = $conn->real_escape_string($id); // tránh SQL injection
            $str = "SELECT * FROM orders WHERE user_id = '$id' ORDER BY order_date DESC LIMIT 3;";
            $tbl = $conn->query($str);
            $p->dongKetNoi($conn);
            return $tbl;
        } else {
            return false;
        }
    }  
    public function getOrderStatus($id, $s){
        $p = new clsketnoi();
        $conn = $p->moKetNoi();
        $conn->set_charset('utf8');
        if($conn){
            $id = $conn->real_escape_string($id); // tránh SQL injection
            $str = "SELECT * FROM orders where user_id = '$id' && status = '$s'";
            $tbl = $conn->query($str);
            $p->dongKetNoi($conn);
            return $tbl;
        } else {
            return false;
        }
    } 
    public function mUProfile($id, $name, $email, $phone, $address){
        $p = new clsketnoi();
        $conn = $p->moKetNoi();
        $conn->set_charset('utf8');
        if($conn){
            $kw = $conn->real_escape_string($id); // tránh SQL injection
            $str = "UPDATE users SET name='$name', email='$email', phone='$phone', address='$address' WHERE id = '$id'";
            $tbl = $conn->query($str);
            $p->dongKetNoi($conn);
            return true;
        } else {
            return false;
        }
    }

    public function mOrderDetail($id){
        $p = new clsketnoi();
        $conn = $p->moKetNoi();
        $conn->set_charset('utf8');
        if($conn){
            $id = $conn->real_escape_string($id); // tránh SQL injection
            $str = "SELECT ot.quantity as sl, p.name as pname, p.price as gia, pi.img as hinh 
            FROM orders o 
            JOIN order_details ot ON o.id = ot.order_id 
            join products p ON p.id = ot.product_id 
            join product_images pi on pi.product_id = p.id 
            WHERE o.id = $id;";
            $tbl = $conn->query($str);
            $p->dongKetNoi($conn);
            return $tbl;
        } else {
            return false;
        }
    }

    public function mOrders($id){
        $p = new clsketnoi();
        $conn = $p->moKetNoi();
        $conn->set_charset('utf8');
        if($conn){
            $id = $conn->real_escape_string($id); // tránh SQL injection
            $str = "SELECT * FROM orders WHERE user_id = '$id';";
            $tbl = $conn->query($str);
            $p->dongKetNoi($conn);
            return $tbl;
        } else {
            return false;
        }
    } 

    public function mChangeP($id, $cP, $nP){
            $p = new clsketnoi();
            $conn = $p->moKetNoi();
            $conn->set_charset('utf8');
            if($conn){
                $id = $conn->real_escape_string($id); // tránh SQL injection
                $str = "SELECT password FROM users WHERE id = '$id';";
                $oP = $conn->query($str);
                if ($oP->num_rows > 0) {
                    $row = $oP->fetch_assoc();
                    $hashedPassword = $row['password'];
                } else {
                    return false; 
                }
                if($cP == $hashedPassword){
                    $str = "UPDATE users SET password = '$nP' WHERE id = '$id';";
                    $tbl = $conn->query($str);
                } else {
                    return false; 
                }

                $p->dongKetNoi($conn);
                return $tbl;
            } else {
                return false;
            }

    }
}

?>