<?php
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
    echo "<script>alert('Giỏ hàng trống!'); window.location.href = '?action=cart';</script>";
    exit;
}

// Tính phí vận chuyển
$shippingFee = ($totalAmount >= 500000) ? 0 : 30000;
$finalTotal = $totalAmount + $shippingFee;

// Tạo mã đơn hàng duy nhất
$orderCode = "ORD" . time() . rand(1000, 9999);

// Lấy URL ngrok từ cấu hình
$ngrokUrl = "https://5395-2402-800-63b3-eafc-db9-75c9-4717-1392.ngrok-free.app";

// Cấu hình SePay - Thay thế bằng thông tin thực của bạn
$sepayConfig = [
    'account_number' => '91902203843', // Số tài khoản ngân hàng liên kết với SePay
    'account_name' => 'TranTanTai', // Tên chủ tài khoản
    'bank_code' => 'TPBank', // Mã ngân hàng (VCB, TCB, MB, etc.)
    'template' => 'compact', // Template QR code
    'webhook_url' => $ngrokUrl . '/DuAn_CNM/view/api/sepay_webhook.php', // URL webhook qua ngrok
    'return_url' => $ngrokUrl . '/DuAn_CNM/view/customer/index.php?action=thank_you' // URL trả về
];

// Tạo đơn hàng trong cơ sở dữ liệu với trạng thái chờ thanh toán
$orderSql = "INSERT INTO orders (user_id, order_date, status, total_amount, notes, Shipping_address) 
             VALUES (?, NOW(), '0', ?, ?, ?)";
$orderStmt = $conn->prepare($orderSql);
$notes = "Đơn hàng thanh toán qua SePay. Mã đơn hàng: " . $orderCode;
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
    $transactionId = $conn->insert_id;
    
    // Lưu thông tin thanh toán vào session
    $_SESSION['sepay_order'] = [
        'order_id' => $orderId,
        'order_code' => $orderCode,
        'amount' => $finalTotal
    ];
}

// Đóng kết nối
$db->dongKetNoi($conn);

// Tạo nội dung chuyển khoản
$transferContent = $orderCode; // Nội dung chuyển khoản là mã đơn hàng
$amount = $finalTotal;

