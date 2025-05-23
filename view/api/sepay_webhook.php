<?php
// Kết nối CSDL
require_once '../../model/connect.php';

// Ghi log để debug - sử dụng thư mục tạm thời nếu không có quyền ghi
function writeLog($message, $data = null) {
    $logFiles = [
        __DIR__ . '/sepay_webhook_log.txt',
        sys_get_temp_dir() . '/sepay_webhook_log.txt',
        '/tmp/sepay_webhook_log.txt'
    ];
    
    $logFile = null;
    foreach ($logFiles as $file) {
        $dir = dirname($file);
        if (is_writable($dir)) {
            $logFile = $file;
            break;
        }
    }
    
    if ($logFile) {
        $timestamp = date('Y-m-d H:i:s');
        $logMessage = "[{$timestamp}] {$message}";
        
        if ($data !== null) {
            $logMessage .= " - Data: " . json_encode($data);
        }
        
        file_put_contents($logFile, $logMessage . PHP_EOL, FILE_APPEND);
    }
}

// Bắt đầu ghi log
writeLog("Webhook received");

// Lấy dữ liệu từ request
$requestData = file_get_contents('php://input');
$headers = getallheaders();
writeLog("Request headers", $headers);
writeLog("Request data", $requestData);

// Parse JSON data
$data = json_decode($requestData, true);

// Kiểm tra dữ liệu
if (empty($data)) {
    writeLog("Empty data received");
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Empty data received']);
    exit;
}

// Log dữ liệu nhận được
writeLog("Processing payment notification", $data);

// Kiểm tra các trường cần thiết từ SePay
if (!isset($data['content']) || !isset($data['transferType']) || !isset($data['transferAmount'])) {
    writeLog("Missing required fields", $data);
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Missing required fields']);
    exit;
}

// Lấy thông tin từ webhook
$content = $data['content']; // Nội dung chuyển khoản (chứa mã đơn hàng)
$transferType = $data['transferType']; // Loại giao dịch (in/out)
$amount = $data['transferAmount']; // Số tiền
$transactionId = $data['referenceCode'] ?? ''; // Mã giao dịch
$transactionDate = $data['transactionDate'] ?? date('Y-m-d H:i:s');

// Chỉ xử lý giao dịch nhận tiền
if ($transferType !== 'in') {
    writeLog("Not an incoming transaction", ['transferType' => $transferType]);
    http_response_code(200);
    echo json_encode(['success' => true, 'message' => 'Not an incoming transaction']);
    exit;
}

// Tìm mã đơn hàng trong nội dung chuyển khoản
$orderCode = '';
if (preg_match('/ORD\d+/', $content, $matches)) {
    $orderCode = $matches[0];
} else {
    // Nếu không tìm thấy mã đơn hàng trong content, thử tìm trong description
    $description = $data['description'] ?? '';
    if (preg_match('/ORD\d+/', $description, $matches)) {
        $orderCode = $matches[0];
    }
}

if (empty($orderCode)) {
    writeLog("Order code not found in transaction content", ['content' => $content]);
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Order code not found']);
    exit;
}

writeLog("Found order code", ['order_code' => $orderCode]);

// Kết nối CSDL
try {
    $db = new clsketnoi();
    $conn = $db->moKetNoi();
    $conn->set_charset('utf8');
} catch (Exception $e) {
    writeLog("Database connection failed", ['error' => $e->getMessage()]);
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database connection failed']);
    exit;
}

// Tìm đơn hàng theo mã đơn hàng
$orderSql = "SELECT o.id, o.user_id, o.total_amount, o.status 
             FROM orders o 
             WHERE o.notes LIKE ?";
$orderStmt = $conn->prepare($orderSql);
$searchPattern = '%' . $orderCode . '%';
$orderStmt->bind_param("s", $searchPattern);
$orderStmt->execute();
$orderResult = $orderStmt->get_result();

writeLog("Order search", ['pattern' => $searchPattern, 'found' => $orderResult->num_rows]);

if ($orderResult->num_rows === 0) {
    writeLog("Order not found", ['order_code' => $orderCode]);
    http_response_code(404);
    echo json_encode(['success' => false, 'message' => 'Order not found']);
    $db->dongKetNoi($conn);
    exit;
}

$orderData = $orderResult->fetch_assoc();
$orderId = $orderData['id'];
$userId = $orderData['user_id'];
$orderAmount = $orderData['total_amount'];
$orderStatus = $orderData['status'];

writeLog("Order found", [
    'order_id' => $orderId,
    'user_id' => $userId,
    'amount' => $orderAmount,
    'status' => $orderStatus
]);

// Kiểm tra nếu đơn hàng đã được thanh toán
if ($orderStatus === '1') {
    writeLog("Order already paid", ['order_id' => $orderId]);
    http_response_code(200);
    echo json_encode(['success' => true, 'message' => 'Order already paid']);
    $db->dongKetNoi($conn);
    exit;
}

// Kiểm tra số tiền (cho phép sai lệch nhỏ)
$tolerance = 1000; // Cho phép sai số 1000đ
if (abs($amount - $orderAmount) > $tolerance) {
    writeLog("Amount mismatch", [
        'expected' => $orderAmount,
        'received' => $amount,
        'difference' => abs($amount - $orderAmount)
    ]);
    
    // Vẫn tiếp tục xử lý nhưng ghi log cảnh báo
    writeLog("WARNING: Processing payment despite amount mismatch");
}

// Cập nhật trạng thái đơn hàng thành đã thanh toán
$updateOrderSql = "UPDATE orders SET status = '1' WHERE id = ?";
$updateOrderStmt = $conn->prepare($updateOrderSql);
$updateOrderStmt->bind_param("i", $orderId);
$updateResult = $updateOrderStmt->execute();

if (!$updateResult) {
    writeLog("Failed to update order", ['order_id' => $orderId, 'error' => $conn->error]);
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Failed to update order']);
    $db->dongKetNoi($conn);
    exit;
}

writeLog("Order status updated successfully", ['order_id' => $orderId]);

// Kiểm tra xem bảng transactions đã tồn tại chưa
$checkTableSql = "SHOW TABLES LIKE 'transactions'";
$checkTableResult = $conn->query($checkTableSql);

if ($checkTableResult->num_rows > 0) {
    // Lưu thông tin giao dịch
    $transactionSql = "INSERT INTO transactions (order_id, transaction_id, method, amount, status, transaction_date) 
                    VALUES (?, ?, 'SePay', ?, 'completed', ?)";
    $transactionStmt = $conn->prepare($transactionSql);
    $transactionStmt->bind_param("isds", $orderId, $transactionId, $amount, $transactionDate);
    $transactionStmt->execute();
    writeLog("Transaction saved", ['transaction_id' => $transactionId]);
}

// Xóa giỏ hàng của người dùng
$deleteCartSql = "DELETE FROM cart WHERE customer_id = ?";
$deleteCartStmt = $conn->prepare($deleteCartSql);
$deleteCartStmt->bind_param("i", $userId);
$deleteCartStmt->execute();

writeLog("Cart cleared for user", ['user_id' => $userId]);

writeLog("Payment processed successfully", [
    'order_id' => $orderId,
    'transaction_id' => $transactionId,
    'amount' => $amount
]);

// Trả về kết quả thành công
http_response_code(200);
echo json_encode([
    'success' => true, 
    'message' => 'Payment processed successfully',
    'order_id' => $orderId,
    'order_code' => $orderCode
]);

// Đóng kết nối
$db->dongKetNoi($conn);
?>
