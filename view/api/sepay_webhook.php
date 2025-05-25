<?php
// sepay_webhook.php - Webhook handler for SePay notifications

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set proper headers
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
    $logFile = __DIR__ . '/sepay_webhook.log';
    $timestamp = date('Y-m-d H:i:s');
    $logMessage = "[{$timestamp}] {$message}";
    if ($data !== null) {
        $logMessage .= " - Data: " . json_encode($data, JSON_UNESCAPED_UNICODE);
    }
    file_put_contents($logFile, $logMessage . PHP_EOL, FILE_APPEND | LOCK_EX);
}

try {
    writeLog("=== SEPAY WEBHOOK RECEIVED ===");
    writeLog("Request Method", $_SERVER['REQUEST_METHOD']);
    writeLog("Headers", getallheaders());
    
    // Get raw input
    $rawInput = file_get_contents('php://input');
    writeLog("Raw Input", $rawInput);
    
    if (empty($rawInput)) {
        writeLog("Empty raw input received");
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Empty data received']);
        exit;
    }
    
    // Parse JSON data
    $data = json_decode($rawInput, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        writeLog("JSON decode error", json_last_error_msg());
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Invalid JSON format']);
        exit;
    }
    
    writeLog("Parsed webhook data", $data);
    
    // Validate required fields
    $requiredFields = ['gateway', 'transferType', 'transferAmount', 'content'];
    foreach ($requiredFields as $field) {
        if (!isset($data[$field])) {
            writeLog("Missing required field: " . $field);
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => "Missing field: {$field}"]);
            exit;
        }
    }
    
    // Only process incoming transactions
    if ($data['transferType'] !== 'in') {
        writeLog("Not an incoming transaction", ['transferType' => $data['transferType']]);
        http_response_code(200);
        echo json_encode(['success' => true, 'message' => 'Not an incoming transaction']);
        exit;
    }
    
    // Extract order code from content
    $content = $data['content'];
    $description = $data['description'] ?? '';
    $orderCode = '';
    
    // Try to find order code in content or description
    if (preg_match('/ORD\d+/', $content, $matches)) {
        $orderCode = $matches[0];
    } elseif (preg_match('/ORD\d+/', $description, $matches)) {
        $orderCode = $matches[0];
    }
    
    if (empty($orderCode)) {
        writeLog("Order code not found", ['content' => $content, 'description' => $description]);
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Order code not found in transaction']);
        exit;
    }
    
    writeLog("Order code extracted", ['order_code' => $orderCode]);
    
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
            writeLog("Database connection file found", ['path' => $path]);
            break;
        }
    }
    
    if (!$connected) {
        writeLog("Database connection file not found", ['attempted_paths' => $connectionPaths]);
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
    writeLog("Database connected successfully");
    
    // Find order by order code
    $orderSql = "SELECT o.id, o.user_id, o.total_amount, o.status 
                 FROM orders o 
                 WHERE o.notes LIKE ?";
    $orderStmt = $conn->prepare($orderSql);
    $searchPattern = '%' . $orderCode . '%';
    $orderStmt->bind_param("s", $searchPattern);
    $orderStmt->execute();
    $orderResult = $orderStmt->get_result();
    
    if ($orderResult->num_rows === 0) {
        writeLog("Order not found", ['order_code' => $orderCode, 'search_pattern' => $searchPattern]);
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
    
    writeLog("Order found", $orderData);
    
    // Check if order is already paid
    if ($orderStatus == '1') {
        writeLog("Order already paid", ['order_id' => $orderId]);
        http_response_code(200);
        echo json_encode(['success' => true, 'message' => 'Order already paid']);
        $db->dongKetNoi($conn);
        exit;
    }
    
    // Validate payment amount (allow small tolerance)
    $receivedAmount = $data['transferAmount'];
    $tolerance = 1000; // Allow 1000đ difference
    
    if (abs($receivedAmount - $orderAmount) > $tolerance) {
        writeLog("Amount mismatch", [
            'expected' => $orderAmount,
            'received' => $receivedAmount,
            'difference' => abs($receivedAmount - $orderAmount)
        ]);
        
        // Log but continue processing (you may want to handle this differently)
        writeLog("WARNING: Processing payment despite amount mismatch");
    }
    
    // Begin transaction
    $conn->begin_transaction();
    
    try {
        // Update order status to paid
        $updateOrderSql = "UPDATE orders SET status = '1' WHERE id = ?";
        $updateOrderStmt = $conn->prepare($updateOrderSql);
        $updateOrderStmt->bind_param("i", $orderId);
        
        if (!$updateOrderStmt->execute()) {
            throw new Exception("Failed to update order status: " . $conn->error);
        }
        
        writeLog("Order status updated to paid", ['order_id' => $orderId]);
        
        // Update transaction status
        $updateTransactionSql = "UPDATE transactions SET status = 'completed' WHERE order_id = ? AND method = 'SePay'";
        $updateTransactionStmt = $conn->prepare($updateTransactionSql);
        $updateTransactionStmt->bind_param("i", $orderId);
        $updateTransactionStmt->execute();
        
        writeLog("Transaction status updated", ['order_id' => $orderId]);
        
        // Log payment event
        $logPaymentSql = "INSERT INTO payment_logs (order_id, transaction_code, event, amount, content, payload, created_at) 
                          VALUES (?, ?, 'success', ?, ?, ?, NOW())";
        $logPaymentStmt = $conn->prepare($logPaymentSql);
        $transactionCode = $data['referenceCode'] ?? '';
        $payloadJson = json_encode($data);
        $logPaymentStmt->bind_param("issds", $orderId, $transactionCode, $receivedAmount, $content, $payloadJson);
        $logPaymentStmt->execute();
        
        writeLog("Payment logged", ['transaction_code' => $transactionCode]);
        
        // Clear user's cart
        $clearCartSql = "DELETE FROM cart WHERE customer_id = ?";
        $clearCartStmt = $conn->prepare($clearCartSql);
        $clearCartStmt->bind_param("i", $userId);
        $clearCartStmt->execute();
        
        writeLog("Cart cleared", ['user_id' => $userId]);
        
        // Commit transaction
        $conn->commit();
        
        writeLog("Payment processed successfully", [
            'order_id' => $orderId,
            'order_code' => $orderCode,
            'amount' => $receivedAmount,
            'transaction_code' => $transactionCode
        ]);
        
        // Success response
        http_response_code(200);
        echo json_encode([
            'success' => true,
            'message' => 'Payment processed successfully',
            'order_id' => $orderId,
            'order_code' => $orderCode,
            'amount' => $receivedAmount
        ]);
        
    } catch (Exception $e) {
        // Rollback transaction
        $conn->rollback();
        
        writeLog("Transaction failed, rolled back", [
            'error' => $e->getMessage(),
            'order_id' => $orderId
        ]);
        
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => 'Failed to process payment: ' . $e->getMessage()
        ]);
    }
    
    $db->dongKetNoi($conn);
    
} catch (Exception $e) {
    writeLog("Webhook exception", [
        'message' => $e->getMessage(),
        'file' => $e->getFile(),
        'line' => $e->getLine(),
        'trace' => $e->getTraceAsString()
    ]);
    
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Internal server error'
    ]);
}
?>