<?php
$location = 'product';
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

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action_type'])) {
    $action = $_POST['action_type'];

    if ($action === 'restock' && isset($_POST['product_id'], $_POST['restock_quantity'])) {
        $productId = intval($_POST['product_id']);
        $restockQuantity = intval($_POST['restock_quantity']);

        if ($p->updateProductQuantity($productId, $restockQuantity)) {
            echo '<script>alert("Cập nhật số lượng thành công!");</script>';
        } else {
            echo '<script>alert("Cập nhật số lượng thất bại!");</script>';
        }
    }

    if ($action === 'update' && isset($_POST['product_id'])) {
        $product_id = intval($_POST['product_id']);
        $name = trim($_POST['product_name']);
        $category = intval($_POST['product_category']);
        $price = floatval($_POST['product_price']);
        $quantity = intval($_POST['product_stock']);
        $description = trim($_POST['product_description']);
        $unit = trim($_POST['product_unit']);

        // Nếu có upload hình ảnh mới
        if (isset($_FILES['product_image']) && $_FILES['product_image']['error'][0] == 0) {
            foreach ($_FILES['product_image']['tmp_name'] as $key => $tmpName) {
                $fileName = $_FILES['product_image']['name'][$key];
                $fileTmp = $_FILES['product_image']['tmp_name'][$key];
                $filePath = "image/" . basename($fileName);

                move_uploaded_file($fileTmp, $filePath);
                // Ghi vào DB nếu cần
            }
        }

        if ($p->updateProduct($product_id, $name, $category, $price, $quantity, $description, $unit)) {
            echo "<script>alert('Cập nhật sản phẩm thành công');</script>";
        } else {
            echo "<script>alert('Cập nhật sản phẩm thất bại');</script>";
        }
    }
}

    
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
                                <li><a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#viewProductModal" onclick="loadProductDetails(' . $row['id'] . ')">Xem chi tiết</a></li>
                                <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#editProductModal" data-product-id="'.$row['id'].'"><i class="fas fa-edit me-2"></i>Chỉnh sửa</a></li>
                                <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#restockModal" onclick="document.getElementById(\'productId\').value=\''.$row['id'].'\'"><i class="fas fa-plus-circle me-2"></i>Nhập thêm</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger" href="#" data-bs-toggle="modal" data-bs-target="#deleteProductModal" data-product-id="'.$row['id'].'"><i class="fas fa-trash-alt me-2"></i>Xóa</a></li>
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


<script>
// Handle the click event for the edit product button
function loadProductDetails(productId) {
fetch('JSON/get_product.php?id=' + productId)
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const product = data.product;
            document.getElementById('productName').innerText = product.name;
            document.getElementById('productDescription').innerText = product.description;
            document.getElementById('productPrice').innerText = Number(product.price).toLocaleString();
            document.getElementById('productQuantity').innerText = product.quantity;
            document.getElementById('productUnit').innerText = product.unit;
            document.getElementById('productCreatedAt').innerText = product.created_at;
        } else {
            alert('Không tìm thấy sản phẩm!');
        }
    })
    .catch(err => {
        console.error(err);
        alert('Đã xảy ra lỗi khi lấy thông tin sản phẩm.');
    });
}


// Hàm tải danh mục sản phẩm
function loadCategories(selectedCategory = '') {
    fetch('JSON/get_categories.php')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const select = document.getElementById('editProductCategory');
                select.innerHTML = '<option value="">Chọn danh mục</option>'; // Xóa các option cũ

                data.categories.forEach(cat => {
                    const option = document.createElement('option');
                    option.value = cat.id;
                    option.textContent = cat.name;
                    if (cat.id === selectedCategory) {
                        option.selected = true;
                    }
                    select.appendChild(option);
                });
            } else {
                console.error('Không thể tải danh mục:', data.message);
            }
        })
        .catch(err => {
            console.error('Lỗi khi tải danh mục:', err);
        });
}

// Hàm tải thông tin sản phẩm để chỉnh sửa

