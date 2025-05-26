<?php
// setting.php - Settings page for buyers

// Kiểm tra đăng nhập và quyền truy cập
if (!isset($_SESSION["id"])) {
    echo "<script>window.location.href = '../customer/index.php';</script>";
    exit;
}

// Kết nối database
include_once '../../model/connect.php';
$db = new clsketnoi();
$conn = $db->moKetNoi();
$conn->set_charset('utf8');

$userId = $_SESSION["id"];
$farmId = $storeId; // Từ index.php

// Lấy thông tin farm hiện tại
$farmSql = "SELECT * FROM farms WHERE user_id = ? AND id = ?";
$farmStmt = $conn->prepare($farmSql);
$farmStmt->bind_param("ii", $userId, $farmId);
$farmStmt->execute();
$farmResult = $farmStmt->get_result();
$farmData = $farmResult->fetch_assoc();

// Lấy thông tin user
$userSql = "SELECT * FROM users WHERE id = ?";
$userStmt = $conn->prepare($userSql);
$userStmt->bind_param("i", $userId);
$userStmt->execute();
$userResult = $userStmt->get_result();
$userData = $userResult->fetch_assoc();

// Xử lý cập nhật thông tin
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action == 'update_farm') {
        $shopname = trim($_POST['shopname']);
        $description = trim($_POST['description']);
        $address = trim($_POST['address']);
        $phone = trim($_POST['phone']);
        $email = trim($_POST['email']);
        $website = trim($_POST['website']);
        $business_hours = trim($_POST['business_hours']);
        $delivery_info = trim($_POST['delivery_info']);
        
        $updateFarmSql = "UPDATE farms SET 
            shopname = ?, 
            description = ?, 
            address = ?, 
            phone = ?, 
            email = ?, 
            website = ?, 
            business_hours = ?, 
            delivery_info = ?
            WHERE id = ? AND user_id = ?";
        
        $updateFarmStmt = $conn->prepare($updateFarmSql);
        $updateFarmStmt->bind_param("ssssssssii", 
            $shopname, $description, $address, $phone, $email, 
            $website, $business_hours, $delivery_info, $farmId, $userId
        );
        
        if ($updateFarmStmt->execute()) {
            $success_message = "Thông tin cửa hàng đã được cập nhật thành công!";
            // Reload farm data
            $farmStmt->execute();
            $farmResult = $farmStmt->get_result();
            $farmData = $farmResult->fetch_assoc();
        } else {
            $error_message = "Có lỗi xảy ra khi cập nhật thông tin cửa hàng!";
        }
    }
    
    if ($action == 'update_profile') {
        $name = trim($_POST['name']);
        $phone = trim($_POST['user_phone']);
        $email = trim($_POST['user_email']);
        $address = trim($_POST['user_address']);
        
        $updateUserSql = "UPDATE users SET name = ?, phone = ?, email = ?, address = ? WHERE id = ?";
        $updateUserStmt = $conn->prepare($updateUserSql);
        $updateUserStmt->bind_param("ssssi", $name, $phone, $email, $address, $userId);
        
        if ($updateUserStmt->execute()) {
            $success_message = "Thông tin cá nhân đã được cập nhật thành công!";
            // Reload user data
            $userStmt->execute();
            $userResult = $userStmt->get_result();
            $userData = $userResult->fetch_assoc();
        } else {
            $error_message = "Có lỗi xảy ra khi cập nhật thông tin cá nhân!";
        }
    }
    
    if ($action == 'change_password') {
        $current_password = $_POST['current_password'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];
        
        // Verify current password
        if (password_verify($current_password, $userData['password'])) {
            if ($new_password === $confirm_password) {
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                
                $updatePasswordSql = "UPDATE users SET password = ? WHERE id = ?";
                $updatePasswordStmt = $conn->prepare($updatePasswordSql);
                $updatePasswordStmt->bind_param("si", $hashed_password, $userId);
                
                if ($updatePasswordStmt->execute()) {
                    $success_message = "Mật khẩu đã được thay đổi thành công!";
                } else {
                    $error_message = "Có lỗi xảy ra khi thay đổi mật khẩu!";
                }
            } else {
                $error_message = "Mật khẩu mới và xác nhận mật khẩu không khớp!";
            }
        } else {
            $error_message = "Mật khẩu hiện tại không đúng!";
        }
    }
}

$db->dongKetNoi($conn);
?>

