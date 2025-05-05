<?php
include_once("connect.php");
    class mUser{
        public $conn;

        public function __construct()
        {
            $p = new clsketnoi();
            $this->conn = $p->moKetNoi();
        }

        public function login($email, $pass)
        {
            $p=new clsketnoi();
            $con=$p->moKetNoi();
            $truyvan="select * from users where email='$email' and password='$pass'";
            $ketqua=mysqli_query($con,$truyvan);
            $p->dongKetNoi($con);
            return $ketqua;
        }
        public function register($name, $email, $hashed_password, $phone, $address, $role)
        {
            $p=new clsketnoi();
            $con=$p->moKetNoi();
            $stmt = $con->prepare("INSERT INTO users (name, email, password, phone, address, role) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssi", $name, $email, $hashed_password, $phone, $address, $role);
            
            if ($stmt->execute()) {
                return true; // Registration successful
            } else {
                return false; // Registration failed
            }
        }
    }
?>