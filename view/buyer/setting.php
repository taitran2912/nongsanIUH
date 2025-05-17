<div class="settings-page">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Cài đặt tài khoản</h2>
        <div>
            <button class="btn btn-success" id="saveAllSettingsBtn">
                <i class="fas fa-save me-2"></i>Lưu tất cả thay đổi
            </button>
        </div>
    </div>

    <div class="row">
        <!-- Settings Navigation -->
        <div class="col-md-3 mb-4">
            <div class="card settings-nav">
                <div class="card-body p-0">
                    <div class="list-group list-group-flush" id="settings-tab" role="tablist">
                        <a class="list-group-item list-group-item-action active" id="account-tab" data-bs-toggle="list" href="#account" role="tab" aria-controls="account">
                            <i class="fas fa-user me-2"></i>Thông tin tài khoản
                        </a>
                        <a class="list-group-item list-group-item-action" id="store-tab" data-bs-toggle="list" href="#store" role="tab" aria-controls="store">
                            <i class="fas fa-store me-2"></i>Thông tin cửa hàng
                        </a>
                        <a class="list-group-item list-group-item-action" id="payment-tab" data-bs-toggle="list" href="#payment" role="tab" aria-controls="payment">
                            <i class="fas fa-credit-card me-2"></i>Phương thức thanh toán
                        </a>
                        <a class="list-group-item list-group-item-action" id="shipping-tab" data-bs-toggle="list" href="#shipping" role="tab" aria-controls="shipping">
                            <i class="fas fa-truck me-2"></i>Vận chuyển
                        </a>
                        <a class="list-group-item list-group-item-action" id="notification-tab" data-bs-toggle="list" href="#notification" role="tab" aria-controls="notification">
                            <i class="fas fa-bell me-2"></i>Thông báo
                        </a>
                        <a class="list-group-item list-group-item-action" id="security-tab" data-bs-toggle="list" href="#security" role="tab" aria-controls="security">
                            <i class="fas fa-shield-alt me-2"></i>Bảo mật
                        </a>
                        <a class="list-group-item list-group-item-action" id="api-tab" data-bs-toggle="list" href="#api" role="tab" aria-controls="api">
                            <i class="fas fa-plug me-2"></i>Tích hợp API
                        </a>
                        <a class="list-group-item list-group-item-action" id="tax-tab" data-bs-toggle="list" href="#tax" role="tab" aria-controls="tax">
                            <i class="fas fa-file-invoice-dollar me-2"></i>Thuế
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Settings Content -->
        <div class="col-md-9">
            <div class="tab-content" id="settings-tabContent">
                <!-- Account Settings -->
                <div class="tab-pane fade show active" id="account" role="tabpanel" aria-labelledby="account-tab">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">Thông tin cá nhân</h5>
                        </div>
                        <div class="card-body">
                            <form id="accountInfoForm">
                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <div class="text-center mb-3">
                                            <div class="avatar-upload">
                                                <div class="avatar-preview rounded-circle">
                                                    <img src="https://via.placeholder.com/150" alt="Avatar" id="avatarPreview" class="rounded-circle img-fluid">
                                                </div>
                                                <div class="avatar-edit mt-2">
                                                    <label for="avatarUpload" class="btn btn-sm btn-outline-primary">Thay đổi ảnh</label>
                                                    <input type="file" id="avatarUpload" accept="image/*" class="d-none">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label for="firstName" class="form-label">Họ</label>
                                                <input type="text" class="form-control" id="firstName" name="firstName" value="Nguyễn">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="lastName" class="form-label">Tên</label>
                                                <input type="text" class="form-control" id="lastName" name="lastName" value="Văn A">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="email" class="form-label">Email</label>
                                                <input type="email" class="form-control" id="email" name="email" value="nguyenvana@example.com">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="phone" class="form-label">Số điện thoại</label>
                                                <input type="tel" class="form-control" id="phone" name="phone" value="0912345678">
                                            </div>
                                            <div class="col-12">
                                                <label for="address" class="form-label">Địa chỉ</label>
                                                <input type="text" class="form-control" id="address" name="address" value="123 Đường ABC, Quận XYZ, TP. Hồ Chí Minh">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">Lưu thông tin</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Đổi mật khẩu</h5>
                        </div>
                        <div class="card-body">
                            <form id="changePasswordForm">
                                <div class="row g-3">
                                    <div class="col-md-12">
                                        <label for="currentPassword" class="form-label">Mật khẩu hiện tại</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" id="currentPassword" name="currentPassword">
                                            <button class="btn btn-outline-secondary toggle-password" type="button" data-target="currentPassword">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="newPassword" class="form-label">Mật khẩu mới</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" id="newPassword" name="newPassword">
                                            <button class="btn btn-outline-secondary toggle-password" type="button" data-target="newPassword">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                        <div class="password-strength mt-2">
                                            <div class="progress" style="height: 5px;">
                                                <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <small class="text-muted">Độ mạnh: <span id="passwordStrength">Yếu</span></small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="confirmPassword" class="form-label">Xác nhận mật khẩu mới</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" id="confirmPassword" name="confirmPassword">
                                            <button class="btn btn-outline-secondary toggle-password" type="button" data-target="confirmPassword">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-end mt-3">
                                    <button type="submit" class="btn btn-primary">Đổi mật khẩu</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Store Settings -->
                <div class="tab-pane fade" id="store" role="tabpanel" aria-labelledby="store-tab">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">Thông tin cửa hàng</h5>
                        </div>
                        <div class="card-body">
                            <form id="storeInfoForm">
                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <div class="text-center mb-3">
                                            <div class="store-logo-upload">
                                                <div class="store-logo-preview">
                                                    <img src="https://via.placeholder.com/150" alt="Store Logo" id="storeLogoPreview" class="img-fluid">
                                                </div>
                                                <div class="store-logo-edit mt-2">
                                                    <label for="storeLogoUpload" class="btn btn-sm btn-outline-primary">Thay đổi logo</label>
                                                    <input type="file" id="storeLogoUpload" accept="image/*" class="d-none">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="row g-3">
                                            <div class="col-md-12">
                                                <label for="storeName" class="form-label">Tên cửa hàng</label>
                                                <input type="text" class="form-control" id="storeName" name="storeName" value="Nông Sản Sạch">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="storePhone" class="form-label">Số điện thoại cửa hàng</label>
                                                <input type="tel" class="form-control" id="storePhone" name="storePhone" value="0987654321">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="storeEmail" class="form-label">Email cửa hàng</label>
                                                <input type="email" class="form-control" id="storeEmail" name="storeEmail" value="contact@nongsansach.com">
                                            </div>
                                            <div class="col-12">
                                                <label for="storeAddress" class="form-label">Địa chỉ cửa hàng</label>
                                                <input type="text" class="form-control" id="storeAddress" name="storeAddress" value="456 Đường XYZ, Quận ABC, TP. Hồ Chí Minh">
                                            </div>
                                            <div class="col-12">
                                                <label for="storeDescription" class="form-label">Mô tả cửa hàng</label>
                                                <textarea class="form-control" id="storeDescription" name="storeDescription" rows="3">Cung cấp các sản phẩm nông sản sạch, hữu cơ, đảm bảo chất lượng và an toàn cho sức khỏe người tiêu dùng.</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">Lưu thông tin</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">Thông tin kinh doanh</h5>
                        </div>
                        <div class="card-body">
                            <form id="businessInfoForm">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="businessType" class="form-label">Loại hình kinh doanh</label>
                                        <select class="form-select" id="businessType" name="businessType">
                                            <option value="individual">Cá nhân</option>
                                            <option value="company" selected>Doanh nghiệp</option>
                                            <option value="cooperative">Hợp tác xã</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="taxCode" class="form-label">Mã số thuế</label>
                                        <input type="text" class="form-control" id="taxCode" name="taxCode" value="0123456789">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="businessLicense" class="form-label">Giấy phép kinh doanh</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="businessLicense" name="businessLicense" value="GPKD-123456" readonly>
                                            <button class="btn btn-outline-secondary" type="button" id="uploadLicenseBtn">Tải lên</button>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="foodSafetyCertificate" class="form-label">Giấy chứng nhận ATTP</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="foodSafetyCertificate" name="foodSafetyCertificate" value="ATTP-789012" readonly>
                                            <button class="btn btn-outline-secondary" type="button" id="uploadCertificateBtn">Tải lên</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-end mt-3">
                                    <button type="submit" class="btn btn-primary">Lưu thông tin</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Mạng xã hội</h5>
                        </div>
                        <div class="card-body">
                            <form id="socialMediaForm">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="facebookUrl" class="form-label">Facebook</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fab fa-facebook-f"></i></span>
                                            <input type="url" class="form-control" id="facebookUrl" name="facebookUrl" value="https://facebook.com/nongsansach">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="instagramUrl" class="form-label">Instagram</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fab fa-instagram"></i></span>
                                            <input type="url" class="form-control" id="instagramUrl" name="instagramUrl" value="https://instagram.com/nongsansach">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="youtubeUrl" class="form-label">YouTube</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fab fa-youtube"></i></span>
                                            <input type="url" class="form-control" id="youtubeUrl" name="youtubeUrl" value="">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="tiktokUrl" class="form-label">TikTok</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fab fa-tiktok"></i></span>
                                            <input type="url" class="form-control" id="tiktokUrl" name="tiktokUrl" value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="text-end mt-3">
                                    <button type="submit" class="btn btn-primary">Lưu thông tin</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Payment Settings -->
                <div class="tab-pane fade" id="payment" role="tabpanel" aria-labelledby="payment-tab">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">Tài khoản ngân hàng</h5>
                        </div>
                        <div class="card-body">
                            <div class="bank-accounts mb-3">
                                <div class="bank-account-item card mb-3">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h6 class="mb-0">Tài khoản chính</h6>
                                            <div>
                                                <button type="button" class="btn btn-sm btn-outline-primary me-2 edit-bank-account" data-id="1">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-outline-danger delete-bank-account" data-id="1">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p class="mb-1"><strong>Ngân hàng:</strong> Vietcombank</p>
                                                <p class="mb-1"><strong>Chủ tài khoản:</strong> NGUYEN VAN A</p>
                                            </div>
                                            <div class="col-md-6">
                                                <p class="mb-1"><strong>Số tài khoản:</strong> 1234567890</p>
                                                <p class="mb-1"><strong>Chi nhánh:</strong> TP. Hồ Chí Minh</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="bank-account-item card">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h6 class="mb-0">Tài khoản phụ</h6>
                                            <div>
                                                <button type="button" class="btn btn-sm btn-outline-primary me-2 edit-bank-account" data-id="2">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-outline-danger delete-bank-account" data-id="2">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p class="mb-1"><strong>Ngân hàng:</strong> Techcombank</p>
                                                <p class="mb-1"><strong>Chủ tài khoản:</strong> NGUYEN VAN A</p>
                                            </div>
                                            <div class="col-md-6">
                                                <p class="mb-1"><strong>Số tài khoản:</strong> 0987654321</p>
                                                <p class="mb-1"><strong>Chi nhánh:</strong> TP. Hồ Chí Minh</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-end">
                                <button type="button" class="btn btn-success" id="addBankAccountBtn">
                                    <i class="fas fa-plus me-2"></i>Thêm tài khoản ngân hàng
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">Phương thức thanh toán</h5>
                        </div>
                        <div class="card-body">
                            <form id="paymentMethodsForm">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="codPayment" checked>
                                            <label class="form-check-label" for="codPayment">Thanh toán khi nhận hàng (COD)</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="bankTransferPayment" checked>
                                            <label class="form-check-label" for="bankTransferPayment">Chuyển khoản ngân hàng</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="momoPayment" checked>
                                            <label class="form-check-label" for="momoPayment">Ví MoMo</label>
                                        </div>
                                        <div class="ms-4 mt-2" id="momoSettings">
                                            <div class="row g-2">
                                                <div class="col-md-6">
                                                    <label for="momoPartnerCode" class="form-label">Partner Code</label>
                                                    <input type="text" class="form-control" id="momoPartnerCode" name="momoPartnerCode" value="MOMO123456">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="momoAccessKey" class="form-label">Access Key</label>
                                                    <input type="text" class="form-control" id="momoAccessKey" name="momoAccessKey" value="abcdef123456">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="zaloPayPayment">
                                            <label class="form-check-label" for="zaloPayPayment">ZaloPay</label>
                                        </div>
                                        <div class="ms-4 mt-2" id="zaloPaySettings" style="display: none;">
                                            <div class="row g-2">
                                                <div class="col-md-6">
                                                    <label for="zaloPayAppId" class="form-label">App ID</label>
                                                    <input type="text" class="form-control" id="zaloPayAppId" name="zaloPayAppId" value="">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="zaloPayKey1" class="form-label">Key 1</label>
                                                    <input type="text" class="form-control" id="zaloPayKey1" name="zaloPayKey1" value="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="vnPayPayment">
                                            <label class="form-check-label" for="vnPayPayment">VNPay</label>
                                        </div>
                                        <div class="ms-4 mt-2" id="vnPaySettings" style="display: none;">
                                            <div class="row g-2">
                                                <div class="col-md-6">
                                                    <label for="vnPayMerchantId" class="form-label">Merchant ID</label>
                                                    <input type="text" class="form-control" id="vnPayMerchantId" name="vnPayMerchantId" value="">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="vnPaySecretKey" class="form-label">Secret Key</label>
                                                    <input type="text" class="form-control" id="vnPaySecretKey" name="vnPaySecretKey" value="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-end mt-3">
                                    <button type="submit" class="btn btn-primary">Lưu thông tin</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Cài đặt thanh toán</h5>
                        </div>
                        <div class="card-body">
                            <form id="paymentSettingsForm">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="currency" class="form-label">Đơn vị tiền tệ</label>
                                        <select class="form-select" id="currency" name="currency">
                                            <option value="VND" selected>Việt Nam Đồng (VND)</option>
                                            <option value="USD">US Dollar (USD)</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="orderPrefix" class="form-label">Tiền tố mã đơn hàng</label>
                                        <input type="text" class="form-control" id="orderPrefix" name="orderPrefix" value="NSS">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="invoicePrefix" class="form-label">Tiền tố mã hóa đơn</label>
                                        <input type="text" class="form-control" id="invoicePrefix" name="invoicePrefix" value="INV">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="paymentTerm" class="form-label">Thời hạn thanh toán</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" id="paymentTerm" name="paymentTerm" value="24">
                                            <span class="input-group-text">giờ</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-end mt-3">
                                    <button type="submit" class="btn btn-primary">Lưu thông tin</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Shipping Settings -->
                <div class="tab-pane fade" id="shipping" role="tabpanel" aria-labelledby="shipping-tab">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">Phương thức vận chuyển</h5>
                        </div>
                        <div class="card-body">
                            <form id="shippingMethodsForm">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="selfDelivery" checked>
                                            <label class="form-check-label" for="selfDelivery">Tự vận chuyển</label>
                                        </div>
                                        <div class="ms-4 mt-2" id="selfDeliverySettings">
                                            <div class="row g-2">
                                                <div class="col-md-6">
                                                    <label for="selfDeliveryRadius" class="form-label">Bán kính giao hàng (km)</label>
                                                    <input type="number" class="form-control" id="selfDeliveryRadius" name="selfDeliveryRadius" value="10">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="selfDeliveryFee" class="form-label">Phí vận chuyển (VNĐ/km)</label>
                                                    <input type="number" class="form-control" id="selfDeliveryFee" name="selfDeliveryFee" value="5000">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="ghnDelivery" checked>
                                            <label class="form-check-label" for="ghnDelivery">Giao Hàng Nhanh (GHN)</label>
                                        </div>
                                        <div class="ms-4 mt-2" id="ghnDeliverySettings">
                                            <div class="row g-2">
                                                <div class="col-md-6">
                                                    <label for="ghnApiKey" class="form-label">API Key</label>
                                                    <input type="text" class="form-control" id="ghnApiKey" name="ghnApiKey" value="ghn123456789">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="ghnShopId" class="form-label">Shop ID</label>
                                                    <input type="text" class="form-control" id="ghnShopId" name="ghnShopId" value="123456">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="ghtk">
                                            <label class="form-check-label" for="ghtk">Giao Hàng Tiết Kiệm (GHTK)</label>
                                        </div>
                                        <div class="ms-4 mt-2" id="ghtkSettings" style="display: none;">
                                            <div class="row g-2">
                                                <div class="col-md-6">
                                                    <label for="ghtkApiKey" class="form-label">API Key</label>
                                                    <input type="text" class="form-control" id="ghtkApiKey" name="ghtkApiKey" value="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="vnpost">
                                            <label class="form-check-label" for="vnpost">VNPost</label>
                                        </div>
                                        <div class="ms-4 mt-2" id="vnpostSettings" style="display: none;">
                                            <div class="row g-2">
                                                <div class="col-md-6">
                                                    <label for="vnpostApiKey" class="form-label">API Key</label>
                                                    <input type="text" class="form-control" id="vnpostApiKey" name="vnpostApiKey" value="">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="vnpostToken" class="form-label">Token</label>
                                                    <input type="text" class="form-control" id="vnpostToken" name="vnpostToken" value="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-end mt-3">
                                    <button type="submit" class="btn btn-primary">Lưu thông tin</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">Kho hàng</h5>
                        </div>
                        <div class="card-body">
                            <div class="warehouses mb-3">
                                <div class="warehouse-item card mb-3">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h6 class="mb-0">Kho chính</h6>
                                            <div>
                                                <button type="button" class="btn btn-sm btn-outline-primary me-2 edit-warehouse" data-id="1">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-outline-danger delete-warehouse" data-id="1">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p class="mb-1"><strong>Tên kho:</strong> Kho Trung Tâm</p>
                                                <p class="mb-1"><strong>Số điện thoại:</strong> 0987654321</p>
                                            </div>
                                            <div class="col-md-6">
                                                <p class="mb-1"><strong>Địa chỉ:</strong> 456 Đường XYZ, Quận ABC, TP. Hồ Chí Minh</p>
                                                <p class="mb-1"><strong>Trạng thái:</strong> <span class="badge bg-success">Hoạt động</span></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-end">
                                <button type="button" class="btn btn-success" id="addWarehouseBtn">
                                    <i class="fas fa-plus me-2"></i>Thêm kho hàng
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Cài đặt vận chuyển</h5>
                        </div>
                        <div class="card-body">
                            <form id="shippingSettingsForm">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="freeShippingThreshold" class="form-label">Ngưỡng miễn phí vận chuyển</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" id="freeShippingThreshold" name="freeShippingThreshold" value="300000">
                                            <span class="input-group-text">VNĐ</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="defaultShippingFee" class="form-label">Phí vận chuyển mặc định</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" id="defaultShippingFee" name="defaultShippingFee" value="30000">
                                            <span class="input-group-text">VNĐ</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="estimatedDeliveryTime" class="form-label">Thời gian giao hàng dự kiến</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" id="estimatedDeliveryTime" name="estimatedDeliveryTime" value="3">
                                            <span class="input-group-text">ngày</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="maxDeliveryDistance" class="form-label">Khoảng cách giao hàng tối đa</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" id="maxDeliveryDistance" name="maxDeliveryDistance" value="50">
                                            <span class="input-group-text">km</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-end mt-3">
                                    <button type="submit" class="btn btn-primary">Lưu thông tin</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Notification Settings -->
                <div class="tab-pane fade" id="notification" role="tabpanel" aria-labelledby="notification-tab">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">Thông báo đơn hàng</h5>
                        </div>
                        <div class="card-body">
                            <form id="orderNotificationForm">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="newOrderNotification" checked>
                                            <label class="form-check-label" for="newOrderNotification">Thông báo khi có đơn hàng mới</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="orderStatusChangeNotification" checked>
                                            <label class="form-check-label" for="orderStatusChangeNotification">Thông báo khi trạng thái đơn hàng thay đổi</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="orderCancelNotification" checked>
                                            <label class="form-check-label" for="orderCancelNotification">Thông báo khi đơn hàng bị hủy</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="orderReturnNotification" checked>
                                            <label class="form-check-label" for="orderReturnNotification">Thông báo khi có yêu cầu trả hàng/hoàn tiền</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-end mt-3">
                                    <button type="submit" class="btn btn-primary">Lưu thông tin</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">Thông báo sản phẩm</h5>
                        </div>
                        <div class="card-body">
                            <form id="productNotificationForm">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="lowStockNotification" checked>
                                            <label class="form-check-label" for="lowStockNotification">Thông báo khi sản phẩm sắp hết hàng</label>
                                        </div>
                                        <div class="ms-4 mt-2">
                                            <div class="row g-2">
                                                <div class="col-md-6">
                                                    <label for="lowStockThreshold" class="form-label">Ngưỡng cảnh báo</label>
                                                    <input type="number" class="form-control" id="lowStockThreshold" name="lowStockThreshold" value="10">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="outOfStockNotification" checked>
                                            <label class="form-check-label" for="outOfStockNotification">Thông báo khi sản phẩm hết hàng</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="productReviewNotification" checked>
                                            <label class="form-check-label" for="productReviewNotification">Thông báo khi có đánh giá sản phẩm mới</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="productExpiryNotification" checked>
                                            <label class="form-check-label" for="productExpiryNotification">Thông báo khi sản phẩm sắp hết hạn</label>
                                        </div>
                                        <div class="ms-4 mt-2">
                                            <div class="row g-2">
                                                <div class="col-md-6">
                                                    <label for="expiryNotificationDays" class="form-label">Số ngày trước khi hết hạn</label>
                                                    <input type="number" class="form-control" id="expiryNotificationDays" name="expiryNotificationDays" value="30">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-end mt-3">
                                    <button type="submit" class="btn btn-primary">Lưu thông tin</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Phương thức nhận thông báo</h5>
                        </div>
                        <div class="card-body">
                            <form id="notificationMethodsForm">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="emailNotification" checked>
                                            <label class="form-check-label" for="emailNotification">Email</label>
                                        </div>
                                        <div class="ms-4 mt-2">
                                            <div class="row g-2">
                                                <div class="col-md-6">
                                                    <label for="notificationEmail" class="form-label">Email nhận thông báo</label>
                                                    <input type="email" class="form-control" id="notificationEmail" name="notificationEmail" value="nguyenvana@example.com">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="smsNotification" checked>
                                            <label class="form-check-label" for="smsNotification">SMS</label>
                                        </div>
                                        <div class="ms-4 mt-2">
                                            <div class="row g-2">
                                                <div class="col-md-6">
                                                    <label for="notificationPhone" class="form-label">Số điện thoại nhận thông báo</label>
                                                    <input type="tel" class="form-control" id="notificationPhone" name="notificationPhone" value="0912345678">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="pushNotification" checked>
                                            <label class="form-check-label" for="pushNotification">Thông báo đẩy</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="telegramNotification">
                                            <label class="form-check-label" for="telegramNotification">Telegram</label>
                                        </div>
                                        <div class="ms-4 mt-2" id="telegramSettings" style="display: none;">
                                            <div class="row g-2">
                                                <div class="col-md-6">
                                                    <label for="telegramChatId" class="form-label">Chat ID</label>
                                                    <input type="text" class="form-control" id="telegramChatId" name="telegramChatId" value="">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="telegramBotToken" class="form-label">Bot Token</label>
                                                    <input type="text" class="form-control" id="telegramBotToken" name="telegramBotToken" value="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-end mt-3">
                                    <button type="submit" class="btn btn-primary">Lưu thông tin</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Security Settings -->
                <div class="tab-pane fade" id="security" role="tabpanel" aria-labelledby="security-tab">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">Xác thực hai yếu tố</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <h6 class="mb-1">Xác thực hai yếu tố (2FA)</h6>
                                    <p class="text-muted mb-0">Bảo vệ tài khoản của bạn bằng cách yêu cầu xác thực thêm khi đăng nhập.</p>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="enable2FA">
                                </div>
                            </div>
                            <div id="setup2FA" style="display: none;">
                                <hr>
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6>Quét mã QR</h6>
                                        <p class="text-muted">Sử dụng ứng dụng xác thực như Google Authenticator, Authy hoặc Microsoft Authenticator để quét mã QR.</p>
                                        <div class="qr-code-container text-center p-3 bg-light rounded mb-3">
                                            <img src="https://via.placeholder.com/150" alt="QR Code" class="img-fluid">
                                        </div>
                                        <p class="text-muted small">Hoặc nhập mã này vào ứng dụng xác thực của bạn: <strong>ABCD EFGH IJKL MNOP</strong></p>
                                    </div>
                                    <div class="col-md-6">
                                        <h6>Xác nhận thiết lập</h6>
                                        <p class="text-muted">Nhập mã xác thực từ ứng dụng của bạn để hoàn tất thiết lập.</p>
                                        <form id="verify2FAForm">
                                            <div class="mb-3">
                                                <label for="verificationCode" class="form-label">Mã xác thực</label>
                                                <input type="text" class="form-control" id="verificationCode" name="verificationCode" placeholder="Nhập mã 6 chữ số">
                                            </div>
                                            <button type="submit" class="btn btn-primary">Xác nhận</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">Lịch sử đăng nhập</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Thời gian</th>
                                            <th>Thiết bị</th>
                                            <th>Địa chỉ IP</th>
                                            <th>Vị trí</th>
                                            <th>Trạng thái</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>15/05/2023 10:30 AM</td>
                                            <td>Chrome trên Windows</td>
                                            <td>192.168.1.1</td>
                                            <td>TP. Hồ Chí Minh, Việt Nam</td>
                                            <td><span class="badge bg-success">Thành công</span></td>
                                        </tr>
                                        <tr>
                                            <td>14/05/2023 08:45 AM</td>
                                            <td>Safari trên iPhone</td>
                                            <td>192.168.1.2</td>
                                            <td>TP. Hồ Chí Minh, Việt Nam</td>
                                            <td><span class="badge bg-success">Thành công</span></td>
                                        </tr>
                                        <tr>
                                            <td>13/05/2023 14:20 PM</td>
                                            <td>Firefox trên Windows</td>
                                            <td>192.168.1.3</td>
                                            <td>TP. Hồ Chí Minh, Việt Nam</td>
                                            <td><span class="badge bg-danger">Thất bại</span></td>
                                        </tr>
                                        <tr>
                                            <td>12/05/2023 09:15 AM</td>
                                            <td>Chrome trên Windows</td>
                                            <td>192.168.1.1</td>
                                            <td>TP. Hồ Chí Minh, Việt Nam</td>
                                            <td><span class="badge bg-success">Thành công</span></td>
                                        </tr>
                                        <tr>
                                            <td>11/05/2023 16:40 PM</td>
                                            <td>Chrome trên Android</td>
                                            <td>192.168.1.4</td>
                                            <td>TP. Hồ Chí Minh, Việt Nam</td>
                                            <td><span class="badge bg-success">Thành công</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Thiết bị đã đăng nhập</h5>
                        </div>
                        <div class="card-body">
                            <div class="device-list">
                                <div class="device-item d-flex justify-content-between align-items-center mb-3 p-3 border rounded">
                                    <div class="d-flex align-items-center">
                                        <div class="device-icon me-3">
                                            <i class="fas fa-laptop fa-2x text-primary"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-1">Windows PC (Chrome)</h6>
                                            <p class="text-muted mb-0 small">TP. Hồ Chí Minh, Việt Nam • Hoạt động gần đây: 15/05/2023 10:30 AM</p>
                                        </div>
                                    </div>
                                    <div>
                                        <span class="badge bg-success me-2">Hiện tại</span>
                                        <button class="btn btn-sm btn-outline-danger">Đăng xuất</button>
                                    </div>
                                </div>
                                <div class="device-item d-flex justify-content-between align-items-center mb-3 p-3 border rounded">
                                    <div class="d-flex align-items-center">
                                        <div class="device-icon me-3">
                                            <i class="fas fa-mobile-alt fa-2x text-primary"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-1">iPhone (Safari)</h6>
                                            <p class="text-muted mb-0 small">TP. Hồ Chí Minh, Việt Nam • Hoạt động gần đây: 14/05/2023 08:45 AM</p>
                                        </div>
                                    </div>
                                    <div>
                                        <button class="btn btn-sm btn-outline-danger">Đăng xuất</button>
                                    </div>
                                </div>
                                <div class="device-item d-flex justify-content-between align-items-center p-3 border rounded">
                                    <div class="d-flex align-items-center">
                                        <div class="device-icon me-3">
                                            <i class="fas fa-tablet-alt fa-2x text-primary"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-1">Android (Chrome)</h6>
                                            <p class="text-muted mb-0 small">TP. Hồ Chí Minh, Việt Nam • Hoạt động gần đây: 11/05/2023 16:40 PM</p>
                                        </div>
                                    </div>
                                    <div>
                                        <button class="btn btn-sm btn-outline-danger">Đăng xuất</button>
                                    </div>
                                </div>
                            </div>
                            <div class="text-end mt-3">
                                <button type="button" class="btn btn-danger" id="logoutAllDevicesBtn">Đăng xuất tất cả thiết bị khác</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- API Integration Settings -->
                <div class="tab-pane fade" id="api" role="tabpanel" aria-labelledby="api-tab">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">API Keys</h5>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <strong>Lưu ý:</strong> Không chia sẻ API key của bạn với bất kỳ ai. API key có quyền truy cập vào dữ liệu cửa hàng của bạn.
                            </div>
                            <div class="api-keys mb-3">
                                <div class="api-key-item card mb-3">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h6 class="mb-0">API Key chính</h6>
                                            <div>
                                                <button type="button" class="btn btn-sm btn-outline-secondary me-2 regenerate-api-key" data-id="1">
                                                    <i class="fas fa-sync-alt me-1"></i>Tạo lại
                                                </button>
                                                <button type="button" class="btn btn-sm btn-outline-danger revoke-api-key" data-id="1">
                                                    <i class="fas fa-ban me-1"></i  data-id="1">
                                                    <i class="fas fa-ban me-1"></i>Thu hồi
                                                </button>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p class="mb-1"><strong>Tên:</strong> API Key Chính</p>
                                                <p class="mb-1"><strong>Ngày tạo:</strong> 01/05/2023</p>
                                            </div>
                                            <div class="col-md-6">
                                                <p class="mb-1"><strong>Key:</strong> 
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" value="sk_live_abcdef123456789" readonly>
                                                        <button class="btn btn-outline-secondary copy-api-key" type="button">
                                                            <i class="fas fa-copy"></i>
                                                        </button>
                                                    </div>
                                                </p>
                                                <p class="mb-1"><strong>Trạng thái:</strong> <span class="badge bg-success">Hoạt động</span></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="api-key-item card">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h6 class="mb-0">API Key phụ</h6>
                                            <div>
                                                <button type="button" class="btn btn-sm btn-outline-secondary me-2 regenerate-api-key" data-id="2">
                                                    <i class="fas fa-sync-alt me-1"></i>Tạo lại
                                                </button>
                                                <button type="button" class="btn btn-sm btn-outline-danger revoke-api-key" data-id="2">
                                                    <i class="fas fa-ban me-1"></i>Thu hồi
                                                </button>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p class="mb-1"><strong>Tên:</strong> API Key Phụ</p>
                                                <p class="mb-1"><strong>Ngày tạo:</strong> 10/05/2023</p>
                                            </div>
                                            <div class="col-md-6">
                                                <p class="mb-1"><strong>Key:</strong> 
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" value="sk_live_xyz987654321" readonly>
                                                        <button class="btn btn-outline-secondary copy-api-key" type="button">
                                                            <i class="fas fa-copy"></i>
                                                        </button>
                                                    </div>
                                                </p>
                                                <p class="mb-1"><strong>Trạng thái:</strong> <span class="badge bg-success">Hoạt động</span></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-end">
                                <button type="button" class="btn btn-success" id="createApiKeyBtn">
                                    <i class="fas fa-plus me-2"></i>Tạo API Key mới
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">Webhooks</h5>
                        </div>
                        <div class="card-body">
                            <div class="webhooks mb-3">
                                <div class="webhook-item card mb-3">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h6 class="mb-0">Webhook đơn hàng</h6>
                                            <div>
                                                <button type="button" class="btn btn-sm btn-outline-primary me-2 edit-webhook" data-id="1">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-outline-danger delete-webhook" data-id="1">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p class="mb-1"><strong>URL:</strong> https://example.com/webhook/orders</p>
                                                <p class="mb-1"><strong>Sự kiện:</strong> Đơn hàng mới, Cập nhật đơn hàng</p>
                                            </div>
                                            <div class="col-md-6">
                                                <p class="mb-1"><strong>Secret:</strong> whsec_abcdef123456</p>
                                                <p class="mb-1"><strong>Trạng thái:</strong> <span class="badge bg-success">Hoạt động</span></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-end">
                                <button type="button" class="btn btn-success" id="createWebhookBtn">
                                    <i class="fas fa-plus me-2"></i>Tạo Webhook mới
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Tích hợp bên thứ ba</h5>
                        </div>
                        <div class="card-body">
                            <div class="third-party-integrations">
                                <div class="integration-item d-flex justify-content-between align-items-center mb-3 p-3 border rounded">
                                    <div class="d-flex align-items-center">
                                        <div class="integration-icon me-3">
                                            <i class="fab fa-facebook fa-2x text-primary"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-1">Facebook</h6>
                                            <p class="text-muted mb-0 small">Kết nối cửa hàng với Facebook Shop</p>
                                        </div>
                                    </div>
                                    <div>
                                        <button class="btn btn-sm btn-primary">Kết nối</button>
                                    </div>
                                </div>
                                <div class="integration-item d-flex justify-content-between align-items-center mb-3 p-3 border rounded">
                                    <div class="d-flex align-items-center">
                                        <div class="integration-icon me-3">
                                            <i class="fab fa-google fa-2x text-danger"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-1">Google Analytics</h6>
                                            <p class="text-muted mb-0 small">Theo dõi lưu lượng và chuyển đổi</p>
                                        </div>
                                    </div>
                                    <div>
                                        <span class="badge bg-success me-2">Đã kết nối</span>
                                        <button class="btn btn-sm btn-outline-danger">Ngắt kết nối</button>
                                    </div>
                                </div>
                                <div class="integration-item d-flex justify-content-between align-items-center mb-3 p-3 border rounded">
                                    <div class="d-flex align-items-center">
                                        <div class="integration-icon me-3">
                                            <i class="fab fa-mailchimp fa-2x text-warning"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-1">Mailchimp</h6>
                                            <p class="text-muted mb-0 small">Email marketing và tự động hóa</p>
                                        </div>
                                    </div>
                                    <div>
                                        <button class="btn btn-sm btn-primary">Kết nối</button>
                                    </div>
                                </div>
                                <div class="integration-item d-flex justify-content-between align-items-center p-3 border rounded">
                                    <div class="d-flex align-items-center">
                                        <div class="integration-icon me-3">
                                            <i class="fab fa-slack fa-2x text-info"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-1">Slack</h6>
                                            <p class="text-muted mb-0 small">Thông báo và cập nhật</p>
                                        </div>
                                    </div>
                                    <div>
                                        <button class="btn btn-sm btn-primary">Kết nối</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tax Settings -->
                <div class="tab-pane fade" id="tax" role="tabpanel" aria-labelledby="tax-tab">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">Cài đặt thuế</h5>
                        </div>
                        <div class="card-body">
                            <form id="taxSettingsForm">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="taxCalculation" class="form-label">Tính thuế dựa trên</label>
                                        <select class="form-select" id="taxCalculation" name="taxCalculation">
                                            <option value="shipping">Địa chỉ giao hàng</option>
                                            <option value="billing">Địa chỉ thanh toán</option>
                                            <option value="store" selected>Địa chỉ cửa hàng</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="pricesIncludeTax" class="form-label">Giá sản phẩm</label>
                                        <select class="form-select" id="pricesIncludeTax" name="pricesIncludeTax">
                                            <option value="1">Đã bao gồm thuế</option>
                                            <option value="0" selected>Chưa bao gồm thuế</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="taxClass" class="form-label">Thuế suất mặc định</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" id="taxClass" name="taxClass" value="10">
                                            <span class="input-group-text">%</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="displayTaxTotals" class="form-label">Hiển thị tổng thuế</label>
                                        <select class="form-select" id="displayTaxTotals" name="displayTaxTotals">
                                            <option value="itemized" selected>Chi tiết theo từng mục</option>
                                            <option value="single">Một dòng tổng</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="text-end mt-3">
                                    <button type="submit" class="btn btn-primary">Lưu thông tin</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Thuế suất theo khu vực</h5>
                            <button type="button" class="btn btn-sm btn-success" id="addTaxRateBtn">
                                <i class="fas fa-plus me-1"></i>Thêm thuế suất
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Tên</th>
                                            <th>Quốc gia</th>
                                            <th>Tỉnh/Thành phố</th>
                                            <th>Thuế suất</th>
                                            <th>Ưu tiên</th>
                                            <th>Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Thuế GTGT</td>
                                            <td>Việt Nam</td>
                                            <td>Tất cả</td>
                                            <td>10%</td>
                                            <td>0</td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-outline-primary me-1 edit-tax-rate" data-id="1">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-outline-danger delete-tax-rate" data-id="1">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Thuế GTGT - TP.HCM</td>
                                            <td>Việt Nam</td>
                                            <td>TP. Hồ Chí Minh</td>
                                            <td>10%</td>
                                            <td>1</td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-outline-primary me-1 edit-tax-rate" data-id="2">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-outline-danger delete-tax-rate" data-id="2">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Thuế GTGT - Hà Nội</td>
                                            <td>Việt Nam</td>
                                            <td>Hà Nội</td>
                                            <td>10%</td>
                                            <td>1</td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-outline-primary me-1 edit-tax-rate" data-id="3">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-outline-danger delete-tax-rate" data-id="3">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Thông tin thuế</h5>
                        </div>
                        <div class="card-body">
                            <form id="taxInfoForm">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="companyName" class="form-label">Tên công ty</label>
                                        <input type="text" class="form-control" id="companyName" name="companyName" value="Công ty TNHH Nông Sản Sạch">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="taxId" class="form-label">Mã số thuế</label>
                                        <input type="text" class="form-control" id="taxId" name="taxId" value="0123456789">
                                    </div>
                                    <div class="col-md-12">
                                        <label for="taxAddress" class="form-label">Địa chỉ đăng ký thuế</label>
                                        <input type="text" class="form-control" id="taxAddress" name="taxAddress" value="456 Đường XYZ, Quận ABC, TP. Hồ Chí Minh">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="taxRepresentative" class="form-label">Người đại diện</label>
                                        <input type="text" class="form-control" id="taxRepresentative" name="taxRepresentative" value="Nguyễn Văn A">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="taxPosition" class="form-label">Chức vụ</label>
                                        <input type="text" class="form-control" id="taxPosition" name="taxPosition" value="Giám đốc">
                                    </div>
                                </div>
                                <div class="text-end mt-3">
                                    <button type="submit" class="btn btn-primary">Lưu thông tin</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modals -->
