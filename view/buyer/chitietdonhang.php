<?php
// Kết nối database
include_once("../../model/connect.php");
// Kết nối CSDL
// $conn = mysqli_connect("localhost", "root", "", "nongsan");
$kn = new clsketnoi();
$conn = $kn->moKetNoi();
$conn->set_charset('utf8');


// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Lấy ID đơn hàng từ URL
$order_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Lấy thông tin đơn hàng
$order_query = "SELECT o.*, u.name as customer_name, u.email as customer_email, u.phone as customer_phone, u.address as customer_address 
                FROM orders o 
                JOIN users u ON o.user_id = u.id 
                WHERE o.id = $order_id";
$order_result = $conn->query($order_query);
$order = $order_result->fetch_assoc();

// Lấy chi tiết đơn hàng - THÊM p.price và p.unit vào câu truy vấn
$items_query = "SELECT od.*, p.name as product_name, p.description as product_description, 
                p.price as price, p.unit as unit, pi.img as product_image, 
                c.name as category_name, f.shopname as farm_name 
                FROM order_details od 
                JOIN products p ON od.product_id = p.id 
                LEFT JOIN product_images pi ON p.id = pi.product_id 
                LEFT JOIN categories c ON p.id_categories = c.id
                LEFT JOIN farms f ON p.farm_id = f.id
                WHERE od.order_id = $order_id";
$items_result = $conn->query($items_query);

