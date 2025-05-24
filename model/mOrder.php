<?php
include_once 'connect.php';
class mOrder
{
    public function checkOrder($str)
    {
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

    public function mCCO($str)
    {
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