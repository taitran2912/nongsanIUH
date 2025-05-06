<?php
include_once("connect.php");
class mSearch{
    public function searchWithKeyWord($kw){
        $p=new clsketnoi();
        $con=$p->moKetNoi();
        $sql="";
        $ketqua=mysqli_query($con,$sql);
        $p->dongKetNoi($con);
        return $ketqua;
    }
}
?>