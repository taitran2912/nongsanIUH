<?php
include_once("connect.php");
    class mLogin{
        public $conn;

        public function __construct()
        {
            $p = new clsketnoi();
            $this->conn = $p->moKetNoi();
        }

        public function selectUser($email, $pass)
        {
            $p=new clsketnoi();
            $con=$p->moKetNoi();
            $truyvan="select * from users where email='$email' and password='$pass'";
            $ketqua=mysqli_query($con,$truyvan);
            $p->dongKetNoi($con);
            return $ketqua;
        }
    }
?>