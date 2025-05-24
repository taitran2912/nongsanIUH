<?php
    $location = 'dashboard';
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

    $localtion = 'dashboard';

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'], $_POST['restock_quantity'])) {
    $productId = intval($_POST['product_id']);
    $restockQuantity = intval($_POST['restock_quantity']);
    }
    if (isset($productId) && isset($restockQuantity)) {
        if($p->updateProductQuantity($productId, $restockQuantity)){
            echo '<script>alert("Cập nhật thành công!");</script>';
        } else {
            echo '<script>alert("Cập nhật thất bại!");</script>';
        }
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
                                <a href="?action=order" class="btn btn-sm btn-outline-success" data-bs-toggle="tab">Xem tất cả</a>
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
                case 1:
                    $color = "bg-warning";
                    $statusText = "Chờ xác nhận";
                    break;
                case 2:
                    $color = "bg-success";
                    $statusText = "Đang giao";
                    break;
                case 3:
                    $color = "bg-primary";
                    $statusText = "Đã giao";
                    break;
                case 4:
                    $color = "bg-dark";
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
                                                <td>'.number_format($row['total_amount'], 0, ',', '.').'đ</td>
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
                                <a href="?action=product" class="btn btn-sm btn-outline-success" data-bs-toggle="tab">Quản lý kho</a>
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
                                            
<?php
$lSPGanHet = $p->dsSPGanHet($storeId);
if ($lSPGanHet && $lSPGanHet->num_rows > 0) {
    while ($row = $lSPGanHet->fetch_assoc()) {
        $quantity = $row['quantity'];
        if ($quantity == 0) {
            $color = "bg-secondary";
            $statusText = "Đã hết hàng";
            $width = 0;
        } elseif ($quantity > 0 && $quantity <= 20) {
            $color = "bg-danger";
            $statusText = "Sắp hết";
            $width = 10;
        } elseif ($quantity > 20 && $quantity <= 40) {
            $color = "bg-warning";
            $statusText = "Còn ít";
            $width = 25;
        } elseif ($quantity > 40 && $quantity <= 50) {
            $color = "bg-success";
            $statusText = "Nên nhập hàng";
            $width = 35;
        }

        // $notes = $rowOders['notes'];

            echo '
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div>'.ucwords($row['name']).'</div>
                                                    </div>
                                                </td>
                                                <td>'.ucwords($row['c_name']).'</td>
                                                <td>'.number_format($row['price'], 0, ',', '.').'đ</td>
                                                <td>
                                                    <div class="progress" style="height: 6px;">
                                                        <div class="progress-bar '.$color.'" style="width: '.$width.'%"></div>
                                                    </div>
                                                    <small class="text-muted">'.$row['quantity'].' '.$row['unit'].'</small>
                                                </td>
                                                <td><span class="badge '.$color.'">'.$statusText.'</span></td>
                                                <td>
                                                    <button class="btn btn-sm btn-outline-primary restock-btn" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#restockModal"
                                                            data-product-id="'.$row['id'].'"
                                                            data-product-name="'.$row['name'].'"
                                                            data-unit="'.$row['unit'].'">
                                                        Nhập thêm
                                                    </button>
                                                </td>
                                            </tr>
            ';
    }
}
?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <?php include_once 'modals/dashboard_modal.php'; ?>
                    </div>
 <?php
    // echo '<h1>'.$productId.'</h1>
    // <h1>'.$restockQuantity.'</h1>';
    // if (isset($productId) && isset($restockQuantity)) {
    //     if($p->updateProductQuantity($productId, $restockQuantity)){
    //         echo '<script>alert("Cập nhật thành công!");</script>';
    //     } else {
    //         echo '<script>alert("Cập nhật thất bại!");</script>';
    //     }
    // }
?> 

