<?php
include_once("connect.php");
class mProfile{
    public function mProfile($id){
        $p = new clsketnoi();
        $conn = $p->moKetNoi();
        $conn->set_charset('utf8');
        if($conn){
            $kw = $conn->real_escape_string($id); // tránh SQL injection
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
            $kw = $conn->real_escape_string($id); // tránh SQL injection
            $str = "SELECT * FROM orders where user_id = '$id'";
            $tbl = $conn->query($str);
            $p->dongKetNoi($conn);
            return $tbl;
        } else {
            return false;
        }
    }   
}

?>