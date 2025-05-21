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

    if ($customerId <= 0) {
        echo json_encode([
            'success' => false, 
            'message' => 'ID khách hàng không hợp lệ.'
        ]);
        exit;
    }

    try {
        $db = new clsketnoi();
        $conn = $db->moKetNoi();
        
        $sql = "DELETE FROM cart WHERE customer_id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $customerId);
        
        $success = mysqli_stmt_execute($stmt);
        
        if ($success) {
            echo json_encode([
                'success' => true,
                'message' => 'Giỏ hàng đã được xóa thành công.'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Không thể xóa giỏ hàng: ' . mysqli_error($conn)
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