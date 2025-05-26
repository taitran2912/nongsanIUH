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
                <div class="profile-sidebar card shadow-sm">
                    <div class="card-body">
                        <div class="user-info text-center mb-4">
                            
                            <h4 class="user-name mt-3"><?php echo $name;?></h4>
                            <p class="user-email text-muted"><?php echo $email;?></p>
                        </div>
                        
                        <div class="profile-nav">
                            <ul class="nav nav-pills flex-column" id="profileTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active w-100 text-start" id="dashboard-tab" data-bs-toggle="tab" data-bs-target="#dashboard" type="button" role="tab" aria-controls="dashboard" aria-selected="true">
                                        <i class="fas fa-tachometer-alt me-2"></i> Tổng quan
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link w-100 text-start" id="personal-info-tab" data-bs-toggle="tab" data-bs-target="#personal-info" type="button" role="tab" aria-controls="personal-info" aria-selected="false">
                                        <i class="fas fa-user me-2"></i> Thông tin cá nhân
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link w-100 text-start" id="orders-tab" data-bs-toggle="tab" data-bs-target="#orders" type="button" role="tab" aria-controls="orders" aria-selected="false">
                                        <i class="fas fa-shopping-bag me-2"></i> Đơn hàng của tôi
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link w-100 text-start" id="settings-tab" data-bs-toggle="tab" data-bs-target="#settings" type="button" role="tab" aria-controls="settings" aria-selected="false">
                                        <i class="fas fa-cog me-2"></i> Cài đặt tài khoản
                                    </button>
                                </li>
                                <!-- <li class="nav-item mt-2">
                                    <a class="nav-link text-danger w-100 text-start" href="../login/logout.php">
                                        <i class="fas fa-sign-out-alt me-2"></i> Đăng xuất
                                    </a>
                                </li> -->
                                <?php
                                    $r = $p -> getBuyer($id);
                                    if($r && $r->num_rows > 0){
                                        $row = $r->fetch_assoc();
                                        $storeId = $row['id'];
                                        $status = $row['status'];
                                        if($storeId != null && $status == 0){
                                            echo '
                                                <li class="nav-item">
                                                    <a class="nav-link w-100 text-start" href="../buyer/">
                                                        <i class="fas fa-store me-2"></i> Cửa hàng của tôi
                                                    </a>
                                                </li>
                                            ';
                                        }else if($storeId != null && $status == 1){
                                            echo '
                                                <li class="nav-item">
                                                    <a class="nav-link w-100 text-start" href="">
                                                        <i class="fas fa-store me-2"></i> Chờ duyệt cửa hàng
                                                    </a>
                                                    
                                                </li>
                                            ';
                                        }
                                    }else{
                                            echo '
                                                <li class="nav-item">
                                                    <a class="nav-link w-100 text-start" href="../buyer/dangkynguoiban.php">
                                                    <i class="fas fa-store me-2"></i>Đăng ký bán hàng
                                                    </a>
                                                </li>
                                            ';
                                        }
                                ?>
                                
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Main Content -->
            <div class="col-lg-9">
                <div class="profile-content card shadow-sm">
                    <div class="card-body">
                        <div class="tab-content" id="profileTabContent">
                            <!-- Dashboard Tab -->
                            <div class="tab-pane fade show active" id="dashboard" role="tabpanel" aria-labelledby="dashboard-tab">
                                <div class="content-header mb-4">
                                    <h3>Tổng quan tài khoản</h3>
                                </div>
                                <div class="dashboard-recent mb-4">
                                    <div class="section-title mb-3">
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
                                                        $totalPrice = number_format($rowOders['total_amount'], 0, ',', '.') . 'đ';
                                                        $status = $rowOders['status'];
                                                        // $notes = $rowOders['notes'];
                                                            switch ($status) {
                                                                case 1:
                                                                    $color = "bg-warning";
                                                                    $statusText = "Chờ xác nhận";
                                                                    
                                                                    break;
                                                                case 2:
                                                                    $color = "bg-success";
                                                                    $statusText = "Đang giao hàng";
                                                                    
                                                                    break;
                                                                case 3:
                                                                    $color = "bg-success";
                                                                    $statusText = "Đã giao";
                                                                    
                                                                    break;
                                                                case 4:
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
                                                                    <td><a href="?action=order_detail&id='.$orderId.'" class="btn btn-sm btn-outline-success">Chi tiết</a></td>
                                                                </tr>';
                                                        };
                                                } else {
                                                    echo "<tr><td colspan='5' class='text-center'>Bạn chưa đặt đơn hàng nào!</td></tr>";
                                                }
                                            } else {
                                                echo "<script>alert('Kết nối thất bại hoặc lỗi truy vấn');</script>";
                                            }
                                            ?>  
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="text-end">
                                        <button class="btn btn-link text-success" id="viewAllOrders">Xem tất cả đơn hàng</button>
                                    </div>
                                </div>
                            </div>

                            <!-- Personal Info Tab -->
                            <div class="tab-pane fade" id="personal-info" role="tabpanel" aria-labelledby="personal-info-tab">
                                <div class="content-header mb-4">
                                    <h3>Thông tin cá nhân</h3>
                                </div>
                                
                                <div class="personal-info-form">
                                    <form action="" method="POST">
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
                                            <input type="text" class="form-control" id="address" name="address" value="<?php echo $address?>">
                                        </div>
                                        
                                        <div class="d-flex justify-content-end">
                                            <button type="button" class="btn btn-outline-secondary me-2" id="cancelPersonalInfo">Hủy</button>
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
                            <div class="tab-pane fade" id="orders" role="tabpanel" aria-labelledby="orders-tab">
                                <div class="content-header mb-4">
                                    <h3>Đơn hàng của tôi</h3>
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
                                        $rOrder = $p->getOrders($id);
                                        if($rOrder) {
                                            if ($rOrder->num_rows > 0) {
                                                // Reset pointer to beginning
                                                $rOrder->data_seek(0);
                                                while($rowOders = $rOrder->fetch_assoc()){
                                                    $orderId = $rowOders['id'];
                                                    $orderDate = $rowOders['order_date'];
                                                    $totalPrice = number_format($rowOders['total_amount'], 0, ',', '.') . 'đ';
                                                    $status = $rowOders['status'];
                                                    
                                                    switch ($status) {
                                                        case 1:
                                                            $color = "bg-warning";
                                                            $statusText = "Chờ xác nhận";
                                                            $cancelBtn = '<a href="?action=cancelorder&id='.$orderId.'" class="btn btn-sm btn-outline-danger ms-2" onclick="return confirm(\'Bạn có chắc chắn muốn hủy đơn hàng này?\')">Hủy đơn</a>';
                                                            break;
                                                        case 2:
                                                            $color = "bg-success";
                                                            $statusText = "Đang giao hàng";
                                                            $cancelBtn = '';
                                                            break;
                                                        case 3:
                                                            $color = "bg-success";
                                                            $statusText = "Đã giao";
                                                            $cancelBtn = '';
                                                            break;
                                                        case 4:
                                                            $color = "bg-danger";
                                                            $statusText = "Đã hủy";
                                                            $cancelBtn = '';
                                                            break;
                                                        default:
                                                            $color = "bg-secondary";
                                                            $statusText = "Không xác định";
                                                            $cancelBtn = '';
                                                    }


                
                                                    echo '<tr>
                                                            <td>#'.$orderId.'</td>
                                                            <td>'.$orderDate.'</td>
                                                            <td>'.$totalPrice.'</td>
                                                            <td><span class="badge '.$color.'">'.$statusText.'</span></td>
                                                            <td>
                                                                <a href="?action=order_detail&id='.$orderId.'" class="btn btn-sm btn-outline-success">Chi tiết</a>
                                                                '.$cancelBtn.'
                                                            </td>
                                                        </tr>';
                                                };
                                            } else {
                                                echo "<tr><td colspan='5' class='text-center'>Bạn chưa đặt đơn hàng nào!</td></tr>";
                                            }
                                        } else {
                                            echo "<tr><td colspan='5' class='text-center'>Lỗi kết nối hoặc truy vấn!</td></tr>";
                                        }
                                        ?>  
                                        </tbody>
                                    </table>
                                </div>
                            </div>


                            <!-- Settings Tab -->
                            <div class="tab-pane fade" id="settings" role="tabpanel" aria-labelledby="settings-tab">
                                <div class="content-header mb-4">
                                    <h3>Cài đặt tài khoản</h3>
                                </div>
                                
                                <div class="settings-section">
                                    <div class="section-title mb-3">
                                        <h4>Đổi mật khẩu</h4>
                                    </div>
                                    <form id="passwordForm" method="POST" class="mb-5">
                                        <div class="mb-3">
                                            <label for="currentPassword" class="form-label">Mật khẩu hiện tại</label>
                                            <div class="input-group">
                                                <input type="password" class="form-control" id="currentPassword" name="currentPassword" required>
                                                <button class="btn btn-outline-secondary toggle-password" type="button" data-target="currentPassword">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="newPassword" class="form-label">Mật khẩu mới</label>
                                            <div class="input-group">
                                                <input type="password" class="form-control" id="newPassword" name="newPassword" required minlength="6">
                                                <button class="btn btn-outline-secondary toggle-password" type="button" data-target="newPassword">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </div>
                                            <small class="form-text text-muted">Mật khẩu phải có ít nhất 6 ký tự</small>
                                        </div>
                                        <div class="mb-4">
                                            <label for="confirmNewPassword" class="form-label">Xác nhận mật khẩu mới</label>
                                            <div class="input-group">
                                                <input type="password" class="form-control" id="confirmNewPassword" name="confirmNewPassword" required minlength="6">
                                                <button class="btn btn-outline-secondary toggle-password" type="button" data-target="confirmNewPassword">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-end">
                                            <button type="submit" name="btnChangePassword" class="btn btn-success">Cập nhật mật khẩu</button>
                                        </div>
                                    </form>
                                    
                                    <?php
                                        if (isset($_POST['btnChangePassword'])) {
                                            $currentPassword = $_POST['currentPassword'];
                                            $newPassword = $_POST['newPassword'];
                                            $confirmNewPassword = $_POST['confirmNewPassword'];
                                            
                                            if ($newPassword != $confirmNewPassword) {
                                                
                                                echo "<div class='alert alert-danger'>Mật khẩu mới và xác nhận mật khẩu không khớp!</div>";
                                            } else {
                                                // Gọi hàm đổi mật khẩu từ controller
                                                if($p->changePassword($id, $currentPassword, $newPassword)){
                                                    echo "<div class='alert alert-success'>Đổi mật khẩu thành công!</div>";
                                                    echo "<script>alert('Đổi mật khẩu thành công!');</script>";
                                                } else {
                                                    echo "<div class='alert alert-danger'>Đổi mật khẩu thất bại! Mật khẩu hiện tại không đúng.</div>";
                                                    echo "<script>alert('Đổi mật khẩu thất bại! Mật khẩu hiện tại không đúng.');</script>";
                                                }
                                            }
                                        }
                                    ?>
                                    
                                    <div class="section-title mb-3 mt-4">
                                        <h4>Xóa tài khoản</h4>
                                    </div>
                                    <div class="delete-account-section">
                                        <div class="alert alert-danger">
                                            <h5 class="alert-heading">Cảnh báo!</h5>
                                            <p>Việc xóa tài khoản sẽ xóa vĩnh viễn tất cả dữ liệu của bạn, bao gồm lịch sử đơn hàng, địa chỉ và thông tin cá nhân. Hành động này không thể hoàn tác.</p>
                                        </div>
                                        <div class="d-flex justify-content-end">
                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
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
    </div>
