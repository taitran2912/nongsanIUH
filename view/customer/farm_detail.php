<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "nongsan";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set character set
$conn->set_charset("utf8mb4");

// Get farm ID from URL parameter
$farm_id = isset($_GET['id']) ? intval($_GET['id']) : 1; // Default to farm ID 1 if not specified

// Get farm information
$farm_sql = "SELECT f.*, u.name as owner_name, u.phone, u.email,
             (SELECT COUNT(*) FROM products WHERE farm_id = f.id) as product_count
             FROM farms f 
             JOIN users u ON f.owner_id = u.id 
             WHERE f.id = $farm_id";
$farm_result = $conn->query($farm_sql);
$farm = $farm_result->fetch_assoc();

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

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($farm['shopname']) ?> - Thông tin Shop</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../../asset/css/farm_detail.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-leaf me-2"></i>Nông Sản Xanh
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Trang chủ</a>
                    </li>
                    
                </ul>
            </div>
        </div>
    </nav>

    <div class="container py-4">
        <!-- Shop Header -->
        <div class="shop-header">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="d-flex align-items-center">
                        <img src="images/farm<?= $farm_id ?>.jpg" alt="<?= htmlspecialchars($farm['shopname']) ?>" class="shop-avatar me-3" onerror="this.src='images/farm-placeholder.jpg'">
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
                    
                    <div class="shop-stats">
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
                        <i class="fas fa-phone-alt me-2"></i><?= htmlspecialchars($farm['phone']) ?>
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

        <div class="row">
            <!-- Categories Sidebar -->
            <div class="col-md-3">
                <div class="category-sidebar">
                    <h5 class="mb-3">Danh mục sản phẩm</h5>
                    <a href="farm_shop.php?id=<?= $farm_id ?>" class="category-item active mb-2">
                        Tất cả sản phẩm <span class="float-end"><?= $farm['product_count'] ?></span>
                    </a>
                    <?php while($category = $categories_result->fetch_assoc()): ?>
                        <a href="farm_shop.php?id=<?= $farm_id ?>&category=<?= $category['id'] ?>" class="category-item mb-2">
                            <?= htmlspecialchars($category['name']) ?> <span class="float-end"><?= $category['product_count'] ?></span>
                        </a>
                    <?php endwhile; ?>
                </div>
                
                <div class="category-sidebar">
                    <h5 class="mb-3">Thông tin shop</h5>
                    <p class="mb-2">
                        <i class="fas fa-store me-2 text-primary"></i>
                        <?= htmlspecialchars($farm['shopname']) ?>
                    </p>
                    <p class="mb-2">
                        <i class="fas fa-user me-2 text-primary"></i>
                        <?= htmlspecialchars($farm['owner_name']) ?>
                    </p>
                    <p class="mb-2">
                        <i class="fas fa-calendar-alt me-2 text-primary"></i>
                        Tham gia: 01/01/2025
                    </p>
                    <p class="mb-0">
                        <i class="fas fa-info-circle me-2 text-primary"></i>
                        <?= htmlspecialchars($farm['description']) ?>
                    </p>
                </div>
            </div>
            
            <!-- Products Grid -->
            <div class="col-md-9">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4>Sản phẩm của shop</h4>
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            Sắp xếp theo
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Phổ biến nhất</a></li>
                            <li><a class="dropdown-item" href="#">Mới nhất</a></li>
                            <li><a class="dropdown-item" href="#">Giá: Thấp đến cao</a></li>
                            <li><a class="dropdown-item" href="#">Giá: Cao đến thấp</a></li>
                        </ul>
                    </div>
                </div>
                
                <?php if($products_result->num_rows > 0): ?>
                    <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 g-3">
                        <?php while($product = $products_result->fetch_assoc()): ?>
                            <div class="col">
                                <div class="product-card">
                                    <a href="product_detail.php?id=<?= $product['id'] ?>">
                                        <img src="images/<?= htmlspecialchars($product['product_image']) ?>" 
                                             class="product-image w-100" 
                                             alt="<?= htmlspecialchars($product['name']) ?>"
                                             onerror="this.src='images/placeholder.jpg'">
                                    </a>
                                    <div class="p-3">
                                        <span class="badge product-category mb-2"><?= htmlspecialchars($product['category_name']) ?></span>
                                        <h5 class="product-title">
                                            <a href="product_detail.php?id=<?= $product['id'] ?>" class="text-decoration-none text-dark">
                                                <?= htmlspecialchars($product['name']) ?>
                                            </a>
                                        </h5>
                                        <div class="d-flex justify-content-between align-items-center mt-2">
                                            <span class="product-price"><?= number_format($product['price'], 0, ',', '.') ?>đ</span>
                                            <span class="text-muted small">Đã bán: 120</span>
                                        </div>
                                        <div class="d-flex align-items-center mt-2">
                                            <div class="text-warning me-1">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star-half-alt"></i>
                                            </div>
                                            <span class="text-muted small">(45)</span>
                                        </div>
                                        <div class="d-grid gap-2 mt-3">
                                            <button class="btn btn-primary btn-sm">
                                                <i class="fas fa-cart-plus me-1"></i>Thêm vào giỏ
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                    
                    <!-- Pagination -->
                    <nav class="mt-4">
                        <ul class="pagination justify-content-center">
                            <li class="page-item disabled">
                                <a class="page-link" href="#"><i class="fas fa-chevron-left"></i></a>
                            </li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#"><i class="fas fa-chevron-right"></i></a>
                            </li>
                        </ul>
                    </nav>
                <?php else: ?>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>Không có sản phẩm nào từ farm này.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5>Nông Sản Xanh</h5>
                    <p>Cung cấp nông sản sạch từ nông trại đến bàn ăn của bạn.</p>
                    <div class="d-flex gap-3 mt-3">
                        <a href="#" class="text-white"><i class="fab fa-facebook fa-lg"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-instagram fa-lg"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-youtube fa-lg"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-tiktok fa-lg"></i></a>
                    </div>
                </div>
                <div class="col-md-2">
                    <h5>Liên kết</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-decoration-none text-white">Trang chủ</a></li>
                        <li><a href="#" class="text-decoration-none text-white">Sản phẩm</a></li>
                        <li><a href="#" class="text-decoration-none text-white">Farms</a></li>
                        <li><a href="#" class="text-decoration-none text-white">Về chúng tôi</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h5>Danh mục</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-decoration-none text-white">Rau củ</a></li>
                        <li><a href="#" class="text-decoration-none text-white">Trái cây</a></li>
                        <li><a href="#" class="text-decoration-none text-white">Gia vị</a></li>
                        <li><a href="#" class="text-decoration-none text-white">Sản phẩm chế biến</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h5>Liên hệ</h5>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-map-marker-alt me-2"></i> 123 Đường ABC, TP.HCM</li>
                        <li><i class="fas fa-phone me-2"></i> (123) 456-7890</li>
                        <li><i class="fas fa-envelope me-2"></i> info@nongsanxanh.com</li>
                    </ul>
                </div>
            </div>
            <hr>
            <div class="text-center">
                <p class="mb-0">&copy; 2025 Nông Sản Xanh. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
// Close connection
$conn->close();
?>