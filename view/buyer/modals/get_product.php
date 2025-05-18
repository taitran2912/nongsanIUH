<?php
header('Content-Type: application/json');
require_once '../../../model/connect.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $conn = (new clsketnoi())->moKetNoi();
    $conn->set_charset("utf8");

    $stmt = $conn->prepare("SELECT id, name, description, price, quantity, created_at, unit FROM products WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($product = $result->fetch_assoc()) {
            echo json_encode([
                "success" => true,
                "product" => $product
            ]);
        } else {
            echo json_encode(["success" => false, "message" => "Không tìm thấy"]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Lỗi truy vấn"]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["success" => false, "message" => "Thiếu ID"]);
}