<!-- Add Bank Account Modal -->
<div class="modal fade" id="addBankAccountModal" tabindex="-1" aria-labelledby="addBankAccountModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addBankAccountModalLabel">Thêm tài khoản ngân hàng</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addBankAccountForm">
                    <div class="mb-3">
                        <label for="bankName" class="form-label">Tên ngân hàng</label>
                        <select class="form-select" id="bankName" name="bankName" required>
                            <option value="">Chọn ngân hàng</option>
                            <option value="Vietcombank">Vietcombank</option>
                            <option value="Techcombank">Techcombank</option>
                            <option value="BIDV">BIDV</option>
                            <option value="Agribank">Agribank</option>
                            <option value="VPBank">VPBank</option>
                            <option value="ACB">ACB</option>
                            <option value="MBBank">MBBank</option>
                            <option value="TPBank">TPBank</option>
                            <option value="Sacombank">Sacombank</option>
                            <option value="VIB">VIB</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="accountName" class="form-label">Tên chủ tài khoản</label>
                        <input type="text" class="form-control" id="accountName" name="accountName" required>
                        <div class="form-text">Nhập chính xác tên chủ tài khoản như trên thẻ/sổ ngân hàng.</div>
                    </div>
                    <div class="mb-3">
                        <label for="accountNumber" class="form-label">Số tài khoản</label>
                        <input type="text" class="form-control" id="accountNumber" name="accountNumber" required>
                    </div>
                    <div class="mb-3">
                        <label for="bankBranch" class="form-label">Chi nhánh</label>
                        <input type="text" class="form-control" id="bankBranch" name="bankBranch">
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="isPrimaryAccount" name="isPrimaryAccount">
                            <label class="form-check-label" for="isPrimaryAccount">
                                Đặt làm tài khoản chính
                            </label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <button type="submit" form="addBankAccountForm" class="btn btn-primary">Thêm tài khoản</button>
            </div>
        </div>
    </div>