function loadProductToEdit(productId) {
    // Hiển thị loading indicator
    const loadingIndicator = document.createElement('div');
    loadingIndicator.id = 'loadingIndicator';
    loadingIndicator.className = 'position-fixed top-0 start-0 w-100 h-100 d-flex justify-content-center align-items-center bg-white bg-opacity-75';
    loadingIndicator.style.zIndex = '9999';
    loadingIndicator.innerHTML = '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Đang tải...</span></div>';
    document.body.appendChild(loadingIndicator);
    
    fetch('JSON/get_product.php?id=' + productId)
        .then(response => response.json())
        .then(data => {
            // Xóa loading indicator
            document.getElementById('loadingIndicator')?.remove();
            
            if (data.success) {
                const product = data.product;
                
                // Log để debug
                console.log('Dữ liệu sản phẩm:', product);
                
                // Điền thông tin sản phẩm vào form
                document.getElementById('editProductId').value = product.id;
                document.getElementById('editProductName').value = product.name;
                document.getElementById('editProductDescription').value = product.description;
                document.getElementById('editProductPrice').value = product.price;
                document.getElementById('editProductStock').value = product.quantity;
                
                // Chọn đơn vị
                const unitSelect = document.getElementById('editProductUnit');
                for (let i = 0; i < unitSelect.options.length; i++) {
                    if (unitSelect.options[i].value === product.unit) {
                        unitSelect.selectedIndex = i;
                        break;
                    }
                }
                
                // Tải danh mục và chọn danh mục hiện tại của sản phẩm
                loadCategories(product.category_id);
                
                // Hiển thị modal
                const editModal = new bootstrap.Modal(document.getElementById('editProductModal'));
                editModal.show();
                
                // Tải hình ảnh sản phẩm sau khi modal đã hiển thị
                loadProductImages(product.id, 'currentProductImages');
            } else {
                alert('Không tìm thấy sản phẩm: ' + data.message);
            }
        })
        .catch(err => {
            // Xóa loading indicator nếu có lỗi
            document.getElementById('loadingIndicator')?.remove();
            
            console.error('Lỗi khi tải sản phẩm:', err);
            alert('Đã xảy ra lỗi khi tải thông tin sản phẩm.');
        });
}

/**
 * Hàm tải và hiển thị hình ảnh sản phẩm
 * @param {number} productId - ID của sản phẩm
 * @param {string} containerId - ID của container để hiển thị hình ảnh
 */
function loadProductImages(productId, containerId = 'currentProductImages') {
    // Lấy container để hiển thị hình ảnh
    const imagesContainer = document.getElementById(containerId);
    if (!imagesContainer) {
        console.error(`Không tìm thấy container với ID: ${containerId}`);
        return;
    }

    // Hiển thị loading
    imagesContainer.innerHTML = '<div class="text-center"><div class="spinner-border spinner-border-sm text-primary" role="status"><span class="visually-hidden">Đang tải...</span></div></div>';

    // Gọi API để lấy hình ảnh
    fetch(`JSON/get_product_images.php?id=${productId}`)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            // Xóa loading
            imagesContainer.innerHTML = '';

            if (data.success) {
                if (data.images && data.images.length > 0) {
                    // Hiển thị hình ảnh
                    data.images.forEach(image => {
                        const imgContainer = document.createElement('div');
                        imgContainer.className = 'position-relative me-2 mb-2';
                        imgContainer.innerHTML = `
                            <img src="${image.url}" class="img-thumbnail" alt="Product Image" 
                                 style="width: 100px; height: 100px; object-fit: cover;">
                            <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0" 
                                    style="padding: 0 5px;" onclick="removeProductImage(${image.id}, '${image.img}')">
                                <i class="fas fa-times"></i>
                            </button>
                        `;
                        imagesContainer.appendChild(imgContainer);
                    });
                } else {
                    // Hiển thị thông báo không có hình ảnh
                    imagesContainer.innerHTML = `
                        <div class="text-center text-muted">
                            <img src="../../image/no-image.png" class="img-thumbnail" alt="No Image" 
                                 style="width: 100px; height: 100px; object-fit: cover;">
                            <p class="small mt-2">Chưa có hình ảnh</p>
                        </div>
                    `;
                }
            } else {
                // Hiển thị thông báo lỗi
                imagesContainer.innerHTML = `
                    <div class="alert alert-danger" role="alert">
                        ${data.message || 'Không thể tải hình ảnh'}
                    </div>
                `;
            }
        })
        .catch(error => {
            console.error('Lỗi khi tải hình ảnh:', error);
            
            // Hiển thị thông báo lỗi
            imagesContainer.innerHTML = `
                <div class="alert alert-danger" role="alert">
                    Đã xảy ra lỗi khi tải hình ảnh: ${error.message}
                </div>
            `;
        });
}

/**
 * Hàm xóa hình ảnh sản phẩm
 * @param {number} imageId - ID của hình ảnh
 * @param {string} imageName - Tên file hình ảnh
 */
function removeProductImage(imageId, imageName) {
    if (!confirm('Bạn có chắc chắn muốn xóa hình ảnh này?')) {
        return;
    }

    // Hiển thị loading trên nút xóa
    const button = event.target.closest('button');
    const originalContent = button.innerHTML;
    button.disabled = true;
    button.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';

    // Gọi API để xóa hình ảnh
    fetch('JSON/delete-product-image.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            image_id: imageId,
            image_name: imageName
        })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            // Xóa phần tử DOM
            const imageElement = button.closest('.position-relative');
            imageElement.remove();
            
            // Hiển thị thông báo thành công
            showToast('Thành công', 'Đã xóa hình ảnh thành công', 'success');
        } else {
            // Khôi phục nút
            button.disabled = false;
            button.innerHTML = originalContent;
            
            // Hiển thị thông báo lỗi
            showToast('Lỗi', data.message || 'Không thể xóa hình ảnh', 'danger');
        }
    })
    .catch(error => {
        console.error('Lỗi khi xóa hình ảnh:', error);
        
        // Khôi phục nút
        button.disabled = false;
        button.innerHTML = originalContent;
        
        // Hiển thị thông báo lỗi
        showToast('Lỗi', `Đã xảy ra lỗi khi xóa hình ảnh: ${error.message}`, 'danger');
    });
}

