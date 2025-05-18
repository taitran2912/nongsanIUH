<?php
header('Content-Type: application/json');
require_once '../../../model/connect.php';

if (isset($_GET['id'])) {
    $productId = intval($_GET['id']);

    $conn = (new clsketnoi())->moKetNoi();
    $conn->set_charset("utf8");

    // Truy vấn để lấy tất cả hình ảnh của sản phẩm
    $stmt = $conn->prepare("SELECT id, product_id, img FROM product_images WHERE product_id = ?");
    $stmt->bind_param("i", $productId);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $images = [];

        while ($row = $result->fetch_assoc()) {
            $images[] = [
                'id' => $row['id'],
                'product_id' => $row['product_id'],
                'img' => $row['img'],
                'url' => '../../image/' . $row['img'] // Đường dẫn đầy đủ đến hình ảnh
            ];
        }

        if (count($images) > 0) {
            echo json_encode([
                "success" => true,
                "images" => $images
            ]);
        } else {
            echo json_encode([
                "success" => true,
                "images" => [],
                "message" => "Sản phẩm không có hình ảnh"
            ]);
        }
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Lỗi truy vấn: " . $stmt->error
        ]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode([
        "success" => false,
        "message" => "Thiếu ID sản phẩm"
    ]);
}