</div>

<!-- Add Warehouse Modal -->
<div class="modal fade" id="addWarehouseModal" tabindex="-1" aria-labelledby="addWarehouseModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addWarehouseModalLabel">Thêm kho hàng</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addWarehouseForm">
                    <div class="mb-3">
                        <label for="warehouseName" class="form-label">Tên kho</label>
                        <input type="text" class="form-control" id="warehouseName" name="warehouseName" required>
                    </div>
                    <div class="mb-3">
                        <label for="warehousePhone" class="form-label">Số điện thoại</label>
                        <input type="tel" class="form-control" id="warehousePhone" name="warehousePhone" required>
                    </div>
                    <div class="mb-3">
                        <label for="warehouseAddress" class="form-label">Địa chỉ</label>
                        <input type="text" class="form-control" id="warehouseAddress" name="warehouseAddress" required>
                    </div>
                    <div class="mb-3">
                        <label for="warehouseCity" class="form-label">Tỉnh/Thành phố</label>
                        <select class="form-select" id="warehouseCity" name="warehouseCity" required>
                            <option value="">Chọn tỉnh/thành phố</option>
                            <option value="TP. Hồ Chí Minh">TP. Hồ Chí Minh</option>
                            <option value="Hà Nội">Hà Nội</option>
                            <option value="Đà Nẵng">Đà Nẵng</option>
                            <option value="Cần Thơ">Cần Thơ</option>
                            <option value="Hải Phòng">Hải Phòng</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="warehouseDistrict" class="form-label">Quận/Huyện</label>
                        <select class="form-select" id="warehouseDistrict" name="warehouseDistrict" required>
                            <option value="">Chọn quận/huyện</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="isPrimaryWarehouse" name="isPrimaryWarehouse">
                            <label class="form-check-label" for="isPrimaryWarehouse">
                                Đặt làm kho chính
                            </label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <button type="submit" form="addWarehouseForm" class="btn btn-primary">Thêm kho</button>
            </div>
        </div>
    </div>
