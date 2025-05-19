<?php
    include_once '../../controller/cCart.php';
    $p = new cCart();
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
                        <!-- Cart Item 1 -->
<?php
$result = $p->getCart($id); // Assuming user ID is 1
$cartItems = []; // key = shop_id

if($result){
while ($row = $result->fetch_assoc()) {
    $shopId = $row['shop_id'];
    
    if (!isset($cartItems[$shopId])) {
        $cartItems[$shopId] = [
            'shop_name' => $row['shopname'],
            'products' => []
        ];
    }

    $cartItems[$shopId]['products'][] = $row;
}

foreach ($cartItems as $shopId => $shop) {
    echo "<div class='shop-block mb-4'>";
    echo "<h5 class='fw-bold mb-3'>{$shop['shop_name']}</h5>";

    foreach ($shop['products'] as $product) {
        $productName = htmlspecialchars($product['name']);
        $productCategory = htmlspecialchars($product['category']);
        $productImage = htmlspecialchars($product['img']);
        $price = number_format($product['price'], 0, ',', '.') . 'đ';
        $quantity = (int)$product['quantity'];
        $total = number_format($product['price'] * $quantity, 0, ',', '.') . 'đ';

        echo "
        <div class='cart-item mb-4 pb-4 border-bottom' data-product-id='{$product['id']}'>
            <div class='row align-items-center'>
                <!-- Hình ảnh -->
                <div class='col-md-2 col-4'>
                    <img src='../../image/{$productImage}' class='img-fluid rounded' alt='{$productName}'>
                </div>

                <!-- Tên & danh mục -->
                <div class='col-md-4 col-8'>
                    <h6 class='product-title mb-1'>
                        <a href='product-detail.php?id={$product['id']}' class='text-dark text-decoration-none'>{$productName}</a>
                    </h6>
                    <p class='product-category text-muted mb-1'>{$productCategory}</p>
                    <span class='product-price text-success fw-semibold'>{$price}/{$product['unit']}</span>
                </div>

                <!-- Số lượng -->
                <div class='col-md-3 col-6 mt-3 mt-md-0'>
                    <div class='quantity-control d-flex align-items-center'>
                        <button class='btn btn-sm btn-outline-secondary quantity-btn' data-action='decrease'>
                            <i class='fas fa-minus'></i>
                        </button>
                        <input type='number' class='form-control form-control-sm quantity-input mx-2 text-center' 
                               value='{$quantity}' min='1' max='99' style='width: 60px;' data-product-id='{$product['id']}' >
                        <button class='btn btn-sm btn-outline-secondary quantity-btn' data-action='increase'>
                            <i class='fas fa-plus'></i>
                        </button>
                    </div>
                </div>

                <!-- Tổng giá -->
                <div class='col-md-2 col-3 mt-3 mt-md-0 text-md-end'>
                    <span class='item-total fw-bold'>{$total}</span>
                </div>

                <!-- Xóa -->
                <div class='col-md-1 col-3 mt-3 mt-md-0 text-end'>
                    <button class='btn btn-sm btn-link text-danger remove-item' data-product-id='{$product['id']}'>
                        <i class='fas fa-trash-alt'></i>
                    </button>
                </div>
            </div>
        </div>";
    }

    echo "</div>"; // End shop-block
}
} else {
    echo '
        <div class="row d-none" id="emptyCart">
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
    ';
}
?>
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
                            <span class="fw-bold" id="subtotal">348.000đ</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Giảm giá</span>
                            <span class="fw-bold text-success" id="discount">0đ</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Phí vận chuyển</span>
                            <span class="fw-bold" id="shipping">30.000đ</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="fw-bold">Tổng cộng</span>
                            <span class="fw-bold text-success fs-5" id="total">378.000đ</span>
                        </div>
                        <div class="alert alert-success d-flex align-items-center mt-3" role="alert">
                            <i class="fas fa-info-circle me-2"></i>
                            <div>
                                Miễn phí vận chuyển cho đơn hàng từ 500.000đ
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-white py-3">
                        <a href="checkout.html" class="btn btn-success w-100">
                            Tiến hành thanh toán <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>

            </div>
        </div>

        

        <!-- Related Products -->
        <div class="row mt-5">
            <div class="col-12">
                <h3 class="section-title mb-4">Có thể bạn cũng thích</h3>
            </div>
            <!-- Product 1 -->
            <div class="col-md-3 col-6">
                <div class="product-card">
                    <div class="product-thumb">
                        <img src="" class="img-fluid" alt="Xoài cát">
                        <div class="product-action">
                            <a href="#" class="btn btn-light btn-sm"><i class="fas fa-eye"></i></a>
                            <a href="#" class="btn btn-light btn-sm"><i class="fas fa-heart"></i></a>
                            <a href="#" class="btn btn-success btn-sm"><i class="fas fa-shopping-cart"></i></a>
                        </div>
                    </div>
                    <div class="product-info p-3">
                        <span class="product-category">Trái cây</span>
                        <h5><a href="#" class="product-title">Xoài cát Hòa Lộc</a></h5>
                        <div class="product-price">
                            <span class="new-price">85.000đ/kg</span>
                        </div>
                        <div class="product-rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <span>(5.0)</span>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</section>
<!-- Back to Top -->
<a href="#" class="back-to-top"><i class="fas fa-arrow-up"></i></a>

<!-- Cart JS -->
<script src="../../asset/js/cart.js"></script>
</html>