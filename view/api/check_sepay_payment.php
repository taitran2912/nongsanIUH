<?php
// Ghi log để debug
function writeLog($message, $data = null) {
    $logFile = __DIR__ . '/payment_check_log.txt';
    $timestamp = date('Y-m-d H:i:s');
    $logMessage = "[{$timestamp}] {$message}";
    
    if ($data !== null) {
        $logMessage .= " - Data: " . json_encode($data);
    }
    
    file_put_contents($logFile, $logMessage . PHP_EOL, FILE_APPEND);
}

// Set header cho JSON response
header('Content-Type: application/json');

// Bắt đầu ghi log
writeLog("Payment check API called");

// Lấy dữ liệu từ request
$requestData = file_get_contents('php://input');
$data = json_decode($requestData, true);

writeLog("Request data", $data);

// Kiểm tra dữ liệu đầu vào
if (empty($data) || !isset($data['order_code'])) {
    writeLog("Missing order_code");
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Missing order_code']);
    exit;
}

$orderCode = $data['order_code'];

try {
    // Kết nối CSDL
    require_once '../../model/connect.php';
    $db = new clsketnoi();
    $conn = $db->moKetNoi();
    $conn->set_charset('utf8');

    // Tìm đơn hàng theo mã đơn hàng
    $orderSql = "SELECT o.id, o.user_id, o.total_amount, o.status, o.order_date 
                 FROM orders o 
                 WHERE o.notes LIKE ?";
    $orderStmt = $conn->prepare($orderSql);
    $searchPattern = '%' . $orderCode . '%';
    $orderStmt->bind_param("s", $searchPattern);
    $orderStmt->execute();
    $orderResult = $orderStmt->get_result();

    if ($orderResult->num_rows === 0) {
        writeLog("Order not found", ['order_code' => $orderCode]);
        echo json_encode(['success' => false, 'message' => 'Order not found']);
        $db->dongKetNoi($conn);
        exit;
    }

    $orderData = $orderResult->fetch_assoc();
    $orderId = $orderData['id'];
    $orderStatus = $orderData['status'];

    writeLog("Order found", [
        'order_id' => $orderId,
        'status' => $orderStatus,
        'order_code' => $orderCode
    ]);

    // Kiểm tra trạng thái thanh toán
    if ($orderStatus === '1') {
        writeLog("Payment completed", ['order_id' => $orderId]);
        echo json_encode([
            'success' => true, 
            'message' => 'Payment completed',
            'order_id' => $orderId,
            'status' => 'paid'
        ]);
    } else {
        writeLog("Payment not completed yet", ['order_id' => $orderId]);
        echo json_encode([
            'success' => false, 
            'message' => 'Payment not completed yet',
            'order_id' => $orderId,
            'status' => 'pending'
        ]);
    }

    // Đóng kết nối
    $db->dongKetNoi($conn);

} catch (Exception $e) {
    writeLog("Error checking payment", ['error' => $e->getMessage()]);
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
?>
