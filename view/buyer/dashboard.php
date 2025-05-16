<div class="tab-pane fade show active">
                        <!-- Stats Cards -->
                        <div class="row g-4 mb-4">
                            <div class="col-md-6 col-lg-3">
                                <div class="card stat-card h-100">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="card-subtitle text-muted">Doanh thu</h6>
                                                <h3 class="card-title mb-0">8.5M đ</h3>
                                                <p class="card-text text-success"><i class="fas fa-arrow-up"></i> 12.5%</p>
                                            </div>
                                            <div class="stat-icon bg-primary-light text-primary">
                                                <i class="fas fa-money-bill-wave"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <div class="card stat-card h-100">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="card-subtitle text-muted">Đơn hàng</h6>
                                                <h3 class="card-title mb-0">42</h3>
                                                <p class="card-text text-success"><i class="fas fa-arrow-up"></i> 8.2%</p>
                                            </div>
                                            <div class="stat-icon bg-success-light text-success">
                                                <i class="fas fa-shopping-bag"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <div class="card stat-card h-100">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="card-subtitle text-muted">Khách hàng</h6>
                                                <h3 class="card-title mb-0">28</h3>
                                                <p class="card-text text-success"><i class="fas fa-arrow-up"></i> 5.3%</p>
                                            </div>
                                            <div class="stat-icon bg-info-light text-info">
                                                <i class="fas fa-users"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <div class="card stat-card h-100">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="card-subtitle text-muted">Sản phẩm</h6>
                                                <h3 class="card-title mb-0">65</h3>
                                                <p class="card-text text-danger"><i class="fas fa-arrow-down"></i> 2.1%</p>
                                            </div>
                                            <div class="stat-icon bg-warning-light text-warning">
                                                <i class="fas fa-box"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Charts -->
                        <div class="row g-4 mb-4">
                            <div class="col-lg-8">
                                <div class="card h-100">
                                    <div class="card-header bg-white">
                                        <h5 class="card-title mb-0">Doanh thu theo thời gian</h5>
                                    </div>
                                    <div class="card-body">
                                        <canvas id="revenueChart" height="250"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="card h-100">
                                    <div class="card-header bg-white">
                                        <h5 class="card-title mb-0">Sản phẩm bán chạy</h5>
                                    </div>
                                    <div class="card-body">
                                        <canvas id="productChart" height="250"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Recent Orders -->
                        <div class="card mb-4">
                            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">Đơn hàng gần đây</h5>
                                <a href="#orders" class="btn btn-sm btn-outline-success" data-bs-toggle="tab">Xem tất cả</a>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Mã đơn hàng</th>
                                                <th>Khách hàng</th>
                                                <th>Sản phẩm</th>
                                                <th>Ngày đặt</th>
                                                <th>Tổng tiền</th>
                                                <th>Trạng thái</th>
                                                <th>Thao tác</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>#ORD-1234</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="https://via.placeholder.com/40" class="rounded-circle me-2" alt="Avatar">
                                                        <div>Nguyễn Văn A</div>
                                                    </div>
                                                </td>
                                                <td>Rau cải, Cà chua, Dưa leo</td>
                                                <td>15/05/2023</td>
                                                <td>320,000 đ</td>
                                                <td><span class="badge bg-success">Đã giao</span></td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm" type="button" data-bs-toggle="dropdown">
                                                            <i class="fas fa-ellipsis-v"></i>
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li><a class="dropdown-item" href="#">Xem chi tiết</a></li>
                                                            <li><a class="dropdown-item" href="#">In hóa đơn</a></li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>#ORD-1233</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="https://via.placeholder.com/40" class="rounded-circle me-2" alt="Avatar">
                                                        <div>Trần Thị B</div>
                                                    </div>
                                                </td>
                                                <td>Táo, Lê, Cam</td>
                                                <td>14/05/2023</td>
                                                <td>450,000 đ</td>
                                                <td><span class="badge bg-primary">Đang giao</span></td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm" type="button" data-bs-toggle="dropdown">
                                                            <i class="fas fa-ellipsis-v"></i>
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li><a class="dropdown-item" href="#">Xem chi tiết</a></li>
                                                            <li><a class="dropdown-item" href="#">In hóa đơn</a></li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>#ORD-1232</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="https://via.placeholder.com/40" class="rounded-circle me-2" alt="Avatar">
                                                        <div>Lê Văn C</div>
                                                    </div>
                                                </td>
                                                <td>Gạo lứt, Đậu xanh</td>
                                                <td>13/05/2023</td>
                                                <td>280,000 đ</td>
                                                <td><span class="badge bg-warning text-dark">Chờ xác nhận</span></td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm" type="button" data-bs-toggle="dropdown">
                                                            <i class="fas fa-ellipsis-v"></i>
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li><a class="dropdown-item" href="#">Xem chi tiết</a></li>
                                                            <li><a class="dropdown-item" href="#">Xác nhận đơn</a></li>
                                                            <li><a class="dropdown-item" href="#">Hủy đơn</a></li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>#ORD-1231</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="https://via.placeholder.com/40" class="rounded-circle me-2" alt="Avatar">
                                                        <div>Phạm Thị D</div>
                                                    </div>
                                                </td>
                                                <td>Bắp cải, Cà rốt</td>
                                                <td>12/05/2023</td>
                                                <td>180,000 đ</td>
                                                <td><span class="badge bg-danger">Đã hủy</span></td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm" type="button" data-bs-toggle="dropdown">
                                                            <i class="fas fa-ellipsis-v"></i>
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li><a class="dropdown-item" href="#">Xem chi tiết</a></li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>#ORD-1230</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="https://via.placeholder.com/40" class="rounded-circle me-2" alt="Avatar">
                                                        <div>Hoàng Văn E</div>
                                                    </div>
                                                </td>
                                                <td>Khoai lang, Khoai tây</td>
                                                <td>11/05/2023</td>
                                                <td>220,000 đ</td>
                                                <td><span class="badge bg-success">Đã giao</span></td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm" type="button" data-bs-toggle="dropdown">
                                                            <i class="fas fa-ellipsis-v"></i>
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li><a class="dropdown-item" href="#">Xem chi tiết</a></li>
                                                            <li><a class="dropdown-item" href="#">In hóa đơn</a></li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Low Stock Products -->
                        <div class="card">
                            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">Sản phẩm sắp hết hàng</h5>
                                <a href="#products" class="btn btn-sm btn-outline-success" data-bs-toggle="tab">Quản lý kho</a>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Sản phẩm</th>
                                                <th>Danh mục</th>
                                                <th>Giá</th>
                                                <th>Tồn kho</th>
                                                <th>Trạng thái</th>
                                                <th>Thao tác</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="https://via.placeholder.com/50" class="rounded me-2" alt="Product">
                                                        <div>Rau cải ngọt hữu cơ</div>
                                                    </div>
                                                </td>
                                                <td>Rau củ</td>
                                                <td>25,000 đ</td>
                                                <td>
                                                    <div class="progress" style="height: 6px;">
                                                        <div class="progress-bar bg-danger" style="width: 10%"></div>
                                                    </div>
                                                    <small class="text-muted">5 kg</small>
                                                </td>
                                                <td><span class="badge bg-danger">Sắp hết</span></td>
                                                <td>
                                                    <button class="btn btn-sm btn-outline-primary">Nhập thêm</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="https://via.placeholder.com/50" class="rounded me-2" alt="Product">
                                                        <div>Cà chua hữu cơ</div>
                                                    </div>
                                                </td>
                                                <td>Rau củ</td>
                                                <td>30,000 đ</td>
                                                <td>
                                                    <div class="progress" style="height: 6px;">
                                                        <div class="progress-bar bg-warning" style="width: 20%"></div>
                                                    </div>
                                                    <small class="text-muted">8 kg</small>
                                                </td>
                                                <td><span class="badge bg-warning text-dark">Sắp hết</span></td>
                                                <td>
                                                    <button class="btn btn-sm btn-outline-primary">Nhập thêm</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="https://via.placeholder.com/50" class="rounded me-2" alt="Product">
                                                        <div>Gạo lứt hữu cơ</div>
                                                    </div>
                                                </td>
                                                <td>Gạo & Ngũ cốc</td>
                                                <td>60,000 đ</td>
                                                <td>
                                                    <div class="progress" style="height: 6px;">
                                                        <div class="progress-bar bg-warning" style="width: 25%"></div>
                                                    </div>
                                                    <small class="text-muted">12 kg</small>
                                                </td>
                                                <td><span class="badge bg-warning text-dark">Sắp hết</span></td>
                                                <td>
                                                    <button class="btn btn-sm btn-outline-primary">Nhập thêm</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>