<?php
// Kiểm tra đăng nhập
if (!isset($_SESSION["id"])) {
    echo "<script>window.location.href = '?action=login';</script>";
    exit;
}

$customerId = $_SESSION["id"];
$orderId = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;

// Nếu không có order_id, kiểm tra trong session
if ($orderId == 0 && isset($_SESSION['sepay_order']['order_id'])) {
    $orderId = $_SESSION['sepay_order']['order_id'];
}

// Kết nối CSDL
$db = new clsketnoi();
$conn = $db->moKetNoi();
$conn->set_charset('utf8');

// Lấy thông tin đơn hàng
$orderSql = "SELECT o.*, u.name, u.email, u.phone 
             FROM orders o 
             JOIN users u ON o.user_id = u.id 
             WHERE o.id = ? AND o.user_id = ?";
$orderStmt = $conn->prepare($orderSql);
$orderStmt->bind_param("ii", $orderId, $customerId);
$orderStmt->execute();
$orderResult = $orderStmt->get_result();

if ($orderResult->num_rows === 0) {
    echo "<script>alert('Không tìm thấy đơn hàng!'); window.location.href = '?action=dashboard';</script>";
    exit;
}

$orderInfo = $orderResult->fetch_assoc();

// Lấy chi tiết đơn hàng
$detailSql = "SELECT od.*, p.name, p.price, p.image 
              FROM order_details od 
              JOIN products p ON od.product_id = p.id 
              WHERE od.order_id = ?";
$detailStmt = $conn->prepare($detailSql);
$detailStmt->bind_param("i", $orderId);
$detailStmt->execute();
$detailResult = $detailStmt->get_result();

$orderDetails = [];
$subtotal = 0;

while ($row = $detailResult->fetch_assoc()) {
    $orderDetails[] = $row;
    $subtotal += $row['price'] * $row['quantity'];
}

// Tính phí vận chuyển
$shippingFee = ($subtotal >= 500000) ? 0 : 30000;

// Đóng kết nối
$db->dongKetNoi($conn);

