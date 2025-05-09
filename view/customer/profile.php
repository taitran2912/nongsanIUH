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
                                    <a class="nav-link" href="profile?page=personal-info" >
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
                                        switch ($status) {
                                            case 0:
                                                $color = "bg-warning";
                                                $statusText = "Đang xử lý";
                                                break;
                                            case 1:
                                                $color = "bg-primary";
                                                $statusText = "Đang giao";
                                                break;
                                            case 2:
                                                $color = "bg-success";
                                                $statusText = "Đã giao";
                                                break;
                                            case 3:
                                                $color = "bg-danger";
                                                $statusText = "Đã hủy";
                                                break;
                                            default:
                                                $color = "bg-secondary";
                                                $statusText = "Không xác định";
                                        }

                                    
                                    echo'   <tr>
                                                <td>#'.$orderId.'</td>
                                                <td>'.$orderDate.'</td>
                                                <td>'.$totalPrice.'</td>
                                                <td><span class="badge '.$color.'">'.$statusText.'</span></td>
                                                <td><a href="#" class="btn btn-sm btn-outline-success">Chi tiết</a></td>
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

                            </div>
                            
                            <!-- Personal Info Tab -->
                            <div class="tab-pane fade" id="personal-info">
                                <div class="content-header">
                                    <h3>Thông tin cá nhân</h3>
                                </div>
                                
                                <div class="personal-info-form">
                                    <form id="" action="" method="POST">
                                        <div class="mb-3">
                                            <label for="fullname" class="form-label">Họ và tên</label>
                                            <input type="text" class="form-control" id="fullname" name="fullname" value="<?php echo $name?>">
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="email" name="email" value="<?php echo $email?>" readonly>
                                            <small class="form-text text-muted">Email không thể thay đổi</small>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="phone" class="form-label">Số điện thoại</label>
                                            <input type="tel" class="form-control" id="phone" name="phone" value="<?php echo $phone?>">
                                            
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="address" class="form-label">Địa chỉ</label>
                                            <input type="text" class="form-control" id="address"  name="address" value="<?php echo $address?>">
                                        </div>
                                        
                                        <div class="d-flex justify-content-end">
                                            <button type="button" class="btn btn-outline-secondary me-2">Hủy</button>
                                            <button type="submit" name="btnSave" class="btn btn-success">Lưu thay đổi</button>
                                        </div>
                                    </form>
                                </div>
                                <?php
                                    if (isset($_POST['btnSave'])) {
                                        $name = $_POST['fullname'];
                                        $email = $_POST['email'];
                                        $phone = $_POST['phone'];
                                        $address = $_POST['address'];
                                        
                                        if($p->updateProfile($id, $name, $email, $phone, $address)){
                                            
                                            echo "<script>alert('Cập nhật thông tin thành công!');</script>";
                                            echo "<script>window.location.href='index.php?action=profile';</script>";
                                        } else {
                                            echo "<script>alert('Cập nhật thông tin thất bại!');</script>";
                                        }
                                    }
                                ?>
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
                                            <form method="POST" action="">
                                                <select name="trang_thai_don" class="form-select w-auto">
                                                    <option value="tat_ca" selected>Tất cả đơn hàng</option>
                                                    <option value="dang_xu_ly">Đang xử lý</option>x
                                                    <option value="dang_giao">Đang giao</option>
                                                    <option value="da_giao">Đã giao</option>
                                                    <option value="da_huy">Đã hủy</option>
                                                </select>
                                                
                                            </form>
                                            <?php
                                        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                                        $trang_thai = $_POST['trang_thai_don'] ?? 'tat_ca';
                                        switch ($trang_thai) {
                                            case 'tat_ca':
                                                $s = 4;
                                                break;
                                            case 'dang_xu_ly':
                                                $s = 0;
                                                break;
                                            case 'dang_giao':
                                                $s = 1;
                                                break;
                                            case 'da_giao':
                                                $s = 2;
                                                break;
                                            case 'da_huy':
                                                $s = 3;
                                                break;
                                        }
                                        
                                        }
                                        ?>
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
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="../../asset/js/script.js"></script>
    <!-- Profile JS -->
    <script src="../../asset/js/profile.js"></script>