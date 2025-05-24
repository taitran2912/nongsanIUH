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
    <!-- Main Content -->
    <div class="container my-5">
        <div class="row">
            
            <!-- Order Details -->
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Chi tiết đơn hàng #<?php echo $order_id; ?></h5>
                        <a href="#" onclick="goBack()" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-arrow-left me-1"></i> Quay lại
                        </a>

                        <script>
                        function goBack() {
                            if (document.referrer !== "") {
                                window.history.back();
                            } else {
                                window.location.href = '../customer/index.php?action=profile'; // fallback
                            }
                        }
                        </script>
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
                                                    case '1':
                                                        $status_text = 'Chờ xác nhận';
                                                        $status_class = 'status-pending';
                                                        break;
                                                    case '2':
                                                        $status_text = 'Đang giao hàng';
                                                        $status_class = 'status-processing';
                                                        break;
                                                    case '3':
                                                        $status_text = 'Đã giao hàng';
                                                        $status_class = 'status-delivered';
                                                        break;
                                                    case '4':
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
                                                    <img src="../../image/<?php echo $item['product_image']; ?>" alt="<?php echo $item['product_name']; ?>" class="product-img me-3" style="width: 50px; height: 50px; object-fit: cover;">
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
                                            <td class="text-end"><?php echo number_format($subtotal, 0, ',', '.'); 
                                            if($order['total_amonunt']-30000 > 5000000){$ship_fee = 0;}else{$ship_fee = 30000;}
                                            ?>đ</td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="text-end"><strong>Phí vận chuyển:</strong></td>
                                            <td class="text-end"><?php echo $ship_fee; ?></td>
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
                                        
                                        if ($order['status'] != '0') {
                                            $history[] = [
                                                'status' => 'Đơn hàng đã được xác nhận',
                                                'time' => date('d/m/Y H:i', strtotime($order['order_date'] . ' +1 hour')),
                                                'icon' => 'fa-check'
                                            ];
                                        }
                                        
                                        if ($order['status'] == '1') {
                                            $history[] = [
                                                'status' => 'Đơn hàng chưa được xác nhận',
                                                'time' => date('d/m/Y H:i', strtotime($order['order_date'] . ' +1 day')),
                                                'icon' => 'fa-truck'
                                            ];
                                        }
                                        
                                        if ($order['status'] == '2') {
                                            $history[] = [
                                                'status' => 'Đơn hàng đang giao',
                                                'time' => date('d/m/Y H:i', strtotime($order['order_date'] . ' +3 days')),
                                                'icon' => 'fa-check-circle'
                                            ];
                                        }
                                        
                                        if ($order['status'] == '3') {
                                            $history[] = [
                                                'status' => 'Đơn hàng đã giao thành công',
                                                'time' => date('d/m/Y H:i', strtotime($order['order_date'] . ' +2 hours')),
                                                'icon' => 'fa-check'
                                            ];
                                        }

                                        if ($order['status'] == '4') {
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
                                <a href="?action=cancelorder&id=<?php echo $order_id; ?>" class="btn btn-sm btn-outline-danger ms-2" onclick="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này?')">Hủy đơn</a>
                                <?php endif; ?>
                               
                                <?php if ($order['status'] == '2'): ?>
                                <a href="review.php?order_id=<?php echo $order_id; ?>" class="btn btn-outline-primary me-2">
                                    <i class="fas fa-star me-1"></i> Đánh giá sản phẩm
                                </a>
                                <?php endif; ?>
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
            window.location.href = '?action=profile.php';
        });
    </script>
