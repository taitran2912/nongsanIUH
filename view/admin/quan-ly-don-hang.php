    <?php 
        
        try {
            // Kết nối đến cơ sở dữ liệu
            $host = "localhost";
            $dbname = "nongsan"; // Thay đổi tên database nếu cần
            $username = "root";
            $password = "";
            
            $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Xử lý cập nhật trạng thái đơn hàng nếu có yêu cầu
            if(isset($_POST['update_status']) && isset($_POST['order_id']) && isset($_POST['new_status'])) {
                $order_id = $_POST['order_id'];
                $new_status = $_POST['new_status'];
                
                $update_query = "UPDATE orders SET status = :status WHERE id = :order_id";
                $update_stmt = $conn->prepare($update_query);
                $update_stmt->bindParam(':status', $new_status);
                $update_stmt->bindParam(':order_id', $order_id);
                
                if($update_stmt->execute()) {
                    echo "<div class='alert alert-success'>Cập nhật trạng thái đơn hàng thành công!</div>";
                } else {
                    echo "<div class='alert alert-danger'>Lỗi khi cập nhật trạng thái đơn hàng!</div>";
                }
            }
            
            // Xử lý xóa đơn hàng nếu có yêu cầu
            if(isset($_POST['delete_order']) && isset($_POST['order_id'])) {
                $order_id = $_POST['order_id'];
                
                // Bắt đầu transaction để đảm bảo tính toàn vẹn dữ liệu
                $conn->beginTransaction();
                
                try {
                    // Xóa chi tiết đơn hàng trước (để tránh lỗi khóa ngoại)
                    $delete_details = "DELETE FROM order_details WHERE order_id = :order_id";
                    $stmt_details = $conn->prepare($delete_details);
                    $stmt_details->bindParam(':order_id', $order_id);
                    $stmt_details->execute();
                    
                    // Xóa đơn hàng
                    $delete_order = "DELETE FROM orders WHERE id = :order_id";
                    $stmt_order = $conn->prepare($delete_order);
                    $stmt_order->bindParam(':order_id', $order_id);
                    $stmt_order->execute();
                    
                    // Commit transaction
                    $conn->commit();
                    
                    // Thông báo thành công
                    echo "<div class='alert alert-success'>Xóa đơn hàng thành công!</div>";
                    
                } catch(Exception $e) {
                    // Rollback transaction nếu có lỗi
                    $conn->rollBack();
                    echo "<div class='alert alert-danger'>Lỗi khi xóa đơn hàng: " . $e->getMessage() . "</div>";
                }
            }
            
            // Truy vấn dữ liệu đơn hàng
            $query = "SELECT o.*, u.name as customer_name, u.email, u.phone 
                    FROM orders o 
                    LEFT JOIN users u ON o.user_id = u.id 
                    ORDER BY o.order_date DESC";
            $result = $conn->prepare($query);
            $result->execute();
            
        } catch(PDOException $e) {
            echo "Lỗi kết nối: " . $e->getMessage();
            $result = null; // Đảm bảo $result được định nghĩa ngay cả khi có lỗi
        }
        
        // Hàm chuyển đổi trạng thái đơn hàng sang tiếng Việt
        function getStatusText($status) {
            switch($status) {
                case 'pending':
                    return 'Chờ xác nhận';
                case 'processing':
                    return 'Đang xử lý';
                case 'shipping':
                    return 'Đang giao hàng';
                case 'completed':
                    return 'Đã hoàn thành';
                case 'cancelled':
                    return 'Đã hủy';
                default:
                    return 'Không xác định';
            }
        }
        
        // Hàm lấy màu cho trạng thái
        function getStatusColor($status) {
            switch($status) {
                case 'pending':
                    return '#f39c12'; // Màu cam
                case 'processing':
                    return '#3498db'; // Màu xanh dương
                case 'shipping':
                    return '#9b59b6'; // Màu tím
                case 'completed':
                    return '#2ecc71'; // Màu xanh lá
                case 'cancelled':
                    return '#e74c3c'; // Màu đỏ
                default:
                    return '#7f8c8d'; // Màu xám
            }
        }
    ?>

