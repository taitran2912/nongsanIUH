<?php
include_once("../../model/mProduct.php");
    class cProduct
    {
        public function getAllProduct()
        {
            $p = new mProduct();
            $result = $p->getAllProduct();
            if ($result) {
                if ($result->num_rows > 0) {
                    return $result;
                } else {
                    return -1;  // Không có dữ liệu
                }
            } else {
                return false;  // Kết nối thất bại hoặc lỗi truy vấn
            }
        }

        public function getAllCategorie()
        {
            $p = new mProduct();
            $result = $p->getAllCategorie();
            if ($result) {
                if ($result->num_rows > 0) {
                    return $result;
                } else {
                    return -1;  // Không có dữ liệu
                }
            } else {
                return false;  // Kết nối thất bại hoặc lỗi truy vấn
            }
        }
        
        public function getProductByCategory($idCate)
        {
            $p = new mProduct();
            $result = $p->getProductByCategory($idCate);
            if ($result) {
                if ($result->num_rows > 0) {
                    return $result;
                } else {
                    return -1;  // Không có dữ liệu
                }
            } else {
                return false;  // Kết nối thất bại hoặc lỗi truy vấn
            }
        }

        public function addCart($idProduct, $idUser)
        {
            $p = new mProduct();
            $result = $p->mAddCart($idProduct, $idUser);
            if ($result) {
                if ($result->num_rows > 0) {
                    return $result;
                } else {
                    return -1;  // Không có dữ liệu
                }
            } else {
                return false;  // Kết nối thất bại hoặc lỗi truy vấn
            }
        }
    }
?>