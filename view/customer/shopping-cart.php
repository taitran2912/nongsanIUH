<?php
// Kiểm tra đăng nhập
if (!isset($_SESSION["id"])) {
    echo "<script>window.location.href = '?action=login';</script>";
    exit;
}

$customerId = $_SESSION["id"];

// Kết nối CSDL
$db = new clsketnoi();
$conn = $db->moKetNoi();
$conn->set_charset('utf8');

// Debug
echo "<!-- Debug: Đã kết nối CSDL -->";

// Lấy danh sách sản phẩm trong giỏ hàng
$sql = "SELECT c.product_id, p.name, p.price, p.unit, c.quantity, 
        f.id as shop_id, f.shopname, pi.img, ct.name as category 
        FROM cart c 
        JOIN products p ON c.product_id = p.id 
        JOIN categories ct ON p.id_categories = ct.id
        JOIN farms f ON p.farm_id = f.id 
        LEFT JOIN (
            SELECT product_id, MIN(img) as img 
            FROM product_images 
            GROUP BY product_id
        ) pi ON pi.product_id = p.id 
        WHERE c.customer_id = ? 
        GROUP BY c.product_id, p.name, p.price, p.unit, c.quantity, f.id, f.shopname, pi.img, p.id_categories
        ORDER BY f.id, p.name
        LIMIT 0, 100
        ";

echo "<!-- Debug: SQL Query: " . htmlspecialchars($sql) . " -->";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $customerId);
$stmt->execute();
$result = $stmt->get_result();

echo "<!-- Debug: Số lượng sản phẩm: " . $result->num_rows . " -->";

// Nhóm sản phẩm theo cửa hàng
$cartItems = [];
$totalAmount = 0;

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $shopId = $row['shop_id'];
        
        if (!isset($cartItems[$shopId])) {
            $cartItems[$shopId] = [
                'shop_name' => $row['shopname'],
                'products' => []
            ];
        }
        
        $cartItems[$shopId]['products'][] = $row;
        $totalAmount += $row['price'] * $row['quantity'];
    }
}

// Tính phí vận chuyển
$shippingFee = ($totalAmount >= 500000) ? 0 : 30000;
$finalTotal = $totalAmount + $shippingFee;

// Đóng kết nối
$db->dongKetNoi($conn);
?>