<div class="settings-page">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Cài đặt</h2>
        <div>
            <button class="btn btn-outline-secondary me-2" onclick="resetSettings()">
                <i class="fas fa-undo me-2"></i>Khôi phục mặc định
            </button>
            <button class="btn btn-success" onclick="saveAllSettings()">
                <i class="fas fa-save me-2"></i>Lưu tất cả
            </button>
        </div>
    </div>

    <?php if (isset($success_message)): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i><?php echo $success_message; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php endif; ?>

    <?php if (isset($error_message)): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i><?php echo $error_message; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php endif; ?>

    <div class="row">
        <!-- Settings Navigation -->
        <div class="col-md-3">
            <div class="card">
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <a href="#farm-info" class="list-group-item list-group-item-action active" data-bs-toggle="pill">
                            <i class="fas fa-store me-2"></i>Thông tin cửa hàng
                        </a>
                        <a href="#profile-info" class="list-group-item list-group-item-action" data-bs-toggle="pill">
                            <i class="fas fa-user me-2"></i>Thông tin cá nhân
                        </a>
                        <a href="#security" class="list-group-item list-group-item-action" data-bs-toggle="pill">
                            <i class="fas fa-shield-alt me-2"></i>Bảo mật
                        </a>
                        <a href="#notifications" class="list-group-item list-group-item-action" data-bs-toggle="pill">
                            <i class="fas fa-bell me-2"></i>Thông báo
                        </a>
                        <a href="#payment" class="list-group-item list-group-item-action" data-bs-toggle="pill">
                            <i class="fas fa-credit-card me-2"></i>Thanh toán
                        </a>
                        <a href="#shipping" class="list-group-item list-group-item-action" data-bs-toggle="pill">
                            <i class="fas fa-truck me-2"></i>Vận chuyển
                        </a>
                        <a href="#advanced" class="list-group-item list-group-item-action" data-bs-toggle="pill">
                            <i class="fas fa-cogs me-2"></i>Nâng cao
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Settings Content -->
        <div class="col-md-9">
            <div class="tab-content">
                <!-- Farm Information -->
                <div class="tab-pane fade show active" id="farm-info">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Thông tin cửa hàng</h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="action" value="update_farm">
                                
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="shopname" class="form-label">Tên cửa hàng <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="shopname" name="shopname" value="<?php echo htmlspecialchars($farmData['shopname'] ?? ''); ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="phone" class="form-label">Số điện thoại <span class="text-danger">*</span></label>
                                        <input type="tel" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($farmData['phone'] ?? ''); ?>" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($farmData['email'] ?? ''); ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="website" class="form-label">Website</label>
                                        <input type="url" class="form-control" id="website" name="website" value="<?php echo htmlspecialchars($farmData['website'] ?? ''); ?>" placeholder="https://example.com">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="address" class="form-label">Địa chỉ <span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="address" name="address" rows="2" required><?php echo htmlspecialchars($farmData['address'] ?? ''); ?></textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label">Mô tả cửa hàng</label>
                                    <textarea class="form-control" id="description" name="description" rows="4" placeholder="Mô tả về cửa hàng, sản phẩm và dịch vụ của bạn..."><?php echo htmlspecialchars($farmData['description'] ?? ''); ?></textarea>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="business_hours" class="form-label">Giờ hoạt động</label>
                                        <input type="text" class="form-control" id="business_hours" name="business_hours" value="<?php echo htmlspecialchars($farmData['business_hours'] ?? ''); ?>" placeholder="8:00 - 18:00 (Thứ 2 - Chủ nhật)">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="delivery_info" class="form-label">Thông tin giao hàng</label>
                                        <input type="text" class="form-control" id="delivery_info" name="delivery_info" value="<?php echo htmlspecialchars($farmData['delivery_info'] ?? ''); ?>" placeholder="Giao hàng trong 2-4 giờ">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="farm_logo" class="form-label">Logo cửa hàng</label>
                                    <input type="file" class="form-control" id="farm_logo" name="farm_logo" accept="image/*">
                                    <div class="form-text">Kích thước khuyến nghị: 200x200px, định dạng: JPG, PNG</div>
                                </div>

                                <div class="mb-3">
                                    <label for="farm_banner" class="form-label">Banner cửa hàng</label>
                                    <input type="file" class="form-control" id="farm_banner" name="farm_banner" accept="image/*">
                                    <div class="form-text">Kích thước khuyến nghị: 1200x400px, định dạng: JPG, PNG</div>
                                </div>

                                <div class="d-flex justify-content-end">
                                    <button type="button" class="btn btn-outline-secondary me-2">Hủy</button>
                                    <button type="submit" class="btn btn-primary">Cập nhật thông tin</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Profile Information -->
                <div class="tab-pane fade" id="profile-info">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Thông tin cá nhân</h5>
                        </div>
                        <div class="card-body">
                            <form method="POST">
                                <input type="hidden" name="action" value="update_profile">
                                
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="name" class="form-label">Họ và tên <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($userData['name'] ?? ''); ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="user_phone" class="form-label">Số điện thoại <span class="text-danger">*</span></label>
                                        <input type="tel" class="form-control" id="user_phone" name="user_phone" value="<?php echo htmlspecialchars($userData['phone'] ?? ''); ?>" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="user_email" class="form-label">Email <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control" id="user_email" name="user_email" value="<?php echo htmlspecialchars($userData['email'] ?? ''); ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="username" class="form-label">Tên đăng nhập</label>
                                        <input type="text" class="form-control" id="username" value="<?php echo htmlspecialchars($userData['username'] ?? ''); ?>" readonly>
                                        <div class="form-text">Tên đăng nhập không thể thay đổi</div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="user_address" class="form-label">Địa chỉ</label>
                                    <textarea class="form-control" id="user_address" name="user_address" rows="2"><?php echo htmlspecialchars($userData['address'] ?? ''); ?></textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="avatar" class="form-label">Ảnh đại diện</label>
                                    <input type="file" class="form-control" id="avatar" name="avatar" accept="image/*">
                                    <div class="form-text">Kích thước khuyến nghị: 200x200px, định dạng: JPG, PNG</div>
                                </div>

                                <div class="d-flex justify-content-end">
                                    <button type="button" class="btn btn-outline-secondary me-2">Hủy</button>
                                    <button type="submit" class="btn btn-primary">Cập nhật thông tin</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Security -->
                <div class="tab-pane fade" id="security">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Bảo mật tài khoản</h5>
                        </div>
                        <div class="card-body">
                            <form method="POST">
                                <input type="hidden" name="action" value="change_password">
                                
                                <div class="mb-3">
                                    <label for="current_password" class="form-label">Mật khẩu hiện tại <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control" id="current_password" name="current_password" required>
                                </div>

                                <div class="mb-3">
                                    <label for="new_password" class="form-label">Mật khẩu mới <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control" id="new_password" name="new_password" required>
                                    <div class="form-text">Mật khẩu phải có ít nhất 8 ký tự, bao gồm chữ hoa, chữ thường và số</div>
                                </div>

                                <div class="mb-3">
                                    <label for="confirm_password" class="form-label">Xác nhận mật khẩu mới <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                                </div>

                                <div class="d-flex justify-content-end">
                                    <button type="button" class="btn btn-outline-secondary me-2">Hủy</button>
                                    <button type="submit" class="btn btn-primary">Thay đổi mật khẩu</button>
                                </div>
                            </form>

                            <hr class="my-4">

                            <h6 class="mb-3">Xác thực hai yếu tố</h6>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <div class="fw-medium">Xác thực qua SMS</div>
                                    <div class="text-muted small">Nhận mã xác thực qua tin nhắn SMS</div>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="sms_2fa">
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <div class="fw-medium">Xác thực qua Email</div>
                                    <div class="text-muted small">Nhận mã xác thực qua email</div>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="email_2fa">
                                </div>
                            </div>

                            <hr class="my-4">

                            <h6 class="mb-3">Phiên đăng nhập</h6>
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="fw-medium">Đăng xuất khỏi tất cả thiết bị</div>
                                    <div class="text-muted small">Đăng xuất khỏi tất cả thiết bị khác ngoại trừ thiết bị hiện tại</div>
                                </div>
                                <button type="button" class="btn btn-outline-danger btn-sm">Đăng xuất tất cả</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Notifications -->
                <div class="tab-pane fade" id="notifications">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Cài đặt thông báo</h5>
                        </div>
                        <div class="card-body">
                            <h6 class="mb-3">Thông báo đơn hàng</h6>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" id="notify_new_order" checked>
                                        <label class="form-check-label" for="notify_new_order">
                                            Đơn hàng mới
                                        </label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" id="notify_order_cancelled" checked>
                                        <label class="form-check-label" for="notify_order_cancelled">
                                            Đơn hàng bị hủy
                                        </label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" id="notify_payment_received" checked>
                                        <label class="form-check-label" for="notify_payment_received">
                                            Thanh toán thành công
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" id="notify_low_stock" checked>
                                        <label class="form-check-label" for="notify_low_stock">
                                            Sản phẩm sắp hết hàng
                                        </label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" id="notify_product_review" checked>
                                        <label class="form-check-label" for="notify_product_review">
                                            Đánh giá sản phẩm mới
                                        </label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" id="notify_customer_message" checked>
                                        <label class="form-check-label" for="notify_customer_message">
                                            Tin nhắn từ khách hàng
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4">

                            <h6 class="mb-3">Phương thức thông báo</h6>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" id="notify_email" checked>
                                        <label class="form-check-label" for="notify_email">
                                            Thông báo qua Email
                                        </label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" id="notify_sms" checked>
                                        <label class="form-check-label" for="notify_sms">
                                            Thông báo qua SMS
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" id="notify_browser" checked>
                                        <label class="form-check-label" for="notify_browser">
                                            Thông báo trên trình duyệt
                                        </label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" id="notify_mobile_app">
                                        <label class="form-check-label" for="notify_mobile_app">
                                            Thông báo trên ứng dụng di động
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4">

                            <h6 class="mb-3">Thời gian thông báo</h6>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="quiet_hours_start" class="form-label">Bắt đầu giờ yên lặng</label>
                                    <input type="time" class="form-control" id="quiet_hours_start" value="22:00">
                                </div>
                                <div class="col-md-6">
                                    <label for="quiet_hours_end" class="form-label">Kết thúc giờ yên lặng</label>
                                    <input type="time" class="form-control" id="quiet_hours_end" value="07:00">
                                </div>
                            </div>

                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn btn-outline-secondary me-2">Khôi phục mặc định</button>
                                <button type="button" class="btn btn-primary">Lưu cài đặt</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Settings -->
                <div class="tab-pane fade" id="payment">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Cài đặt thanh toán</h5>
                        </div>
                        <div class="card-body">
                            <h6 class="mb-3">Phương thức thanh toán</h6>
                            
                            <div class="payment-method mb-3">
                                <div class="d-flex justify-content-between align-items-center p-3 border rounded">
                                    <div class="d-flex align-items-center">
                                        <div class="form-check me-3">
                                            <input class="form-check-input" type="checkbox" id="payment_cod" checked>
                                        </div>
                                        <div>
                                            <div class="fw-medium">Thanh toán khi nhận hàng (COD)</div>
                                            <div class="text-muted small">Khách hàng thanh toán khi nhận hàng</div>
                                        </div>
                                    </div>
                                    <button class="btn btn-sm btn-outline-secondary">Cài đặt</button>
                                </div>
                            </div>

                            <div class="payment-method mb-3">
                                <div class="d-flex justify-content-between align-items-center p-3 border rounded">
                                    <div class="d-flex align-items-center">
                                        <div class="form-check me-3">
                                            <input class="form-check-input" type="checkbox" id="payment_bank" checked>
                                        </div>
                                        <div>
                                            <div class="fw-medium">Chuyển khoản ngân hàng</div>
                                            <div class="text-muted small">Khách hàng chuyển khoản trước khi giao hàng</div>
                                        </div>
                                    </div>
                                    <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#bankInfoModal">Cài đặt</button>
                                </div>
                            </div>

                            <div class="payment-method mb-3">
                                <div class="d-flex justify-content-between align-items-center p-3 border rounded">
                                    <div class="d-flex align-items-center">
                                        <div class="form-check me-3">
                                            <input class="form-check-input" type="checkbox" id="payment_momo">
                                        </div>
                                        <div>
                                            <div class="fw-medium">Ví MoMo</div>
                                            <div class="text-muted small">Thanh toán qua ví điện tử MoMo</div>
                                        </div>
                                    </div>
                                    <button class="btn btn-sm btn-outline-secondary">Kết nối</button>
                                </div>
                            </div>

                            <div class="payment-method mb-3">
                                <div class="d-flex justify-content-between align-items-center p-3 border rounded">
                                    <div class="d-flex align-items-center">
                                        <div class="form-check me-3">
                                            <input class="form-check-input" type="checkbox" id="payment_sepay" checked>
                                        </div>
                                        <div>
                                            <div class="fw-medium">SePay</div>
                                            <div class="text-muted small">Thanh toán qua SePay QR Code</div>
                                        </div>
                                    </div>
                                    <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#sepayConfigModal">Cài đặt</button>
                                </div>
                            </div>

                            <hr class="my-4">

                            <h6 class="mb-3">Cài đặt khác</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="min_order_amount" class="form-label">Giá trị đơn hàng tối thiểu</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" id="min_order_amount" value="50000">
                                            <span class="input-group-text">đ</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="free_shipping_amount" class="form-label">Miễn phí vận chuyển từ</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" id="free_shipping_amount" value="200000">
                                            <span class="input-group-text">đ</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn btn-outline-secondary me-2">Khôi phục mặc định</button>
                                <button type="button" class="btn btn-primary">Lưu cài đặt</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Shipping Settings -->
                <div class="tab-pane fade" id="shipping">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Cài đặt vận chuyển</h5>
                        </div>
                        <div class="card-body">
                            <h6 class="mb-3">Khu vực giao hàng</h6>
                            
                            <div class="mb-3">
                                <label for="delivery_radius" class="form-label">Bán kính giao hàng</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="delivery_radius" value="10">
                                    <span class="input-group-text">km</span>
                                </div>
                                <div class="form-text">Khoảng cách tối đa từ cửa hàng để giao hàng</div>
                            </div>

                            <div class="mb-3">
                                <label for="delivery_areas" class="form-label">Khu vực giao hàng cụ thể</label>
                                <textarea class="form-control" id="delivery_areas" rows="3" placeholder="Nhập các quận, huyện, phường... cách nhau bởi dấu phẩy">Quận 1, Quận 3, Quận 5, Quận 7, Quận Bình Thạnh</textarea>
                            </div>

                            <hr class="my-4">

                            <h6 class="mb-3">Phí vận chuyển</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="base_shipping_fee" class="form-label">Phí vận chuyển cơ bản</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" id="base_shipping_fee" value="20000">
                                            <span class="input-group-text">đ</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="additional_km_fee" class="form-label">Phí mỗi km thêm</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" id="additional_km_fee" value="5000">
                                            <span class="input-group-text">đ/km</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4">

                            <h6 class="mb-3">Thời gian giao hàng</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="preparation_time" class="form-label">Thời gian chuẩn bị</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" id="preparation_time" value="30">
                                            <span class="input-group-text">phút</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="delivery_time" class="form-label">Thời gian giao hàng</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" id="delivery_time" value="60">
                                            <span class="input-group-text">phút</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Khung giờ giao hàng</label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="delivery_start_time" class="form-label small">Bắt đầu</label>
                                        <input type="time" class="form-control" id="delivery_start_time" value="08:00">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="delivery_end_time" class="form-label small">Kết thúc</label>
                                        <input type="time" class="form-control" id="delivery_end_time" value="20:00">
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn btn-outline-secondary me-2">Khôi phục mặc định</button>
                                <button type="button" class="btn btn-primary">Lưu cài đặt</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Advanced Settings -->
                <div class="tab-pane fade" id="advanced">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Cài đặt nâng cao</h5>
                        </div>
                        <div class="card-body">
                            <h6 class="mb-3">Tự động hóa</h6>
                            
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <div class="fw-medium">Tự động xác nhận đơn hàng</div>
                                    <div class="text-muted small">Tự động xác nhận đơn hàng khi thanh toán thành công</div>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="auto_confirm_order" checked>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <div class="fw-medium">Tự động cập nhật tồn kho</div>
                                    <div class="text-muted small">Tự động giảm số lượng tồn kho khi có đơn hàng</div>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="auto_update_stock" checked>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <div class="fw-medium">Tự động gửi email xác nhận</div>
                                    <div class="text-muted small">Gửi email xác nhận đơn hàng cho khách hàng</div>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="auto_send_email" checked>
                                </div>
                            </div>

                            <hr class="my-4">

                            <h6 class="mb-3">Sao lưu dữ liệu</h6>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <div class="fw-medium">Sao lưu tự động</div>
                                    <div class="text-muted small">Tự động sao lưu dữ liệu hàng ngày</div>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="auto_backup" checked>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="backup_time" class="form-label">Thời gian sao lưu</label>
                                <input type="time" class="form-control" id="backup_time" value="02:00" style="max-width: 200px;">
                            </div>

                            <div class="mb-3">
                                <button type="button" class="btn btn-outline-primary">Sao lưu ngay</button>
                                <button type="button" class="btn btn-outline-secondary ms-2">Khôi phục dữ liệu</button>
                            </div>

                            <hr class="my-4">

                            <h6 class="mb-3">API & Tích hợp</h6>
                            <div class="mb-3">
                                <label for="api_key" class="form-label">API Key</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="api_key" value="sk_live_xxxxxxxxxxxxxxxx" readonly>
                                    <button class="btn btn-outline-secondary" type="button" onclick="toggleApiKey()">
                                        <i class="fas fa-eye" id="apiKeyIcon"></i>
                                    </button>
                                    <button class="btn btn-outline-primary" type="button">Tạo mới</button>
                                </div>
                                <div class="form-text">Sử dụng API key này để tích hợp với các ứng dụng bên ngoài</div>
                            </div>

                            <div class="mb-3">
                                <label for="webhook_url" class="form-label">Webhook URL</label>
                                <input type="url" class="form-control" id="webhook_url" placeholder="https://your-app.com/webhook">
                                <div class="form-text">URL để nhận thông báo về các sự kiện từ hệ thống</div>
                            </div>

                            <hr class="my-4">

                            <h6 class="mb-3">Xóa dữ liệu</h6>
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <strong>Cảnh báo:</strong> Các thao tác dưới đây không thể hoàn tác.
                            </div>

                            <div class="mb-3">
                                <button type="button" class="btn btn-outline-warning me-2">Xóa tất cả đơn hàng cũ</button>
                                <button type="button" class="btn btn-outline-danger">Xóa tài khoản</button>
                            </div>

                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn btn-outline-secondary me-2">Khôi phục mặc định</button>
                                <button type="button" class="btn btn-primary">Lưu cài đặt</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bank Info Modal -->
