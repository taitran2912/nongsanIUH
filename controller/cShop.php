<?php
    include_once __DIR__ . '/../model/mShop.php';
    class CShop
    {
        // Lấy danh sách tất cả shop
        public function getAllShops()
        {
            $MShop = new MShop();
            return $MShop->getAllShops();
        }

        // Lấy thông tin shop theo ID
        public function getShopById($id)
        {
            $MShop = new MShop();
            return $MShop->getShopById($id);
        }

        // Thêm shop mới
        public function addShop($shopname, $address, $description, $owner_id, $status)
        {
            $MShop = new MShop();
            return $MShop->createShop($shopname, $address, $description, $owner_id, $status);
        }

        // Cập nhật shop
        public function updateShop($id, $shopname, $address, $description, $status)
        {
            $MShop = new MShop();
            return $MShop->updateShop($id, $shopname, $address, $description, $status);
        }

        // Xóa shop
        public function deleteShop($id)
        {
            $MShop = new MShop();
            return $MShop->deleteShop($id);
        }
    }
?>
