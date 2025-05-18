<?php

$idCate = isset($_GET['idCate']) ? $_GET['idCate'] : 0; 
// Pagination settings
$items_per_page = 15;
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$current_page = max(1, $current_page); // Ensure page is at least 1

$all_products = $p->dsSP($storeId);


// First, get all products to count them
if($idCate != 0){
    $all_products = $p->dsSPnCate($storeId,$idCate);
} else {
    $all_products = $p->dsSP($storeId);
}

// Get total count from the result
$total_products = $all_products ? $all_products->num_rows : 0;

// Calculate total pages
$total_pages = ceil($total_products / $items_per_page);

// Ensure current page is within valid range
$current_page = min($current_page, max(1, $total_pages));

// Calculate offset for pagination
$offset = ($current_page - 1) * $items_per_page;
?>

<div class="product-management">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Quản lý sản phẩm</h2>
        <div>
            <button class="btn btn-outline-success me-2" id="exportProductsBtn">
                <i class="fas fa-file-export me-2"></i>Xuất Excel
            </button>
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addProductModal">
                <a href="?action=addProduct" class="text-white text-decoration-none">
                    <i class="fas fa-plus me-2"></i>Thêm sản phẩm
                </a>
            </button>
        </div>
    </div>

    <!-- Product Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <form id="productFilterForm">
                <div class="row g-3">
                    <div class="col-md-9">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                            <input type="text" class="form-control border-0 bg-light" id="searchProduct" placeholder="Tìm kiếm sản phẩm...">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="dropdown">
                            <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="dropdownCategoryButton" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-filter me-2"></i>Danh mục
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownCategoryButton">
                                <li><a class="dropdown-item" href="?action=product">Tất cả danh mục</a></li>
                                <?php
                                $danhmuc = " ";
                                $cate = $p->getAllCategory();
                                if($cate && $cate->num_rows > 0){
                                    while($row = $cate->fetch_assoc()){
                                        $idCate = isset($_GET['idCate']) ? $_GET['idCate'] : 0;
                                        if($row['id'] == $idCate){
                                            echo '<li><a class="dropdown-item active" href="?action=product&idCate='.$row['id'].'">'.ucwords($row['name']).'</a></li>';
                                        }else{
                                            echo '<li><a class="dropdown-item" href="?action=product&idCate='.$row['id'].'">'.ucwords($row['name']).'</a></li>';
                                        }
                                        $danhmuc .= $row['name'].", ";
                                    }
                                }
                                ?>
                                
                            </ul>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Products Table -->
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="productsTable">
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
                        <!-- Sản phẩm -->
<?php

if($idCate != 0){
    $listSP = $p->dsSPnCate($storeId,$idCate);
} else {
    $listSP = $p->dsSP($storeId);
}

// $listSP = $p->dsSP($storeId);

