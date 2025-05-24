<?php
include_once '../../controller/cOrder.php';
$p = new cOrder();

if(isset($_POST['btnChange'])) {
    $orID = $_POST['orderId'];
    $nStatus = $_POST['status']; 

    if($nStatus == 1){
        $remove = $p->infOr($orID); 
        if($remove && $remove->num_rows > 0) {
            while($row = $remove->fetch_assoc()) {
                $productId = $row['product_id'];
                $quantity = $row['slBan'];
                if($quantity > $row['slKho']) {
                    echo '<script>alert("Số lượng sản phẩm không đủ trong kho!");</script>';
                    return; // Dừng xử lý nếu số lượng không đủ
                }
                // Cập nhật số lượng sản phẩm trong kho
                $p->updateQLT($productId, $quantity);
            }  
        } 
    }

    $changeStatus = $nStatus + 1; // Tăng trạng thái đơn hàng lên 1

    // Xử lý xác nhận đơn hàng
    if($p->changeOrder($orID, $changeStatus)) {
        echo '<script>alert("Đơn hàng đã được xác nhận thành công!");</script>';
    } else {
        echo '<script>alert("Xác nhận đơn hàng thất bại!");</script>';
    }
}
?>

<div class="order-management">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Quản lý đơn hàng</h2>
    </div>

    <!-- Orders Table -->
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="ordersTable">
                    <thead class="table-light">
                        <tr>
                            
                            <th>Mã đơn hàng</th>
                            <th>Khách hàng</th>
                            <th>Ngày đặt</th>
                            <th>Tổng tiền</th>
                            <th>Trạng thái</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Đơn hàng 1 -->
<?php
    $order = $p -> checkOrder($storeId);
    if ($order && $order->num_rows > 0) {
        while ($row = $order->fetch_assoc()) {
            // Hiển thị thông tin đơn hàng
            $status = $row['status'];
        // $notes = $rowOders['notes'];
            switch ($status) {
                case 1:
                    $color = "bg-warning";
                    $statusText = "Chuẩn bị hàng";
                    $nextAction = "Đang giao";
                    break;
                case 2:
                    $color = "bg-success";
                    $statusText = "Đang giao";
                    $nextAction = "Giao thành công";
                    break;
                case 3:
                    $color = "bg-danger";
                    $statusText = "Đã giao hàng";
                    break;
                case 4:
                    $color = "bg-dark";
                    $statusText = "Đã hủy";
                    $nextAction = "text-danger";
                    break;
                default:
                    $color = "bg-secondary";
                    $statusText = "Đơn lỗi";
                    $nextAction = "text-muted";

                }
            echo '
                        <tr>
                            <td><a href="#" class="fw-medium text-decoration-none">#'.$row['id'].'</a></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    
                                    <div>
                                        <div class="fw-medium">'.$row['name'].'</div>
                                        <div class="small text-muted">'.$row['phone'].'</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div>'.$row['order_date'].'</div>
                                
                            </td>
                            <td>
                                <div class="fw-medium">'.$row['total_amount'].'đ</div>
                                <div class="small text-muted">'.$row['totalProducts'].' sản phẩm</div>
                                <!-- Nút bấm hiển thị sản phẩm -->
                                <button class="btn btn-sm btn-link text-primary p-0 mt-1" type="button" 
                                        data-bs-toggle="collapse" 
                                        data-bs-target="#productListORD'.$row['id'].'" 
                                        aria-expanded="false" 
                                        aria-controls="productListORD'.$row['id'].'">
                                    Xem sản phẩm
                                </button>
                            </td>
                            <td><span class="badge '.$color.'">'.$statusText.'</span></td>';
            if($status == 1 || $status == 2){
            echo'           <td>
                                <div>
                                    <form action="" method="post">
                                        <input type="hidden" name="orderId" value="'.$row['id'].'">
                                        <input type="hidden" name="status" value="'.$row['status'].'">
                                        <button type="submit" name="btnChange" class="btn btn-sm btn-primary">'.$nextAction.'</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                ';
            } else {
            echo'           <td>
                                <div class="'.$nextAction.'">'.$statusText.'</div>
                            </td>
                        </tr>
                ';
            }

            echo'
                <tr class="collapse" id="productListORD'.$row['id'].'">
                    <td colspan="7">
                        <table class="table table-sm table-bordered mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Tên sản phẩm</th>
                                    <th>Số lượng</th>
                                    <th>Giá</th>
                                    <th>Tổng tiền</th>
                                </tr>
                            </thead>
                            <tbody>
            ';
            // Lấy thông tin chi tiết đơn hàng
            $orderDetails = $p->getProduct($row['id']);
            if ($orderDetails && $orderDetails->num_rows > 0) {
                $count = 1;
                while ($detail = $orderDetails->fetch_assoc()) {
                    $total = $detail['quantity'] * $detail['price'];
                    echo '
                        <tr>
                            <td>'.$count.'</td>
                            <td>'.$detail['name'].'</td>
                            <td>'.$detail['quantity'].'</td>
                            <td>'.number_format($detail['price']).' đ</td>
                            <td>'.number_format($total).' đ</td>
                        </tr>
                    ';
                    $count++;
                }
            }
            echo '
                            </tbody>
                        </table>
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
</div>
