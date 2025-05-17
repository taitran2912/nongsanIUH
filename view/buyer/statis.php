<div class="statistics-dashboard">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Thống kê & Báo cáo</h2>
        <div>
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-outline-secondary active" id="viewDay">Ngày</button>
                <button type="button" class="btn btn-outline-secondary" id="viewWeek">Tuần</button>
                <button type="button" class="btn btn-outline-secondary" id="viewMonth">Tháng</button>
                <button type="button" class="btn btn-outline-secondary" id="viewYear">Năm</button>
            </div>
            <button class="btn btn-success ms-2" id="exportStatsBtn">
                <i class="fas fa-file-export me-2"></i>Xuất báo cáo
            </button>
        </div>
    </div>

    <!-- Date Range Selector -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="d-flex align-items-center">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0">
                                <i class="fas fa-calendar-alt text-muted"></i>
                            </span>
                            <input type="date" class="form-control border-0 bg-light" id="dateFrom" value="2023-05-01">
                        </div>
                        <span class="mx-2">đến</span>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0">
                                <i class="fas fa-calendar-alt text-muted"></i>
                            </span>
                            <input type="date" class="form-control border-0 bg-light" id="dateTo" value="2023-05-15">
                        </div>
                    </div>
                </div>
                <div class="col-md-6 text-md-end mt-3 mt-md-0">
                    <button class="btn btn-sm btn-outline-secondary me-2" id="dateToday">Hôm nay</button>
                    <button class="btn btn-sm btn-outline-secondary me-2" id="dateYesterday">Hôm qua</button>
                    <button class="btn btn-sm btn-outline-secondary me-2" id="date7Days">7 ngày qua</button>
                    <button class="btn btn-sm btn-outline-secondary me-2" id="date30Days">30 ngày qua</button>
                    <button class="btn btn-sm btn-primary" id="applyDateFilter">Áp dụng</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Key Metrics -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="text-muted">Tổng doanh thu</div>
                        <div class="icon-circle bg-success-light">
                            <i class="fas fa-money-bill-wave text-success"></i>
                        </div>
                    </div>
                    <h3 class="mb-1" id="totalRevenue">4,250,000 đ</h3>
                    <div class="d-flex align-items-center">
                        <span class="badge bg-success me-2">
                            <i class="fas fa-arrow-up me-1"></i>12.5%
                        </span>
                        <small class="text-muted">so với kỳ trước</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="text-muted">Tổng đơn hàng</div>
                        <div class="icon-circle bg-primary-light">
                            <i class="fas fa-shopping-cart text-primary"></i>
                        </div>
                    </div>
                    <h3 class="mb-1" id="totalOrders">42</h3>
                    <div class="d-flex align-items-center">
                        <span class="badge bg-success me-2">
                            <i class="fas fa-arrow-up me-1"></i>8.3%
                        </span>
                        <small class="text-muted">so với kỳ trước</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="text-muted">Sản phẩm đã bán</div>
                        <div class="icon-circle bg-warning-light">
                            <i class="fas fa-box text-warning"></i>
                        </div>
                    </div>
                    <h3 class="mb-1" id="totalSoldItems">156</h3>
                    <div class="d-flex align-items-center">
                        <span class="badge bg-success me-2">
                            <i class="fas fa-arrow-up me-1"></i>15.2%
                        </span>
                        <small class="text-muted">so với kỳ trước</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="text-muted">Khách hàng mới</div>
                        <div class="icon-circle bg-info-light">
                            <i class="fas fa-user-plus text-info"></i>
                        </div>
                    </div>
                    <h3 class="mb-1" id="newCustomers">18</h3>
                    <div class="d-flex align-items-center">
                        <span class="badge bg-danger me-2">
                            <i class="fas fa-arrow-down me-1"></i>3.1%
                        </span>
                        <small class="text-muted">so với kỳ trước</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sales Chart -->
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="card h-100">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Doanh thu theo thời gian</h5>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="salesChartOptions" data-bs-toggle="dropdown" aria-expanded="false">
                            Tùy chọn
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="salesChartOptions">
                            <li><a class="dropdown-item" href="#" data-chart-view="revenue">Doanh thu</a></li>
                            <li><a class="dropdown-item" href="#" data-chart-view="orders">Đơn hàng</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#" data-chart-view="download">Tải xuống biểu đồ</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="salesChart" height="300"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Phân bổ đơn hàng</h5>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="orderDistributionOptions" data-bs-toggle="dropdown" aria-expanded="false">
                            Tùy chọn
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="orderDistributionOptions">
                            <li><a class="dropdown-item" href="#" data-chart-view="status">Theo trạng thái</a></li>
                            <li><a class="dropdown-item" href="#" data-chart-view="payment">Theo thanh toán</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#" data-chart-view="download">Tải xuống biểu đồ</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body d-flex flex-column justify-content-center">
                    <canvas id="orderDistributionChart" height="260"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Product Performance & Customer Stats -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Sản phẩm bán chạy</h5>
                    <button class="btn btn-sm btn-outline-secondary">Xem tất cả</button>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Sản phẩm</th>
                                    <th class="text-center">Đã bán</th>
                                    <th class="text-end">Doanh thu</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="product-img-sm me-2 bg-light rounded">
                                                <img src="https://via.placeholder.com/40" alt="Product" class="img-fluid">
                                            </div>
                                            <div>
                                                <div class="fw-medium">Rau cải ngọt hữu cơ</div>
                                                <div class="small text-muted">25,000 đ/kg</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">32 kg</td>
                                    <td class="text-end">800,000 đ</td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="product-img-sm me-2 bg-light rounded">
                                                <img src="https://via.placeholder.com/40" alt="Product" class="img-fluid">
                                            </div>
                                            <div>
                                                <div class="fw-medium">Gạo lứt hữu cơ</div>
                                                <div class="small text-muted">60,000 đ/kg</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">28 kg</td>
                                    <td class="text-end">1,680,000 đ</td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="product-img-sm me-2 bg-light rounded">
                                                <img src="https://via.placeholder.com/40" alt="Product" class="img-fluid">
                                            </div>
                                            <div>
                                                <div class="fw-medium">Táo hữu cơ</div>
                                                <div class="small text-muted">45,000 đ/kg</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">25 kg</td>
                                    <td class="text-end">1,125,000 đ</td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="product-img-sm me-2 bg-light rounded">
                                                <img src="https://via.placeholder.com/40" alt="Product" class="img-fluid">
                                            </div>
                                            <div>
                                                <div class="fw-medium">Cà chua hữu cơ</div>
                                                <div class="small text-muted">30,000 đ/kg</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">18 kg</td>
                                    <td class="text-end">540,000 đ</td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="product-img-sm me-2 bg-light rounded">
                                                <img src="https://via.placeholder.com/40" alt="Product" class="img-fluid">
                                            </div>
                                            <div>
                                                <div class="fw-medium">Dưa hấu không hạt</div>
                                                <div class="small text-muted">30,000 đ/kg</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">15 kg</td>
                                    <td class="text-end">450,000 đ</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Khách hàng thân thiết</h5>
                    <button class="btn btn-sm btn-outline-secondary">Xem tất cả</button>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Khách hàng</th>
                                    <th class="text-center">Đơn hàng</th>
                                    <th class="text-end">Chi tiêu</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
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
                                    <td class="text-center">8</td>
                                    <td class="text-end">1,250,000 đ</td>
                                </tr>
                                <tr>
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
                                    <td class="text-center">6</td>
                                    <td class="text-end">980,000 đ</td>
                                </tr>
                                <tr>
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
                                    <td class="text-center">5</td>
                                    <td class="text-end">850,000 đ</td>
                                </tr>
                                <tr>
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
                                    <td class="text-center">4</td>
                                    <td class="text-end">720,000 đ</td>
                                </tr>
                                <tr>
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
                                    <td class="text-center">3</td>
                                    <td class="text-end">450,000 đ</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Category Performance & Recent Orders -->
    <div class="row">
        <div class="col-md-5">
            <div class="card h-100">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Hiệu suất danh mục</h5>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="categoryChartOptions" data-bs-toggle="dropdown" aria-expanded="false">
                            Tùy chọn
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="categoryChartOptions">
                            <li><a class="dropdown-item" href="#" data-chart-view="revenue">Doanh thu</a></li>
                            <li><a class="dropdown-item" href="#" data-chart-view="orders">Đơn hàng</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#" data-chart-view="download">Tải xuống biểu đồ</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="categoryChart" height="260"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="card h-100">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Đơn hàng gần đây</h5>
                    <button class="btn btn-sm btn-outline-secondary">Xem tất cả</button>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Mã đơn hàng</th>
                                    <th>Khách hàng</th>
                                    <th>Ngày đặt</th>
                                    <th class="text-end">Tổng tiền</th>
                                    <th class="text-center">Trạng thái</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><a href="#" class="text-decoration-none">#ORD001</a></td>
                                    <td>Nguyễn Văn Tuấn</td>
                                    <td>15/05/2023</td>
                                    <td class="text-end">320,000 đ</td>
                                    <td class="text-center"><span class="badge bg-info">Đang giao hàng</span></td>
                                </tr>
                                <tr>
                                    <td><a href="#" class="text-decoration-none">#ORD002</a></td>
                                    <td>Lê Thị Hương</td>
                                    <td>14/05/2023</td>
                                    <td class="text-end">450,000 đ</td>
                                    <td class="text-center"><span class="badge bg-success">Đã hoàn thành</span></td>
                                </tr>
                                <tr>
                                    <td><a href="#" class="text-decoration-none">#ORD003</a></td>
                                    <td>Trần Văn Hùng</td>
                                    <td>14/05/2023</td>
                                    <td class="text-end">180,000 đ</td>
                                    <td class="text-center"><span class="badge bg-warning text-dark">Đang xử lý</span></td>
                                </tr>
                                <tr>
                                    <td><a href="#" class="text-decoration-none">#ORD004</a></td>
                                    <td>Phạm Thị Lan</td>
                                    <td>13/05/2023</td>
                                    <td class="text-end">560,000 đ</td>
                                    <td class="text-center"><span class="badge bg-danger">Đã hủy</span></td>
                                </tr>
                                <tr>
                                    <td><a href="#" class="text-decoration-none">#ORD005</a></td>
                                    <td>Hoàng Minh</td>
                                    <td>13/05/2023</td>
                                    <td class="text-end">290,000 đ</td>
                                    <td class="text-center"><span class="badge bg-secondary">Chờ xác nhận</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>