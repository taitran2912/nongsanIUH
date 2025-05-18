<?php
header('Content-Type: application/json');
require_once '../../../model/connect.php';

// Lấy dữ liệu từ request
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['image_id']) && isset($data['image_name'])) {
    $imageId = intval($data['image_id']);
    $imageName = $data['image_name'];
    
    $conn = (new clsketnoi())->moKetNoi();
    $conn->set_charset("utf8");
    
    // Xóa hình ảnh từ cơ sở dữ liệu
    $stmt = $conn->prepare("DELETE FROM product_images WHERE id = ?");
    $stmt->bind_param("i", $imageId);
    
    if ($stmt->execute()) {
        // Xóa file hình ảnh từ thư mục (nếu cần)
        $imagePath = "../../../image/products/" . $imageName;
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
        
        echo json_encode([
            "success" => true,
            "message" => "Đã xóa hình ảnh thành công"
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Lỗi khi xóa hình ảnh: " . $stmt->error
        ]);
    }
    
    $stmt->close();
    $conn->close();
} else {
    echo json_encode([
        "success" => false,
        "message" => "Thiếu thông tin hình ảnh"
    ]);
}