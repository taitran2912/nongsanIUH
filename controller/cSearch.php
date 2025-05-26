<?php
include_once("../../model/mSearch.php");
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
                return $tbl;
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
                return $tbl;
            } else {
                return -1;  // Không có dữ liệu
            }
        } else {
            return false;  // Kết nối thất bại hoặc lỗi truy vấn
        }
    }

    public function changeStatus($id) {
        $p = new mSearch();
        $tbl = $p->mChangeStatus($id);
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
    public function count() {
        $p = new mSearch();
        $tbl = $p->mCount();
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


    public function searchDK($kw){
        $p = new mSearch();
        $tbl = $p->msearchDK($kw);
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

    public function listDK() {
        $p = new mSearch();
        $tbl = $p->mListDK();
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

    public function deleteDK($id) {
        $p = new mSearch();
        $tbl = $p->mDeleteDK($id);
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