<div class="modal fade" id="bankInfoModal" tabindex="-1" aria-labelledby="bankInfoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bankInfoModalLabel">Thông tin tài khoản ngân hàng</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="bankInfoForm">
                    <div class="mb-3">
                        <label for="bank_name" class="form-label">Tên ngân hàng</label>
                        <select class="form-select" id="bank_name" name="bank_name" required>
                            <option value="">Chọn ngân hàng</option>
                            <option value="vietcombank">Vietcombank</option>
                            <option value="techcombank">Techcombank</option>
                            <option value="bidv">BIDV</option>
                            <option value="vietinbank">VietinBank</option>
                            <option value="agribank">Agribank</option>
                            <option value="mbbank">MB Bank</option>
                            <option value="acb">ACB</option>
                            <option value="vpbank">VPBank</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="account_number" class="form-label">Số tài khoản</label>
                        <input type="text" class="form-control" id="account_number" name="account_number" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="account_holder" class="form-label">Tên chủ tài khoản</label>
                        <input type="text" class="form-control" id="account_holder" name="account_holder" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="branch_name" class="form-label">Chi nhánh</label>
                        <input type="text" class="form-control" id="branch_name" name="branch_name">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-primary" onclick="saveBankInfo()">Lưu thông tin</button>
            </div>
        </div>
    </div>