/**
 * Hàm hiển thị thông báo toast
 * @param {string} title - Tiêu đề thông báo
 * @param {string} message - Nội dung thông báo
 * @param {string} type - Loại thông báo (success, danger, warning, info)
 */
function showToast(title, message, type = 'info') {
    // Kiểm tra xem container toast đã tồn tại chưa
    let toastContainer = document.querySelector('.toast-container');
    
    if (!toastContainer) {
        // Tạo container nếu chưa tồn tại
        toastContainer = document.createElement('div');
        toastContainer.className = 'toast-container position-fixed bottom-0 end-0 p-3';
        document.body.appendChild(toastContainer);
    }
    
    // Tạo ID duy nhất cho toast
    const toastId = 'toast-' + Date.now();
    
    // Tạo HTML cho toast
    const toastHTML = `
        <div id="${toastId}" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header bg-${type} text-white">
                <strong class="me-auto">${title}</strong>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                ${message}
            </div>
        </div>
    `;
    
    // Thêm toast vào container
    toastContainer.insertAdjacentHTML('beforeend', toastHTML);
    
    // Khởi tạo và hiển thị toast
    const toastElement = document.getElementById(toastId);
    const toast = new bootstrap.Toast(toastElement, {
        autohide: true,
        delay: 5000
    });
    toast.show();
    
    // Xóa toast sau khi ẩn
    toastElement.addEventListener('hidden.bs.toast', function () {
        toastElement.remove();
    });
}

// Thêm sự kiện cho các nút chỉnh sửa sản phẩm
document.addEventListener('DOMContentLoaded', function() {
    // Tìm tất cả các nút chỉnh sửa sản phẩm
    const editButtons = document.querySelectorAll('[data-bs-target="#editProductModal"]');
    
    editButtons.forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.getAttribute('data-product-id');
            loadProductToEdit(productId);
        });
    });
});

// Giải pháp toàn diện để xử lý vấn đề modal backdrop
document.addEventListener('DOMContentLoaded', function() {
    // 1. Xóa tất cả backdrop hiện tại nếu có
    function cleanupModals() {
        document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
        document.body.classList.remove('modal-open');
        document.body.style.overflow = '';
        document.body.style.paddingRight = '';
    }
    
    // Thực hiện cleanup khi trang tải xong
    cleanupModals();
    
    // 2. Ghi đè phương thức ẩn modal của Bootstrap
    if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
        const originalHide = bootstrap.Modal.prototype.hide;
        bootstrap.Modal.prototype.hide = function() {
            originalHide.apply(this, arguments);
            
            // Đảm bảo xóa backdrop sau khi animation kết thúc
            setTimeout(cleanupModals, 300);
        };
    }
    
    // 3. Xử lý tất cả các nút đóng modal
    document.querySelectorAll('[data-bs-dismiss="modal"]').forEach(button => {
        button.addEventListener('click', function() {
            setTimeout(cleanupModals, 300);
        });
    });
    
    // 4. Xử lý sự kiện khi modal được ẩn
    document.querySelectorAll('.modal').forEach(modal => {
        modal.addEventListener('hidden.bs.modal', function() {
            setTimeout(cleanupModals, 300);
        });
    });
    
    // 5. Xử lý sự kiện khi người dùng nhấn ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            setTimeout(cleanupModals, 300);
        }
    });
    
    // 6. Xử lý sự kiện khi người dùng click vào backdrop
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('modal-backdrop')) {
            setTimeout(cleanupModals, 300);
        }
    });
    
    // 7. Thêm phím tắt khẩn cấp Alt+Z
    document.addEventListener('keydown', function(e) {
        if (e.altKey && e.key === 'z') {
            cleanupModals();
            
            // Đóng tất cả các modal đang mở
            document.querySelectorAll('.modal.show').forEach(modal => {
                const modalInstance = bootstrap.Modal.getInstance(modal);
                if (modalInstance) {
                    modalInstance.hide();
                } else {
                    modal.classList.remove('show');
                    modal.style.display = 'none';
                }
            });
        }
    });
});

// Thêm hàm global để xử lý trường hợp khẩn cấp
window.fixModalBackdrop = function() {
    document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
    document.body.classList.remove('modal-open');
    document.body.style.overflow = '';
    document.body.style.paddingRight = '';
    
    // Đóng tất cả các modal đang mở
    document.querySelectorAll('.modal.show').forEach(modal => {
        modal.classList.remove('show');
        modal.style.display = 'none';
    });
};
</script>
