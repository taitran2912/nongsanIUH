<?php
// check_sepay_payment.php - API to check payment status

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Logging function
function writeLog($message, $data = null) {
    $logFile = __DIR__ . '/payment_check.log';
    $timestamp = date('Y-m-d H:i:s');
    $logMessage = "[{$timestamp}] {$message}";
    if ($data !== null) {
        $logMessage .= " - Data: " . json_encode($data, JSON_UNESCAPED_UNICODE);
    }
    file_put_contents($logFile, $logMessage . PHP_EOL, FILE_APPEND | LOCK_EX);
}

try {
    writeLog("Payment check API called");
    
    // Get request data
    $requestData = file_get_contents('php://input');
    $data = json_decode($requestData, true);
    
    writeLog("Request data", $data);
    
    // Validate input
    if (empty($data) || !isset($data['order_code'])) {
        writeLog("Missing order_code");
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Missing order_code']);
        exit;
    }
    
    $orderCode = $data['order_code'];
    
    // Database connection
    $connectionPaths = [
        __DIR__ . '/../../model/connect.php',
        __DIR__ . '/../model/connect.php',
        dirname(__DIR__) . '/model/connect.php'
    ];
    
    $connected = false;
    foreach ($connectionPaths as $path) {
        if (file_exists($path)) {
            require_once $path;
            $connected = true;
            break;
        }
    }
    
    if (!$connected) {
        writeLog("Database connection file not found");
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Database connection failed']);
        exit;
    }
    
    $db = new clsketnoi();
    $conn = $db->moKetNoi();
    
    if (!$conn) {
        writeLog("Database connection failed");
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Database connection failed']);
        exit;
    }
    
    $conn->set_charset('utf8');
    
    // Find order by order code
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
    
    // Check payment status
    if ($orderStatus == '1') {
        writeLog("Payment completed", ['order_id' => $orderId]);
        echo json_encode([
            'success' => true,
            'message' => 'Payment completed',
            'order_id' => $orderId,
            'status' => 'paid',
            'order_data' => $orderData
        ]);
    } else {
        writeLog("Payment not completed yet", ['order_id' => $orderId]);
        echo json_encode([
            'success' => false,
            'message' => 'Payment not completed yet',
            'order_id' => $orderId,
            'status' => 'pending',
            'order_data' => $orderData
        ]);
    }
    
    $db->dongKetNoi($conn);
    
} catch (Exception $e) {
    writeLog("Error checking payment", ['error' => $e->getMessage()]);
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
?>