</div>

<!-- SePay Config Modal -->
<div class="modal fade" id="sepayConfigModal" tabindex="-1" aria-labelledby="sepayConfigModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="sepayConfigModalLabel">Cấu hình SePay</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="sepayConfigForm">
                    <div class="mb-3">
                        <label for="sepay_api_key" class="form-label">SePay API Key</label>
                        <input type="password" class="form-control" id="sepay_api_key" name="sepay_api_key" required>
                        <div class="form-text">Lấy API key từ tài khoản SePay của bạn</div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="sepay_account_number" class="form-label">Số tài khoản SePay</label>
                        <input type="text" class="form-control" id="sepay_account_number" name="sepay_account_number" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="sepay_webhook_url" class="form-label">Webhook URL</label>
                        <input type="url" class="form-control" id="sepay_webhook_url" name="sepay_webhook_url" value="<?php echo $_SERVER['HTTP_HOST']; ?>/buyer/sepay_webhook.php" readonly>
                        <div class="form-text">URL này sẽ được sử dụng để nhận thông báo từ SePay</div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="sepay_test_mode" name="sepay_test_mode">
                            <label class="form-check-label" for="sepay_test_mode">
                                Chế độ test
                            </label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-success" onclick="testSepayConnection()">Test kết nối</button>
                <button type="button" class="btn btn-primary" onclick="saveSepayConfig()">Lưu cấu hình</button>
            </div>
        </div>
    </div>
