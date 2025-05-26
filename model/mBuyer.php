<?php
include_once 'connect.php';
class mBuyer{
    public function mCheckShop($id){
        $p = new clsketnoi();
        $conn = $p->moKetNoi();
        $conn->set_charset('utf8');
        if($conn){
            // tránh SQL injection
            $str = "SELECT count(*) as count FROM farms WHERE owner_id = $id;";
            $tbl = $conn->query($str);
            $p->dongKetNoi($conn);

            if ($tbl == 0){

            }
            return $tbl;
        } else {
            return false;
        }
    }

    public function mfarm($id){
        $p = new clsketnoi();
        $conn = $p->moKetNoi();
        $conn->set_charset('utf8');
        if($conn){
            $id = $conn->real_escape_string($id); // tránh SQL injection
            $str = "SELECT id, shopname FROM farms WHERE owner_id = $id AND status = 0;";
            $tbl = $conn->query($str);
            $p->dongKetNoi($conn);
            return $tbl;
        } else {
            return false;
        }
    }

    public function sumDT($str){
        $p = new clsketnoi();
        $conn = $p->moKetNoi();
        $conn->set_charset('utf8');
        if($conn){
            $tbl = $conn->query($str);
            $p->dongKetNoi($conn);
            return $tbl;
        } else {
            return false;
        }
    }

    
    
    
}
?>