if($listSP && $listSP->num_rows > 0){
    // Convert mysqli result to array for pagination
    $products = [];
    while($row = $listSP->fetch_assoc()){
        $products[] = $row;
    }
    
    // Apply pagination to the array
    $paginated_products = array_slice($products, $offset, $items_per_page);
    
    // Display paginated products
    foreach($paginated_products as $row){
        $quantity = $row['quantity'];
        if ($quantity == 0) {
            $color = "bg-secondary";
            $statusText = "Đã hết hàng";
            $width = $quantity;
        } elseif ($quantity > 0 && $quantity <= 20) {
            $color = "bg-danger";
            $statusText = "Sắp hết";
            $width = $quantity;
        } elseif ($quantity > 20 && $quantity <= 40) {
            $color = "bg-warning";
            $statusText = "Còn ít";
            $width = $quantity;
        } elseif ($quantity > 40 && $quantity <= 50) {
            $color = "bg-success";
            $statusText = "Nên nhập hàng";
            $width = $quantity;
        }else {
            $color = "bg-success";
            $statusText = "Đủ hàng";
            if($quantity >= 100){
                $width = 100;
            }else{
                $width = $quantity; 
            }
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
                    <td>'.number_format($row['price'], 0, ',', '.').'đ/'.$row['unit'].'</td>
                    <td>
                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar '.$color.'" style="width: '.$width.'%"></div>
                        </div>
                        <small class="text-muted">'.$row['quantity'].' '.$row['unit'].'</small>
                    </td>
                    
                    <td><span class="badge '.$color.'">'. $statusText.'</span></td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-sm" type="button" data-bs-toggle="dropdown">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#viewProductModal" data-product-id="1"><i class="fas fa-eye me-2"></i>Xem chi tiết</a></li>
                                <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#editProductModal" data-product-id="1"><i class="fas fa-edit me-2"></i>Chỉnh sửa</a></li>
                                <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#restockModal" onclick="document.getElementById("productId").value="1""><i class="fas fa-plus-circle me-2"></i>Nhập thêm</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger" href="#" data-bs-toggle="modal" data-bs-target="#deleteProductModal" data-product-id="1"><i class="fas fa-trash-alt me-2"></i>Xóa</a></li>
                            </ul>
                        </div>
                    </td>
                </tr>
                                        
            ';
    }
}else{
    echo '
        <tr>
            <td colspan="6" class="text-center">Không có sản phẩm nào</td>
        </tr>
    ';
}
?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <div class="me-3">
                                Hiển thị <?php echo min(($current_page-1)*$items_per_page+1, $total_products); ?> - 
                                <?php echo min($current_page*$items_per_page, $total_products); ?> 
                                trên <?php echo $total_products; ?> sản phẩm
                    </div>
<!-- phân trang -->
                    <?php if($total_pages > 1): ?>
                        <nav aria-label="Page navigation">
                            <ul class="pagination justify-content-center">
                                <?php if($current_page > 1): ?>
                                    <li class="page-item">
                                        <a class="page-link" href="?action=product<?php echo $idCate != 0 ? '&idCate='.$idCate : ''; ?>&page=<?php echo $current_page-1; ?>" aria-label="Previous">
                                            <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>
                                <?php endif; ?>
                                <?php
                                // Display page numbers
                                $start_page = max(1, $current_page - 2);
                                $end_page = min($total_pages, $current_page + 2);
                                
                                // Always show first page
                                if($start_page > 1) {
                                    echo '<li class="page-item"><a class="page-link" href="?action=product'.($idCate != 0 ? '&idCate='.$idCate : '').'&page=1">1</a></li>';
                                    if($start_page > 2) {
                                        echo '<li class="page-item disabled"><a class="page-link" href="#">...</a></li>';
                                    }
                                }
                                
                                // Display page links
                                for($i = $start_page; $i <= $end_page; $i++) {
                                    $active = $i == $current_page ? 'active' : '';
                                    echo '<li class="page-item '.$active.'"><a class="page-link" href="?action=product'.($idCate != 0 ? '&idCate='.$idCate : '').'&page='.$i.'">'.$i.'</a></li>';
                                }
                                
                                // Always show last page
                                if($end_page < $total_pages) {
                                    if($end_page < $total_pages - 1) {
                                        echo '<li class="page-item disabled"><a class="page-link" href="#">...</a></li>';
                                    }
                                    echo '<li class="page-item"><a class="page-link" href="?action=product'.($idCate != 0 ? '&idCate='.$idCate : '').'&page='.$total_pages.'">'.$total_pages.'</a></li>';
                                }
                                ?>
                                
                                <?php if($current_page < $total_pages): ?>
                                    <li class="page-item">
                                        <a class="page-link" href="?action=product<?php echo $idCate != 0 ? '&idCate='.$idCate : ''; ?>&page=<?php echo $current_page+1; ?>" aria-label="Next">
                                            <span aria-hidden="true">&raquo;</span>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </nav>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modals -->
<!-- Thêm sản phẩm Modal -->
<?php include_once 'modals/dashboard_modal.php'; ?>

<!-- Xem chi tiết sản phẩm Modal -->
<?php include_once 'modals/detail_product.php'; ?>

<!-- Chỉnh sửa sản phẩm Modal -->
<?php include_once 'modals/edit_product.php'; ?>

<!-- Xóa sản phẩm Modal -->
<?php include_once 'modals/delete_product.php'; ?>

<!-- Nhập thêm sản phẩm Modal -->
<?php include_once 'modals/restock_product.php'; ?>