</section>

<!-- Delete Account Modal -->
<div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-labelledby="deleteAccountModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteAccountModalLabel">Xác nhận xóa tài khoản</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Bạn có chắc chắn muốn xóa tài khoản? Hành động này không thể hoàn tác.</p>
                <form id="deleteAccountForm" method="POST">
                    <div class="mb-3">
                        <label for="passwordConfirm" class="form-label">Nhập mật khẩu để xác nhận</label>
                        <input type="password" class="form-control" id="passwordConfirm" name="passwordConfirm" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <button type="submit" form="deleteAccountForm" name="btnDeleteAccount" class="btn btn-danger">Xóa tài khoản</button>
            </div>
        </div>
    </div>
</div>

<!-- Thêm JavaScript để xử lý các tương tác -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Xử lý nút "Xem tất cả đơn hàng"
    const viewAllOrdersBtn = document.getElementById('viewAllOrders');
    if (viewAllOrdersBtn) {
        viewAllOrdersBtn.addEventListener('click', function() {
            const ordersTab = document.getElementById('orders-tab');
            if (ordersTab) {
                ordersTab.click();
            }
        });
    }

    // Xử lý nút "Hủy" trong form thông tin cá nhân
    const cancelPersonalInfoBtn = document.getElementById('cancelPersonalInfo');
    if (cancelPersonalInfoBtn) {
        cancelPersonalInfoBtn.addEventListener('click', function() {
            const dashboardTab = document.getElementById('dashboard-tab');
            if (dashboardTab) {
                dashboardTab.click();
            }
        });
    }

    // Xử lý hiển thị/ẩn mật khẩu
    const togglePasswordBtns = document.querySelectorAll('.toggle-password');
    togglePasswordBtns.forEach(function(btn) {
        btn.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target');
            const passwordInput = document.getElementById(targetId);
            const icon = this.querySelector('i');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    });

    // Xác thực form đổi mật khẩu
    const passwordForm = document.getElementById('passwordForm');
    if (passwordForm) {
        passwordForm.addEventListener('submit', function(e) {
            const newPassword = document.getElementById('newPassword').value;
            const confirmNewPassword = document.getElementById('confirmNewPassword').value;
            
            if (newPassword !== confirmNewPassword) {
                e.preventDefault();
                alert('Mật khẩu mới và xác nhận mật khẩu không khớp!');
            }
        });
    }
});
</script>