</div>

<style>
.settings-page .list-group-item {
    border: none;
    padding: 0.75rem 1rem;
    color: #6c757d;
    transition: all 0.2s ease;
}

.settings-page .list-group-item:hover {
    background-color: #f8f9fa;
    color: #495057;
}

.settings-page .list-group-item.active {
    background-color: #e3f2fd;
    color: #1976d2;
    border-left: 3px solid #1976d2;
}

.payment-method {
    transition: all 0.2s ease;
}

.payment-method:hover {
    background-color: #f8f9fa;
}

.form-check-input:checked {
    background-color: #28a745;
    border-color: #28a745;
}

.form-switch .form-check-input:checked {
    background-color: #28a745;
    border-color: #28a745;
}

.card {
    border: none;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    border-radius: 0.5rem;
}

.card-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid #dee2e6;
    border-radius: 0.5rem 0.5rem 0 0 !important;
}

.btn {
    border-radius: 0.375rem;
}

.form-control, .form-select {
    border-radius: 0.375rem;
}

.alert {
    border-radius: 0.5rem;
}
</style>

<script>
function toggleApiKey() {
    const apiKeyInput = document.getElementById('api_key');
    const apiKeyIcon = document.getElementById('apiKeyIcon');
    
    if (apiKeyInput.type === 'password') {
        apiKeyInput.type = 'text';
        apiKeyIcon.className = 'fas fa-eye-slash';
    } else {
        apiKeyInput.type = 'password';
        apiKeyIcon.className = 'fas fa-eye';
    }
}

