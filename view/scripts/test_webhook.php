<?php
/**
 * Script để giả lập webhook từ SePay cho mục đích kiểm thử
 * Chỉ sử dụng trong môi trường phát triển
 */

// Lấy cấu hình SePay
$sepayConfig = require_once 'ngrok_config.php';

// Lấy thông tin đơn hàng từ tham số
$orderCode = $_GET['order_code'] ?? '';
$amount = $_GET['amount'] ?? 0;

if (empty($orderCode)) {
    die('Vui lòng cung cấp mã đơn hàng (order_code)');
}

// Kết nối CSDL
require_once 'config.php'; // Đảm bảo file này chứa class clsketnoi
$db = new clsketnoi();
$conn = $db->moKetNoi();
$conn->set_charset('utf8');

// Lấy thông tin đơn hàng
$orderSql = "SELECT o.id, o.total_amount FROM orders o WHERE o.notes LIKE ?";
$orderStmt = $conn->prepare($orderSql);
$searchPattern = '%' . $orderCode . '%';
$orderStmt->bind_param("s", $searchPattern);
$orderStmt->execute();
$orderResult = $orderStmt->get_result();

if ($orderResult->num_rows === 0) {
    die('Không tìm thấy đơn hàng với mã: ' . $orderCode);
}

$orderData = $orderResult->fetch_assoc();
$amount = $amount ?: $orderData['total_amount'];

// Đóng kết nối
$db->dongKetNoi($conn);

// Tạo dữ liệu webhook giả lập
$webhookData = [
    'gateway' => 'SEPAY',
    'transferType' => 'in',
    'accountNumber' => $sepayConfig['account_number'],
    'amount' => (float)$amount,
    'content' => $orderCode,
    'referenceCode' => 'TEST_' . time(),
    'description' => 'Thanh toán đơn hàng ' . $orderCode,
    'transactionDateTime' => date('Y-m-d H:i:s'),
    'data' => [
        'orderCode' => $orderCode,
        'status' => 'success'
    ]
];

// Chuyển đổi dữ liệu thành JSON
$payload = json_encode($webhookData);

// Gửi webhook đến endpoint
$ch = curl_init($sepayConfig['webhook_url']);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json'
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
curl_close($ch);

// Hiển thị kết quả
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kiểm tra Webhook SePay</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container py-5">
        <h1>Kiểm tra Webhook SePay</h1>
        
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Thông tin gửi đi</h5>
            </div>
            <div class="card-body">
                <p><strong>Webhook URL:</strong> <?php echo $sepayConfig['webhook_url']; ?></p>
                <p><strong>Mã đơn hàng:</strong> <?php echo $orderCode; ?></p>
                <p><strong>Số tiền:</strong> <?php echo number_format($amount, 0, ',', '.'); ?>đ</p>
                <h6>Dữ liệu JSON:</h6>
                <pre class="bg-light p-3 rounded"><?php echo json_encode($webhookData, JSON_PRETTY_PRINT); ?></pre>
            </div>
        </div>
        
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Kết quả</h5>
            </div>
            <div class="card-body">
                <p><strong>Mã HTTP:</strong> <?php echo $httpCode; ?></p>
                <?php if ($error): ?>
                <div class="alert alert-danger">
                    <strong>Lỗi:</strong> <?php echo $error; ?>
                </div>
                <?php endif; ?>
                
                <h6>Phản hồi:</h6>
                <pre class="bg-light p-3 rounded"><?php 
                    if (json_decode($response)) {
                        echo json_encode(json_decode($response), JSON_PRETTY_PRINT);
                    } else {
                        echo htmlspecialchars($response);
                    }
                ?></pre>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Kiểm tra đơn hàng khác</h5>
            </div>
            <div class="card-body">
                <form method="get" class="row g-3">
                    <div class="col-md-6">
                        <label for="order_code" class="form-label">Mã đơn hàng:</label>
                        <input type="text" class="form-control" id="order_code" name="order_code" required>
                    </div>
                    <div class="col-md-6">
                        <label for="amount" class="form-label">Số tiền (để trống để lấy từ đơn hàng):</label>
                        <input type="number" class="form-control" id="amount" name="amount" step="0.01">
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Gửi webhook</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
