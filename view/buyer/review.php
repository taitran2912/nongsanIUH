
<div class="reviews-management">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Quản lý đánh giá</h2>
        <div>
            <button class="btn btn-outline-success me-2" id="exportReviewsBtn">
                <i class="fas fa-file-export me-2"></i>Xuất Excel
            </button>
            <button class="btn btn-success" id="reviewSettingsBtn">
                <i class="fas fa-cog me-2"></i>Cài đặt đánh giá
            </button>
        </div>
    </div>

    <!-- Rating Overview -->
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="card h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-4 text-center border-end">
                            <h6 class="text-muted mb-2">Đánh giá trung bình</h6>
                            <div class="d-flex align-items-center justify-content-center">
                                <h1 class="display-4 fw-bold mb-0 me-2">4.7</h1>
                                <div class="d-flex flex-column">
                                    <div class="stars">
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star-half-alt text-warning"></i>
                                    </div>
                                    <small class="text-muted">(128 đánh giá)</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="rating-bars">
                                <div class="rating-bar-item d-flex align-items-center mb-2">
                                    <div class="rating-label me-2">5 <i class="fas fa-star text-warning small"></i></div>
                                    <div class="progress flex-grow-1 me-2" style="height: 8px;">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 75%;" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <div class="rating-count small">96</div>
                                </div>
                                <div class="rating-bar-item d-flex align-items-center mb-2">
                                    <div class="rating-label me-2">4 <i class="fas fa-star text-warning small"></i></div>
                                    <div class="progress flex-grow-1 me-2" style="height: 8px;">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 15%;" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <div class="rating-count small">19</div>
                                </div>
                                <div class="rating-bar-item d-flex align-items-center mb-2">
                                    <div class="rating-label me-2">3 <i class="fas fa-star text-warning small"></i></div>
                                    <div class="progress flex-grow-1 me-2" style="height: 8px;">
                                        <div class="progress-bar bg-warning" role="progressbar" style="width: 5%;" aria-valuenow="5" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <div class="rating-count small">6</div>
                                </div>
                                <div class="rating-bar-item d-flex align-items-center mb-2">
                                    <div class="rating-label me-2">2 <i class="fas fa-star text-warning small"></i></div>
                                    <div class="progress flex-grow-1 me-2" style="height: 8px;">
                                        <div class="progress-bar bg-danger" role="progressbar" style="width: 3%;" aria-valuenow="3" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <div class="rating-count small">4</div>
                                </div>
                                <div class="rating-bar-item d-flex align-items-center">
                                    <div class="rating-label me-2">1 <i class="fas fa-star text-warning small"></i></div>
                                    <div class="progress flex-grow-1 me-2" style="height: 8px;">
                                        <div class="progress-bar bg-danger" role="progressbar" style="width: 2%;" aria-valuenow="2" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <div class="rating-count small">3</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <h6 class="text-muted mb-3">Thống kê đánh giá</h6>
                    <div class="row text-center">
                        <div class="col-4">
                            <div class="stat-item">
                                <h3 class="mb-1">128</h3>
                                <div class="small text-muted">Tổng đánh giá</div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="stat-item">
                                <h3 class="mb-1">12</h3>
                                <div class="small text-muted">Chưa trả lời</div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="stat-item">
                                <h3 class="mb-1">94%</h3>
                                <div class="small text-muted">Tỷ lệ hài lòng</div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="text-muted">Tỷ lệ phản hồi</div>
                        <div class="fw-medium">91%</div>
                    </div>
                    <div class="progress mb-3" style="height: 6px;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 91%;" aria-valuenow="91" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="text-muted">Thời gian phản hồi trung bình</div>
                        <div class="fw-medium">8 giờ</div>
                    </div>
                    <div class="progress" style="height: 6px;">
                        <div class="progress-bar bg-info" role="progressbar" style="width: 75%;" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Review Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <form id="reviewFilterForm">
                <div class="row g-3">
                    <div class="col-md-3">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                            <input type="text" class="form-control border-0 bg-light" id="searchReview" placeholder="Tìm kiếm đánh giá...">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <select class="form-select" id="ratingFilter">
                            <option value="">Tất cả sao</option>
                            <option value="5">5 sao</option>
                            <option value="4">4 sao</option>
                            <option value="3">3 sao</option>
                            <option value="2">2 sao</option>
                            <option value="1">1 sao</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select class="form-select" id="productFilter">
                            <option value="">Tất cả sản phẩm</option>
                            <option value="rau-cai">Rau cải ngọt hữu cơ</option>
                            <option value="ca-chua">Cà chua hữu cơ</option>
                            <option value="tao">Táo hữu cơ</option>
                            <option value="gao-lut">Gạo lứt hữu cơ</option>
                            <option value="dua-hau">Dưa hấu không hạt</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select class="form-select" id="responseFilter">
                            <option value="">Tất cả trạng thái</option>
                            <option value="replied">Đã phản hồi</option>
                            <option value="not-replied">Chưa phản hồi</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" id="dateFilter">
                            <option value="all">Tất cả thời gian</option>
                            <option value="today">Hôm nay</option>
                            <option value="yesterday">Hôm qua</option>
                            <option value="week">7 ngày qua</option>
                            <option value="month">30 ngày qua</option>
                        </select>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Reviews List -->
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="reviewsTable">
                    <thead class="table-light">
                        <tr>
                            <th>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="selectAllReviews">
                                </div>
                            </th>
                            <th>Khách hàng</th>
                            <th>Sản phẩm</th>
                            <th>Đánh giá</th>
                            <th>Nội dung</th>
                            <th>Ngày đánh giá</th>
                            <th>Trạng thái</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Đánh giá 1 -->
                        <tr>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input review-checkbox" type="checkbox" value="REV001">
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm me-2 bg-primary-light rounded-circle text-center">
                                        <span class="avatar-text">NT</span>
                                    </div>
                                    <div>
                                        <div class="fw-medium">Nguyễn Văn Tuấn</div>
                                        <div class="small text-muted">0912345678</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="product-img-sm me-2 bg-light rounded">
                                        <img src="https://via.placeholder.com/40" alt="Product" class="img-fluid">
                                    </div>
                                    <div>Rau cải ngọt hữu cơ</div>
                                </div>
                            </td>
                            <td>
                                <div class="stars">
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                </div>
                            </td>
                            <td>
                                <div class="review-content">Rau tươi ngon, giao hàng nhanh, đóng gói cẩn thận. Sẽ ủng hộ shop dài dài.</div>
                            </td>
                            <td>
                                <div>15/05/2023</div>
                                <div class="small text-muted">10:30 AM</div>
                            </td>
                            <td><span class="badge bg-success">Đã phản hồi</span></td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-sm" type="button" data-bs-toggle="dropdown">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#viewReviewModal" data-review-id="REV001"><i class="fas fa-eye me-2"></i>Xem chi tiết</a></li>
                                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#replyReviewModal" data-review-id="REV001"><i class="fas fa-reply me-2"></i>Phản hồi</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item text-danger" href="#" data-bs-toggle="modal" data-bs-target="#reportReviewModal" data-review-id="REV001"><i class="fas fa-flag me-2"></i>Báo cáo vi phạm</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        
                        <!-- Đánh giá 2 -->
                        <tr>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input review-checkbox" type="checkbox" value="REV002">
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm me-2 bg-success-light rounded-circle text-center">
                                        <span class="avatar-text">LH</span>
                                    </div>
                                    <div>
                                        <div class="fw-medium">Lê Thị Hương</div>
                                        <div class="small text-muted">0987654321</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="product-img-sm me-2 bg-light rounded">
                                        <img src="https://via.placeholder.com/40" alt="Product" class="img-fluid">
                                    </div>
                                    <div>Táo hữu cơ</div>
                                </div>
                            </td>
                            <td>
                                <div class="stars">
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="far fa-star text-warning"></i>
                                </div>
                            </td>
                            <td>
                                <div class="review-content">Táo ngọt, giòn, không bị dập. Tuy nhiên có vài quả hơi nhỏ so với mô tả.</div>
                            </td>
                            <td>
                                <div>14/05/2023</div>
                                <div class="small text-muted">15:45 PM</div>
                            </td>
                            <td><span class="badge bg-success">Đã phản hồi</span></td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-sm" type="button" data-bs-toggle="dropdown">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#viewReviewModal" data-review-id="REV002"><i class="fas fa-eye me-2"></i>Xem chi tiết</a></li>
                                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#replyReviewModal" data-review-id="REV002"><i class="fas fa-reply me-2"></i>Phản hồi</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item text-danger" href="#" data-bs-toggle="modal" data-bs-target="#reportReviewModal" data-review-id="REV002"><i class="fas fa-flag me-2"></i>Báo cáo vi phạm</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        
                        <!-- Đánh giá 3 -->
                        <tr>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input review-checkbox" type="checkbox" value="REV003">
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm me-2 bg-info-light rounded-circle text-center">
                                        <span class="avatar-text">TH</span>
                                    </div>
                                    <div>
                                        <div class="fw-medium">Trần Văn Hùng</div>
                                        <div class="small text-muted">0909123456</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="product-img-sm me-2 bg-light rounded">
                                        <img src="https://via.placeholder.com/40" alt="Product" class="img-fluid">
                                    </div>
                                    <div>Gạo lứt hữu cơ</div>
                                </div>
                            </td>
                            <td>
                                <div class="stars">
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="far fa-star text-warning"></i>
                                    <i class="far fa-star text-warning"></i>
                                </div>
                            </td>
                            <td>
                                <div class="review-content">Gạo chất lượng khá ổn, nhưng thời gian giao hàng hơi lâu. Mong shop cải thiện.</div>
                            </td>
                            <td>
                                <div>14/05/2023</div>
                                <div class="small text-muted">09:15 AM</div>
                            </td>
                            <td><span class="badge bg-warning text-dark">Chưa phản hồi</span></td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-sm" type="button" data-bs-toggle="dropdown">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#viewReviewModal" data-review-id="REV003"><i class="fas fa-eye me-2"></i>Xem chi tiết</a></li>
                                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#replyReviewModal" data-review-id="REV003"><i class="fas fa-reply me-2"></i>Phản hồi</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item text-danger" href="#" data-bs-toggle="modal" data-bs-target="#reportReviewModal" data-review-id="REV003"><i class="fas fa-flag me-2"></i>Báo cáo vi phạm</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        
                        <!-- Đánh giá 4 -->
                        <tr>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input review-checkbox" type="checkbox" value="REV004">
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm me-2 bg-warning-light rounded-circle text-center">
                                        <span class="avatar-text">PL</span>
                                    </div>
                                    <div>
                                        <div class="fw-medium">Phạm Thị Lan</div>
                                        <div class="small text-muted">0978123456</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="product-img-sm me-2 bg-light rounded">
                                        <img src="https://via.placeholder.com/40" alt="Product" class="img-fluid">
                                    </div>
                                    <div>Cà chua hữu cơ</div>
                                </div>
                            </td>
                            <td>
                                <div class="stars">
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="far fa-star text-warning"></i>
                                    <i class="far fa-star text-warning"></i>
                                    <i class="far fa-star text-warning"></i>
                                </div>
                            </td>
                            <td>
                                <div class="review-content">Cà chua bị dập nhiều, không tươi như hình. Rất thất vọng với chất lượng sản phẩm.</div>
                            </td>
                            <td>
                                <div>13/05/2023</div>
                                <div class="small text-muted">14:20 PM</div>
                            </td>
                            <td><span class="badge bg-success">Đã phản hồi</span></td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-sm" type="button" data-bs-toggle="dropdown">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#viewReviewModal" data-review-id="REV004"><i class="fas fa-eye me-2"></i>Xem chi tiết</a></li>
                                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#replyReviewModal" data-review-id="REV004"><i class="fas fa-reply me-2"></i>Phản hồi</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item text-danger" href="#" data-bs-toggle="modal" data-bs-target="#reportReviewModal" data-review-id="REV004"><i class="fas fa-flag me-2"></i>Báo cáo vi phạm</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        
                        <!-- Đánh giá 5 -->
                        <tr>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input review-checkbox" type="checkbox" value="REV005">
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm me-2 bg-danger-light rounded-circle text-center">
                                        <span class="avatar-text">HM</span>
                                    </div>
                                    <div>
                                        <div class="fw-medium">Hoàng Minh</div>
                                        <div class="small text-muted">0965432198</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="product-img-sm me-2 bg-light rounded">
                                        <img src="https://via.placeholder.com/40" alt="Product" class="img-fluid">
                                    </div>
                                    <div>Dưa hấu không hạt</div>
                                </div>
                            </td>
                            <td>
                                <div class="stars">
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                </div>
                            </td>
                            <td>
                                <div class="review-content">Dưa hấu ngọt, mọng nước, đúng là không có hạt. Rất hài lòng với sản phẩm.</div>
                            </td>
                            <td>
                                <div>13/05/2023</div>
                                <div class="small text-muted">11:05 AM</div>
                            </td>
                            <td><span class="badge bg-warning text-dark">Chưa phản hồi</span></td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-sm" type="button" data-bs-toggle="dropdown">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#viewReviewModal" data-review-id="REV005"><i class="fas fa-eye me-2"></i>Xem chi tiết</a></li>
                                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#replyReviewModal" data-review-id="REV005"><i class="fas fa-reply me-2"></i>Phản hồi</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item text-danger" href="#" data-bs-toggle="modal" data-bs-target="#reportReviewModal" data-review-id="REV005"><i class="fas fa-flag me-2"></i>Báo cáo vi phạm</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        
                        <!-- Đánh giá 6 -->
                        <tr>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input review-checkbox" type="checkbox" value="REV006">
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm me-2 bg-primary-light rounded-circle text-center">
                                        <span class="avatar-text">VT</span>
                                    </div>
                                    <div>
                                        <div class="fw-medium">Vũ Thị Thanh</div>
                                        <div class="small text-muted">0932145678</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="product-img-sm me-2 bg-light rounded">
                                        <img src="https://via.placeholder.com/40" alt="Product" class="img-fluid">
                                    </div>
                                    <div>Rau cải ngọt hữu cơ</div>
                                </div>
                            </td>
                            <td>
                                <div class="stars">
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star-half-alt text-warning"></i>
                                </div>
                            </td>
                            <td>
                                <div class="review-content">Rau tươi, sạch, giao hàng đúng hẹn. Sẽ tiếp tục ủng hộ shop.</div>
                            </td>
                            <td>
                                <div>12/05/2023</div>
                                <div class="small text-muted">16:40 PM</div>
                            </td>
                            <td><span class="badge bg-success">Đã phản hồi</span></td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-sm" type="button" data-bs-toggle="dropdown">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#viewReviewModal" data-review-id="REV006"><i class="fas fa-eye me-2"></i>Xem chi tiết</a></li>
                                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#replyReviewModal" data-review-id="REV006"><i class="fas fa-reply me-2"></i>Phản hồi</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item text-danger" href="#" data-bs-toggle="modal" data-bs-target="#reportReviewModal" data-review-id="REV006"><i class="fas fa-flag me-2"></i>Báo cáo vi phạm</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        
                        <!-- Đánh giá 7 -->
                        <tr>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input review-checkbox" type="checkbox" value="REV007">
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm me-2 bg-success-light rounded-circle text-center">
                                        <span class="avatar-text">ĐA</span>
                                    </div>
                                    <div>
                                        <div class="fw-medium">Đỗ Văn An</div>
                                        <div class="small text-muted">0945678123</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="product-img-sm me-2 bg-light rounded">
                                        <img src="https://via.placeholder.com/40" alt="Product" class="img-fluid">
                                    </div>
                                    <div>Táo hữu cơ</div>
                                </div>
                            </td>
                            <td>
                                <div class="stars">
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="far fa-star text-warning"></i>
                                </div>
                            </td>
                            <td>
                                <div class="review-content">Táo ngon, ngọt, giòn. Đóng gói cẩn thận. Sẽ mua lại.</div>
                            </td>
                            <td>
                                <div>12/05/2023</div>
                                <div class="small text-muted">08:30 AM</div>
                            </td>
                            <td><span class="badge bg-warning text-dark">Chưa phản hồi</span></td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-sm" type="button" data-bs-toggle="dropdown">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#viewReviewModal" data-review-id="REV007"><i class="fas fa-eye me-2"></i>Xem chi tiết</a></li>
                                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#replyReviewModal" data-review-id="REV007"><i class="fas fa-reply me-2"></i>Phản hồi</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item text-danger" href="#" data-bs-toggle="modal" data-bs-target="#reportReviewModal" data-review-id="REV007"><i class="fas fa-flag me-2"></i>Báo cáo vi phạm</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <div class="bulk-actions d-flex align-items-center">
                    <select class="form-select form-select-sm me-2" id="bulkActionSelect" style="width: auto;">
                        <option value="">Thao tác hàng loạt</option>
                        <option value="reply">Phản hồi đánh giá</option>
                        <option value="mark-replied">Đánh dấu đã phản hồi</option>
                        <option value="mark-not-replied">Đánh dấu chưa phản hồi</option>
                        <option value="report">Báo cáo vi phạm</option>
                    </select>
                    <button class="btn btn-sm btn-outline-secondary" id="applyBulkAction" disabled>Áp dụng</button>
                </div>
                <div class="d-flex align-items-center">
                    <div class="me-3">Hiển thị 1-7 của 128 đánh giá</div>
                    <nav aria-label="Page navigation">
                        <ul class="pagination pagination-sm mb-0">
                            <li class="page-item disabled">
                                <a class="page-link" href="#" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modals -->