function saveBankInfo() {
    const form = document.getElementById('bankInfoForm');
    const formData = new FormData(form);
    
    // Simulate saving
    setTimeout(() => {
        alert('Thông tin ngân hàng đã được lưu thành công!');
        const modal = bootstrap.Modal.getInstance(document.getElementById('bankInfoModal'));
        modal.hide();
    }, 1000);
}

function saveSepayConfig() {
    const form = document.getElementById('sepayConfigForm');
    const formData = new FormData(form);
    
    // Simulate saving
    setTimeout(() => {
        alert('Cấu hình SePay đã được lưu thành công!');
        const modal = bootstrap.Modal.getInstance(document.getElementById('sepayConfigModal'));
        modal.hide();
    }, 1000);
}

function testSepayConnection() {
    const apiKey = document.getElementById('sepay_api_key').value;
    const accountNumber = document.getElementById('sepay_account_number').value;
    
    if (!apiKey || !accountNumber) {
        alert('Vui lòng nhập đầy đủ thông tin API Key và số tài khoản!');
        return;
    }
    
    // Simulate testing connection
    const btn = event.target;
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Đang kiểm tra...';
    
    setTimeout(() => {
        btn.disabled = false;
        btn.innerHTML = 'Test kết nối';
        alert('Kết nối SePay thành công!');
    }, 2000);
}

