<?php
// thank_you.php - Thank you page after successful payment

// Kiểm tra đăng nhập
if (!isset($_SESSION["id"])) {
    echo "<script>window.location.href = '?action=login';</script>";
    exit;
}

$customerId = $_SESSION["id"];
$orderId = $_GET['order_id'] ?? null;

if (!$orderId) {
    echo "<script>window.location.href = '?action=product';</script>";
    exit;
}

// Kết nối CSDL
$db = new clsketnoi();
$conn = $db->moKetNoi();
$conn->set_charset('utf8');

// Lấy thông tin đơn hàng
$orderSql = "SELECT o.*, u.name as customer_name, u.email, u.phone 
             FROM orders o 
             JOIN users u ON o.user_id = u.id 
             WHERE o.id = ? AND o.user_id = ? AND o.status = '1'";
$orderStmt = $conn->prepare($orderSql);
$orderStmt->bind_param("ii", $orderId, $customerId);
$orderStmt->execute();
$orderResult = $orderStmt->get_result();

if ($orderResult->num_rows === 0) {
    echo "<script>alert('Đơn hàng không tồn tại hoặc chưa được thanh toán!'); window.location.href = '?action=product';</script>";
    exit;
}

$orderData = $orderResult->fetch_assoc();

// Lấy chi tiết đơn hàng
$detailSql = "SELECT od.*, p.name, p.price, p.unit 
              FROM order_details od 
              JOIN products p ON od.product_id = p.id 
              WHERE od.order_id = ?";
$detailStmt = $conn->prepare($detailSql);
$detailStmt->bind_param("i", $orderId);
$detailStmt->execute();
$detailResult = $detailStmt->get_result();

$orderItems = [];
while ($row = $detailResult->fetch_assoc()) {
    $orderItems[] = $row;
}

// Lấy thông tin thanh toán
$paymentSql = "SELECT * FROM payment_logs WHERE order_id = ? ORDER BY created_at DESC LIMIT 1";
$paymentStmt = $conn->prepare($paymentSql);
$paymentStmt->bind_param("i", $orderId);
$paymentStmt->execute();
$paymentResult = $paymentStmt->get_result();
$paymentData = $paymentResult->fetch_assoc();

$db->dongKetNoi($conn);