<!-- Xem chi tiết đánh giá Modal -->
<div class="modal fade" id="viewReviewModal" tabindex="-1" aria-labelledby="viewReviewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewReviewModalLabel">Chi tiết đánh giá</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="review-detail">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-uppercase text-muted mb-3">Thông tin đánh giá</h6>
                            <p class="mb-1"><strong>Mã đánh giá:</strong> <span id="reviewIdDetail">REV001</span></p>
                            <p class="mb-1"><strong>Ngày đánh giá:</strong> <span id="reviewDateDetail">15/05/2023 10:30 AM</span></p>
                            <p class="mb-1"><strong>Đánh giá:</strong> 
                                <span id="reviewRatingDetail" class="stars">
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                </span>
                            </p>
                            <p class="mb-1"><strong>Trạng thái:</strong> <span class="badge bg-success" id="reviewStatusDetail">Đã phản hồi</span></p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-uppercase text-muted mb-3">Thông tin khách hàng</h6>
                            <p class="mb-1"><strong>Tên khách hàng:</strong> <span id="customerNameDetail">Nguyễn Văn Tuấn</span></p>
                            <p class="mb-1"><strong>Số điện thoại:</strong> <span id="customerPhoneDetail">0912345678</span></p>
                            <p class="mb-1"><strong>Email:</strong> <span id="customerEmailDetail">nguyenvantuan@example.com</span></p>
                            <p class="mb-1"><strong>Đơn hàng:</strong> <a href="#" id="orderIdDetail">#ORD001</a></p>
                        </div>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-12">
                            <h6 class="text-uppercase text-muted mb-3">Sản phẩm đánh giá</h6>
                            <div class="d-flex align-items-center">
                                <div class="product-img me-3 bg-light rounded" style="width: 80px; height: 80px;">
                                    <img src="https://via.placeholder.com/80" alt="Product" class="img-fluid">
                                </div>
                                <div>
                                    <h6 class="mb-1" id="productNameDetail">Rau cải ngọt hữu cơ</h6>
                                    <p class="mb-1 text-muted" id="productPriceDetail">25,000 đ/kg</p>
                                    <p class="mb-0 small" id="productCategoryDetail">Danh mục: Rau củ</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-12">
                            <h6 class="text-uppercase text-muted mb-3">Nội dung đánh giá</h6>
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex mb-3">
                                        <div class="avatar-sm me-2 bg-primary-light rounded-circle text-center">
                                            <span class="avatar-text">NT</span>
                                        </div>
                                        <div>
                                            <div class="fw-medium">Nguyễn Văn Tuấn</div>
                                            <div class="small text-muted">15/05/2023 10:30 AM</div>
                                        </div>
                                    </div>
                                    <p id="reviewContentDetail">Rau tươi ngon, giao hàng nhanh, đóng gói cẩn thận. Sẽ ủng hộ shop dài dài.</p>
                                    <div class="review-images mt-3">
                                        <div class="row g-2">
                                            <div class="col-auto">
                                                <img src="https://via.placeholder.com/100" alt="Review Image" class="img-thumbnail" style="width: 100px; height: 100px; object-fit: cover;">
                                            </div>
                                            <div class="col-auto">
                                                <img src="https://via.placeholder.com/100" alt="Review Image" class="img-thumbnail" style="width: 100px; height: 100px; object-fit: cover;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-12">
                            <h6 class="text-uppercase text-muted mb-3">Phản hồi của shop</h6>
                            <div class="card bg-light">
                                <div class="card-body">
                                    <div class="d-flex mb-3">
                                        <div class="avatar-sm me-2 bg-success rounded-circle text-center">
                                            <span class="avatar-text text-white">NS</span>
                                        </div>
                                        <div>
                                            <div class="fw-medium">Nông Sản Sạch <span class="badge bg-success ms-1">Shop</span></div>
                                            <div class="small text-muted">15/05/2023 11:45 AM</div>
                                        </div>
                                    </div>
                                    <p id="replyContentDetail">Cảm ơn anh Tuấn đã tin tưởng và ủng hộ shop. Chúng tôi luôn cố gắng mang đến những sản phẩm tươi ngon, chất lượng nhất đến tay khách hàng. Rất mong được phục vụ anh trong những lần mua sắm tiếp theo!</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#replyReviewModal" data-review-id="REV001">Phản hồi</button>
            </div>
        </div>
    </div>
