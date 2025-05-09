<?php
    include_once '../../controller/cProfile.php';
    $p = new cProfile();
    $result = $p->getProfile($id);
    $name = $email = $phone = $address = "";
    // Lấy dữ liệu từ bảng users
    if($result) {
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $name = $row['name'];
            $email = $row['email'];
            $phone = $row['phone'];
            $address = $row['address'];
        } else {
            echo "<script>alert('Không có dữ liệu');</script>";
        }
    } else {
        echo "<script>alert('Kết nối thất bại hoặc lỗi truy vấn');</script>";
    }
    // Lấy dữ liệu orders
    
?>
<section class="profile-section py-5">
    <div class="container">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-3 mb-4">
                <div class="profile-sidebar">
                    <div class="user-info text-center mb-4">
                        <h4 class="user-name mt-3"><?php echo $name;?></h4>
                        <p class="user-email"><?php echo $email;?></p>
                    </div>
                    
                    <div class="profile-nav">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link active" href="#dashboard" data-bs-toggle="tab">
                                    <i class="fas fa-tachometer-alt"></i> Tổng quan
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#personal-info" data-bs-toggle="tab">
                                    <i class="fas fa-user"></i> Thông tin cá nhân
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#orders" data-bs-toggle="tab">
                                    <i class="fas fa-shopping-bag"></i> Đơn hàng của tôi
                                </a>
                            </li>
                            
                            <li class="nav-item">
                                <a class="nav-link" href="#settings" data-bs-toggle="tab">
                                    <i class="fas fa-cog"></i> Cài đặt tài khoản
                                </a>
                            </li>
                            
                        </ul>
                    </div>
                </div>
            </div>
            
            <!-- Main Content -->
            <div class="col-lg-9">
                <div class="profile-content">
                    <div class="tab-content">
                        <!-- Dashboard Tab -->
                        <div class="tab-pane fade show active" id="dashboard">
                            <div class="dashboard-recent mb-4">
                                <div class="section-title">
                                    <h4>Đơn hàng gần đây</h4>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Mã đơn hàng</th>
                                                <th>Ngày đặt</th>
                                                <th>Tổng tiền</th>
                                                <th>Trạng thái</th>
                                                <th>Thao tác</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                <?php
                $rOrder = $p->getOrder($id);
                    if($rOrder) {
                        if ($rOrder->num_rows > 0) {
                            while($rowOders = $rOrder->fetch_assoc()){
                                $orderId = $rowOders['id'];
                                $orderDate = $rowOders['order_date'];
                                $totalPrice = $rowOders['total_amount'];
                                $status = $rowOders['status'];
                                // $notes = $rowOders['notes'];
                                    if($status == 0) {
                                        $color = "bg-warning";
                                        $statusText = "Đang xử lý";
                                    }elseif($status == 1) {
                                        $color = "bg-primary";
                                        $statusText = "Đang giao";
                                    }elseif($status == 2) {
                                        $color = "bg-success";
                                        $statusText = "Đã giao";
                                    }elseif($status == 3) {
                                        $color = "bg-danger";
                                        $statusText = "Đã hủy";
                                    }
                                
                                echo'   <tr>
                                            <td>#'.$orderId.'</td>
                                            <td>'.$orderDate.'</td>
                                            <td>'.$totalPrice.'</td>
                                            <td><span class="badge '.$color.'">'.$statusText.'</span></td>
                                            <td><a href="?" class="btn btn-sm btn-outline-success">Chi tiết</a></td>
                                        </tr>';
                            
                                };
                            
                        } else {
                            echo "<tr><td>Bạn chưa đặt đơn hàng nào!</td></tr>";
                        }
                    } else {
                        echo "<script>alert('Kết nối thất bại hoặc lỗi truy vấn');</script>";
                    }
                ?>
                                        
                                        </tbody>
                                    </table>
                                </div>
                                <div class="text-end">
                                    <a href="#orders" class="btn btn-link text-success" data-bs-toggle="tab">Xem tất cả đơn hàng</a>
                                </div>
                            </div>
                            
                            <!-- <div class="dashboard-recommendations">
                                <div class="section-title">
                                    <h4>Gợi ý cho bạn</h4>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <div class="product-card">
                                            <div class="product-image">
                                                <img src="https://via.placeholder.com/200x200?text=Rau+Cải" alt="Product">
                                                <div class="product-tag">-15%</div>
                                                <div class="product-actions">
                                                    <a href="#" class="action-btn"><i class="fas fa-heart"></i></a>
                                                    <a href="#" class="action-btn"><i class="fas fa-shopping-cart"></i></a>
                                                </div>
                                            </div>
                                            <div class="product-info">
                                                <h5 class="product-title">Rau cải ngọt hữu cơ</h5>
                                                <div class="product-price">
                                                    <span class="new-price">25.000₫</span>
                                                    <span class="old-price">30.000₫</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="product-card">
                                            <div class="product-image">
                                                <img src="https://via.placeholder.com/200x200?text=Cà+Chua" alt="Product">
                                                <div class="product-actions">
                                                    <a href="#" class="action-btn"><i class="fas fa-heart"></i></a>
                                                    <a href="#" class="action-btn"><i class="fas fa-shopping-cart"></i></a>
                                                </div>
                                            </div>
                                            <div class="product-info">
                                                <h5 class="product-title">Cà chua beef hữu cơ</h5>
                                                <div class="product-price">
                                                    <span class="new-price">45.000₫</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="product-card">
                                            <div class="product-image">
                                                <img src="https://via.placeholder.com/200x200?text=Táo" alt="Product">
                                                <div class="product-tag bg-success">Mới</div>
                                                <div class="product-actions">
                                                    <a href="#" class="action-btn"><i class="fas fa-heart"></i></a>
                                                    <a href="#" class="action-btn"><i class="fas fa-shopping-cart"></i></a>
                                                </div>
                                            </div>
                                            <div class="product-info">
                                                <h5 class="product-title">Táo Fuji hữu cơ</h5>
                                                <div class="product-price">
                                                    <span class="new-price">85.000₫</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                        </div>
                        
                        <!-- Personal Info Tab -->
                        <div class="tab-pane fade" id="personal-info">
                            <div class="content-header">
                                <h3>Thông tin cá nhân</h3>
                            </div>
                            
                            <div class="personal-info-form">
                                <form id="profileForm">
                                    <div class="row mb-3">
                                        <div class="col-md-6 mb-3">
                                            <label for="firstName" class="form-label">Họ</label>
                                            <input type="text" class="form-control" id="firstName" value="Nguyễn">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="lastName" class="form-label">Tên</label>
                                            <input type="text" class="form-control" id="lastName" value="Văn A">
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" value="nguyenvana@example.com" readonly>
                                        <small class="form-text text-muted">Email không thể thay đổi</small>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="phone" class="form-label">Số điện thoại</label>
                                        <input type="tel" class="form-control" id="phone" value="0912345678">
                                    </div>
                                    
                                    <div class="row mb-3">
                                        <div class="col-md-6 mb-3">
                                            <label for="birthdate" class="form-label">Ngày sinh</label>
                                            <input type="date" class="form-control" id="birthdate" value="1990-01-15">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Giới tính</label>
                                            <div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="gender" id="male" value="male" checked>
                                                    <label class="form-check-label" for="male">Nam</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="gender" id="female" value="female">
                                                    <label class="form-check-label" for="female">Nữ</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="gender" id="other" value="other">
                                                    <label class="form-check-label" for="other">Khác</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <label for="bio" class="form-label">Giới thiệu bản thân</label>
                                        <textarea class="form-control" id="bio" rows="3">Tôi là một người yêu thích sản phẩm hữu cơ và luôn tìm kiếm những thực phẩm sạch cho gia đình.</textarea>
                                    </div>
                                    
                                    <div class="d-flex justify-content-end">
                                        <button type="button" class="btn btn-outline-secondary me-2">Hủy</button>
                                        <button type="submit" class="btn btn-success">Lưu thay đổi</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        
                        <!-- Orders Tab -->
                        <div class="tab-pane fade" id="orders">
                            <div class="content-header">
                                <h3>Đơn hàng của tôi</h3>
                            </div>
                            
                            <div class="orders-filter mb-4">
                                <div class="row align-items-center">
                                    <div class="col-md-6 mb-3 mb-md-0">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Tìm kiếm đơn hàng...">
                                            <button class="btn btn-success" type="button">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-6 d-flex justify-content-md-end">
                                        <select class="form-select w-auto">
                                            <option selected>Tất cả đơn hàng</option>
                                            <option>Đang xử lý</option>
                                            <option>Đang giao</option>
                                            <option>Đã giao</option>
                                            <option>Đã hủy</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="orders-list">
                                <div class="order-item">
                                    <div class="order-header">
                                        <div class="row align-items-center">
                                            <div class="col-md-3">
                                                <span class="order-id">#NSX12345</span>
                                            </div>
                                            <div class="col-md-3">
                                                <span class="order-date">20/04/2023</span>
                                            </div>
                                            <div class="col-md-3">
                                                <span class="order-total">650.000₫</span>
                                            </div>
                                            <div class="col-md-3 text-md-end">
                                                <span class="order-status completed">Đã giao</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="order-body">
                                        <div class="order-products">
                                            <div class="order-product-item">
                                                <div class="row align-items-center">
                                                    <div class="col-md-2 col-3">
                                                        <img src="https://via.placeholder.com/80x80?text=Rau+Cải" alt="Product" class="product-image">
                                                    </div>
                                                    <div class="col-md-5 col-9">
                                                        <h5 class="product-name">Rau cải ngọt hữu cơ</h5>
                                                        <p class="product-variant">Loại: 500g</p>
                                                    </div>
                                                    <div class="col-md-2 col-4">
                                                        <span class="product-price">25.000₫</span>
                                                    </div>
                                                    <div class="col-md-1 col-3">
                                                        <span class="product-quantity">x2</span>
                                                    </div>
                                                    <div class="col-md-2 col-5">
                                                        <span class="product-total">50.000₫</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="order-product-item">
                                                <div class="row align-items-center">
                                                    <div class="col-md-2 col-3">
                                                        <img src="https://via.placeholder.com/80x80?text=Gạo" alt="Product" class="product-image">
                                                    </div>
                                                    <div class="col-md-5 col-9">
                                                        <h5 class="product-name">Gạo lứt hữu cơ</h5>
                                                        <p class="product-variant">Loại: 2kg</p>
                                                    </div>
                                                    <div class="col-md-2 col-4">
                                                        <span class="product-price">120.000₫</span>
                                                    </div>
                                                    <div class="col-md-1 col-3">
                                                        <span class="product-quantity">x5</span>
                                                    </div>
                                                    <div class="col-md-2 col-5">
                                                        <span class="product-total">600.000₫</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="order-footer">
                                        <div class="row align-items-center">
                                            <div class="col-md-6 mb-3 mb-md-0">
                                                <div class="delivery-info">
                                                    <p><strong>Địa chỉ giao hàng:</strong> 123 Đường ABC, Quận 1, TP. Hồ Chí Minh</p>
                                                    <p><strong>Phương thức thanh toán:</strong> Thanh toán khi nhận hàng (COD)</p>
                                                </div>
                                            </div>
                                            <div class="col-md-6 text-md-end">
                                                <a href="#" class="btn btn-sm btn-outline-success me-2">Chi tiết</a>
                                                <a href="#" class="btn btn-sm btn-success">Mua lại</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="order-item">
                                    <div class="order-header">
                                        <div class="row align-items-center">
                                            <div class="col-md-3">
                                                <span class="order-id">#NSX12346</span>
                                            </div>
                                            <div class="col-md-3">
                                                <span class="order-date">05/05/2023</span>
                                            </div>
                                            <div class="col-md-3">
                                                <span class="order-total">420.000₫</span>
                                            </div>
                                            <div class="col-md-3 text-md-end">
                                                <span class="order-status shipping">Đang giao</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="order-body">
                                        <div class="order-products">
                                            <div class="order-product-item">
                                                <div class="row align-items-center">
                                                    <div class="col-md-2 col-3">
                                                        <img src="https://via.placeholder.com/80x80?text=Táo" alt="Product" class="product-image">
                                                    </div>
                                                    <div class="col-md-5 col-9">
                                                        <h5 class="product-name">Táo Fuji hữu cơ</h5>
                                                        <p class="product-variant">Loại: 1kg</p>
                                                    </div>
                                                    <div class="col-md-2 col-4">
                                                        <span class="product-price">85.000₫</span>
                                                    </div>
                                                    <div class="col-md-1 col-3">
                                                        <span class="product-quantity">x3</span>
                                                    </div>
                                                    <div class="col-md-2 col-5">
                                                        <span class="product-total">255.000₫</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="order-product-item">
                                                <div class="row align-items-center">
                                                    <div class="col-md-2 col-3">
                                                        <img src="https://via.placeholder.com/80x80?text=Cà+Rốt" alt="Product" class="product-image">
                                                    </div>
                                                    <div class="col-md-5 col-9">
                                                        <h5 class="product-name">Cà rốt hữu cơ</h5>
                                                        <p class="product-variant">Loại: 500g</p>
                                                    </div>
                                                    <div class="col-md-2 col-4">
                                                        <span class="product-price">35.000₫</span>
                                                    </div>
                                                    <div class="col-md-1 col-3">
                                                        <span class="product-quantity">x3</span>
                                                    </div>
                                                    <div class="col-md-2 col-5">
                                                        <span class="product-total">105.000₫</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="order-product-item">
                                                <div class="row align-items-center">
                                                    <div class="col-md-2 col-3">
                                                        <img src="https://via.placeholder.com/80x80?text=Bơ" alt="Product" class="product-image">
                                                    </div>
                                                    <div class="col-md-5 col-9">
                                                        <h5 class="product-name">Bơ sáp Đắk Lắk</h5>
                                                        <p class="product-variant">Loại: 500g</p>
                                                    </div>
                                                    <div class="col-md-2 col-4">
                                                        <span class="product-price">60.000₫</span>
                                                    </div>
                                                    <div class="col-md-1 col-3">
                                                        <span class="product-quantity">x1</span>
                                                    </div>
                                                    <div class="col-md-2 col-5">
                                                        <span class="product-total">60.000₫</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="order-tracking mt-3">
                                            <h5 class="tracking-title">Theo dõi đơn hàng</h5>
                                            <div class="tracking-steps">
                                                <div class="step completed">
                                                    <div class="step-icon">
                                                        <i class="fas fa-check"></i>
                                                    </div>
                                                    <div class="step-content">
                                                        <h6>Đặt hàng</h6>
                                                        <p>05/05/2023 08:30</p>
                                                    </div>
                                                </div>
                                                <div class="step completed">
                                                    <div class="step-icon">
                                                        <i class="fas fa-check"></i>
                                                    </div>
                                                    <div class="step-content">
                                                        <h6>Xác nhận</h6>
                                                        <p>05/05/2023 09:15</p>
                                                    </div>
                                                </div>
                                                <div class="step completed">
                                                    <div class="step-icon">
                                                        <i class="fas fa-check"></i>
                                                    </div>
                                                    <div class="step-content">
                                                        <h6>Đóng gói</h6>
                                                        <p>05/05/2023 14:20</p>
                                                    </div>
                                                </div>
                                                <div class="step active">
                                                    <div class="step-icon">
                                                        <i class="fas fa-truck"></i>
                                                    </div>
                                                    <div class="step-content">
                                                        <h6>Đang giao</h6>
                                                        <p>06/05/2023 08:45</p>
                                                    </div>
                                                </div>
                                                <div class="step">
                                                    <div class="step-icon">
                                                        <i class="fas fa-home"></i>
                                                    </div>
                                                    <div class="step-content">
                                                        <h6>Đã giao</h6>
                                                        <p>Dự kiến: 07/05/2023</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="order-footer">
                                        <div class="row align-items-center">
                                            <div class="col-md-6 mb-3 mb-md-0">
                                                <div class="delivery-info">
                                                    <p><strong>Địa chỉ giao hàng:</strong> 456 Đường XYZ, Quận 2, TP. Hồ Chí Minh</p>
                                                    <p><strong>Phương thức thanh toán:</strong> Chuyển khoản ngân hàng</p>
                                                </div>
                                            </div>
                                            <div class="col-md-6 text-md-end">
                                                <a href="#" class="btn btn-sm btn-outline-success me-2">Chi tiết</a>
                                                <a href="#" class="btn btn-sm btn-outline-danger">Hủy đơn</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="order-item">
                                    <div class="order-header">
                                        <div class="row align-items-center">
                                            <div class="col-md-3">
                                                <span class="order-id">#NSX12347</span>
                                            </div>
                                            <div class="col-md-3">
                                                <span class="order-date">18/05/2023</span>
                                            </div>
                                            <div class="col-md-3">
                                                <span class="order-total">780.000₫</span>
                                            </div>
                                            <div class="col-md-3 text-md-end">
                                                <span class="order-status processing">Đang xử lý</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="order-body">
                                        <div class="order-products">
                                            <div class="order-product-item">
                                                <div class="row align-items-center">
                                                    <div class="col-md-2 col-3">
                                                        <img src="https://via.placeholder.com/80x80?text=Bưởi" alt="Product" class="product-image">
                                                    </div>
                                                    <div class="col-md-5 col-9">
                                                        <h5 class="product-name">Bưởi da xanh</h5>
                                                        <p class="product-variant">Loại: 1.5kg</p>
                                                    </div>
                                                    <div class="col-md-2 col-4">
                                                        <span class="product-price">75.000₫</span>
                                                    </div>
                                                    <div class="col-md-1 col-3">
                                                        <span class="product-quantity">x2</span>
                                                    </div>
                                                    <div class="col-md-2 col-5">
                                                        <span class="product-total">150.000₫</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="order-product-item">
                                                <div class="row align-items-center">
                                                    <div class="col-md-2 col-3">
                                                        <img src="https://via.placeholder.com/80x80?text=Mật+Ong" alt="Product" class="product-image">
                                                    </div>
                                                    <div class="col-md-5 col-9">
                                                        <h5 class="product-name">Mật ong rừng nguyên chất</h5>
                                                        <p class="product-variant">Loại: 500ml</p>
                                                    </div>
                                                    <div class="col-md-2 col-4">
                                                        <span class="product-price">210.000₫</span>
                                                    </div>
                                                    <div class="col-md-1 col-3">
                                                        <span class="product-quantity">x3</span>
                                                    </div>
                                                    <div class="col-md-2 col-5">
                                                        <span class="product-total">630.000₫</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="order-footer">
                                        <div class="row align-items-center">
                                            <div class="col-md-6 mb-3 mb-md-0">
                                                <div class="delivery-info">
                                                    <p><strong>Địa chỉ giao hàng:</strong> 789 Đường MNO, Quận 3, TP. Hồ Chí Minh</p>
                                                    <p><strong>Phương thức thanh toán:</strong> Ví điện tử MoMo</p>
                                                </div>
                                            </div>
                                            <div class="col-md-6 text-md-end">
                                                <a href="#" class="btn btn-sm btn-outline-success me-2">Chi tiết</a>
                                                <a href="#" class="btn btn-sm btn-outline-danger">Hủy đơn</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="pagination-wrapper mt-4">
                                <nav aria-label="Page navigation">
                                    <ul class="pagination justify-content-center">
                                        <li class="page-item disabled">
                                            <a class="page-link" href="#" tabindex="-1" aria-disabled="true">
                                                <i class="fas fa-chevron-left"></i>
                                            </a>
                                        </li>
                                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                                        <li class="page-item">
                                            <a class="page-link" href="#">
                                                <i class="fas fa-chevron-right"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                        
                        <!-- Reviews Tab -->
                        <div class="tab-pane fade" id="reviews">
                            <div class="content-header">
                                <h3>Đánh giá của tôi</h3>
                            </div>
                            
                            <div class="reviews-list">
                                <div class="review-item">
                                    <div class="review-header">
                                        <div class="row align-items-center">
                                            <div class="col-md-8">
                                                <div class="product-info d-flex align-items-center">
                                                    <img src="https://via.placeholder.com/80x80?text=Rau+Cải" alt="Product" class="product-image me-3">
                                                    <div>
                                                        <h5 class="product-name">Rau cải ngọt hữu cơ</h5>
                                                        <p class="review-date">Đánh giá vào: 22/04/2023</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 text-md-end">
                                                <div class="review-rating">
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="review-body">
                                        <p class="review-text">Rau tươi, xanh và ngọt. Giao hàng nhanh và đóng gói cẩn thận. Sẽ tiếp tục ủng hộ shop!</p>
                                        <div class="review-images">
                                            <img src="https://via.placeholder.com/100x100?text=Review1" alt="Review Image">
                                            <img src="https://via.placeholder.com/100x100?text=Review2" alt="Review Image">
                                        </div>
                                    </div>
                                    <div class="review-footer">
                                        <div class="d-flex justify-content-end">
                                            <button class="btn btn-sm btn-outline-success me-2">Chỉnh sửa</button>
                                            <button class="btn btn-sm btn-outline-danger">Xóa</button>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            
                            <div class="reviews-to-write mt-5">
                                <div class="section-title">
                                    <h4>Sản phẩm chờ đánh giá</h4>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <div class="review-pending-item">
                                            <div class="d-flex align-items-center">
                                                <img src="https://via.placeholder.com/80x80?text=Táo" alt="Product" class="product-image me-3">
                                                <div>
                                                    <h5 class="product-title">Táo Fuji hữu cơ</h5>
                                                    <p class="order-info">Đơn hàng: #NSX12346 - Ngày mua: 05/05/2023</p>
                                                </div>
                                            </div>
                                            <div class="mt-3">
                                                <button class="btn btn-sm btn-success">Viết đánh giá</button>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        
                        <!-- Settings Tab -->
                        <div class="tab-pane fade" id="settings">
                            <div class="content-header">
                                <h3>Cài đặt tài khoản</h3>
                            </div>
                            
                            <div class="settings-section">
                                <div class="section-title">
                                    <h4>Đổi mật khẩu</h4>
                                </div>
                                <form id="passwordForm" class="mb-5">
                                    <div class="mb-3">
                                        <label for="currentPassword" class="form-label">Mật khẩu hiện tại</label>
                                        <div class="password-input">
                                            <input type="password" class="form-control" id="currentPassword" required>
                                            <span class="password-toggle" onclick="togglePassword('currentPassword')">
                                                <i class="fas fa-eye"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="newPassword" class="form-label">Mật khẩu mới</label>
                                        <div class="password-input">
                                            <input type="password" class="form-control" id="newPassword" required>
                                            <span class="password-toggle" onclick="togglePassword('newPassword')">
                                                <i class="fas fa-eye"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <label for="confirmNewPassword" class="form-label">Xác nhận mật khẩu mới</label>
                                        <div class="password-input">
                                            <input type="password" class="form-control" id="confirmNewPassword" required>
                                            <span class="password-toggle" onclick="togglePassword('confirmNewPassword')">
                                                <i class="fas fa-eye"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <button type="submit" class="btn btn-success">Cập nhật mật khẩu</button>
                                    </div>
                                </form>
                                
                                <div class="section-title">
                                    <h4>Xóa tài khoản</h4>
                                </div>
                                <div class="delete-account-section">
                                    <div class="alert alert-danger">
                                        <h5 class="alert-heading">Cảnh báo!</h5>
                                        <p>Việc xóa tài khoản sẽ xóa vĩnh viễn tất cả dữ liệu của bạn, bao gồm lịch sử đơn hàng, địa chỉ và thông tin cá nhân. Hành động này không thể hoàn tác.</p>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                            <button type="button" class="btn btn-danger"> <!-- data-bs-toggle="modal" data-bs-target="#deleteAccountModal" > -->
                                            Xóa tài khoản
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



<!-- Delete Account Modal -->
<!-- <div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Xác nhận xóa tài khoản</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Bạn có chắc chắn muốn xóa tài khoản? Hành động này không thể hoàn tác và tất cả dữ liệu của bạn sẽ bị xóa vĩnh viễn.</p>
                <div class="mb-3">
                    <label for="deleteConfirm" class="form-label">Nhập "XÓA TÀI KHOẢN" để xác nhận</label>
                    <input type="text" class="form-control" id="deleteConfirm">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-danger" disabled>Xóa tài khoản</button>
            </div>
        </div>
    </div>
</div> -->

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Custom JS -->
<script src="../../asset/js/script.js"></script>
<!-- Profile JS -->
<script src="../../asset/js/profile.js"></script>