<?php 
    include_once("../../model/mProfile.php");
    class cProfile{
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
            $tbl = $p->getOrderStatus($id, $s);
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
        
        public function getBuyer($id){
            $p = new mProfile();
            $tbl = $p->mBuyer($id);
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
        public function updateOrderStatus($id, $status, $note){
            $p = new mProfile();
            $tbl = $p->mUpdateOrderStatus($id, $status, $note);
            if ($tbl) {
                return true;
            } else {
                return false;  // Kết nối thất bại hoặc lỗi truy vấn
            }
        }
    }
?>