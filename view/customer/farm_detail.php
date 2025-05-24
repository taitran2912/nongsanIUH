<?php
include_once '../../controller/cProduct.php';
$p = new cProduct();
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "nongsan";

// Get farm ID from URL parameter
$farm_id = isset($_GET['id']) ? intval($_GET['id']) : 1; // Default to farm ID 1 if not specified

$idCate = isset($_GET['idCate']) ? $_GET['idCate'] : 0; 
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);


// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set character set
$conn->set_charset("utf8mb4");



// Get farm information
$farm_sql = "SELECT f.*, u.name as owner_name, u.phone, u.email,
             (SELECT COUNT(*) FROM products WHERE farm_id = f.id) as product_count
             FROM farms f 
             JOIN users u ON f.owner_id = u.id 
             WHERE f.id = $farm_id";
$farm_result = $conn->query($farm_sql);
$farm = $farm_result ? $farm_result->fetch_assoc() : null;

// Get products for this farm
$products_sql = "SELECT p.*, c.name as category_name, pi.img as product_image 
                FROM products p 
                JOIN categories c ON p.id_categories = c.id 
                LEFT JOIN product_images pi ON p.id = pi.product_id 
                WHERE p.farm_id = $farm_id 
                ORDER BY p.created_at DESC";
$products_result = $conn->query($products_sql);

// Get categories for this farm
$categories_sql = "SELECT DISTINCT c.id, c.name, COUNT(p.id) as product_count
                  FROM categories c
                  JOIN products p ON c.id = p.id_categories
                  WHERE p.farm_id = $farm_id
                  GROUP BY c.id
                  ORDER BY c.name";
$categories_result = $conn->query($categories_sql);
?>

<div class="container py-4">
    <!-- Shop Header -->
    <?php if ($farm): ?>
    <div class="shop-header">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="d-flex align-items-center">
                    <div>
                        <h2><?= htmlspecialchars($farm['shopname']) ?></h2>
                        <div class="d-flex align-items-center mt-1">
                            <span class="badge bg-success me-2">
                                <i class="fas fa-check-circle me-1"></i>Đã xác thực
                            </span>
                            <span class="text-muted">
                                <i class="fas fa-map-marker-alt me-1"></i><?= htmlspecialchars($farm['address']) ?>
                            </span>
                        </div>
                    </div>
                </div>
                
                <div class="shop-stats mt-2">
                    <div class="shop-stat">
                        <div class="shop-stat-value"><?= $farm['product_count'] ?></div>
                        <div class="shop-stat-label">Sản phẩm</div>
                    </div>
                    <div class="shop-stat">
                        <div class="shop-stat-value">4.8</div>
                        <div class="shop-stat-label">Đánh giá</div>
                    </div>
                    <div class="shop-stat">
                        <div class="shop-stat-value">95%</div>
                        <div class="shop-stat-label">Phản hồi</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 text-md-end">
                <p class="mb-2">
                    <i class="fas fa-phone-alt me-2"></i><?= htmlspecialchars($farm['phone'] ?? 'N/A') ?>
                </p>
                <p class="mb-3">
                    <i class="fas fa-envelope me-2"></i><?= htmlspecialchars($farm['email'] ?? 'info@nongsan.com') ?>
                </p>
                <div class="d-flex justify-content-md-end gap-2">
                    <button class="btn btn-chat">
                        <i class="fas fa-comments me-1"></i>Chat Ngay
                    </button>
                    <button class="btn btn-outline-primary">
                        <i class="fas fa-heart me-1"></i>Theo dõi
                    </button>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <div class="row">
        <!-- Categories Sidebar -->
        <div class="col-md-3">
            <div class="category-sidebar mb-4">
                <h5 class="mb-3">Danh mục sản phẩm</h5>
                <a href="?action=farm_detail&id=<?= $farm_id ?>" class="category-item  mb-2">
                    Tất cả sản phẩm <span class="float-end"><?= $farm['product_count'] ?? 0 ?></span>
                </a>
                <?php if ($categories_result && $categories_result->num_rows > 0): ?>
                    <?php while($category = $categories_result->fetch_assoc()): ?>
                        <a href="?action=farm_detail&id=<?= $farm_id ?>&idCate=<?= $category['id'] ?>" class="category-item mb-2">
                            <?= htmlspecialchars($category['name']) ?> <span class="float-end"><?= $category['product_count'] ?></span>
                        </a>
                    <?php endwhile; ?>
                <?php endif; ?>
            </div>

            <div class="category-sidebar">
                <h5 class="mb-3">Thông tin shop</h5>
                <p class="mb-2">
                    <i class="fas fa-store me-2 text-primary"></i>
                    <?= htmlspecialchars($farm['shopname'] ?? 'Chưa có') ?>
                </p>
                <p class="mb-2">
                    <i class="fas fa-user me-2 text-primary"></i>
                    <?= htmlspecialchars($farm['owner_name'] ?? 'N/A') ?>
                </p>
                <p class="mb-0">
                    <i class="fas fa-info-circle me-2 text-primary"></i>
                    <?= htmlspecialchars($farm['description'] ?? 'Chưa có mô tả') ?>
                </p>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="col-md-9">
                 <div class="row g-4">
                    <?php
                        // We need to modify the existing methods to support pagination
                        // Since we can't modify cProduct.php, we'll use a workaround with PHP's array_slice
                        
                      

                        if($idCate != 0){
                            $pd = $p->getByCategory($idCate, $farm_id);
                        } else {
                            $pd = $p->getProduct($farm_id);
                        }
                        
                        if($pd && $pd->num_rows > 0){
                            // Convert mysqli result to array for pagination
                            $products = [];
                            while($row = $pd->fetch_assoc()){
                                $products[] = $row;
                            }
                            
                            // Apply pagination to the array
                            $paginated_products = array_slice($products, $offset, $items_per_page);
                            
                            // Display paginated products
                            foreach($paginated_products as $row){
                                echo'
                                    <div class="col-md-4">
                                        <div class="product-card">
                                                <div class="product-thumb">
                                                    <img src="../../image/'.$row['img'].'" class="img-fluid" alt="'.$row['name'].'">
                                                    <div class="product-action">
                                                    <form action="" method="POST">
                                                        <input type="hidden" name="txtID" value="'.$row['id'].'">
                                                        <button type="submit" name="btnADD" class="btn btn-primary"><i class="fas fa-shopping-cart"></i></button>
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="product-info p-3">
                                                <span class="product-category">Rau củ</span>
                                                <h5><a href="?action=detail&id='.$row['id'].'" class="product-title">'.$row['name'].'</a></h5>
                                                <div class="product-price">
                                                    <span class="new-price">'.$row['price'].'đ/kg</span>
                                                </div>
                                                <div class="product-rating">
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star-half-alt"></i>
                                                    <span>(4.5)</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                ';
                            }
                        } else {
                            echo '<div class="col-12"><p class="text-center">Không tìm thấy sản phẩm nào.</p></div>';
                        }
                    ?>

                        <!-- Pagination -->
                        <?php if($total_pages > 1): ?>
                        <div class="pagination-container mt-5">
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
                        </div>
                        <?php endif; ?>
                    </div>
                </divc>
        </div>

        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<?php
// Close connection
$conn->close();
?>
