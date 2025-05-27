<?php
// sepay_checkout.php - Complete SePay checkout page

// Kiểm tra đăng nhập
if (!isset($_SESSION["id"])) {
    echo "<script>window.location.href = '?action=login';</script>";
    exit;
}

$customerId = $_SESSION["id"];

// Kết nối CSDL
$db = new clsketnoi();
$conn = $db->moKetNoi();
$conn->set_charset('utf8');

// Lấy thông tin người dùng
$userSql = "SELECT name, email, phone, address FROM users WHERE id = ?";
$userStmt = $conn->prepare($userSql);
$userStmt->bind_param("i", $customerId);
$userStmt->execute();
$userResult = $userStmt->get_result();
$userInfo = $userResult->fetch_assoc();

// Lấy danh sách sản phẩm trong giỏ hàng
$cartSql = "SELECT c.product_id, p.name, p.price, c.quantity 
            FROM cart c 
            JOIN products p ON c.product_id = p.id 
            WHERE c.customer_id = ?";

$cartStmt = $conn->prepare($cartSql);
$cartStmt->bind_param("i", $customerId);
$cartStmt->execute();
$cartResult = $cartStmt->get_result();

$cartItems = [];
$totalAmount = 0;

if ($cartResult->num_rows > 0) {
    while ($row = $cartResult->fetch_assoc()) {
        $cartItems[] = $row;
        $totalAmount += $row['price'] * $row['quantity'];
    }
}

// Kiểm tra giỏ hàng có sản phẩm không
if (empty($cartItems)) {
    echo "<script>alert('Giỏ hàng trống!'); window.location.href = '?action=shopping-cart';</script>";
    exit;
}

// Tính phí vận chuyển
$shippingFee = ($totalAmount >= 500000) ? 0 : 30000;
$finalTotal = $totalAmount + $shippingFee;

// Tạo mã đơn hàng duy nhất
$orderCode = "ORD" . time() . rand(1000, 9999);

// Cấu hình SePay
// https://1f3f-2401-d800-a84-cd16-2498-10a9-3fcd-ffc9.ngrok-free.app/DuAn_CNM/view/customer/index.php?action=dashboard
$ngrokUrl = "https://1f3f-2401-d800-a84-cd16-2498-10a9-3fcd-ffc9.ngrok-free.app"; // Thay đổi URL ngrok của bạn
$sepayConfig = [
    'account_number' => '91902203843',
    'account_name' => 'TranTanTai',
    'bank_code' => 'TPBank',
    'template' => 'compact',
    'webhook_url' => $ngrokUrl . '/DuAn_CNM/view/api/sepay_webhook.php',
    'return_url' => $ngrokUrl . '/DuAn_CNM/view/customer/index.php?action=thank_you'
];

// Tạo đơn hàng trong cơ sở dữ liệu
$orderSql = "INSERT INTO orders (user_id, order_date, status, total_amount, notes, Shipping_address) 
             VALUES (?, NOW(), '0', ?, ?, ?)";
$orderStmt = $conn->prepare($orderSql);
$notes = "Mã đơn hàng: " . $orderCode;
$orderStmt->bind_param("idss", $customerId, $finalTotal, $notes, $userInfo['address']);
$orderStmt->execute();
$orderId = $conn->insert_id;

// Lưu chi tiết đơn hàng
if ($orderId) {
    $detailSql = "INSERT INTO order_details (order_id, product_id, quantity) VALUES (?, ?, ?)";
    $detailStmt = $conn->prepare($detailSql);
    
    foreach ($cartItems as $item) {
        $detailStmt->bind_param("iii", $orderId, $item['product_id'], $item['quantity']);
        $detailStmt->execute();
    }
    
    // Lưu thông tin giao dịch
    $transactionSql = "INSERT INTO transactions (order_id, method, amount, status, transaction_date) 
                       VALUES (?, 'SePay', ?, 'pending', NOW())";
    $transactionStmt = $conn->prepare($transactionSql);
    $transactionStmt->bind_param("id", $orderId, $finalTotal);
    $transactionStmt->execute();
    
    // Lưu thông tin thanh toán vào session
    $_SESSION['sepay_order'] = [
        'order_id' => $orderId,
        'order_code' => $orderCode,
        'amount' => $finalTotal
    ];
}

$db->dongKetNoi($conn);

// Tạo URL QR code VietQR
function generateSepayQR($config, $amount, $content) {
    $url = sprintf(
        "https://img.vietqr.io/image/%s-%s-%s.png?amount=%s&addInfo=%s&accountName=%s",
        $config['bank_code'],
        $config['account_number'],
        $config['template'],
        $amount,
        urlencode($content),
        urlencode($config['account_name'])
    );
    return $url;
}

