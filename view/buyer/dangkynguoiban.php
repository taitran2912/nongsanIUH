<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Ký Người Bán - Sàn Giao Dịch Nông Sản</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../../asset/css/dangkynguoiban.css">
</head>
<body>
    <div class="container">
        <div class="register-container">
            <div class="register-header text-center">
                <h1><i class="fas fa-leaf me-2"></i>Đăng Ký Trở Thành Người Bán</h1>
                <p>Tham gia cộng đồng nông sản và tiếp cận hàng ngàn khách hàng tiềm năng</p>
            </div>

            <div class="row g-0">
                <div class="col-md-8">
                    <div class="register-form">
                        <form id="sellerRegistrationForm" action="process_registration.php" method="POST">
                            <!-- Thông tin liên hệ -->
                            <div class="form-section">
                                <h4 class="form-section-title">Thông Tin Liên Hệ</h4>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="shopname" class="form-label required-field">Tên nông trại</label>
                                        <input type="shopname" class="form-control" id="shopname" name="shopname" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="phone" class="form-label">Số điện thoại</label>
                                        <input type="tel" class="form-control" id="phone" name="phone">
                                    </div>
                                 </div>
                                <div class="mb-3">
                                    <label for="decription" class="form-label required-field">Mô tả</label>
                                    <textarea class="form-control" id="decription" name="decription" rows="2" required></textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="address" class="form-label required-field">Địa chỉ</label>
                                    <textarea class="form-control" id="address" name="address" rows="2" required></textarea>
                                </div>
                            </div>

                            <!-- Checkbox điều khoản -->
                            <div class="form-check mb-4">
                                <input class="form-check-input" type="checkbox" id="termsCheck" name="termsCheck" required>
                                <label class="form-check-label" for="termsCheck">
                                    Tôi đã đọc và đồng ý với <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">Điều khoản dịch vụ</a> và <a href="#" data-bs-toggle="modal" data-bs-target="#privacyModal">Chính sách bảo mật</a>
                                </label>
                            </div>

                            <!-- Nút submit -->
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">Đăng Ký</button>
                            </div>

                            <div class="login-link">
                                Đã có tài khoản? <a href="login.php">Đăng nhập</a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-md-4">
                    <div class="register-sidebar ps-4">
                        <h4 class="mb-4">Lợi ích khi trở thành người bán</h4>
                        <ul class="benefits-list">
                            <li><i class="fas fa-check-circle text-success me-2"></i> Tiếp cận hàng ngàn khách hàng</li>
                            <li><i class="fas fa-check-circle text-success me-2"></i> Quản lý đơn hàng dễ dàng</li>
                            <li><i class="fas fa-check-circle text-success me-2"></i> Hỗ trợ vận chuyển toàn quốc</li>
                            <li><i class="fas fa-check-circle text-success me-2"></i> Thanh toán nhanh chóng</li>
                            <li><i class="fas fa-check-circle text-success me-2"></i> Công cụ marketing hiệu quả</li>
                            <li><i class="fas fa-check-circle text-success me-2"></i> Hỗ trợ kỹ thuật 24/7</li>
                        </ul>
                        <div class="mt-4">
                            <h5>Cần hỗ trợ?</h5>
                            <p><i class="fas fa-phone me-2"></i> 1900 xxxx</p>
                            <p><i class="fas fa-envelope me-2"></i> hotro@nongsan.vn</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal điều khoản -->
    <div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="termsModalLabel">Điều khoản dịch vụ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                </div>
                <div class="modal-body">
                    <p>Đây là nội dung điều khoản dịch vụ của sàn giao dịch nông sản...</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal chính sách bảo mật -->
    <div class="modal fade" id="privacyModal" tabindex="-1" aria-labelledby="privacyModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="privacyModalLabel">Chính sách bảo mật</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                </div>
                <div class="modal-body">
                    <p>Đây là nội dung chính sách bảo mật của sàn giao dịch nông sản...</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Script ẩn/hiện mật khẩu -->
    <script>
        document.getElementById('togglePassword').addEventListener('click', function () {
            const passwordInput = document.getElementById('password');
            const type = passwordInput.type === 'password' ? 'text' : 'password';
            passwordInput.type = type;
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });

        document.getElementById('toggleConfirmPassword').addEventListener('click', function () {
            const confirmPasswordInput = document.getElementById('confirmPassword');
            const type = confirmPasswordInput.type === 'password' ? 'text' : 'password';
            confirmPasswordInput.type = type;
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
    </script>
</body>
</html>
