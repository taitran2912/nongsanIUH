<?php
include_once("connect.php");
class mSearch{
    
    public function msearch($kw){
        $p = new clsketnoi();
        $conn = $p->moKetNoi();
        $conn->set_charset('utf8');
        if($conn){
            $kw = $conn->real_escape_string($kw); // tránh SQL injection
            $str = "SELECT u.name, u.phone, f.address, f.shopname, f.id as idF, u.id as idU FROM users u JOIN farms f ON u.id = f.owner_id WHERE f.shopname LIKE '%$kw%' && f.status = 0";
            $tbl = $conn->query($str);
            $p->dongKetNoi($conn);
            return $tbl;
        } else {
            return false;
        }
    }
    
    public function mList(){
        $p = new clsketnoi();
        $conn = $p->moKetNoi();
        $conn->set_charset('utf8');
        if($conn){
            $str = "SELECT u.name, u.phone, f.address, f.shopname, f.id as idF, u.id as idU from users u join farms f ON u.id = f.owner_id && f.status = 0";
            $tbl = $conn->query($str);
            $p->dongKetNoi($conn);
            return $tbl;
        }else{
            return false;
        }
    }
    public function mDelete($id){
        $p = new clsketnoi();
        $conn = $p->moKetNoi();
        $conn->set_charset('utf8');
        if($conn){
            $str = "UPDATE farms SET status = 1 WHERE farms.id = $id;";
            $tbl = $conn->query($str);
            $p->dongKetNoi($conn);
            return $tbl;
        }else{
            return false;
        }
    }
}
?>
