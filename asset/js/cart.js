document.addEventListener('DOMContentLoaded', function() {
    // Elements
    const quantityInputs = document.querySelectorAll('.quantity-input');
    const quantityBtns = document.querySelectorAll('.quantity-btn');
    const removeItemBtns = document.querySelectorAll('.remove-item');
    const updateCartBtn = document.getElementById('updateCart');
    const clearCartBtn = document.getElementById('clearCart');
    const cartContent = document.getElementById('cartContent');
    const emptyCart = document.getElementById('emptyCart');
    const subtotalEl = document.getElementById('subtotal');
    const discountEl = document.getElementById('discount');
    const shippingEl = document.getElementById('shipping');
    const totalEl = document.getElementById('total');
    const couponForm = document.querySelector('.coupon-form');
    
    // Initialize tooltips if Bootstrap is available
    if (typeof bootstrap !== 'undefined') {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }
    
    // Cart functionality
    function initCart() {
        // Quantity buttons
        quantityBtns.forEach(btn => {
            btn.addEventListener('click', function() {
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
        quantityInputs.forEach(input => {
            input.addEventListener('change', function() {
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
        removeItemBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const cartItem = this.closest('.cart-item');
                
                // Animation for removing item
                cartItem.style.opacity = '0';
                cartItem.style.height = cartItem.offsetHeight + 'px';
                
                setTimeout(() => {
                    cartItem.style.height = '0';
                    cartItem.style.padding = '0';
                    cartItem.style.margin = '0';
                    cartItem.style.overflow = 'hidden';
                    
                    setTimeout(() => {
                        cartItem.remove();
                        updateCartCount();
                        updateCartTotals();
                        checkEmptyCart();
                    }, 300);
                }, 300);
            });
        });
        
        // Update cart button
        if (updateCartBtn) {
            updateCartBtn.addEventListener('click', function() {
                updateCartTotals();
                
                // Show success message
                const alert = document.createElement('div');
                alert.className = 'alert alert-success alert-dismissible fade show mt-3';
                alert.innerHTML = `
                    <strong>Thành công!</strong> Giỏ hàng đã được cập nhật.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                `;
                
                const cardFooter = this.closest('.card-footer');
                cardFooter.appendChild(alert);
                
                // Remove alert after 3 seconds
                setTimeout(() => {
                    alert.remove();
                }, 3000);
            });
        }
        
        // Clear cart button
        if (clearCartBtn) {
            clearCartBtn.addEventListener('click', function() {
                if (confirm('Bạn có chắc chắn muốn xóa tất cả sản phẩm trong giỏ hàng?')) {
                    const cartItems = document.querySelectorAll('.cart-item');
                    
                    cartItems.forEach(item => {
                        item.remove();
                    });
                    
                    updateCartCount();
                    updateCartTotals();
                    checkEmptyCart();
                }
            });
        }
        
        // Coupon form
        if (couponForm) {
            couponForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const input = this.querySelector('input');
                const couponCode = input.value.trim();
                
                if (couponCode === '') {
                    showCouponMessage('Vui lòng nhập mã giảm giá', 'danger');
                    return;
                }
                
                // Check coupon code (demo only)
                if (couponCode.toUpperCase() === 'FRESH10') {
                    // Apply 10% discount
                    const subtotal = parseFloat(subtotalEl.textContent.replace(/[^\d]/g, ''));
                    const discount = Math.round(subtotal * 0.1);
                    
                    discountEl.textContent = formatCurrency(discount) + 'đ';
                    updateCartTotals();
                    
                    showCouponMessage('Mã giảm giá đã được áp dụng thành công!', 'success');
                } else {
                    showCouponMessage('Mã giảm giá không hợp lệ hoặc đã hết hạn', 'danger');
                }
            });
        }
        
        // Initialize cart totals
        updateCartTotals();
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

        // ✅ Gửi AJAX để cập nhật CSDL
        const productId = input.dataset.productId;

        if (productId) {
            fetch('update-cart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `product_id=${productId}&quantity=${quantity}`
            })
            .then(response => response.json())
            .then(data => {
                if (!data.success) {
                    alert('Không thể cập nhật số lượng. Vui lòng thử lại.');
                }
            })
            .catch(error => {
                console.error('Lỗi khi cập nhật số lượng:', error);
            });
        }
    }

    
    // Update cart totals
    function updateCartTotals() {
        const itemTotals = document.querySelectorAll('.item-total');
        let subtotal = 0;
        
        itemTotals.forEach(item => {
            subtotal += parseFloat(item.textContent.replace(/[^\d]/g, ''));
        });
        
        const discount = parseFloat(discountEl.textContent.replace(/[^\d]/g, '')) || 0;
        
        // Free shipping for orders over 500,000đ
        let shipping = subtotal >= 500000 ? 0 : 30000;
        
        const total = subtotal - discount + shipping;
        
        subtotalEl.textContent = formatCurrency(subtotal) + 'đ';
        shippingEl.textContent = formatCurrency(shipping) + 'đ';
        totalEl.textContent = formatCurrency(total) + 'đ';
    }
    
    // Update cart count in header
    function updateCartCount() {
        const cartItems = document.querySelectorAll('.cart-item');
        const cartCount = document.querySelector('.top-bar .fa-shopping-cart').nextSibling;
        
        if (cartCount) {
            cartCount.textContent = ` Giỏ hàng (${cartItems.length})`;
        }
    }
    
    // Check if cart is empty
    function checkEmptyCart() {
        const cartItems = document.querySelectorAll('.cart-item');
        
        if (cartItems.length === 0) {
            cartContent.classList.add('d-none');
            emptyCart.classList.remove('d-none');
        } else {
            cartContent.classList.remove('d-none');
            emptyCart.classList.add('d-none');
        }
    }
    
    // Show coupon message
    function showCouponMessage(message, type) {
        const couponForm = document.querySelector('.coupon-form');
        
        // Remove existing alert
        const existingAlert = couponForm.nextElementSibling;
        if (existingAlert && existingAlert.classList.contains('alert')) {
            existingAlert.remove();
        }
        
        // Create new alert
        const alert = document.createElement('div');
        alert.className = `alert alert-${type} mt-3`;
        alert.textContent = message;
        
        couponForm.parentNode.insertBefore(alert, couponForm.nextSibling);
        
        // Remove alert after 3 seconds
        setTimeout(() => {
            alert.remove();
        }, 3000);
    }
    
    // Format currency
    function formatCurrency(value) {
        return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }
    
    // Back to top button
    const backToTopButton = document.querySelector('.back-to-top');
    
    if (backToTopButton) {
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
                backToTopButton.style.display = 'flex';
            } else {
                backToTopButton.style.display = 'none';
            }
        });
        
        backToTopButton.addEventListener('click', function(e) {
            e.preventDefault();
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }
    
    // Initialize cart
    initCart();
});