// Tạo URL QR code VietQR
function generateSepayQR($config, $amount, $content) {
    // Sử dụng cấu trúc URL chính xác của VietQR
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

$qrCodeUrl = generateSepayQR($sepayConfig, $amount, $transferContent);

// Lưu thông tin thanh toán vào session
$_SESSION['sepay_payment'] = [
    'order_code' => $orderCode,
    'qr_code_url' => $qrCodeUrl,
    'amount' => $finalTotal,
    'expires_at' => time() + 900 // 15 phút
];
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh toán với SePay</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .payment-container {
            max-width: 800px;
            margin: 0 auto;
        }
        .qr-container {
            text-align: center;
            padding: 2rem;
            background-color: #f8f9fa;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .payment-info {
            margin-top: 2rem;
        }
        .timer {
            font-size: 1.5rem;
            font-weight: bold;
            color: #dc3545;
            margin: 1rem 0;
        }
        .qr-code-img {
            max-width: 300px;
            margin: 1rem auto;
            border: 2px solid #ddd;
            border-radius: 10px;
            padding: 10px;
            background: white;
        }
        .payment-steps {
            margin-top: 2rem;
        }
        .step {
            display: flex;
            align-items: flex-start;
            margin-bottom: 1rem;
        }
        .step-number {
            width: 30px;
            height: 30px;
            background-color: #198754;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            flex-shrink: 0;
        }
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255,255,255,0.8);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            display: none;
        }
        .spinner-border {
            width: 3rem;
            height: 3rem;
        }
        .bank-info {
            background-color: #e7f3ff;
            border: 1px solid #b3d9ff;
            border-radius: 8px;
            padding: 1rem;
            margin: 1rem 0;
        }
        .webhook-info {
            margin-top: 1rem;
            padding: 0.5rem;
            background-color: #f8f9fa;
            border: 1px dashed #ccc;
            border-radius: 5px;
            font-family: monospace;
            font-size: 0.8rem;
            word-break: break-all;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="payment-container">
            <h2 class="text-center mb-4">Thanh toán đơn hàng</h2>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="qr-container">
                        <h4>Quét mã QR để thanh toán</h4>
                        <div class="timer" id="countdown">15:00</div>
                        <div class="qr-code-img">
                            <img src="<?php echo $qrCodeUrl; ?>" alt="Mã QR thanh toán" class="img-fluid">
                        </div>
                        <p class="text-muted">Quét mã QR bằng ứng dụng ngân hàng để thanh toán</p>
                        
                        <div class="bank-info">
                            <h6><i class="fas fa-university me-2"></i>Thông tin chuyển khoản</h6>
                            <p class="mb-1"><strong>Số tài khoản:</strong> <?php echo $sepayConfig['account_number']; ?></p>
                            <p class="mb-1"><strong>Tên tài khoản:</strong> <?php echo $sepayConfig['account_name']; ?></p>
                            <p class="mb-1"><strong>Ngân hàng:</strong> <?php echo $sepayConfig['bank_code']; ?></p>
                            <p class="mb-1"><strong>Số tiền:</strong> <span class="text-danger fw-bold"><?php echo number_format($finalTotal, 0, ',', '.'); ?>đ</span></p>
                            <p class="mb-0"><strong>Nội dung:</strong> <span class="text-primary fw-bold"><?php echo $orderCode; ?></span></p>
                        </div>
                        
                        <!-- Thông tin webhook cho developer -->
                        <?php if (isset($_GET['debug']) && $_GET['debug'] == 1): ?>
                        <div class="webhook-info">
                            <p class="mb-1"><strong>Webhook URL:</strong> <?php echo $sepayConfig['webhook_url']; ?></p>
                            <p class="mb-0"><strong>Return URL:</strong> <?php echo $sepayConfig['return_url']; ?></p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="payment-info">
                        <div class="card">
                            <div class="card-header bg-success text-white">
                                <h5 class="mb-0">Thông tin đơn hàng</h5>
                            </div>
                            <div class="card-body">
                                <p><strong>Mã đơn hàng:</strong> <?php echo $orderCode; ?></p>
                                <p><strong>Tổng tiền hàng:</strong> <?php echo number_format($totalAmount, 0, ',', '.'); ?>đ</p>
                                <p><strong>Phí vận chuyển:</strong> <?php echo number_format($shippingFee, 0, ',', '.'); ?>đ</p>
                                <p><strong>Tổng thanh toán:</strong> <span class="text-danger fw-bold"><?php echo number_format($finalTotal, 0, ',', '.'); ?>đ</span></p>
                            </div>
                        </div>
                        
                        <div class="payment-steps mt-4">
                            <h5>Hướng dẫn thanh toán:</h5>
                            <div class="step">
                                <div class="step-number">1</div>
                                <div>Mở ứng dụng ngân hàng trên điện thoại của bạn</div>
                            </div>
                            <div class="step">
                                <div class="step-number">2</div>
                                <div>Chọn chức năng quét mã QR hoặc chuyển khoản</div>
                            </div>
                            <div class="step">
                                <div class="step-number">3</div>
                                <div>Quét mã QR hoặc nhập thông tin chuyển khoản</div>
                            </div>
                            <div class="step">
                                <div class="step-number">4</div>
                                <div><strong>Quan trọng:</strong> Nhập đúng nội dung chuyển khoản: <span class="text-primary fw-bold"><?php echo $orderCode; ?></span></div>
                            </div>
                            <div class="step">
                                <div class="step-number">5</div>
                                <div>Xác nhận và hoàn tất thanh toán</div>
                            </div>
                        </div>
                        
                        <div class="d-grid gap-2 mt-4">
                            <button id="checkPayment" class="btn btn-success">
                                <i class="fas fa-sync-alt me-2"></i>Kiểm tra thanh toán
                            </button>
                            
                            <?php if (isset($_GET['debug']) && $_GET['debug'] == 1): ?>
                            <!-- Nút test payment chỉ hiển thị trong chế độ debug -->
                            <a href="../api/simulate_payment.php?order_code=<?php echo $orderCode; ?>&amount=<?php echo $finalTotal; ?>" class="btn btn-warning" target="_blank">
                                <i class="fas fa-flask me-2"></i>Mô phỏng thanh toán (Dev)
                            </a>
                            <?php endif; ?>
                            
                            <a href="?action=cart" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Quay lại giỏ hàng
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="spinner-border text-success mb-3" role="status">
            <span class="visually-hidden">Đang xử lý...</span>
        </div>
        <h5 id="loadingMessage">Đang kiểm tra thanh toán...</h5>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Đếm ngược thời gian
            var timeLeft = 15 * 60; // 15 phút
            var countdownElement = document.getElementById('countdown');
            
            if (countdownElement) {
                var countdownTimer = setInterval(function() {
                    var minutes = Math.floor(timeLeft / 60);
                    var seconds = timeLeft % 60;
                    
                    countdownElement.textContent = minutes.toString().padStart(2, '0') + ':' + 
                                                seconds.toString().padStart(2, '0');
                    
                    if (timeLeft <= 0) {
                        clearInterval(countdownTimer);
                        countdownElement.textContent = "Hết thời gian";
                        alert("Thời gian thanh toán đã hết. Vui lòng thử lại.");
                        window.location.href = "?action=cart";
                    }
                    
                    timeLeft--;
                }, 1000);
            }
            
            // Kiểm tra thanh toán
            var checkPaymentBtn = document.getElementById('checkPayment');
            var loadingOverlay = document.getElementById('loadingOverlay');
            var loadingMessage = document.getElementById('loadingMessage');
            
            if (checkPaymentBtn && loadingOverlay && loadingMessage) {
                checkPaymentBtn.addEventListener('click', function() {
                    loadingOverlay.style.display = 'flex';
                    loadingMessage.textContent = 'Đang kiểm tra thanh toán...';
                    
                    // Gọi API kiểm tra thanh toán
                    fetch('../api/check_sepay_payment.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            order_code: '<?php echo $orderCode; ?>'
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            loadingMessage.textContent = 'Thanh toán thành công! Đang chuyển hướng...';
                            
                            // Chuyển hướng đến trang cảm ơn
                            setTimeout(function() {
                                window.location.href = "?action=thank_you&order_id=<?php echo $orderId; ?>";
                            }, 2000);
                        } else {
                            loadingOverlay.style.display = 'none';
                            alert(data.message || "Chưa nhận được thanh toán. Vui lòng thử lại.");
                        }
                    })
                    .catch(error => {
                        loadingOverlay.style.display = 'none';
                        alert("Có lỗi xảy ra khi kiểm tra thanh toán. Vui lòng thử lại.");
                        console.error('Error:', error);
                    });
                });
            }
            
            // Tự động kiểm tra thanh toán mỗi 10 giây
            setInterval(function() {
                fetch('../api/check_sepay_payment.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        order_code: '<?php echo $orderCode; ?>'
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Hiển thị thông báo
                        loadingOverlay.style.display = 'flex';
                        loadingMessage.textContent = 'Thanh toán thành công! Đang chuyển hướng...';
                        
                        // Chuyển hướng đến trang cảm ơn
                        setTimeout(function() {
                            window.location.href = "?action=thank_you&order_id=<?php echo $orderId; ?>";
                        }, 2000);
                    }
                })
                .catch(error => {
                    console.error('Error checking payment:', error);
                });
            }, 10000);
        });
    </script>
</body>
</html>