<div class="content">
    <div class="filter-section">
        <div class="filter-group">
            <input type="text" class="search-box" id="searchOrder" placeholder="Tìm kiếm đơn hàng...">
            <select class="filter-select" id="statusFilter">
                <option value="">Tất cả trạng thái</option>
                <option value="pending">Chờ xác nhận</option>
                <option value="processing">Đang xử lý</option>
                <option value="shipping">Đang giao hàng</option>
                <option value="completed">Đã hoàn thành</option>
                <option value="cancelled">Đã hủy</option>
            </select>
        </div>
        <div>
            <button class="order-btn" onclick="exportOrders()">Xuất Excel</button>
        </div>
    </div>
    
    <table class="order-table">
        <thead>
            <tr>
                <th>Mã đơn</th>
                <th>Khách hàng</th>
                <th>Ngày đặt</th>
                <th>Tổng tiền</th>
                <th>Trạng thái</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            if ($result && $result->rowCount() > 0) {
                while($row = $result->fetch(PDO::FETCH_ASSOC)): 
                    $statusText = getStatusText($row['status']);
                    $statusColor = getStatusColor($row['status']);
            ?>
            <tr>
                <td>#<?php echo $row['id']; ?></td>
                <td>
                    <?php echo $row['customer_name']; ?><br>
                    <small><?php echo $row['email']; ?></small><br>
                    <small><?php echo $row['phone']; ?></small>
                </td>
                <td><?php echo date('d/m/Y H:i', strtotime($row['order_date'])); ?></td>
                <td><?php echo number_format($row['total_amount'], 0, ',', '.') . ' VNĐ'; ?></td>
                <td>
                    <span class="status-badge" style="background-color: <?php echo $statusColor; ?>">
                        <?php echo $statusText; ?>
                    </span>
                </td>
                <td class="action-buttons">
                    <button class="order-btn" onclick="viewOrderDetails(<?php echo $row['id']; ?>)">Chi tiết</button>
                    <button class="order-btn" onclick="updateOrderStatus(<?php echo $row['id']; ?>, '<?php echo $row['status']; ?>')">Cập nhật</button>
                    <button class="order-btn delete-btn" onclick="confirmDeleteOrder(<?php echo $row['id']; ?>)">Xóa</button>
                </td>
            </tr>
            <?php 
                endwhile; 
            } else {
                echo "<tr><td colspan='6' style='text-align:center'>Không có đơn hàng nào</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>  

<!-- Modal Chi tiết đơn hàng -->
<div id="orderDetailModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeOrderDetailModal()">&times;</span>
        <h2>Chi tiết đơn hàng #<span id="orderIdDetail"></span></h2>
        <div class="order-detail">
            <div class="order-info">
                <div class="order-info-group">
                    <h3>Thông tin khách hàng</h3>
                    <p><strong>Tên:</strong> <span id="customerName"></span></p>
                    <p><strong>Email:</strong> <span id="customerEmail"></span></p>
                    <p><strong>Điện thoại:</strong> <span id="customerPhone"></span></p>
                </div>
                <div class="order-info-group">
                    <h3>Thông tin đơn hàng</h3>
                    <p><strong>Ngày đặt:</strong> <span id="orderDate"></span></p>
                    <p><strong>Trạng thái:</strong> <span id="orderStatus"></span></p>
                    <p><strong>Phương thức thanh toán:</strong> <span id="paymentMethod"></span></p>
                </div>
                <div class="order-info-group">
                    <h3>Địa chỉ giao hàng</h3>
                    <p id="shippingAddress"></p>
                </div>
            </div>
            <h3>Sản phẩm đã đặt</h3>
            <table class="detail-table">
                <thead>
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                        <th>Thành tiền</th>
                    </tr>
                </thead>
                <tbody id="orderItems">
                    <!-- Dữ liệu sản phẩm sẽ được thêm vào đây bằng JavaScript -->
                </tbody>
                <tfoot>
                    <tr class="total-row">
                        <td colspan="3" style="text-align: right;">Tổng cộng:</td>
                        <td id="orderTotal"></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<!-- Modal Cập nhật trạng thái đơn hàng -->
<div id="updateStatusModal" class="modal">
    <div class="modal-content" style="max-width: 500px;">
        <span class="close" onclick="closeUpdateStatusModal()">&times;</span>
        <h2>Cập nhật trạng thái đơn hàng #<span id="orderIdUpdate"></span></h2>
        <form method="POST" id="updateStatusForm">
            <input type="hidden" name="update_status" value="1">
            <input type="hidden" name="order_id" id="updateOrderId">
            <div style="margin: 20px 0;">
                <label for="new_status" style="display: block; margin-bottom: 10px;">Chọn trạng thái mới:</label>
                <select name="new_status" id="new_status" class="filter-select" style="width: 100%;">
                    <option value="pending">Chờ xác nhận</option>
                    <option value="processing">Đang xử lý</option>
                    <option value="shipping">Đang giao hàng</option>
                    <option value="completed">Đã hoàn thành</option>
                    <option value="cancelled">Đã hủy</option>
                </select>
            </div>
            <div style="margin-top: 20px; text-align: right;">
                <button type="button" class="order-btn" onclick="closeUpdateStatusModal()">Hủy</button>
                <button type="submit" class="order-btn">Cập nhật</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Xác nhận xóa đơn hàng -->
<div id="deleteOrderModal" class="modal">
    <div class="modal-content" style="max-width: 500px;">
        <span class="close" onclick="closeDeleteOrderModal()">&times;</span>
        <h2>Xác nhận xóa đơn hàng</h2>
        <p>Bạn có chắc chắn muốn xóa đơn hàng #<span id="orderIdDelete"></span>?</p>
        <p style="color: #e74c3c;">Lưu ý: Hành động này không thể hoàn tác!</p>
        <div style="margin-top: 20px; text-align: right;">
            <form method="POST" id="deleteOrderForm">
                <input type="hidden" name="delete_order" value="1">
                <input type="hidden" name="order_id" id="deleteOrderId">
                <button type="button" class="order-btn" onclick="closeDeleteOrderModal()">Hủy</button>
                <button type="submit" class="order-btn delete-btn">Xác nhận xóa</button>
            </form>
        </div>
    </div>
</div>

<script>
    // Lấy các modal
    var orderDetailModal = document.getElementById("orderDetailModal");
    var updateStatusModal = document.getElementById("updateStatusModal");
    var deleteOrderModal = document.getElementById("deleteOrderModal");
    
    // Hàm xem chi tiết đơn hàng
    function viewOrderDetails(orderId) {
        // Trong thực tế, bạn sẽ gửi AJAX request để lấy chi tiết đơn hàng
        // Ở đây tôi sẽ mô phỏng dữ liệu
        
        // Giả lập dữ liệu đơn hàng
        var orderData = {
            id: orderId,
            customer_name: "Nguyễn Văn A",
            email: "nguyenvana@example.com",
            phone: "0987654321",
            order_date: "15/05/2023 14:30",
            status: "Đang xử lý",
            payment_method: "Thanh toán khi nhận hàng (COD)",
            shipping_address: "123 Đường ABC, Phường XYZ, Quận 1, TP. Hồ Chí Minh",
            total: "1.250.000 VNĐ",
            items: [
                { name: "Cà chua hữu cơ", price: "25.000 VNĐ", quantity: 2, subtotal: "50.000 VNĐ" },
                { name: "Bắp cải tím", price: "22.000 VNĐ", quantity: 1, subtotal: "22.000 VNĐ" },
                { name: "Cải kale", price: "45.000 VNĐ", quantity: 3, subtotal: "135.000 VNĐ" }
            ]
        };
        
        // Cập nhật thông tin đơn hàng trong modal
        document.getElementById("orderIdDetail").textContent = orderData.id;
        document.getElementById("customerName").textContent = orderData.customer_name;
        document.getElementById("customerEmail").textContent = orderData.email;
        document.getElementById("customerPhone").textContent = orderData.phone;
        document.getElementById("orderDate").textContent = orderData.order_date;
        document.getElementById("orderStatus").textContent = orderData.status;
        document.getElementById("paymentMethod").textContent = orderData.payment_method;
        document.getElementById("shippingAddress").textContent = orderData.shipping_address;
        document.getElementById("orderTotal").textContent = orderData.total;
        
        // Cập nhật danh sách sản phẩm
        var orderItemsHtml = "";
        orderData.items.forEach(function(item) {
            orderItemsHtml += `
                <tr>
                    <td>${item.name}</td>
                    <td>${item.price}</td>
                    <td>${item.quantity}</td>
                    <td>${item.subtotal}</td>
                </tr>
            `;
        });
        document.getElementById("orderItems").innerHTML = orderItemsHtml;
        
        // Hiển thị modal
        orderDetailModal.style.display = "block";
    }
    
    // Hàm đóng modal chi tiết đơn hàng
    function closeOrderDetailModal() {
        orderDetailModal.style.display = "none";
    }
    
    // Hàm cập nhật trạng thái đơn hàng
    function updateOrderStatus(orderId, currentStatus) {
        document.getElementById("orderIdUpdate").textContent = orderId;
        document.getElementById("updateOrderId").value = orderId;
        document.getElementById("new_status").value = currentStatus;
        updateStatusModal.style.display = "block";
    }
    
    // Hàm đóng modal cập nhật trạng thái
    function closeUpdateStatusModal() {
        updateStatusModal.style.display = "none";
    }
    
    // Hàm xác nhận xóa đơn hàng
    function confirmDeleteOrder(orderId) {
        document.getElementById("orderIdDelete").textContent = orderId;
        document.getElementById("deleteOrderId").value = orderId;
        deleteOrderModal.style.display = "block";
    }
    
    // Hàm đóng modal xác nhận xóa
    function closeDeleteOrderModal() {
        deleteOrderModal.style.display = "none";
    }
    
    // Hàm xuất đơn hàng ra Excel
    function exportOrders() {
        alert("Chức năng xuất Excel sẽ được triển khai sau!");
    }
    
    // Đóng modal khi nhấp vào bên ngoài modal
    window.onclick = function(event) {
        if (event.target == orderDetailModal) {
            closeOrderDetailModal();
        }
        if (event.target == updateStatusModal) {
            closeUpdateStatusModal();
        }
        if (event.target == deleteOrderModal) {
            closeDeleteOrderModal();
        }
    }
    
    // Lọc đơn hàng theo trạng thái
    document.getElementById("statusFilter").addEventListener("change", function() {
        filterOrders();
    });
    
    // Tìm kiếm đơn hàng
    document.getElementById("searchOrder").addEventListener("keyup", function() {
        filterOrders();
    });
    
    // Hàm lọc đơn hàng
    function filterOrders() {
        var statusFilter = document.getElementById("statusFilter").value.toLowerCase();
        var searchText = document.getElementById("searchOrder").value.toLowerCase();
        var rows = document.querySelectorAll(".order-table tbody tr");
        
        rows.forEach(function(row) {
            var statusCell = row.querySelector("td:nth-child(5)").textContent.toLowerCase();
            var customerCell = row.querySelector("td:nth-child(2)").textContent.toLowerCase();
            var orderIdCell = row.querySelector("td:nth-child(1)").textContent.toLowerCase();
            
            var statusMatch = statusFilter === "" || statusCell.includes(statusFilter);
            var textMatch = searchText === "" || 
                            customerCell.includes(searchText) || 
                            orderIdCell.includes(searchText);
            
            if (statusMatch && textMatch) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    }
</script>