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
    }
?>