<?php
    // Tính doanh thu tháng này
    $tbl = $p->tinhTongDoanhThu($storeId);
    if ($tbl && $tbl->num_rows > 0) {
        $row = $tbl->fetch_assoc();
        $doanhthu = $row['doanhThu'] ?? 0;
    }
    // Tính số lượng đơn hàng
    $tbl = $p->tinhTongDonHang($storeId);
    if ($tbl && $tbl->num_rows > 0) {
        $row = $tbl->fetch_assoc();
        $tongDon = $row['DonHang'] ?? 0;
    }
    // Lấy tổng sản phẩm bán ra
    $tbl = $p->tinhTongSanPham($storeId);
    if ($tbl && $tbl->num_rows > 0) {
        $row = $tbl->fetch_assoc();
        $tongSP = $row['SanPham'] ?? 0;
    }

?>
<div class="tab-pane fade show active">
                        <!-- Stats Cards -->
                        <div class="row g-4 mb-4">
                            <div class="col-12 col-sm-6 col-md-4 col-lg-4">
                                <div class="card stat-card h-100">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="card-subtitle text-muted">Doanh thu</h6>
                                                <h3 class="card-title mb-0">
                                                    <?php echo is_numeric($doanhthu) ? number_format($doanhthu, 0, ',', '.') . " ₫" : $doanhthu; ?> 
                                                </h3>
                                            </div>
                                            <div class="stat-icon bg-primary-light text-primary">
                                                <i class="fas fa-money-bill-wave"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-sm-6 col-md-4 col-lg-4">
                                <div class="card stat-card h-100">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="card-subtitle text-muted">Đơn hàng</h6>
                                                <h3 class="card-title mb-0">
                                                    <?php echo is_numeric($tongDon) ? number_format($tongDon, 0, ',', '.') : $tongDon; ?>                       
                                                </h3>
                                                
                                            </div>
                                            <div class="stat-icon bg-success-light text-success">
                                                <i class="fas fa-shopping-bag"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!--  -->

                            <div class="col-12 col-sm-6 col-md-4 col-lg-4">
                                <div class="card stat-card h-100">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="card-subtitle text-muted">Sản phẩm</h6>
                                                <h3 class="card-title mb-0">
                                                    <?php echo is_numeric($tongSP) ? number_format($tongSP, 0, ',', '.') : $tongSP; ?>
                                                </h3>
                                               
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
                        <!-- <div class="row g-4 mb-4">
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
                        </div> -->

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
                                                
                                                <th>Ngày đặt</th>
                                                <th>Tổng tiền</th>
                                                <th>Trạng thái</th>
                                                <th>Thao tác</th>
                                            </tr>
                                        </thead>
                                        <tbody>
<?php
$dsDH = $p->dsDonHang($storeId);
if ($dsDH && $dsDH->num_rows > 0) {
    $limit = 5;
    $count = 0;
    while ($row = $dsDH->fetch_assoc()) {
        if ($count >= $limit) {
            break;
        }
        $status = $row['status'];
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

            echo '              
                                            <tr>
                                                <td>#'.$row['id'].'</td>
                                                <td>'.$row['order_date'].'</td>
                                                <td>'.$row['total_amount'].'</td>
                                                <td><span class="badge '.$color.'">'.$statusText.'</span></td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm" type="button" data-bs-toggle="dropdown">
                                                            <i class="fas fa-ellipsis-v"></i>
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li><a class="dropdown-item" href="?action=orderDetail&id='.$row['id'].'">Xem chi tiết</a></li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                    
            ';   
            $count++; 
    }
}                   
?>            

                                            
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
                                                <a href="">
                                                <td>
                                                    <div class="d-flex align-items-center">
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
                                                </a>
                                            </tr>
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>