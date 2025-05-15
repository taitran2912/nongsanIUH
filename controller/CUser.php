<?php
    include_once("model/mUser.php");
    class CUser{
        public function login($email, $pass){
            $pass =md5($pass);
            $p = new mUser();
            $ketqua = $p->login($email, $pass);
            // echo mysqli_num_rows($ketqua);
            if (mysqli_num_rows($ketqua) > 0) {
                while ($r = mysqli_fetch_assoc($ketqua)) {
                    $_SESSION["role"] = $r["role"];
                    $_SESSION["id"] = $r["id"];
                    return $_SESSION["role"]; 
                }
            } else {
                
                return 0; 
            }
        }
        
        public function register($name, $email, $hashed_password, $phone, $address, $role){
            $p = new mUser();
            $status = $p->register($name, $email, $hashed_password, $phone, $address, $role);
            if ($status) {
                return true; // Registration successful
            } else {
                return false; // Registration failed
            }
        }
    }
?>