</div>

<!-- Add API Key Modal -->
<div class="modal fade" id="addApiKeyModal" tabindex="-1" aria-labelledby="addApiKeyModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addApiKeyModalLabel">Tạo API Key mới</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addApiKeyForm">
                    <div class="mb-3">
                        <label for="apiKeyName" class="form-label">Tên API Key</label>
                        <input type="text" class="form-control" id="apiKeyName" name="apiKeyName" required>
                    </div>
                    <div class="mb-3">
                        <label for="apiKeyPermissions" class="form-label">Quyền truy cập</label>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="permissionReadProducts" name="permissions[]" value="read_products" checked>
                            <label class="form-check-label" for="permissionReadProducts">
                                Đọc sản phẩm
                            </label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="permissionWriteProducts" name="permissions[]" value="write_products">
                            <label class="form-check-label" for="permissionWriteProducts">
                                Ghi sản phẩm
                            </label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="permissionReadOrders" name="permissions[]" value="read_orders" checked>
                            <label class="form-check-label" for="permissionReadOrders">
                                Đọc đơn hàng
                            </label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="permissionWriteOrders" name="permissions[]" value="write_orders">
                            <label class="form-check-label" for="permissionWriteOrders">
                                Ghi đơn hàng
                            </label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="permissionReadCustomers" name="permissions[]" value="read_customers" checked>
                            <label class="form-check-label" for="permissionReadCustomers">
                                Đọc khách hàng
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="permissionWriteCustomers" name="permissions[]" value="write_customers">
                            <label class="form-check-label" for="permissionWriteCustomers">
                                Ghi khách hàng
                            </label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="apiKeyExpiration" class="form-label">Thời hạn</label>
                        <select class="form-select" id="apiKeyExpiration" name="apiKeyExpiration">
                            <option value="never">Không giới hạn</option>
                            <option value="30">30 ngày</option>
                            <option value="90">90 ngày</option>
                            <option value="180">180 ngày</option>
                            <option value="365">365 ngày</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <button type="submit" form="addApiKeyForm" class="btn btn-primary">Tạo API Key</button>
            </div>
        </div>
    </div>