<!-- Cart Section -->
<section class="cart-section py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title text-center mb-5">
                    <h2>Giỏ hàng của bạn</h2>
                    <p class="text-muted">Xem lại và điều chỉnh sản phẩm trước khi thanh toán</p>
                </div>
            </div>
        </div>

        <?php if (!empty($cartItems)): ?>
        <div class="row" id="cartContent">
            <div class="col-lg-8">
                <!-- Cart Items -->
                <div class="cart-items card mb-4">
                    <div class="card-header bg-white py-3">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h5 class="mb-0">Sản phẩm</h5>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Cart Items by Shop -->
                        <?php foreach ($cartItems as $shopId => $shop): ?>
                            <div class="shop-block mb-4">
                                <h5 class="fw-bold mb-3"><?= htmlspecialchars($shop['shop_name']) ?></h5>

                                <?php foreach ($shop['products'] as $product): ?>
                                    <div class="cart-item mb-4 pb-4 border-bottom" data-product-id="<?= $product['product_id'] ?>">
                                        <div class="row align-items-center">
                                            <!-- Hình ảnh -->
                                            <div class="col-md-2 col-4">
                                                <img src="../../image/<?= htmlspecialchars($product['img'] ?? 'default.jpg') ?>" 
                                                     class="img-fluid rounded" 
                                                     alt="<?= htmlspecialchars($product['name']) ?>">
                                            </div>

                                            <!-- Tên & danh mục -->
                                            <div class="col-md-4 col-8">
                                                <h6 class="product-title mb-1">
                                                    <a href="?action=detail&id=<?= $product['product_id'] ?>" 
                                                       class="text-dark text-decoration-none">
                                                        <?= htmlspecialchars($product['name']) ?>
                                                    </a>
                                                </h6>
                                                <p class="product-category text-muted mb-1">
                                                    <?= htmlspecialchars($product['category'] ?? 'Sản phẩm') ?>
                                                </p>
                                                <span class="product-price text-success fw-semibold">
                                                    <?= number_format($product['price'], 0, ',', '.') ?>đ/<?= $product['unit'] ?>
                                                </span>
                                            </div>

                                            <!-- Số lượng -->
                                            <div class="col-md-3 col-6 mt-3 mt-md-0">
                                                <div class="quantity-control d-flex align-items-center">
                                                    <button class="btn btn-sm btn-outline-secondary quantity-btn" 
                                                            data-action="decrease" 
                                                            data-product-id="<?= $product['product_id'] ?>">
                                                        <i class="fas fa-minus"></i>
                                                    </button>
                                                    <input type="number" 
                                                           class="form-control form-control-sm quantity-input mx-2 text-center" 
                                                           value="<?= $product['quantity'] ?>" 
                                                           min="1" 
                                                           max="99" 
                                                           style="width: 60px;" 
                                                           data-product-id="<?= $product['product_id'] ?>">
                                                    <button class="btn btn-sm btn-outline-secondary quantity-btn" 
                                                            data-action="increase" 
                                                            data-product-id="<?= $product['product_id'] ?>">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>

                                            <!-- Tổng giá -->
                                            <div class="col-md-2 col-3 mt-3 mt-md-0 text-md-end">
                                                <span class="item-total fw-bold">
                                                    <?= number_format($product['price'] * $product['quantity'], 0, ',', '.') ?>đ
                                                </span>
                                            </div>

                                            <!-- Xóa -->
                                            <div class="col-md-1 col-3 mt-3 mt-md-0 text-end">
                                                <button class="btn btn-sm btn-link text-danger remove-item" 
                                                        data-product-id="<?= $product['product_id'] ?>">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="card-footer bg-white py-3">
                        <div class="row">
                            <div class="col-md-6">
                                <a href="?action=product" class="btn btn-outline-success">
                                    <i class="fas fa-arrow-left me-2"></i>Tiếp tục mua sắm
                                </a>
                            </div>
                            <div class="col-md-6 text-md-end mt-3 mt-md-0">
                                <button id="updateCart" class="btn btn-outline-secondary">
                                    <i class="fas fa-sync-alt me-2"></i>Cập nhật giỏ hàng
                                </button>
                                <button id="clearCart" class="btn btn-outline-danger ms-2">
                                    <i class="fas fa-trash-alt me-2"></i>Xóa giỏ hàng
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <!-- Order Summary -->
                <div class="card order-summary">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0">Tóm tắt đơn hàng</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <span>Tạm tính</span>
                            <span class="fw-bold" id="subtotal"><?= number_format($totalAmount, 0, ',', '.') ?>đ</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Giảm giá</span>
                            <span class="fw-bold text-success" id="discount">0đ</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Phí vận chuyển</span>
                            <span class="fw-bold" id="shipping"><?= number_format($shippingFee, 0, ',', '.') ?>đ</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="fw-bold">Tổng cộng</span>
                            <span class="fw-bold text-success fs-5" id="total"><?= number_format($finalTotal, 0, ',', '.') ?>đ</span>
                        </div>
                        <div class="alert alert-success d-flex align-items-center mt-3" role="alert">
                            <i class="fas fa-info-circle me-2"></i>
                            <div>
                                Miễn phí vận chuyển cho đơn hàng từ 500.000đ
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-white py-3">
                        <a href="?action=checkout" class="btn btn-success w-100">
                            Tiến hành thanh toán <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <?php else: ?>
        <!-- Empty Cart -->
        <div class="row" id="emptyCart">
            <div class="col-12">
                <div class="empty-cart text-center py-5">
                    <div class="empty-cart-icon mb-4">
                        <i class="fas fa-shopping-cart fa-5x text-muted"></i>
                    </div>
                    <h3>Giỏ hàng của bạn đang trống</h3>
                    <p class="text-muted mb-4">Có vẻ như bạn chưa thêm bất kỳ sản phẩm nào vào giỏ hàng.</p>
                    <a href="?action=product" class="btn btn-success">
                        <i class="fas fa-shopping-basket me-2"></i>Tiếp tục mua sắm
                    </a>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- Notification Container -->
<div id="notification-container" class="position-fixed bottom-0 end-0 p-3" style="z-index: 1050;"></div>

