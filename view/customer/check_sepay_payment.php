<?php
// Kết nối CSDL
require_once '../../model/connect.php';

// Kiểm tra phương thức yêu cầu
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('HTTP/1.1 405 Method Not Allowed');
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

// Lấy dữ liệu từ request
$data = json_decode(file_get_contents('php://input'), true);
$orderCode = $data['order_code'] ?? '';

if (empty($orderCode)) {
    echo json_encode(['success' => false, 'message' => 'Order code is required']);
    exit;
}

// Kết nối CSDL
$db = new clsketnoi();
$conn = $db->moKetNoi();
$conn->set_charset('utf8');

// Kiểm tra trạng thái đơn hàng
$orderSql = "SELECT o.id, o.status FROM orders o WHERE o.notes LIKE ?";
$orderStmt = $conn->prepare($orderSql);
$searchPattern = '%' . $orderCode . '%';
$orderStmt->bind_param("s", $searchPattern);
$orderStmt->execute();
$orderResult = $orderStmt->get_result();

if ($orderResult->num_rows === 0) {
    echo json_encode(['success' => false, 'message' => 'Order not found']);
    $db->dongKetNoi($conn);
    exit;
}

$orderData = $orderResult->fetch_assoc();

// Kiểm tra trạng thái thanh toán
if ($orderData['status'] === '1') {
    echo json_encode(['success' => true, 'message' => 'Payment completed']);
} else {
    echo json_encode(['success' => false, 'message' => 'Payment not completed yet']);
}

// Đóng kết nối
$db->dongKetNoi($conn);
?>