</div>

<!-- Phản hồi đánh giá Modal -->
<div class="modal fade" id="replyReviewModal" tabindex="-1" aria-labelledby="replyReviewModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="replyReviewModalLabel">Phản hồi đánh giá</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="replyReviewForm" method="POST" action="process/reply-review.php">
                    <input type="hidden" id="replyReviewId" name="review_id" value="REV001">
                    
                    <div class="mb-3">
                        <label for="reviewSummary" class="form-label">Đánh giá của khách hàng</label>
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex mb-2">
                                    <div class="avatar-sm me-2 bg-primary-light rounded-circle text-center">
                                        <span class="avatar-text">NT</span>
                                    </div>
                                    <div>
                                        <div class="fw-medium" id="replyCustomerName">Nguyễn Văn Tuấn</div>
                                        <div class="small text-muted" id="replyReviewDate">15/05/2023 10:30 AM</div>
                                    </div>
                                </div>
                                <div class="stars mb-2" id="replyReviewRating">
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                </div>
                                <p class="mb-0" id="replyReviewContent">Rau tươi ngon, giao hàng nhanh, đóng gói cẩn thận. Sẽ ủng hộ shop dài dài.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="replyContent" class="form-label">Nội dung phản hồi</label>
                        <textarea class="form-control" id="replyContent" name="reply_content" rows="5" placeholder="Nhập nội dung phản hồi..." required></textarea>
                        <div class="form-text">Hãy viết phản hồi chuyên nghiệp, thân thiện và cảm ơn khách hàng đã đánh giá.</div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="sendNotification" name="send_notification" checked>
                            <label class="form-check-label" for="sendNotification">
                                Gửi thông báo cho khách hàng về phản hồi này
                            </label>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="saveTemplate" name="save_template">
                            <label class="form-check-label" for="saveTemplate">
                                Lưu làm mẫu phản hồi
                            </label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="dropdown me-auto">
                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="replyTemplateDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        Mẫu phản hồi
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="replyTemplateDropdown">
                        <li><a class="dropdown-item" href="#" data-template="positive">Phản hồi tích cực</a></li>
                        <li><a class="dropdown-item" href="#" data-template="negative">Phản hồi tiêu cực</a></li>
                        <li><a class="dropdown-item" href="#" data-template="neutral">Phản hồi trung lập</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#" data-template="custom">Quản lý mẫu phản hồi</a></li>
                    </ul>
                </div>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <button type="submit" form="replyReviewForm" class="btn btn-success">Gửi phản hồi</button>
            </div>
        </div>
    </div>
