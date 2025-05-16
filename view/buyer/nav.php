<?php
// Lấy thông tin người dùng từ session
$seller_name = isset($_SESSION['seller_name']) ? $_SESSION['seller_name'] : 'Người bán';
$seller_email = isset($_SESSION['seller_email']) ? $_SESSION['seller_email'] : 'seller@example.com';
$seller_avatar = isset($_SESSION['seller_avatar']) ? $_SESSION['seller_avatar'] : 'https://via.placeholder.com/40';

// Đếm số thông báo mới (giả lập)
$notification_count = 3;
$message_count = 2;
?>

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
    <div class="container-fluid">
        <!-- Left side content or brand can be added here if needed -->
        <div class="navbar-brand">
            <img src="../../image/logo.png" alt="Nông Sản Xanh Logo" height="30" class="d-inline-block align-text-top">
            <span class="ms-2 d-none d-md-inline">Nông Sản Xanh</span>
        </div>
        
        <!-- Spacer to push content to the right -->
        <div class="flex-grow-1"></div>
        
        <!-- Right-aligned Nav Items -->
        <div class="d-flex align-items-center">
            <!-- Notifications -->
            <div class="dropdown me-3">
                <button class="btn position-relative" type="button" id="notificationsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-bell"></i>
                    <?php if ($notification_count > 0): ?>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        <?php echo $notification_count; ?>
                        <span class="visually-hidden">thông báo mới</span>
                    </span>
                    <?php endif; ?>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="notificationsDropdown" style="min-width: 300px;">
                    <li><h6 class="dropdown-header">Thông báo mới</h6></li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center py-2" href="#">
                            <div class="flex-shrink-0">
                                <div class="bg-success-light rounded-circle p-2">
                                    <i class="fas fa-shopping-bag text-success"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <p class="mb-0 fw-semibold">Đơn hàng mới #ORD-1234</p>
                                <p class="text-muted small mb-0">30 phút trước</p>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center py-2" href="#">
                            <div class="flex-shrink-0">
                                <div class="bg-warning-light rounded-circle p-2">
                                    <i class="fas fa-star text-warning"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <p class="mb-0 fw-semibold">Đánh giá mới từ Nguyễn Văn A</p>
                                <p class="text-muted small mb-0">1 giờ trước</p>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center py-2" href="#">
                            <div class="flex-shrink-0">
                                <div class="bg-danger-light rounded-circle p-2">
                                    <i class="fas fa-exclamation-triangle text-danger"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <p class="mb-0 fw-semibold">Sản phẩm "Rau cải" sắp hết hàng</p>
                                <p class="text-muted small mb-0">2 giờ trước</p>
                            </div>
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-center" href="#">Xem tất cả thông báo</a></li>
                </ul>
            </div>

            <!-- Messages -->
            <div class="dropdown me-3">
                <button class="btn position-relative" type="button" id="messagesDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-envelope"></i>
                    <?php if ($message_count > 0): ?>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary">
                        <?php echo $message_count; ?>
                        <span class="visually-hidden">tin nhắn mới</span>
                    </span>
                    <?php endif; ?>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="messagesDropdown" style="min-width: 300px;">
                    <li><h6 class="dropdown-header">Tin nhắn mới</h6></li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center py-2" href="#">
                            <div class="flex-shrink-0">
                                <img src="https://via.placeholder.com/40" class="rounded-circle" alt="Avatar">
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <p class="mb-0 fw-semibold">Nguyễn Văn A</p>
                                <p class="text-muted small mb-0 text-truncate" style="max-width: 200px;">Tôi muốn hỏi về sản phẩm rau cải...</p>
                            </div>
                            <div class="text-muted small ms-2">5p</div>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center py-2" href="#">
                            <div class="flex-shrink-0">
                                <img src="https://via.placeholder.com/40" class="rounded-circle" alt="Avatar">
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <p class="mb-0 fw-semibold">Trần Thị B</p>
                                <p class="text-muted small mb-0 text-truncate" style="max-width: 200px;">Khi nào shop có thêm sản phẩm mới?</p>
                            </div>
                            <div class="text-muted small ms-2">30p</div>
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-center" href="#">Xem tất cả tin nhắn</a></li>
                </ul>
            </div>
            
            <!-- Logout Button -->
            <a href="../login/logout.php" class="btn btn-outline-danger">
                <i class="fas fa-sign-out-alt me-1"></i>
                <span class="d-none d-md-inline">Đăng xuất</span>
            </a>
        </div>
    </div>
</nav>