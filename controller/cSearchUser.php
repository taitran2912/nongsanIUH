<?php
include_once("../../model/mSearchUser.php");
class cSearch{
    public function search($kw){
        $p = new mSearch();
        $tbl = $p->msearch($kw);
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

    public function list() {
        $p = new mSearch();
        $tbl = $p->mList();
        if ($tbl) {
            if ($tbl->num_rows > 0) {
                return $tbl; // Không có dữ liệu 
            } else {
                return -1;  // Không có dữ liệu
            }
        } else {
            return false;  // Kết nối thất bại hoặc lỗi truy vấn
        }
    }
    public function delete($id) {
        $p = new mSearch();
        $tbl = $p->mDelete($id);
        if ($tbl) {
            if ($tbl->num_rows > 0) {
                return $tbl; // Không có dữ liệu 
            } else {
                return -1;  // Không có dữ liệu
            }
        } else {
            return false;  // Kết nối thất bại hoặc lỗi truy vấn
        }
    }
}

?>