</div>

<!-- Báo cáo vi phạm Modal -->
<div class="modal fade" id="reportReviewModal" tabindex="-1" aria-labelledby="reportReviewModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reportReviewModalLabel">Báo cáo đánh giá vi phạm</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="reportReviewForm" method="POST" action="process/report-review.php">
                    <input type="hidden" id="reportReviewId" name="review_id" value="REV001">
                    
                    <div class="mb-3">
                        <label for="reportReviewSummary" class="form-label">Đánh giá cần báo cáo</label>
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex mb-2">
                                    <div class="avatar-sm me-2 bg-primary-light rounded-circle text-center">
                                        <span class="avatar-text">NT</span>
                                    </div>
                                    <div>
                                        <div class="fw-medium" id="reportCustomerName">Nguyễn Văn Tuấn</div>
                                        <div class="small text-muted" id="reportReviewDate">15/05/2023 10:30 AM</div>
                                    </div>
                                </div>
                                <p class="mb-0" id="reportReviewContent">Rau tươi ngon, giao hàng nhanh, đóng gói cẩn thận. Sẽ ủng hộ shop dài dài.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="reportReason" class="form-label">Lý do báo cáo</label>
                        <select class="form-select" id="reportReason" name="report_reason" required>
                            <option value="">Chọn lý do báo cáo</option>
                            <option value="spam">Spam hoặc quảng cáo</option>
                            <option value="inappropriate">Nội dung không phù hợp</option>
                            <option value="offensive">Ngôn từ xúc phạm</option>
                            <option value="fake">Đánh giá giả mạo</option>
                            <option value="irrelevant">Không liên quan đến sản phẩm</option>
                            <option value="other">Lý do khác</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="reportDescription" class="form-label">Mô tả chi tiết</label>
                        <textarea class="form-control" id="reportDescription" name="report_description" rows="4" placeholder="Mô tả chi tiết lý do báo cáo..." required></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="hideReview" name="hide_review">
                            <label class="form-check-label" for="hideReview">
                                Ẩn đánh giá này cho đến khi được xử lý
                            </label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <button type="submit" form="reportReviewForm" class="btn btn-danger">Gửi báo cáo</button>
            </div>
        </div>
    </div>
