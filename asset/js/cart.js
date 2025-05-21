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
    console.log('Quantity buttons:', elements.quantityBtns.length);
    console.log('Remove buttons:', elements.removeItemBtns.length);
    
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
        
        // Create form data
        const formData = new FormData();
        formData.append('product_id', productId);
        formData.append('quantity', quantity);
        formData.append('action', 'update');
        
        // Send AJAX request
        fetch('../../controller/update-cart.php', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
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
        
        // Create form data
        const formData = new FormData();
        formData.append('product_id', productId);
        formData.append('action', 'remove');
        
        // Send AJAX request
        fetch('../../controller/update-cart.php', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
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
                        
                        // Update cart count in header if exists
                        const cartCountElement = document.querySelector('.cart-count');
                        if (cartCountElement) {
                            const currentCount = parseInt(cartCountElement.textContent);
                            if (!isNaN(currentCount) && currentCount > 0) {
                                cartCountElement.textContent = currentCount - 1;
                            }
                        }
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
        
        // Create form data
        const formData = new FormData();
        formData.append('action', 'clear');
        
        // Send AJAX request
        fetch('../../controller/update-cart.php', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
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