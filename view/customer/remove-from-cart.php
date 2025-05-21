<?php
session_start();
include_once '../../model/connect.php';

header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['id'])) {
    echo json_encode([
        'success' => false, 
        'message' => 'Vui lòng đăng nhập để tiếp tục.'
    ]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customerId = isset($_SESSION['id']) ? intval($_SESSION['id']) : 0;
    $productId = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;

    if ($customerId <= 0 || $productId <= 0) {
        echo json_encode([
            'success' => false, 
            'message' => 'Thông tin không hợp lệ.'
        ]);
        exit;
    }

    try {
        $db = new clsketnoi();
        $conn = $db->moKetNoi();
        
        $sql = "DELETE FROM cart WHERE customer_id = ? AND product_id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ii", $customerId, $productId);
        
        $success = mysqli_stmt_execute($stmt);
        
        if ($success) {
            echo json_encode([
                'success' => true,
                'message' => 'Sản phẩm đã được xóa khỏi giỏ hàng.'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Không thể xóa sản phẩm: ' . mysqli_error($conn)
            ]);
        }
        
        $db->dongKetNoi($conn);
    } catch (Exception $e) {
        echo json_encode([
            'success' => false,
            'message' => 'Lỗi hệ thống: ' . $e->getMessage()
        ]);
    }
    
    exit;
}

echo json_encode([
    'success' => false,
    'message' => 'Phương thức không được hỗ trợ.'
]);
?>