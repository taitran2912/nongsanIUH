<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "nongsan";

include_once("../../model/connect.php");
// Kết nối CSDL
// $conn = mysqli_connect("localhost", "root", "", "nongsan");
$kn = new clsketnoi();
$conn = $kn->moKetNoi();
$conn->set_charset('utf8');

// Lấy ID sản phẩm từ URL
$product_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Truy vấn thông tin sản phẩm
$sql = "SELECT p.*, c.name as category_name, f.shopname as farm_name, f.id as farm_id, pi.img as img
        FROM products p 
        JOIN product_images pi ON p.id = pi.product_id
        JOIN categories c ON p.id_categories = c.id 
        JOIN farms f ON p.farm_id = f.id 
        WHERE p.id = $product_id";
$result = mysqli_query($conn, $sql);
$product = mysqli_fetch_assoc($result);

// Truy vấn hình ảnh sản phẩm
$sql_images = "SELECT * FROM product_images WHERE product_id = $product_id";
$result_images = mysqli_query($conn, $sql_images);
$product_images = [];
while ($row = mysqli_fetch_assoc($result_images)) {
    $product_images[] = $row;
}

// Truy vấn sản phẩm liên quan
$category_id = $product['id_categories'];
$sql_related = "SELECT p.*, pi.img 
                FROM products p 
                LEFT JOIN product_images pi ON p.id = pi.product_id 
                WHERE p.id_categories = $category_id AND p.id != $product_id 
                GROUP BY p.id 
                LIMIT 6";
$result_related = mysqli_query($conn, $sql_related);
$related_products = [];
while ($row = mysqli_fetch_assoc($result_related)) {
    $related_products[] = $row;
}
//đánh giá
$sql_reviews = "SELECT r.*, u.name as user_name 
                FROM reviews r 
                JOIN users u ON r.buyer_id = u.id 
                WHERE r.product_id = ? 
                ORDER BY r.reviewed_at DESC";
$stmt = $conn->prepare($sql_reviews);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$reviews_result = $stmt->get_result();
$reviews = [];
while ($row = $reviews_result->fetch_assoc()) {
    $reviews[] = $row;
}

$category_id = $product['id_categories'];
$sql_related = "SELECT p.*, pi.img 
                FROM products p 
                LEFT JOIN product_images pi ON p.id = pi.product_id 
                WHERE p.id_categories = ? AND p.id != ? 
                GROUP BY p.id 
                LIMIT 6";