// Lấy thông tin giao dịch
$transaction_query = "SELECT * FROM transactions WHERE order_id = $order_id";
$transaction_result = $conn->query($transaction_query);
$transaction = $transaction_result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết đơn hàng #<?php echo $order_id; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #1e8449; /* Màu xanh lá đậm */
            --secondary-color: #fce4ec; /* Màu hồng nhạt */
        }
        
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        
        .top-header {
            background-color: var(--primary-color);
            color: white;
            padding: 10px 0;
        }
        
        .top-header a {
            color: white;
            text-decoration: none;
        }
        
        .main-header {
            background-color: white;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            padding: 15px 0;
        }
        
        .nav-link {
            color: #333;
            font-weight: 500;
            margin: 0 15px;
        }
        
        .nav-link.active {
            color: var(--primary-color);
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-outline-primary {
            color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-outline-primary:hover {
            background-color: var(--primary-color);
            color: white;
        }
        
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        
        .card-header {
            background-color: var(--secondary-color);
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }
        
        .sidebar {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        
        .sidebar .nav-link {
            color: #333;
            padding: 12px 20px;
            border-bottom: 1px solid #eee;
        }
        
        .sidebar .nav-link.active {
            background-color: var(--secondary-color);
            color: var(--primary-color);
            font-weight: bold;
        }
        
        .sidebar .nav-link i {
            color: var(--primary-color);
            margin-right: 10px;
        }
        
        .order-status {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: bold;
        }
        
        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }
        
        .status-processing {
            background-color: #cce5ff;
            color: #004085;
        }
        
        .status-shipped {
            background-color: #d4edda;
            color: #155724;
        }
        
        .status-delivered {
            background-color: #d1e7dd;
            color: #0f5132;
        }
        
        .status-cancelled {
            background-color: #f8d7da;
            color: #721c24;
        }
        
        .product-img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 5px;
        }
        
        .table th {
            background-color: #f8f9fa;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="top-header">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <i class="fas fa-phone-alt me-2"></i> 0123 456 789
                    <i class="fas fa-envelope ms-3 me-2"></i> info@nongsanxanh.com
                </div>
                <div class="col-md-6 text-end">
                    <a href="#" class="me-3"><i class="fab fa-facebook"></i></a>
                    <a href="#" class="me-3"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="me-3"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="main-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-3">
                    <a href="index.php" class="text-decoration-none">
                        <img src="assets/images/logo.png" alt="Nông Sản Xanh" height="60">
                    </a>
                </div>
                <div class="col-md-6">
                    <nav class="navbar navbar-expand-lg">
                        <div class="container-fluid">
                            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                            <div class="collapse navbar-collapse" id="navbarNav">
                                <ul class="navbar-nav">
                                    <li class="nav-item">
                                        <a class="nav-link" href="../customer/index.php">Trang chủ</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="products.php">Sản phẩm</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="about.php">Về chúng tôi</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </nav>
                </div>
                <div class="col-md-3 text-end">
                    <a href="profile.php" class="btn btn-outline-primary me-2">
                        <i class="fas fa-user"></i>
                    </a>
                    <a href="logout.php" class="btn btn-outline-primary me-2">
                        Đăng xuất
                    </a>
                    <a href="cart.php" class="btn btn-primary position-relative">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            3
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Main Content -->
    <div class="container my-5">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3">
                <div class="sidebar">
                    <div class="p-3 text-center">
                        <h5 class="mb-1"><?php echo isset($order['customer_name']) ? $order['customer_name'] : 'Khách hàng'; ?></h5>
                        <p class="text-muted mb-0"><?php echo isset($order['customer_email']) ? $order['customer_email'] : 'email@example.com'; ?></p>
                    </div>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="profile.php">
                                <i class="fas fa-tachometer-alt"></i> Tổng quan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="profile_info.php">
                                <i class="fas fa-user"></i> Thông tin cá nhân
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="orders.php">
                                <i class="fas fa-shopping-bag"></i> Đơn hàng của tôi
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="addresses.php">
                                <i class="fas fa-map-marker-alt"></i> Sổ địa chỉ
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="wishlist.php">
                                <i class="fas fa-heart"></i> Sản phẩm yêu thích
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="reviews.php">
                                <i class="fas fa-star"></i> Đánh giá của tôi
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="settings.php">
                                <i class="fas fa-cog"></i> Cài đặt tài khoản
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            
            <!-- Order Details -->
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Chi tiết đơn hàng #<?php echo $order_id; ?></h5>
                        <a href="../customer/index.php?action=profile" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-arrow-left me-1"></i> Quay lại
                        </a>
                    </div>
                    <div class="card-body">
                        <?php if (isset($order) && $order): ?>
                            <!-- Order Information -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <h6 class="text-muted">Thông tin đơn hàng</h6>
                                    <table class="table table-borderless">
                                        <tr>
                                            <td><strong>Mã đơn hàng:</strong></td>
                                            <td>#<?php echo $order['id']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Ngày đặt:</strong></td>
                                            <td><?php echo date('d/m/Y H:i', strtotime($order['order_date'])); ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Trạng thái:</strong></td>
                                            <td>
                                                <?php
                                                $status_class = '';
                                                $status_text = '';
                                                switch($order['status']) {
                                                    case '0':
                                                        $status_text = 'Chờ xác nhận';
                                                        $status_class = 'status-pending';
                                                        break;
                                                    case '1':
                                                        $status_text = 'Đang xử lý';
                                                        $status_class = 'status-processing';
                                                        break;
                                                    case '2':
                                                        $status_text = 'Đã giao hàng';
                                                        $status_class = 'status-delivered';
                                                        break;
                                                    case '3':
                                                        $status_text = 'Đã hủy';
                                                        $status_class = 'status-cancelled';
                                                        break;
                                                    default:
                                                        $status_text = $order['status'];
                                                }
                                                ?>
                                                <span class="order-status <?php echo $status_class; ?>">
                                                    <?php echo $status_text; ?>
                                                </span>
                                            </td>
                                        </tr>
                                        <?php if (isset($transaction) && $transaction): ?>
                                        <tr>
                                            <td><strong>Phương thức thanh toán:</strong></td>
                                            <td><?php echo $transaction['method']; ?></td>
                                        </tr>
                                        <?php endif; ?>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="text-muted">Thông tin khách hàng</h6>
                                    <table class="table table-borderless">
                                        <tr>
                                            <td><strong>Họ tên:</strong></td>
                                            <td><?php echo $order['customer_name']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Email:</strong></td>
                                            <td><?php echo $order['customer_email']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Số điện thoại:</strong></td>
                                            <td><?php echo $order['customer_phone']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Địa chỉ:</strong></td>
                                            <td><?php echo isset($order['Shipping_address']) ? $order['Shipping_address'] : $order['customer_address']; ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            
                            <?php if ($order['notes']): ?>
                            <div class="alert alert-info mb-4">
                                <h6 class="mb-1"><i class="fas fa-info-circle me-2"></i>Ghi chú đơn hàng:</h6>
                                <p class="mb-0"><?php echo $order['notes']; ?></p>
                            </div>
                            <?php endif; ?>
                            
                            <!-- Order Items -->
                            <h6 class="text-muted mb-3">Chi tiết sản phẩm</h6>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Sản phẩm</th>
                                            <th>Đơn giá</th>
                                            <th>Số lượng</th>
                                            <th class="text-end">Thành tiền</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $subtotal = 0;
                                        if ($items_result && $items_result->num_rows > 0): 
                                            while($item = $items_result->fetch_assoc()): 
                                                // Tính thành tiền cho mỗi sản phẩm
                                                $item_total = $item['price'] * $item['quantity'];
                                                $subtotal += $item_total;
                                        ?>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <?php if ($item['product_image']): ?>
                                                    <img src="../../image/<?php echo $item['product_image']; ?>" alt="<?php echo $item['product_name']; ?>" class="product-img me-3">
                                                    <?php else: ?>
                                                    <div class="product-img me-3 bg-light d-flex align-items-center justify-content-center">
                                                        <i class="fas fa-image text-muted"></i>
                                                    </div>
                                                    <?php endif; ?>
                                                    <div>
                                                        <h6 class="mb-0"><?php echo $item['product_name']; ?></h6>
                                                        <small class="text-muted">
                                                            <?php echo isset($item['category_name']) ? $item['category_name'] : ''; ?> 
                                                            <?php echo isset($item['farm_name']) ? '| '.$item['farm_name'] : ''; ?>
                                                        </small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><?php echo number_format($item['price'], 0, ',', '.'); ?>đ<?php echo isset($item['unit']) ? '/'.$item['unit'] : ''; ?></td>
                                            <td><?php echo $item['quantity']; ?></td>
                                            <td class="text-end"><?php echo number_format($item_total, 0, ',', '.'); ?>đ</td>
                                        </tr>
                                        <?php 
                                            endwhile; 
                                        else: 
                                        ?>
                                        <tr>
                                            <td colspan="4" class="text-center py-4">
                                                <i class="fas fa-shopping-basket fa-3x text-muted mb-3"></i>
                                                <h5>Không có sản phẩm nào trong đơn hàng</h5>
                                                <p class="text-muted">Có thể đơn hàng đã bị hủy hoặc có lỗi xảy ra.</p>
                                            </td>
                                        </tr>
                                        <?php endif; ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="3" class="text-end"><strong>Tổng tiền sản phẩm:</strong></td>
                                            <td class="text-end"><?php echo number_format($subtotal, 0, ',', '.'); ?>đ</td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="text-end"><strong>Phí vận chuyển:</strong></td>
                                            <td class="text-end">0đ</td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="text-end"><strong>Tổng thanh toán:</strong></td>
                                            <td class="text-end fw-bold fs-5"><?php echo number_format($order['total_amount'], 0, ',', '.'); ?>đ</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            
                            <!-- Order Timeline -->
                            <h6 class="text-muted mb-3 mt-4">Lịch sử đơn hàng</h6>
                            <div class="card">
                                <div class="card-body p-0">
                                    <ul class="list-group list-group-flush">
                                        <?php
                                        // Giả lập lịch sử đơn hàng
                                        $history = [
                                            [
                                                'status' => 'Đơn hàng đã được tạo',
                                                'time' => date('d/m/Y H:i', strtotime($order['order_date'])),
                                                'icon' => 'fa-shopping-cart'
                                            ]
                                        ];
                                        
                                        if ($order['status'] != '0' && $order['status'] != '3') {
                                            $history[] = [
                                                'status' => 'Đơn hàng đã được xác nhận',
                                                'time' => date('d/m/Y H:i', strtotime($order['order_date'] . ' +1 hour')),
                                                'icon' => 'fa-check'
                                            ];
                                        }
                                        
                                        if ($order['status'] == '1') {
                                            $history[] = [
                                                'status' => 'Đơn hàng đang được xử lý',
                                                'time' => date('d/m/Y H:i', strtotime($order['order_date'] . ' +1 day')),
                                                'icon' => 'fa-truck'
                                            ];
                                        }
                                        
                                        if ($order['status'] == '2') {
                                            $history[] = [
                                                'status' => 'Đơn hàng đã giao thành công',
                                                'time' => date('d/m/Y H:i', strtotime($order['order_date'] . ' +3 days')),
                                                'icon' => 'fa-check-circle'
                                            ];
                                        }
                                        
                                        if ($order['status'] == '3') {
                                            $history[] = [
                                                'status' => 'Đơn hàng đã bị hủy',
                                                'time' => date('d/m/Y H:i', strtotime($order['order_date'] . ' +2 hours')),
                                                'icon' => 'fa-times-circle'
                                            ];
                                        }
                                        
                                        foreach ($history as $event):
                                        ?>
                                        <li class="list-group-item">
                                            <div class="d-flex">
                                                <div class="me-3">
                                                    <span class="fa-stack">
                                                        <i class="fas fa-circle fa-stack-2x text-primary opacity-25"></i>
                                                        <i class="fas <?php echo $event['icon']; ?> fa-stack-1x text-primary"></i>
                                                    </span>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0"><?php echo $event['status']; ?></h6>
                                                    <small class="text-muted"><?php echo $event['time']; ?></small>
                                                </div>
                                            </div>
                                        </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                            
                            <!-- Actions -->
                            <div class="d-flex justify-content-end mt-4">
                                <?php if ($order['status'] == '0'): ?>
                                <button type="button" class="btn btn-outline-danger me-2" data-bs-toggle="modal" data-bs-target="#cancelOrderModal">
                                    <i class="fas fa-times me-1"></i> Hủy đơn hàng
                                </button>
                                <?php endif; ?>
                                
                                <?php if ($order['status'] == '2'): ?>
                                <a href="review.php?order_id=<?php echo $order_id; ?>" class="btn btn-outline-primary me-2">
                                    <i class="fas fa-star me-1"></i> Đánh giá sản phẩm
                                </a>
                                <?php endif; ?>
                                
                                <a href="#" class="btn btn-primary" onclick="window.print()">
                                    <i class="fas fa-print me-1"></i> In đơn hàng
                                </a>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-5">
                                <i class="fas fa-exclamation-circle fa-3x text-muted mb-3"></i>
                                <h5>Không tìm thấy thông tin đơn hàng</h5>
                                <p class="text-muted">Đơn hàng không tồn tại hoặc bạn không có quyền truy cập.</p>
                                <a href="orders.php" class="btn btn-primary mt-3">
                                    <i class="fas fa-arrow-left me-1"></i> Quay lại danh sách đơn hàng
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Cancel Order Modal -->
    <div class="modal fade" id="cancelOrderModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Xác nhận hủy đơn hàng</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Bạn có chắc chắn muốn hủy đơn hàng #<?php echo $order_id; ?>?</p>
                    <p class="text-muted small">Lưu ý: Hành động này không thể hoàn tác.</p>
                    
                    <form id="cancelOrderForm">
                        <div class="mb-3">
                            <label for="cancelReason" class="form-label">Lý do hủy đơn</label>
                            <select class="form-select" id="cancelReason" required>
                                <option value="">-- Chọn lý do --</option>
                                <option value="changed_mind">Tôi đổi ý, không muốn mua nữa</option>
                                <option value="found_better_price">Tìm thấy giá tốt hơn ở nơi khác</option>
                                <option value="wrong_item">Đặt nhầm sản phẩm</option>
                                <option value="delivery_too_long">Thời gian giao hàng quá lâu</option>
                                <option value="other">Lý do khác</option>
                            </select>
                        </div>
                        <div class="mb-3" id="otherReasonContainer" style="display: none;">
                            <label for="otherReason" class="form-label">Lý do khác</label>
                            <textarea class="form-control" id="otherReason" rows="3"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-danger" id="confirmCancelBtn">Xác nhận hủy</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Footer -->
    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5>Nông Sản Xanh</h5>
                    <p>Cung cấp các sản phẩm nông sản sạch, an toàn và chất lượng cao.</p>
                    <p>
                        <i class="fas fa-map-marker-alt me-2"></i> 123 Đường ABC, Quận XYZ, TP. HCM<br>
                        <i class="fas fa-phone-alt me-2"></i> 0123 456 789<br>
                        <i class="fas fa-envelope me-2"></i> info@nongsanxanh.com
                    </p>
                </div>
                <div class="col-md-4">
                    <h5>Liên kết nhanh</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-white">Trang chủ</a></li>
                        <li><a href="#" class="text-white">Sản phẩm</a></li>
                        <li><a href="#" class="text-white">Về chúng tôi</a></li>
                        <li><a href="#" class="text-white">Liên hệ</a></li>
                        <li><a href="#" class="text-white">Chính sách bảo mật</a></li>
                        <li><a href="#" class="text-white">Điều khoản sử dụng</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>Đăng ký nhận tin</h5>
                    <p>Nhận thông tin khuyến mãi và sản phẩm mới nhất.</p>
                    <form>
                        <div class="input-group mb-3">
                            <input type="email" class="form-control" placeholder="Email của bạn">
                            <button class="btn btn-primary" type="button">Đăng ký</button>
                        </div>
                    </form>
                    <div class="mt-3">
                        <a href="#" class="text-white me-3"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-white me-3"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-white me-3"><i class="fab fa-youtube"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-tiktok"></i></a>
                    </div>
                </div>
            </div>
            <hr>
            <div class="text-center">
                <p class="mb-0">© 2023 Nông Sản Xanh. Tất cả quyền được bảo lưu.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Hiển thị trường lý do khác khi chọn "Lý do khác"
        document.getElementById('cancelReason').addEventListener('change', function() {
            const otherReasonContainer = document.getElementById('otherReasonContainer');
            if (this.value === 'other') {
                otherReasonContainer.style.display = 'block';
            } else {
                otherReasonContainer.style.display = 'none';
            }
        });
        
        // Xử lý sự kiện khi nhấn nút xác nhận hủy
        document.getElementById('confirmCancelBtn').addEventListener('click', function() {
            const form = document.getElementById('cancelOrderForm');
            const reason = document.getElementById('cancelReason').value;
            
            if (!reason) {
                alert('Vui lòng chọn lý do hủy đơn hàng');
                return;
            }
            
            // Gửi yêu cầu hủy đơn hàng
            // Trong thực tế, bạn sẽ sử dụng AJAX để gửi yêu cầu đến máy chủ
            alert('Đơn hàng đã được hủy thành công!');
            window.location.href = 'orders.php';
        });
    </script>
</body>
</html>