</div>

<!-- Add Webhook Modal -->
<div class="modal fade" id="addWebhookModal" tabindex="-1" aria-labelledby="addWebhookModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addWebhookModalLabel">Tạo Webhook mới</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addWebhookForm">
                    <div class="mb-3">
                        <label for="webhookUrl" class="form-label">URL</label>
                        <input type="url" class="form-control" id="webhookUrl" name="webhookUrl" required>
                        <div class="form-text">URL này sẽ nhận các sự kiện từ cửa hàng của bạn.</div>
                    </div>
                    <div class="mb-3">
                        <label for="webhookEvents" class="form-label">Sự kiện</label>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="eventOrderCreated" name="events[]" value="order.created" checked>
                            <label class="form-check-label" for="eventOrderCreated">
                                Đơn hàng mới
                            </label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="eventOrderUpdated" name="events[]" value="order.updated" checked>
                            <label class="form-check-label" for="eventOrderUpdated">
                                Cập nhật đơn hàng
                            </label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="eventOrderCancelled" name="events[]" value="order.cancelled">
                            <label class="form-check-label" for="eventOrderCancelled">
                                Hủy đơn hàng
                            </label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="eventProductCreated" name="events[]" value="product.created">
                            <label class="form-check-label" for="eventProductCreated">
                                Sản phẩm mới
                            </label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="eventProductUpdated" name="events[]" value="product.updated">
                            <label class="form-check-label" for="eventProductUpdated">
                                Cập nhật sản phẩm
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="eventCustomerCreated" name="events[]" value="customer.created">
                            <label class="form-check-label" for="eventCustomerCreated">
                                Khách hàng mới
                            </label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="webhookDescription" class="form-label">Mô tả</label>
                        <textarea class="form-control" id="webhookDescription" name="webhookDescription" rows="2"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <button type="submit" form="addWebhookForm" class="btn btn-primary">Tạo Webhook</button>
            </div>
        </div>
    </div>
