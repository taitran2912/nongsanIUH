<?php
header('Content-Type: application/json');
require_once '../../../model/connect.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $conn = (new clsketnoi())->moKetNoi();
    $conn->set_charset("utf8");

    $stmt = $conn->prepare("SELECT p.*, pi.img FROM products p JOIN product_images pi ON p.id =pi.product_id WHERE p.id = ? AND p.status = 0;");
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