</div>

<!-- Cài đặt đánh giá Modal -->
<div class="modal fade" id="reviewSettingsModal" tabindex="-1" aria-labelledby="reviewSettingsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reviewSettingsModalLabel">Cài đặt đánh giá</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="reviewSettingsForm" method="POST" action="process/update-review-settings.php">
                    <div class="mb-3">
                        <label class="form-label">Hiển thị đánh giá</label>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="display_reviews" id="displayAllReviews" value="all" checked>
                            <label class="form-check-label" for="displayAllReviews">
                                Hiển thị tất cả đánh giá
                            </label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="display_reviews" id="displayVerifiedReviews" value="verified">
                            <label class="form-check-label" for="displayVerifiedReviews">
                                Chỉ hiển thị đánh giá từ khách hàng đã mua hàng
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="display_reviews" id="displayModeratedReviews" value="moderated">
                            <label class="form-check-label" for="displayModeratedReviews">
                                Chỉ hiển thị đánh giá sau khi kiểm duyệt
                            </label>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Sắp xếp đánh giá</label>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="sort_reviews" id="sortNewest" value="newest" checked>
                            <label class="form-check-label" for="sortNewest">
                                Mới nhất trước
                            </label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="sort_reviews" id="sortHighest" value="highest">
                            <label class="form-check-label" for="sortHighest">
                                Đánh giá cao nhất trước
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="sort_reviews" id="sortLowest" value="lowest">
                            <label class="form-check-label" for="sortLowest">
                                Đánh giá thấp nhất trước
                            </label>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="reviewsPerPage" class="form-label">Số đánh giá hiển thị mỗi trang</label>
                        <select class="form-select" id="reviewsPerPage" name="reviews_per_page">
                            <option value="5">5</option>
                            <option value="10" selected>10</option>
                            <option value="15">15</option>
                            <option value="20">20</option>
                            <option value="25">25</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Thông báo</label>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="notifyNewReview" name="notify_new_review" checked>
                            <label class="form-check-label" for="notifyNewReview">
                                Thông báo khi có đánh giá mới
                            </label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="notifyLowRating" name="notify_low_rating" checked>
                            <label class="form-check-label" for="notifyLowRating">
                                Thông báo khi có đánh giá thấp (1-2 sao)
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="emailNotification" name="email_notification" checked>
                            <label class="form-check-label" for="emailNotification">
                                Gửi thông báo qua email
                            </label>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="autoReplyTemplate" class="form-label">Mẫu phản hồi tự động</label>
                        <textarea class="form-control" id="autoReplyTemplate" name="auto_reply_template" rows="3" placeholder="Nhập mẫu phản hồi tự động...">Cảm ơn bạn đã đánh giá sản phẩm của chúng tôi. Chúng tôi rất trân trọng phản hồi của bạn và sẽ không ngừng cải thiện chất lượng sản phẩm và dịch vụ.</textarea>
                        <div class="form-text">Sử dụng {customer_name} để chèn tên khách hàng, {product_name} để chèn tên sản phẩm.</div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="enableAutoReply" name="enable_auto_reply">
                            <label class="form-check-label" for="enableAutoReply">
                                Bật phản hồi tự động cho đánh giá 4-5 sao
                            </label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <button type="submit" form="reviewSettingsForm" class="btn btn-primary">Lưu cài đặt</button>
            </div>
        </div>
    </div>
</div>