// Xóa thông tin thanh toán từ session
if (isset($_SESSION['sepay_payment'])) {
    unset($_SESSION['sepay_payment']);
}
if (isset($_SESSION['sepay_order'])) {
    unset($_SESSION['sepay_order']);
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt hàng thành công</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .thank-you-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 2rem;
        }
        .order-success {
            text-align: center;
            margin-bottom: 2rem;
        }
        .success-icon {
            font-size: 5rem;
            color: #28a745;
            margin-bottom: 1rem;
        }
        .order-details {
            background-color: #f8f9fa;
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .product-item {
            display: flex;
            align-items: center;
            padding: 1rem 0;
            border-bottom: 1px solid #dee2e6;
        }
        .product-item:last-child {
            border-bottom: none;
        }
        .product-image {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 5px;
            margin-right: 1rem;
        }
        .product-info {
            flex-grow: 1;
        }
        .product-price {
            font-weight: bold;
            white-space: nowrap;
        }
        .order-summary {
            background-color: #e9f7ef;
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .summary-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.5rem;
        }
        .total-amount {
            font-size: 1.25rem;
            font-weight: bold;
            color: #dc3545;
        }
        .next-steps {
            text-align: center;
            margin-top: 2rem;
        }
        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-weight: bold;
            display: inline-block;
        }
        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }
        .status-paid {
            background-color: #d4edda;
            color: #155724;
        }
        .status-processing {
            background-color: #cce5ff;
            color: #004085;
        }
        .status-shipped {
            background-color: #d1ecf1;
            color: #0c5460;
        }
        .status-delivered {
            background-color: #d4edda;
            color: #155724;
        }
        .status-cancelled {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="thank-you-container">
            <div class="order-success">
                <i class="fas fa-check-circle success-icon"></i>
                <h1>Cảm ơn bạn đã đặt hàng!</h1>
                <p class="lead">Đơn hàng của bạn đã được xác nhận và đang được xử lý.</p>
                
                <?php
                $statusText = '';
                $statusClass = '';
                
                switch($orderInfo['status']) {
                    case '0':
                        $statusText = 'Chờ thanh toán';
                        $statusClass = 'status-pending';
                        break;
                    case '1':
                        $statusText = 'Đã thanh toán';
                        $statusClass = 'status-paid';
                        break;
                    case '2':
                        $statusText = 'Đang xử lý';
                        $statusClass = 'status-processing';
                        break;
                    case '3':
                        $statusText = 'Đang giao hàng';
                        $statusClass = 'status-shipped';
                        break;
                    case '4':
                        $statusText = 'Đã giao hàng';
                        $statusClass = 'status-delivered';
                        break;
                    case '5':
                        $statusText = 'Đã hủy';
                        $statusClass = 'status-cancelled';
                        break;
                    default:
                        $statusText = 'Không xác định';
                        $statusClass = 'status-pending';
                }
                ?>
                
                <div class="status-badge <?php echo $statusClass; ?>">
                    <?php echo $statusText; ?>
                </div>
            </div>
            
            <div class="order-details">
                <h4 class="mb-3">Thông tin đơn hàng #<?php echo $orderId; ?></h4>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <p><strong>Ngày đặt hàng:</strong> <?php echo date('d/m/Y H:i', strtotime($orderInfo['order_date'])); ?></p>
                        <p><strong>Tên khách hàng:</strong> <?php echo $orderInfo['name']; ?></p>
                        <p><strong>Email:</strong> <?php echo $orderInfo['email']; ?></p>
                        <p><strong>Số điện thoại:</strong> <?php echo $orderInfo['phone']; ?></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Địa chỉ giao hàng:</strong> <?php echo $orderInfo['Shipping_address']; ?></p>
                        <p><strong>Phương thức thanh toán:</strong> SePay</p>
                        <?php
                        // Hiển thị mã đơn hàng nếu có
                        if (strpos($orderInfo['notes'], 'Mã đơn hàng:') !== false) {
                            $orderCodeParts = explode('Mã đơn hàng:', $orderInfo['notes']);
                            $orderCode = trim($orderCodeParts[1]);
                            echo '<p><strong>Mã đơn hàng:</strong> ' . $orderCode . '</p>';
                        }
                        ?>
                    </div>
                </div>
                
                <h5 class="mb-3">Sản phẩm đã đặt</h5>
                
                <?php foreach ($orderDetails as $item): ?>
                <div class="product-item">
                    <img src="<?php echo $item['image']; ?>" alt="<?php echo $item['name']; ?>" class="product-image">
                    <div class="product-info">
                        <h6><?php echo $item['name']; ?></h6>
                        <p class="text-muted">Số lượng: <?php echo $item['quantity']; ?></p>
                    </div>
                    <div class="product-price">
                        <?php echo number_format($item['price'] * $item['quantity'], 0, ',', '.'); ?>đ
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            
            <div class="order-summary">
                <h4 class="mb-3">Tổng quan đơn hàng</h4>
                
                <div class="summary-item">
                    <span>Tổng tiền hàng:</span>
                    <span><?php echo number_format($subtotal, 0, ',', '.'); ?>đ</span>
                </div>
                <div class="summary-item">
                    <span>Phí vận chuyển:</span>
                    <span><?php echo number_format($shippingFee, 0, ',', '.'); ?>đ</span>
                </div>
                <hr>
                <div class="summary-item">
                    <span>Tổng thanh toán:</span>
                    <span class="total-amount"><?php echo number_format($orderInfo['total_amount'], 0, ',', '.'); ?>đ</span>
                </div>
            </div>
            
            <div class="next-steps">
                <p>Chúng tôi sẽ thông báo cho bạn khi đơn hàng được giao.</p>
                <div class="d-grid gap-2 d-md-block">
                    <a href="?action=dashboard" class="btn btn-primary me-md-2">
                        <i class="fas fa-user me-2"></i>Tài khoản của tôi
                    </a>
                    <a href="?action=home" class="btn btn-success">
                        <i class="fas fa-shopping-basket me-2"></i>Tiếp tục mua sắm
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
