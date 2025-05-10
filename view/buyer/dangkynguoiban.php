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
    <link href="../../asset/css/dangkynguoiban.css" rel="stylesheet">
    
</head>
<body>
    <div class="container">
        <div class="register-container">
            <div class="register-header">
                <h1><i class="fas fa-leaf me-2"></i>Đăng Ký Trở Thành Người Bán</h1>
                <p>Tham gia cộng đồng nông sản và tiếp cận hàng ngàn khách hàng tiềm năng</p>
            </div>
            
            <div class="row g-0">
                <div class="col-md-8">
                    <div class="register-form">
                        <form id="sellerRegistrationForm" action="process_registration.php" method="POST">
                            <div class="form-section">
                                <h4 class="form-section-title">Thông Tin Tài Khoản</h4>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="fullName" class="form-label required-field">Họ và tên</label>
                                        <input type="text" class="form-control" id="fullName" name="fullName" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="email" class="form-label required-field">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" required>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="password" class="form-label required-field">Mật khẩu</label>
                                        <div class="position-relative">
                                            <input type="password" class="form-control" id="password" name="password" required>
                                            <i class="fas fa-eye password-toggle" id="togglePassword"></i>
                                        </div>
                                        <div class="form-text">Mật khẩu phải có ít nhất 8 ký tự, bao gồm chữ hoa, chữ thường và số</div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="confirmPassword" class="form-label required-field">Xác nhận mật khẩu</label>
                                        <div class="position-relative">
                                            <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
                                            <i class="fas fa-eye password-toggle" id="toggleConfirmPassword"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-section">
                                <h4 class="form-section-title">Thông Tin Liên Hệ</h4>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="phone" class="form-label required-field">Số điện thoại</label>
                                        <input type="tel" class="form-control" id="phone" name="phone" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="alternatePhone" class="form-label">Số điện thoại khác (nếu có)</label>
                                        <input type="tel" class="form-control" id="alternatePhone" name="alternatePhone">
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="address" class="form-label required-field">Địa chỉ</label>
                                    <textarea class="form-control" id="address" name="address" rows="2" required></textarea>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="province" class="form-label required-field">Tỉnh/Thành phố</label>
                                        <select class="form-select" id="province" name="province" required>
                                            <option value="" selected disabled>Chọn tỉnh/thành phố</option>
                                            <option value="hanoi">Hà Nội</option>
                                            <option value="hcm">TP. Hồ Chí Minh</option>
                                            <option value="danang">Đà Nẵng</option>
                                            <!-- Thêm các tỉnh thành khác -->
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="district" class="form-label required-field">Quận/Huyện</label>
                                        <select class="form-select" id="district" name="district" required>
                                            <option value="" selected disabled>Chọn quận/huyện</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="ward" class="form-label required-field">Phường/Xã</label>
                                        <select class="form-select" id="ward" name="ward" required>
                                            <option value="" selected disabled>Chọn phường/xã</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-section">
                                <h4 class="form-section-title">Thông Tin Kinh Doanh</h4>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="businessName" class="form-label required-field">Tên cửa hàng/doanh nghiệp</label>
                                        <input type="text" class="form-control" id="businessName" name="businessName" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="businessType" class="form-label required-field">Loại hình kinh doanh</label>
                                        <select class="form-select" id="businessType" name="businessType" required>
                                            <option value="" selected disabled>Chọn loại hình</option>
                                            <option value="individual">Cá nhân</option>
                                            <option value="household">Hộ kinh doanh</option>
                                            <option value="company">Doanh nghiệp</option>
                                            <option value="cooperative">Hợp tác xã</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="taxCode" class="form-label">Mã số thuế (nếu có)</label>
                                        <input type="text" class="form-control" id="taxCode" name="taxCode">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="productCategory" class="form-label required-field">Danh mục sản phẩm chính</label>
                                        <select class="form-select" id="productCategory" name="productCategory" required>
                                            <option value="" selected disabled>Chọn danh mục</option>
                                            <option value="vegetables">Rau củ quả</option>
                                            <option value="fruits">Trái cây</option>
                                            <option value="rice">Gạo & ngũ cốc</option>
                                            <option value="processed">Thực phẩm chế biến</option>
                                            <option value="other">Khác</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="businessDescription" class="form-label">Mô tả về sản phẩm của bạn</label>
                                    <textarea class="form-control" id="businessDescription" name="businessDescription" rows="3"></textarea>
                                </div>
                            </div>
                            
                            <div class="terms-checkbox mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="termsCheck" name="termsCheck" required>
                                    <label class="form-check-label" for="termsCheck">
                                        Tôi đã đọc và đồng ý với <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">Điều khoản dịch vụ</a> và <a href="#" data-bs-toggle="modal" data-bs-target="#privacyModal">Chính sách bảo mật</a>
                                    </label>
                                </div>
                            </div>
                            
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">Đăng Ký</button>
                            </div>
                            
                            <div class="login-link">
                                Đã có tài khoản? <a href="login.php">Đăng nhập</a>
                            </div>
                        </form>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="register-sidebar">
                        <h4 class="mb-4">Lợi ích khi trở thành người bán</h4>
                        <ul class="benefits-list">
                            <li><i class="fas fa-check-circle"></i> Tiếp cận hàng ngàn khách hàng tiềm năng</li>
                            <li><i class="fas fa-check-circle"></i> Quản lý đơn hàng dễ dàng</li>
                            <li><i class="fas fa-check-circle"></i> Hỗ trợ vận chuyển toàn quốc</li>
                            <li><i class="fas fa-check-circle"></i> Thanh toán an toàn và nhanh chóng</li>
                            <li><i class="fas fa-check-circle"></i> Công cụ marketing hiệu quả</li>
                            <li><i class="fas fa-check-circle"></i> Hỗ trợ kỹ thuật 24/7</li>
                        </ul>
                        
                        <div class="mt-4">
                            <h5>Cần hỗ trợ?</h5>
                            <p>Liên hệ với chúng tôi qua:</p>
                            <p><i class="fas fa-phone me-2"></i> 1900 xxxx</p>
                            <p><i class="fas fa-envelope me-2"></i> hotro@nongsan.vn</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Terms Modal -->
    <div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="termsModalLabel">Điều khoản dịch vụ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Nội dung điều khoản dịch vụ -->
                    <p>Đây là nội dung điều khoản dịch vụ của sàn giao dịch nông sản...</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Privacy Modal -->
    <div class="modal fade" id="privacyModal" tabindex="-1" aria-labelledby="privacyModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="privacyModalLabel">Chính sách bảo mật</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Nội dung chính sách bảo mật -->
                    <p>Đây là nội dung chính sách bảo mật của sàn giao dịch nông sản...</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Xử lý hiển thị/ẩn mật khẩu
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
        
        document.getElementById('toggleConfirmPassword').addEventListener('click', function() {
            const confirmPasswordInput = document.getElementById('confirmPassword');
            const type = confirmPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            confirmPasswordInput.setAttribute('type', type);
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
        
        // Xử lý form submit
        document.getElementById('sellerRegistrationForm').addEventListener('submit', function(event) {
            event.preventDefault();
            
            // Kiểm tra mật khẩu
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirmPassword').value;
            
            if (password !== confirmPassword) {
                alert('Mật khẩu xác nhận không khớp!');
                return;
            }
            
            // Kiểm tra định dạng mật khẩu
            const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/;
            if (!passwordRegex.test(password)) {
                alert('Mật khẩu phải có ít nhất 8 ký tự, bao gồm chữ hoa, chữ thường và số!');
                return;
            }
            
            // Gửi form
            this.submit();
        });
        
        // Xử lý chọn tỉnh/thành phố, quận/huyện
        document.getElementById('province').addEventListener('change', function() {
            const provinceValue = this.value;
            const districtSelect = document.getElementById('district');
            
            // Xóa các option cũ
            districtSelect.innerHTML = '<option value="" selected disabled>Chọn quận/huyện</option>';
            
            // Thêm các option mới dựa trên tỉnh/thành phố đã chọn
            if (provinceValue === 'hanoi') {
                const hanoiDistricts = ['Ba Đình', 'Hoàn Kiếm', 'Hai Bà Trưng', 'Đống Đa', 'Cầu Giấy', 'Thanh Xuân'];
                hanoiDistricts.forEach(district => {
                    const option = document.createElement('option');
                    option.value = district.toLowerCase().replace(/\s/g, '');
                    option.textContent = district;
                    districtSelect.appendChild(option);
                });
            } else if (provinceValue === 'hcm') {
                const hcmDistricts = ['Quận 1', 'Quận 2', 'Quận 3', 'Quận 4', 'Quận 5', 'Quận 6'];
                hcmDistricts.forEach(district => {
                    const option = document.createElement('option');
                    option.value = district.toLowerCase().replace(/\s/g, '');
                    option.textContent = district;
                    districtSelect.appendChild(option);
                });
            }
            // Thêm các tỉnh/thành phố khác tương tự
        });
        
        document.getElementById('district').addEventListener('change', function() {
            const districtValue = this.value;
            const wardSelect = document.getElementById('ward');
            
            // Xóa các option cũ
            wardSelect.innerHTML = '<option value="" selected disabled>Chọn phường/xã</option>';
            
            // Thêm các option mới dựa trên quận/huyện đã chọn
            // Đây chỉ là ví dụ, bạn cần thay thế bằng dữ liệu thực tế
            const wards = ['Phường 1', 'Phường 2', 'Phường 3', 'Phường 4', 'Phường 5'];
            wards.forEach(ward => {
                const option = document.createElement('option');
                option.value = ward.toLowerCase().replace(/\s/g, '');
                option.textContent = ward;
                wardSelect.appendChild(option);
            });
        });
    </script>
</body>
</html>