// Extract order code from notes
$orderCode = '';
if (preg_match('/ORD\d+/', $orderData['notes'], $matches)) {
    $orderCode = $matches[0];
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh toán thành công</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .success-container { max-width: 800px; margin: 0 auto; }
        .success-icon { font-size: 4rem; color: #28a745; }
        .order-summary { background: #f8f9fa; border-radius: 10px; padding: 1.5rem; }
        .thank-you-header { background: linear-gradient(135deg, #28a745, #20c997); color: white; border-radius: 15px; padding: 2rem; text-align: center; margin-bottom: 2rem; }
        .info-card { border: none; box-shadow: 0 2px 10px rgba(0,0,0,0.1); border-radius: 10px; }
        .badge-success { background-color: #28a745; }
        .timeline-item { border-left: 3px solid #28a745; padding-left: 1rem; margin-bottom: 1rem; }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="success-container">
            <!-- Success Header -->
            <div class="thank-you-header">
                <div class="success-icon mb-3">
                    <i class="fas fa-check-circle"></i>
                </div>
                <h1 class="mb-3">Thanh toán thành công!</h1>
                <p class="mb-0">Cảm ơn bạn đã tin tưởng và mua sắm tại cửa hàng của chúng tôi</p>
            </div>
            
            <div class="row">
                <!-- Order Information -->
                <div class="col-lg-8">
                    <div class="card info-card mb-4">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0"><i class="fas fa-receipt me-2"></i>Thông tin đơn hàng</h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <strong>Mã đơn hàng:</strong>
                                    <span class="badge badge-success ms-2"><?php echo $orderCode; ?></span>
                                </div>
                                <div class="col-md-6">
                                    <strong>Ngày đặt:</strong>
                                    <span><?php echo date('d/m/Y H:i', strtotime($orderData['order_date'])); ?></span>
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <strong>Khách hàng:</strong>
                                    <span><?php echo htmlspecialchars($orderData['customer_name']); ?></span>
                                </div>
                                <div class="col-md-6">
                                    <strong>Tổng tiền:</strong>
                                    <span class="text-success fw-bold"><?php echo number_format($orderData['total_amount'], 0, ',', '.'); ?>đ</span>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <strong>Địa chỉ giao hàng:</strong>
                                <span><?php echo htmlspecialchars($orderData['Shipping_address']); ?></span>
                            </div>
                            
                            <?php if ($paymentData): ?>
                            <div class="mb-3">
                                <strong>Mã giao dịch:</strong>
                                <span class="badge bg-info"><?php echo htmlspecialchars($paymentData['transaction_code']); ?></span>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <!-- Order Items -->
                    <div class="card info-card mb-4">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0"><i class="fas fa-shopping-bag me-2"></i>Sản phẩm đã đặt</h5>
                        </div>
                        <div class="card-body">
                            <?php foreach ($orderItems as $item): ?>
                            <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                                <div>
                                    <h6 class="mb-1"><?php echo htmlspecialchars($item['name']); ?></h6>
                                    <small class="text-muted">
                                        <?php echo number_format($item['price'], 0, ',', '.'); ?>đ/<?php echo $item['unit']; ?> 
                                        × <?php echo $item['quantity']; ?>
                                    </small>
                                </div>
                                <div class="text-end">
                                    <strong><?php echo number_format($item['price'] * $item['quantity'], 0, ',', '.'); ?>đ</strong>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                
                <!-- Next Steps -->
                <div class="col-lg-4">
                    <div class="card info-card mb-4">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0"><i class="fas fa-clock me-2"></i>Tiến trình đơn hàng</h5>
                        </div>
                        <div class="card-body">
                            <div class="timeline-item">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-check-circle text-success me-2"></i>
                                    <strong>Đã thanh toán</strong>
                                </div>
                                <small class="text-muted">
                                    <?php echo date('d/m/Y H:i', strtotime($orderData['order_date'])); ?>
                                </small>
                            </div>
                            
                            <div class="timeline-item">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-clock text-warning me-2"></i>
                                    <strong>Đang chuẩn bị hàng</strong>
                                </div>
                                <small class="text-muted">Dự kiến trong 1-2 giờ</small>
                            </div>
                            
                            <div class="timeline-item">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-truck text-muted me-2"></i>
                                    <strong>Đang giao hàng</strong>
                                </div>
                                <small class="text-muted">Dự kiến trong 2-4 giờ</small>
                            </div>
                            
                            <div class="timeline-item">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-home text-muted me-2"></i>
                                    <strong>Đã giao hàng</strong>
                                </div>
                                <small class="text-muted">Hoàn thành</small>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Contact Info -->
                    <div class="card info-card mb-4">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0"><i class="fas fa-headset me-2"></i>Hỗ trợ khách hàng</h5>
                        </div>
                        <div class="card-body">
                            <p class="mb-2">
                                <i class="fas fa-phone text-success me-2"></i>
                                <strong>Hotline:</strong> 1900-xxxx
                            </p>
                            <p class="mb-2">
                                <i class="fas fa-envelope text-primary me-2"></i>
                                <strong>Email:</strong> support@nongsan.com
                            </p>
                            <p class="mb-0">
                                <i class="fas fa-clock text-warning me-2"></i>
                                <strong>Giờ làm việc:</strong> 8:00 - 22:00
                            </p>
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="d-grid gap-2">
                        <a href="?action=product" class="btn btn-success">
                            <i class="fas fa-shopping-cart me-2"></i>Tiếp tục mua sắm
                        </a>
                        <a href="?action=order-history" class="btn btn-outline-primary">
                            <i class="fas fa-history me-2"></i>Xem lịch sử đơn hàng
                        </a>
                        <button onclick="window.print()" class="btn btn-outline-secondary">
                            <i class="fas fa-print me-2"></i>In hóa đơn
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Additional Info -->
            <div class="alert alert-info mt-4" role="alert">
                <div class="d-flex align-items-center">
                    <i class="fas fa-info-circle me-3"></i>
                    <div>
                        <strong>Lưu ý:</strong> Chúng tôi sẽ gửi thông tin chi tiết đơn hàng qua email 
                        <strong><?php echo htmlspecialchars($orderData['email']); ?></strong>. 
                        Vui lòng kiểm tra hộp thư và thư mục spam.
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Clear session data
        <?php unset($_SESSION['sepay_order']); ?>
        
        // Auto-redirect after 30 seconds (optional)
        setTimeout(function() {
            if (confirm('Bạn có muốn tiếp tục mua sắm không?')) {
                window.location.href = '?action=product';
            }
        }, 30000);
    </script>
</body>
</html>