$stmt = $conn->prepare($sql_related);
$stmt->bind_param("ii", $category_id, $product_id);
$stmt->execute();
$related_result = $stmt->get_result();
$related_products = [];
while ($row = $related_result->fetch_assoc()) {
    $related_products[] = $row;
}
?>

    <!-- Product Detail -->
    <div class="container my-4">
        <div class="row">
            <!-- Product Images -->
            <div class="col-md-5">
                <div class="product-image mb-3">
                    <img src="../../image/<?php echo $product['img']; ?>" id="main-image" class="img-fluid border" alt="<?php echo $product['name']; ?>">
                </div>
                
                <?php if (!empty($images)): ?>
                <div class="product-thumbnails d-flex flex-wrap">
                    <?php foreach ($images as $index => $image): ?>
                    <div class="p-1">
                        <img src="<?php echo $image['image_url']; ?>" 
                             class="<?php echo $index === 0 ? 'active' : ''; ?>"
                             onclick="changeImage('<?php echo $image['image_url']; ?>', this)" 
                             alt="<?php echo $product['name']; ?>">
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
            
            <!-- Product Info -->
            <div class="col-md-7">
                <h1 class="mb-3"><?php echo $product['name']; ?></h1>
                
                <div class="d-flex align-items-center mb-3">
                    <div class="product-rating me-3">
                        <?php
                        $rating = $product['rating'] ?? 0;
                        for ($i = 1; $i <= 5; $i++) {
                            if ($i <= $rating) {
                                echo '<i class="fas fa-star"></i>';
                            } else if ($i - 0.5 <= $rating) {
                                echo '<i class="fas fa-star-half-alt"></i>';
                            } else {
                                echo '<i class="fas fa-star gray"></i>';
                            }
                        }
                        ?>
                    </div>
                    <span class="text-muted"><?php echo $product['review_count'] ?? 0; ?> đánh giá</span>
                    <span class="mx-3">|</span>
                    <span class="text-muted"><?php echo $product['sold_count'] ?? 0; ?> đã bán</span>
                </div>
                
                <div class="mb-4">
                    <span class="product-price"><?php echo number_format($product['price'], 0, ',', '.'); ?>đ/<?php echo $product['unit']; ?></span>
                    <?php if (isset($product['original_price']) && $product['original_price'] > $product['price']): ?>
                    <span class="product-original-price"><?php echo number_format($product['original_price'], 0, ',', '.'); ?>đ</span>
                    <span class="product-discount">-<?php echo round((($product['original_price'] - $product['price']) / $product['original_price']) * 100); ?>%</span>
                    <?php endif; ?>
                </div>
                
                <div class="mb-4">
                    <h5>Mô tả:</h5>
                    <p><?php echo $product['description']; ?></p>
                </div>
                
                <div class="mb-4">
                    <h5>Số lượng:</h5>
                    <div class="d-flex align-items-center">
                        <input type="number" id="quantity" class="form-control mx-2 quantity-input" value="1" min="1">
                        <span class="ms-3 text-muted">Còn <?php echo $product['quantity']; ?> <?php echo $product['unit']; ?></span>
                    </div>
                </div>
                
                <div class="d-flex mt-4">
                    <button class="btn btn-add-cart btn-lg me-3" onclick="addToCart(<?php echo $product_id; ?>)">
                        <i class="fas fa-cart-plus me-2"></i> Thêm vào giỏ hàng
                    </button>
                </div>
                
                
            </div>
        </div>
    </div>


    <!-- Product Details -->
    
    <!-- Shop Information Section -->
    <div class="container my-4 border rounded-lg p-4 bg-white">
        <?php
        // Get farm information from the current product
        $farm_id = $product['farm_id'];
        $farm_name = $product['farm_name'];
        
        // Query additional farm information
        $sql_farm = "SELECT f.*, u.name as owner_name 
                    FROM farms f 
                    JOIN users u ON f.owner_id = u.id 
                    WHERE f.id = ?";
        
        $stmt_farm = $conn->prepare($sql_farm);
        
        if ($stmt_farm) {
            $stmt_farm->bind_param("i", $farm_id);
            $stmt_farm->execute();
            $farm_result = $stmt_farm->get_result();
            $farm_data = $farm_result->fetch_assoc();
            
            // Count products from this farm
            $sql_product_count = "SELECT COUNT(*) as count FROM products WHERE farm_id = ?";
            $stmt_product_count = $conn->prepare($sql_product_count);
            $stmt_product_count->bind_param("i", $farm_id);
            $stmt_product_count->execute();
            $product_count_result = $stmt_product_count->get_result();
            $product_count_data = $product_count_result->fetch_assoc();
            $product_count = $product_count_data['count'];
            
            // Get average rating for farm's products
            $sql_avg_rating = "SELECT AVG(r.rating) as avg_rating, COUNT(r.id) as review_count 
                            FROM reviews r 
                            JOIN products p ON r.product_id = p.id 
                            WHERE p.farm_id = ?";
            $stmt_avg_rating = $conn->prepare($sql_avg_rating);
            $stmt_avg_rating->bind_param("i", $farm_id);
            $stmt_avg_rating->execute();
            $avg_rating_result = $stmt_avg_rating->get_result();
            $avg_rating_data = $avg_rating_result->fetch_assoc();
            $avg_rating = round($avg_rating_data['avg_rating'] ?? 0, 1);
            $review_count = $avg_rating_data['review_count'] ?? 0;
            
            // Format numbers for display
            $formatted_product_count = $product_count > 1000 ? round($product_count / 1000, 1) . 'k' : $product_count;
            $formatted_review_count = $review_count > 1000 ? round($review_count / 1000, 1) . 'k' : $review_count;
            
            // Since there's no follower table in the database, we'll use a placeholder value
            $follower_count = rand(500, 6000); // Random placeholder
            $formatted_follower_count = $follower_count > 1000 ? round($follower_count / 1000, 1) . 'k' : $follower_count;
            
            // Response rate placeholder (since it's not in the database)
            $response_rate = rand(90, 99);
            
            // Calculate years since joining (using current timestamp as reference)
            // Since there's no created_at field in farms table, we'll use a placeholder
            $years_since = rand(1, 5); // Random placeholder between 1-5 years
        } else {
            // Fallback to default values if query fails
            $product_count = $formatted_product_count = "1,6k";
            $review_count = $formatted_review_count = "65,3k";
            $follower_count = $formatted_follower_count = "6k";
            $response_rate = 99;
            $years_since = 4;
            $avg_rating = 4.8;
        }
        ?>
        
        <div class="row">
            <!-- Shop Avatar and Basic Info -->
            <div class="col-md-6 d-flex align-items-center gap-3">
                <!-- <div class="position-relative" style="width: 64px; height: 64px;">
                    <?php 
                    // Since there's no farm avatar in the database, we'll use a default image
                    $farm_avatar = "../../image/default_shop_avatar.jpg";
                    ?>
                    <img src="<?php echo $farm_avatar; ?>" alt="<?php echo htmlspecialchars($farm_name); ?>" 
                        class="rounded-circle border" style="width: 100%; height: 100%; object-fit: cover;">
                </div> -->
                <div>
                    <h3 class="fw-semibold"><?php echo htmlspecialchars($farm_name); ?></h3>
                </div>
            </div>

            <!-- Shop Actions -->
            <div class="col-md-6 d-flex justify-content-md-end align-items-center gap-2 my-2 my-md-0">
                <a href="javascript:void(0);" onclick="openChatWithFarm(<?php echo $farm_id; ?>)" class="btn btn-outline-danger">
                    <i class="fas fa-comment-dots me-1"></i> Chat Ngay
                </a>
                <a href="farm-detail.php?id=<?php echo $farm_id; ?>" class="btn btn-outline-secondary">
                    <i class="fas fa-store me-1"></i> Xem Shop
                </a>
            </div>
        </div>

    </div>

    <script> 
