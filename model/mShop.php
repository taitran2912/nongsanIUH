<?php
include_once("connect.php");

class mShop
{
    public function getAllShops()
    {
        $p = new clsketnoi();
        $conn = $p->moKetNoi();
        $conn->set_charset('utf8');

        if ($conn) {
            $query = "SELECT * FROM farms";
            $result = $conn->query($query);
            $p->dongKetNoi($conn);
            return $result;
        }

        return false;
    }

    public function getShopById($id)
    {
        $p = new clsketnoi();
        $conn = $p->moKetNoi();
        $conn->set_charset('utf8');

        if ($conn) {
            $stmt = $conn->prepare("SELECT * FROM farms WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $p->dongKetNoi($conn);
            return $result;
        }

        return false;
    }

    public function createShop($shopname, $address, $description, $owner_id, $status)
    {
        $p = new clsketnoi();
        $conn = $p->moKetNoi();
        $conn->set_charset('utf8');

        if ($conn) {
            $stmt = $conn->prepare("INSERT INTO farms (shopname, address, description, owner_id, status) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssii", $shopname, $address, $description, $owner_id, $status);
            $success = $stmt->execute();
            $p->dongKetNoi($conn);
            return $success;
        }

        return false;
    }

    public function updateShop($id, $shopname, $address, $description, $status)
    {
        $p = new clsketnoi();
        $conn = $p->moKetNoi();
        $conn->set_charset('utf8');

        if ($conn) {
            $stmt = $conn->prepare("UPDATE farms SET shopname = ?, address = ?, description = ?, status = ? WHERE id = ?");
            $stmt->bind_param("sssii", $shopname, $address, $description, $status, $id);
            $success = $stmt->execute();
            $p->dongKetNoi($conn);
            return $success;
        }

        return false;
    }

    public function deleteShop($id)
    {
        $p = new clsketnoi();
        $conn = $p->moKetNoi();
        $conn->set_charset('utf8');

        if ($conn) {
            $stmt = $conn->prepare("DELETE FROM farms WHERE id = ?");
            $stmt->bind_param("i", $id);
            $success = $stmt->execute();
            $p->dongKetNoi($conn);
            return $success;
        }

        return false;
    }
}
?>
