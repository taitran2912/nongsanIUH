<?php
class clsketnoi{
    public function moKetNoi(){
        $con = mysqli_connect("localhost", "root", "", "nongsan");
        mysqli_set_charset($con,'utf8');
        return $con;
    }
    public function dongKetNoi($con){
        mysqli_close($con);
    }
}
?>