// Function to open chat widget with specific chat
function openChatWithFarm(farmId) {
    <?php if (isset($_SESSION['id'])): ?>
        // Show loading indicator
        const chatButton = document.querySelector('.btn-outline-danger');
        const originalContent = chatButton.innerHTML;
        chatButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang kết nối...';
        chatButton.disabled = true;
        
        // Check if chat already exists or create a new one
        $.ajax({
            url: 'check_chat.php',
            type: 'POST',
            data: {
                farm_id: farmId,
                user_id: <?php echo isset($_SESSION['id']) ? $_SESSION['id'] : 0; ?>
            },
            success: function(response) {
                try {
                    var data = JSON.parse(response);
                    if (data.exists) {
                        // Open chat widget and load this specific chat
                        openChatWidget(data.chat_id, '<?php echo htmlspecialchars($farm_name); ?>');
                        // Reset button
                        chatButton.innerHTML = originalContent;
                        chatButton.disabled = false;
                    } else {
                        // Create new chat
                        $.ajax({
                            url: 'create_chat.php',
                            type: 'POST',
                            data: {
                                farm_id: farmId,
                                user_id: <?php echo isset($_SESSION['id']) ? $_SESSION['id'] : 0; ?>
                            },
                            success: function(response) {
                                try {
                                    var data = JSON.parse(response);
                                    if (data.success) {
                                        // Open chat widget with the new chat
                                        openChatWidget(data.chat_id, '<?php echo htmlspecialchars($farm_name); ?>');
                                    } else {
                                        alert('Có lỗi xảy ra khi tạo cuộc trò chuyện: ' + (data.message || 'Không xác định'));
                                    }
                                } catch (e) {
                                    console.error('Error parsing JSON:', e, response);
                                    alert('Có lỗi xảy ra khi xử lý phản hồi từ máy chủ.');
                                }
                                // Reset button
                                chatButton.innerHTML = originalContent;
                                chatButton.disabled = false;
                            },
                            error: function(xhr, status, error) {
                                console.error('AJAX Error:', status, error);
                                alert('Không thể kết nối đến máy chủ. Vui lòng thử lại sau.');
                                // Reset button
                                chatButton.innerHTML = originalContent;
                                chatButton.disabled = false;
                            }
                        });
                    }
                } catch (e) {
                    console.error('Error parsing JSON:', e, response);
                    alert('Có lỗi xảy ra khi xử lý phản hồi từ máy chủ.');
                    // Reset button
                    chatButton.innerHTML = originalContent;
                    chatButton.disabled = false;
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', status, error);
                alert('Không thể kết nối đến máy chủ. Vui lòng thử lại sau.');
                // Reset button
                chatButton.innerHTML = originalContent;
                chatButton.disabled = false;
            }
        });
    <?php else: ?>
        alert('Vui lòng đăng nhập để chat với cửa hàng');
        window.location.href = 'login.php';
    <?php endif; ?>
}   
    </script>
    
    <!-- Product Details Tabs -->
    <div class="container my-5">
        <ul class="nav nav-tabs" id="productTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="details-tab" data-bs-toggle="tab" data-bs-target="#details" type="button" role="tab">
                    Chi tiết sản phẩm
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button" role="tab">
                    Đánh giá (<?php echo $reviews_result->num_rows; ?>)
                </button>
            </li>
            <!-- <li class="nav-item" role="presentation">
                <button class="nav-link" id="shipping-tab" data-bs-toggle="tab" data-bs-target="#shipping" type="button" role="tab">
                    Vận chuyển & Thanh toán
                </button>
            </li> -->
        </ul>
        
        <div class="tab-content p-4 border border-top-0" id="productTabsContent">
            <!-- Product Details Tab -->
            <div class="tab-pane fade show active" id="details" role="tabpanel">
                <div class="row">
                    <div class="col-md-6">
                        <h4 class="section-title">Thông tin sản phẩm</h4>
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>Xuất xứ</td>
                                    <td><?php echo $product['origin'] ?? 'Việt Nam'; ?></td>
                                </tr>
                                <tr>
                                    <td>Loại</td>
                                    <td><?php echo ucwords($product['category_name']) ?? ''; ?></td>
                                </tr>
                                <tr>
                                    <td>Đơn vị</td>
                                    <td><?php echo $product['unit']; ?></td>
                                </tr>
                                <tr>
                                    <td>Bảo quản</td>
                                    <td><?php echo $product['storage_instructions'] ?? 'Bảo quản lạnh 2-5°C'; ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h4 class="section-title">Mô tả chi tiết</h4>
                        <p><?php echo $product['detailed_description'] ?? $product['description']; ?></p>
                        
                        <h5 class="mt-4">Giá trị dinh dưỡng</h5>
                        <p><?php echo $product['nutritional_info'] ?? 'Thông tin đang được cập nhật'; ?></p>
                        
                        <h5 class="mt-4">Lợi ích sức khỏe</h5>
                        <p><?php echo $product['health_benefits'] ?? 'Thông tin đang được cập nhật'; ?></p>
                    </div>
                </div>
            </div>
            
            <!-- Reviews Tab -->
            <div class="tab-pane fade" id="reviews" role="tabpanel">
                <h4 class="section-title">Đánh giá từ khách hàng</h4>
                
                <?php if ($reviews_result->num_rows > 0): ?>
                    <?php while ($review = $reviews_result->fetch_assoc()): ?>
                    <div class="review-item">
                        <div class="d-flex justify-content-between">
                            <h5><?php echo $review['customer_name']; ?></h5>
                            <small class="text-muted"><?php echo date('d/m/Y', strtotime($review['created_at'])); ?></small>
                        </div>
                        <div class="review-rating">
                            <?php
                            for ($i = 1; $i <= 5; $i++) {
                                if ($i <= $review['rating']) {
                                    echo '<i class="fas fa-star text-warning"></i>';
                                } else {
                                    echo '<i class="far fa-star text-warning"></i>';
                                }
                            }
                            ?>
                        </div>
                        <p><?php echo $review['comment']; ?></p>
                    </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>Chưa có đánh giá nào cho sản phẩm này.</p>
                <?php endif; ?>
                
                <!-- Review Form -->
                <div class="mt-4">
                    <h5>Viết đánh giá của bạn</h5>
                    <form action="process_review.php" method="post">
                        <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                        
                        <div class="mb-3">
                            <label class="form-label">Đánh giá của bạn</label>
                            <div class="rating-stars mb-2">
                                <i class="far fa-star star-rating" data-rating="1"></i>
                                <i class="far fa-star star-rating" data-rating="2"></i>
                                <i class="far fa-star star-rating" data-rating="3"></i>
                                <i class="far fa-star star-rating" data-rating="4"></i>
                                <i class="far fa-star star-rating" data-rating="5"></i>
                            </div>
                            <input type="hidden" name="rating" id="rating-value" value="0">
                        </div>
                        
                        <div class="mb-3">
                            <label for="review-comment" class="form-label">Nhận xét của bạn</label>
                            <textarea class="form-control" id="review-comment" name="comment" rows="3" required></textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-success">Gửi đánh giá</button>
                    </form>
                </div>
            </div>
            
        
        </div>
    </div>
    
    <!-- Related Products -->
 <div class="container my-5">
    <h3 class="section-title">Sản phẩm liên quan</h3>
    
    <div class="row">
        <?php if (!empty($related_products)): ?>
            <?php foreach ($related_products as $related): ?>
            <div class="col-6 col-md-4 col-lg-2 mb-4">
                <div class="card h-100 related-product">
                    <a href="product-detail.php?id=<?php echo $related['id']; ?>">
                        <img src="../../image/<?php echo htmlspecialchars($related['img']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($related['name']); ?>">
                    </a>
                    <div class="card-body">
                        <h6 class="card-title">
                            <a href="product-detail.php?id=<?php echo $related['id']; ?>" class="text-decoration-none text-dark">
                                <?php echo htmlspecialchars($related['name']); ?>
                            </a>
                        </h6>
                        <div class="product-rating small">
                            <?php
                            $rating = $related['rating'] ?? 0;
                            for ($i = 1; $i <= 5; $i++) {
                                echo $i <= $rating
                                    ? '<i class="fas fa-star"></i>'
                                    : '<i class="fas fa-star gray"></i>';
                            }
                            ?>
                        </div>
                        <p class="card-text mt-2 text-danger fw-bold">
                            <?php echo number_format($related['price'], 0, ',', '.'); ?>đ/<?php echo $related['unit']; ?>
                        </p>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <p>Đang cập nhật.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Change main image when clicking on thumbnails
        function changeImage(imageUrl, element) {
            document.getElementById('main-image').src = imageUrl;
            
            // Remove active class from all thumbnails
            const thumbnails = document.querySelectorAll('.product-thumbnails img');
            thumbnails.forEach(thumb => {
                thumb.classList.remove('active');
            });
            
            // Add active class to clicked thumbnail
            element.classList.add('active');
        }
        
        // Quantity controls
        function increaseQuantity() {
            const quantityInput = document.getElementById('quantity');
            const currentValue = parseInt(quantityInput.value);
            const maxStock = <?php echo $product['stock']; ?>;
            
            if (currentValue < maxStock) {
                quantityInput.value = currentValue + 1;
            }
        }
        
        function decreaseQuantity() {
            const quantityInput = document.getElementById('quantity');
            const currentValue = parseInt(quantityInput.value);
            
            if (currentValue > 1) {
                quantityInput.value = currentValue - 1;
            }
        }
        
        // Add to cart function
        function addToCart(productId) {
            const quantity = document.getElementById('quantity').value;
            
            // AJAX request to add product to cart
            fetch('add_to_cart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `product_id=${productId}&quantity=${quantity}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Sản phẩm đã được thêm vào giỏ hàng!');
                } else {
                    alert('Có lỗi xảy ra: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Có lỗi xảy ra khi thêm sản phẩm vào giỏ hàng.');
            });
        }
        
        // Buy now function
        function buyNow(productId) {
            const quantity = document.getElementById('quantity').value;
            
            // Add to cart and redirect to checkout
            fetch('add_to_cart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `product_id=${productId}&quantity=${quantity}&buy_now=1`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = 'index.php?action=checkout';
                } else {
                    alert('Có lỗi xảy ra: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Có lỗi xảy ra khi mua sản phẩm.');
            });
        }
        
        // Add to wishlist function
        function addToWishlist(productId) {
            // AJAX request to add product to wishlist
            fetch('add_to_wishlist.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `product_id=${productId}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Sản phẩm đã được thêm vào danh sách yêu thích!');
                } else {
                    alert('Có lỗi xảy ra: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Có lỗi xảy ra khi thêm sản phẩm vào danh sách yêu thích.');
            });
        }
        
        // Star rating functionality
        document.addEventListener('DOMContentLoaded', function() {
            const stars = document.querySelectorAll('.star-rating');
            const ratingInput = document.getElementById('rating-value');
            
            stars.forEach(star => {
                star.addEventListener('click', function() {
                    const rating = this.getAttribute('data-rating');
                    ratingInput.value = rating;
                    
                    // Update stars display
                    stars.forEach(s => {
                        const sRating = s.getAttribute('data-rating');
                        if (sRating <= rating) {
                            s.classList.remove('far');
                            s.classList.add('fas');
                        } else {
                            s.classList.remove('fas');
                            s.classList.add('far');
                        }
                    });
                });
                
                // Hover effects
                star.addEventListener('mouseover', function() {
                    const rating = this.getAttribute('data-rating');
                    
                    stars.forEach(s => {
                        const sRating = s.getAttribute('data-rating');
                        if (sRating <= rating) {
                            s.classList.remove('far');
                            s.classList.add('fas');
                        }
                    });
                });
                
                star.addEventListener('mouseout', function() {
                    const currentRating = ratingInput.value;
                    
                    stars.forEach(s => {
                        const sRating = s.getAttribute('data-rating');
                        if (sRating <= currentRating) {
                            s.classList.remove('far');
                            s.classList.add('fas');
                        } else {
                            s.classList.remove('fas');
                            s.classList.add('far');
                        }
                    });
                });
            });
        });
    </script>

<?php
// Close database connection
$conn->close();
?>
