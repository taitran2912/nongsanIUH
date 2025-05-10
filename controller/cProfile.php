<?php 
    include_once("../../model/mProfile.php");
    class cProfile{
    //     private $conn;
    
    // public function __construct() {
    //     // Kết nối đến cơ sở dữ liệu
    //     include_once '../../model/connect.php';
    //     $connect = new Connect();
    //     $this->conn = $connect->getConnection();
    // }

        public function getProfile($id){
            $p = new mProfile();
            $tbl = $p->mProfile($id);
            if ($tbl) {
                if ($tbl->num_rows > 0) {
                    return $tbl;
                } else {
                    return -1;  // Không có dữ liệu
                }
            } else {
                return false;  // Kết nối thất bại hoặc lỗi truy vấn
            }
        }
        public function getOrder($id){
            $p = new mProfile();
            $tbl = $p->mOrder($id);
            if ($tbl) {
                if ($tbl->num_rows > 0) {
                    return $tbl;
                } else {
                    return -1;  // Không có dữ liệu
                }
            } else {
                return false;  // Kết nối thất bại hoặc lỗi truy vấn
            }
        }
        public function updateProfile($id, $name, $email, $phone, $address){
            $p = new mProfile();
            $tbl = $p->mUProfile($id, $name, $email, $phone, $address);
            if ($tbl) {
                return true;
            } else {
                return false;  // Kết nối thất bại hoặc lỗi truy vấn
            }
        }
        public function getOrderStatus($id, $s){
            $p = new mProfile();
            $tbl = $p->mOrderStatus($id, $s);
            if ($tbl) {
                if ($tbl->num_rows > 0) {
                    return $tbl;
                } else {
                    return -1;  // Không có dữ liệu
                }
            } else {
                return false;  // Kết nối thất bại hoặc lỗi truy vấn
            }
        }

         public function getOrderDetail($id){
            $p = new mProfile();
            $tbl = $p->mOrderDetail($id);
            if ($tbl) {
                if ($tbl->num_rows > 0) {
                    return $tbl;
                } else {
                    return -1;  // Không có dữ liệu
                }
            } else {
                return false;  // Kết nối thất bại hoặc lỗi truy vấn
            }
        }
        public function getOrders($id){
            $p = new mProfile();
            $tbl = $p->mOrders($id);
            if ($tbl) {
                if ($tbl->num_rows > 0) {
                    return $tbl;
                } else {
                    return -1;  // Không có dữ liệu
                }
            } else {
                return false;  // Kết nối thất bại hoặc lỗi truy vấn
            }
        }

        public function changePassword($id, $cP, $nP){
            $p = new mProfile();
            $cP = md5($cP);
            $nP = md5($nP);
            $result = $p->mChangeP($id, $cP, $nP);
            
            if ($result === true) {
                return true; // Đổi mật khẩu thành công
            } else {
                return false; // Thất bại (sai mật khẩu cũ, không tìm thấy user, hoặc lỗi truy vấn)
            }
        }


        // public function deleteAccount($id, $password) {
        //     // Kiểm tra mật khẩu
        //     $query = "SELECT password FROM users WHERE id = ?";
        //     $stmt = $this->conn->prepare($query);
        //     $stmt->bind_param("i", $id);
        //     $stmt->execute();
        //     $result = $stmt->get_result();
            
        //     if ($result->num_rows > 0) {
        //         $row = $result->fetch_assoc();
        //         $hashedPassword = $row['password'];
                
        //         // Xác minh mật khẩu
        //         if (password_verify($password, $hashedPassword)) {
        //             // Xóa tài khoản
        //             $deleteQuery = "DELETE FROM users WHERE id = ?";
        //             $deleteStmt = $this->conn->prepare($deleteQuery);
        //             $deleteStmt->bind_param("i", $id);
        //             return $deleteStmt->execute();
        //         }
        //     }
            
        //     return false;
        // }

        
    }
?>