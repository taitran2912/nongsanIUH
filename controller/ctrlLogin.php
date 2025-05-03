<?php
    include_once("model/mLogin.php");
    class ctrlLogin{
        public function getUser($email, $pass){
            $pass =md5($pass);
            $p = new mLogin();
            $ketqua = $p->selectUser($email, $pass);
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
    }
?>