<!-- Cart JS -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('Cart script loaded');
    
    // Cache DOM elements
    const elements = {
        quantityInputs: document.querySelectorAll('.quantity-input'),
        quantityBtns: document.querySelectorAll('.quantity-btn'),
        removeItemBtns: document.querySelectorAll('.remove-item'),
        updateCartBtn: document.getElementById('updateCart'),
        clearCartBtn: document.getElementById('clearCart'),
        cartContent: document.getElementById('cartContent'),
        emptyCart: document.getElementById('emptyCart'),
        subtotalEl: document.getElementById('subtotal'),
        discountEl: document.getElementById('discount'),
        shippingEl: document.getElementById('shipping'),
        totalEl: document.getElementById('total'),
        notificationContainer: document.getElementById('notification-container')
    };
    
    console.log('Quantity inputs:', elements.quantityInputs.length);
    
    // Format currency helper
    function formatCurrency(value) {
        return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }
    
    // Show notification
    function showNotification(message, type = 'success') {
        const notification = document.createElement('div');
        notification.className = `alert alert-${type} alert-dismissible fade show`;
        notification.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `;
        
        elements.notificationContainer.appendChild(notification);
        
        // Remove notification after 3 seconds
        setTimeout(() => {
            notification.classList.remove('show');
            setTimeout(() => {
                notification.remove();
            }, 300);
        }, 3000);
    }
    
    // Update item quantity in database
    function updateQuantityInDatabase(productId, quantity) {
        console.log(`Updating product ${productId} to quantity ${quantity}`);
        
        // Show loading indicator
        const cartItem = document.querySelector(`.cart-item[data-product-id="${productId}"]`);
        if (cartItem) {
            cartItem.classList.add('opacity-75');
        }
        
        // Send AJAX request
        fetch('update-cart.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `action=update&product_id=${productId}&quantity=${quantity}`
        })
        .then(response => response.json())
        .then(data => {
            console.log('Update response:', data);
            
            // Remove loading indicator
            if (cartItem) {
                cartItem.classList.remove('opacity-75');
            }
            
            if (data.success) {
                showNotification('Số lượng đã được cập nhật');
            } else {
                showNotification(data.message || 'Không thể cập nhật số lượng', 'danger');
            }
        })
        .catch(error => {
            console.error('Error updating quantity:', error);
            
            // Remove loading indicator
            if (cartItem) {
                cartItem.classList.remove('opacity-75');
            }
            
            showNotification('Lỗi kết nối. Vui lòng thử lại sau.', 'danger');
        });
    }
    
    // Remove item from cart
    function removeItemFromCart(productId, cartItem) {
        console.log(`Removing product ${productId} from cart`);
        
        // Show loading indicator
        cartItem.classList.add('opacity-75');
        
        // Send AJAX request
        fetch('update-cart.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `action=remove&product_id=${productId}`
        })
        .then(response => response.json())
        .then(data => {
            console.log('Remove response:', data);
            
            if (data.success) {
                // Remove item from DOM with animation
                cartItem.style.opacity = '0';
                setTimeout(() => {
                    cartItem.style.height = '0';
                    cartItem.style.padding = '0';
                    cartItem.style.margin = '0';
                    cartItem.style.overflow = 'hidden';
                    
                    setTimeout(() => {
                        cartItem.remove();
                        updateCartTotals();
                        checkEmptyCart();
                        showNotification('Sản phẩm đã được xóa khỏi giỏ hàng');
                    }, 300);
                }, 300);
            } else {
                // Remove loading indicator
                cartItem.classList.remove('opacity-75');
                showNotification(data.message || 'Không thể xóa sản phẩm', 'danger');
            }
        })
        .catch(error => {
            console.error('Error removing item:', error);
            
            // Remove loading indicator
            cartItem.classList.remove('opacity-75');
            showNotification('Lỗi kết nối. Vui lòng thử lại sau.', 'danger');
        });
    }
    
    // Clear entire cart
    function clearCart() {
        if (!confirm('Bạn có chắc chắn muốn xóa tất cả sản phẩm trong giỏ hàng?')) {
            return;
        }
        
        console.log('Clearing cart');
        
        // Show loading indicator
        const cartItems = document.querySelectorAll('.cart-item');
        cartItems.forEach(item => {
            item.classList.add('opacity-75');
        });
        
        // Send AJAX request
        fetch('update-cart.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'action=clear'
        })
        .then(response => response.json())
        .then(data => {
            console.log('Clear cart response:', data);
            
            if (data.success) {
                // Reload the page to show empty cart
                window.location.reload();
            } else {
                // Remove loading indicator
                cartItems.forEach(item => {
                    item.classList.remove('opacity-75');
                });
                
                showNotification(data.message || 'Không thể xóa giỏ hàng', 'danger');
            }
        })
        .catch(error => {
            console.error('Error clearing cart:', error);
            
            // Remove loading indicator
            cartItems.forEach(item => {
                item.classList.remove('opacity-75');
            });
            
            showNotification('Lỗi kết nối. Vui lòng thử lại sau.', 'danger');
        });
    }
    
    // Update item total price
    function updateItemTotal(input) {
        const cartItem = input.closest('.cart-item');
        const quantity = parseInt(input.value);
        const priceText = cartItem.querySelector('.product-price').textContent;
        const price = parseFloat(priceText.replace(/[^\d]/g, ''));
        
        const totalElement = cartItem.querySelector('.item-total');
        const total = price * quantity;
        
        totalElement.textContent = formatCurrency(total) + 'đ';
        
        updateCartTotals();
        
        // Update database
        const productId = input.dataset.productId;
        if (productId) {
            // Use a timeout to avoid too many requests when typing
            clearTimeout(input.updateTimeout);
            input.updateTimeout = setTimeout(() => {
                updateQuantityInDatabase(productId, quantity);
            }, 500);
        }
    }
    
    // Update cart totals
    function updateCartTotals() {
        const itemTotals = document.querySelectorAll('.item-total');
        let subtotal = 0;
        
        itemTotals.forEach(item => {
            subtotal += parseFloat(item.textContent.replace(/[^\d]/g, ''));
        });
        
        const discount = parseFloat(elements.discountEl.textContent.replace(/[^\d]/g, '')) || 0;
        
        // Free shipping for orders over 500,000đ
        let shipping = subtotal >= 500000 ? 0 : 30000;
        
        const total = subtotal - discount + shipping;
        
        elements.subtotalEl.textContent = formatCurrency(subtotal) + 'đ';
        elements.shippingEl.textContent = formatCurrency(shipping) + 'đ';
        elements.totalEl.textContent = formatCurrency(total) + 'đ';
    }
    
    // Check if cart is empty
    function checkEmptyCart() {
        const cartItems = document.querySelectorAll('.cart-item');
        
        if (cartItems.length === 0) {
            // Reload the page to show empty cart template
            window.location.reload();
        }
    }
    
    // Initialize cart functionality
    function initCart() {
        console.log('Initializing cart functionality');
        
        // Quantity buttons
        elements.quantityBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                console.log('Quantity button clicked:', this.dataset.action);
                const input = this.parentElement.querySelector('.quantity-input');
                const currentValue = parseInt(input.value);
                const action = this.getAttribute('data-action');
                
                if (action === 'increase') {
                    if (currentValue < 99) {
                        input.value = currentValue + 1;
                    }
                } else if (action === 'decrease') {
                    if (currentValue > 1) {
                        input.value = currentValue - 1;
                    }
                }
                
                updateItemTotal(input);
            });
        });
        
        // Quantity input change
        elements.quantityInputs.forEach(input => {
            input.addEventListener('change', function() {
                console.log('Quantity input changed:', this.value);
                let value = parseInt(this.value);
                
                if (isNaN(value) || value < 1) {
                    value = 1;
                } else if (value > 99) {
                    value = 99;
                }
                
                this.value = value;
                updateItemTotal(this);
            });
        });
        
        // Remove item buttons
        elements.removeItemBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                console.log('Remove button clicked for product:', this.dataset.productId);
                const cartItem = this.closest('.cart-item');
                const productId = this.getAttribute('data-product-id');
                
                if (confirm('Bạn có chắc chắn muốn xóa sản phẩm này khỏi giỏ hàng?')) {
                    removeItemFromCart(productId, cartItem);
                }
            });
        });
        
        // Update cart button
        if (elements.updateCartBtn) {
            elements.updateCartBtn.addEventListener('click', function() {
                console.log('Update cart button clicked');
                updateCartTotals();
                showNotification('Giỏ hàng đã được cập nhật');
            });
        }
        
        // Clear cart button
        if (elements.clearCartBtn) {
            elements.clearCartBtn.addEventListener('click', function() {
                console.log('Clear cart button clicked');
                clearCart();
            });
        }
        
        // Initialize cart totals
        updateCartTotals();
    }
    
    // Initialize cart
    initCart();
});
</script>