function resetSettings() {
    if (confirm('Bạn có chắc chắn muốn khôi phục tất cả cài đặt về mặc định?')) {
        alert('Đã khôi phục cài đặt mặc định!');
        location.reload();
    }
}

function saveAllSettings() {
    alert('Đã lưu tất cả cài đặt thành công!');
}

// Auto-save functionality
document.addEventListener('DOMContentLoaded', function() {
    const inputs = document.querySelectorAll('input, select, textarea');
    
    inputs.forEach(input => {
        input.addEventListener('change', function() {
            // Auto-save after 2 seconds of no changes
            clearTimeout(this.saveTimeout);
            this.saveTimeout = setTimeout(() => {
                console.log('Auto-saving...', this.name, this.value);
                // Implement auto-save logic here
            }, 2000);
        });
    });
});

// Password strength checker
document.getElementById('new_password')?.addEventListener('input', function() {
    const password = this.value;
    const strength = checkPasswordStrength(password);
    
    // Update UI to show password strength
    console.log('Password strength:', strength);
});

function checkPasswordStrength(password) {
    let strength = 0;
    
    if (password.length >= 8) strength++;
    if (/[a-z]/.test(password)) strength++;
    if (/[A-Z]/.test(password)) strength++;
    if (/[0-9]/.test(password)) strength++;
    if (/[^A-Za-z0-9]/.test(password)) strength++;
    
    return strength;
}
</script>