$qrCodeUrl = generateSepayQR($sepayConfig, $finalTotal, $orderCode);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh toán với SePay</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .payment-container { max-width: 1000px; margin: 0 auto; }
        .qr-container { text-align: center; padding: 2rem; background: #f8f9fa; border-radius: 15px; }
        .qr-code-img { max-width: 280px; margin: 1rem auto; border: 3px solid #28a745; border-radius: 15px; padding: 15px; background: white; }
        .timer { font-size: 1.8rem; font-weight: bold; color: #dc3545; margin: 1rem 0; }
        .bank-info { background: #e7f3ff; border: 1px solid #b3d9ff; border-radius: 10px; padding: 1.5rem; margin: 1rem 0; }
        .payment-steps .step { display: flex; align-items: flex-start; margin-bottom: 1rem; }
        .step-number { width: 35px; height: 35px; background: #28a745; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 1rem; flex-shrink: 0; font-weight: bold; }
        .loading-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(255,255,255,0.9); display: none; flex-direction: column; align-items: center; justify-content: center; z-index: 1000; }
        .status-badge { padding: 0.5rem 1rem; border-radius: 25px; font-weight: bold; }
        .status-pending { background: #fff3cd; color: #856404; }
        .status-success { background: #d1edff; color: #0c5460; }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="payment-container">
            <div class="text-center mb-4">
                <h2><i class="fas fa-qrcode me-2"></i>Thanh toán đơn hàng</h2>
                <p class="text-muted">Quét mã QR để hoàn tất thanh toán</p>
            </div>
            
            <div class="row">
                <!-- QR Code Section -->
                <div class="col-lg-7">
                    <div class="qr-container">
                        <h4><i class="fas fa-mobile-alt me-2"></i>Quét mã QR để thanh toán</h4>
                        <div class="timer" id="countdown">15:00</div>
                        
                        <div class="qr-code-img">
                            <img src="<?php echo $qrCodeUrl; ?>" alt="Mã QR thanh toán" class="img-fluid">
                        </div>
                        
                        <div class="bank-info">
                            <h6><i class="fas fa-university me-2"></i>Thông tin chuyển khoản</h6>
                            <div class="row">
                                <div class="col-6">
                                    <p class="mb-1"><strong>Số TK:</strong> <?php echo $sepayConfig['account_number']; ?></p>
                                    <p class="mb-1"><strong>Tên TK:</strong> <?php echo $sepayConfig['account_name']; ?></p>
                                </div>
                                <div class="col-6">
                                    <p class="mb-1"><strong>Ngân hàng:</strong> <?php echo $sepayConfig['bank_code']; ?></p>
                                    <p class="mb-1"><strong>Số tiền:</strong> <span class="text-danger fw-bold"><?php echo number_format($finalTotal, 0, ',', '.'); ?>đ</span></p>
                                </div>
                            </div>
                            <p class="mb-0 mt-2"><strong>Nội dung CK:</strong> <span class="text-primary fw-bold"><?php echo $orderCode; ?></span></p>
                        </div>
                        
                        <div class="d-grid gap-2 mt-3">
                            <button id="checkPayment" class="btn btn-success btn-lg">
                                <i class="fas fa-sync-alt me-2"></i>Kiểm tra thanh toán
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Order Info Section -->
                <div class="col-lg-5">
                    <div class="card">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0"><i class="fas fa-receipt me-2"></i>Chi tiết đơn hàng</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <strong>Mã đơn hàng:</strong> 
                                <span class="badge bg-primary"><?php echo $orderCode; ?></span>
                            </div>
                            
                            <div class="mb-3">
                                <strong>Trạng thái:</strong>
                                <span class="status-badge status-pending" id="orderStatus">
                                    <i class="fas fa-clock me-1"></i>Chờ thanh toán
                                </span>
                            </div>
                            
                            <hr>
                            
                            <div class="order-items mb-3">
                                <h6>Sản phẩm đã đặt:</h6>
                                <?php foreach ($cartItems as $item): ?>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <div>
                                        <small><?php echo htmlspecialchars($item['name']); ?></small>
                                        <br><small class="text-muted">SL: <?php echo $item['quantity']; ?></small>
                                    </div>
                                    <small class="fw-bold"><?php echo number_format($item['price'] * $item['quantity'], 0, ',', '.'); ?>đ</small>
                                </div>
                                <?php endforeach; ?>
                            </div>
                            
                            <hr>
                            
                            <div class="d-flex justify-content-between mb-2">
                                <span>Tạm tính:</span>
                                <span><?php echo number_format($totalAmount, 0, ',', '.'); ?>đ</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Phí vận chuyển:</span>
                                <span><?php echo number_format($shippingFee, 0, ',', '.'); ?>đ</span>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <strong>Tổng cộng:</strong>
                                <strong class="text-success"><?php echo number_format($finalTotal, 0, ',', '.'); ?>đ</strong>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="payment-steps">
                                <h6>Hướng dẫn thanh toán:</h6>
                                <div class="step">
                                    <div class="step-number">1</div>
                                    <small>Mở app ngân hàng trên điện thoại</small>
                                </div>
                                <div class="step">
                                    <div class="step-number">2</div>
                                    <small>Quét mã QR hoặc chuyển khoản thủ công</small>
                                </div>
                                <div class="step">
                                    <div class="step-number">3</div>
                                    <small>Nhập đúng nội dung: <strong><?php echo $orderCode; ?></strong></small>
                                </div>
                                <div class="step">
                                    <div class="step-number">4</div>
                                    <small>Xác nhận và hoàn tất thanh toán</small>
                                </div>
                            </div>
                            
                            <div class="d-grid gap-2 mt-3">
                                <a href="?action=shopping-cart" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>Quay lại giỏ hàng
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="spinner-border text-success mb-3" style="width: 3rem; height: 3rem;" role="status">
            <span class="visually-hidden">Đang xử lý...</span>
        </div>
        <h5 id="loadingMessage">Đang kiểm tra thanh toán...</h5>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let paymentCheckInterval;
            let countdownTimer;
            
            // Countdown timer (15 minutes)
            let timeLeft = 15 * 60;
            const countdownElement = document.getElementById('countdown');
            
            if (countdownElement) {
                countdownTimer = setInterval(function() {
                    const minutes = Math.floor(timeLeft / 60);
                    const seconds = timeLeft % 60;
                    
                    countdownElement.textContent = minutes.toString().padStart(2, '0') + ':' + 
                                                seconds.toString().padStart(2, '0');
                    
                    if (timeLeft <= 0) {
                        clearInterval(countdownTimer);
                        clearInterval(paymentCheckInterval);
                        countdownElement.textContent = "Hết thời gian";
                        alert("Thời gian thanh toán đã hết. Vui lòng thử lại.");
                        window.location.href = "?action=shopping-cart";
                        return;
                    }
                    
                    timeLeft--;
                }, 1000);
            }
            
            // Payment check function
            function checkPaymentStatus() {
                return fetch('../api/check_sepay_payment.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        order_code: '<?php echo $orderCode; ?>'
                    })
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Payment check response:', data);
                    
                    if (data.success && data.status === 'paid') {
                        // Clear intervals
                        clearInterval(countdownTimer);
                        clearInterval(paymentCheckInterval);
                        
                        // Update status
                        const statusElement = document.getElementById('orderStatus');
                        if (statusElement) {
                            statusElement.className = 'status-badge status-success';
                            statusElement.innerHTML = '<i class="fas fa-check-circle me-1"></i>Đã thanh toán';
                        }
                        
                        // Show success message
                        const loadingOverlay = document.getElementById('loadingOverlay');
                        const loadingMessage = document.getElementById('loadingMessage');
                        
                        if (loadingOverlay && loadingMessage) {
                            loadingOverlay.style.display = 'flex';
                            loadingMessage.textContent = 'Thanh toán thành công! Đang chuyển hướng...';
                        }
                        
                        // Redirect to thank you page
                        setTimeout(function() {
                            window.location.href = "?action=thank_you&order_id=<?php echo $orderId; ?>";
                        }, 2000);
                        
                        return true;
                    }
                    return false;
                })
                .catch(error => {
                    console.error('Payment check error:', error);
                    return false;
                });
            }
            
            // Manual check button
            const checkPaymentBtn = document.getElementById('checkPayment');
            if (checkPaymentBtn) {
                checkPaymentBtn.addEventListener('click', function() {
                    const loadingOverlay = document.getElementById('loadingOverlay');
                    const loadingMessage = document.getElementById('loadingMessage');
                    
                    if (loadingOverlay && loadingMessage) {
                        loadingOverlay.style.display = 'flex';
                        loadingMessage.textContent = 'Đang kiểm tra thanh toán...';
                    }
                    
                    checkPaymentStatus().then(success => {
                        if (!success && loadingOverlay) {
                            loadingOverlay.style.display = 'none';
                            alert("Chưa nhận được thanh toán. Vui lòng thử lại sau khi chuyển khoản.");
                        }
                    });
                });
            }
            
            // Auto-check every 5 seconds
            paymentCheckInterval = setInterval(function() {
                checkPaymentStatus();
            }, 5000);
            
            // Initial check after 3 seconds
            setTimeout(function() {
                checkPaymentStatus();
            }, 3000);
        });
    </script>
</body>
</html>