</div>

<!-- Add Tax Rate Modal -->
<div class="modal fade" id="addTaxRateModal" tabindex="-1" aria-labelledby="addTaxRateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addTaxRateModalLabel">Thêm thuế suất</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addTaxRateForm">
                    <div class="mb-3">
                        <label for="taxRateName" class="form-label">Tên</label>
                        <input type="text" class="form-control" id="taxRateName" name="taxRateName" required>
                    </div>
                    <div class="mb-3">
                        <label for="taxRateCountry" class="form-label">Quốc gia</label>
                        <select class="form-select" id="taxRateCountry" name="taxRateCountry" required>
                            <option value="VN" selected>Việt Nam</option>
                            <option value="US">United States</option>
                            <option value="JP">Japan</option>
                            <option value="SG">Singapore</option>
                            <option value="KR">South Korea</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="taxRateState" class="form-label">Tỉnh/Thành phố</label>
                        <select class="form-select" id="taxRateState" name="taxRateState">
                            <option value="">Tất cả</option>
                            <option value="TP. Hồ Chí Minh">TP. Hồ Chí Minh</option>
                            <option value="Hà Nội">Hà Nội</option>
                            <option value="Đà Nẵng">Đà Nẵng</option>
                            <option value="Cần Thơ">Cần Thơ</option>
                            <option value="Hải Phòng">Hải Phòng</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="taxRateValue" class="form-label">Thuế suất (%)</label>
                        <input type="number" class="form-control" id="taxRateValue" name="taxRateValue" min="0" max="100" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label for="taxRatePriority" class="form-label">Ưu tiên</label>
                        <input type="number" class="form-control" id="taxRatePriority" name="taxRatePriority" min="0" value="0">
                        <div class="form-text">Thuế suất với ưu tiên cao hơn sẽ được áp dụng trước.</div>
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="taxRateCompound" name="taxRateCompound">
                            <label class="form-check-label" for="taxRateCompound">
                                Thuế ghép (áp dụng sau các thuế khác)
                            </label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <button type="submit" form="addTaxRateForm" class="btn btn-primary">Thêm thuế suất</button>
            </div>
        </div>
    </div>
</div>