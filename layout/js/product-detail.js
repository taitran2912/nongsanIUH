document.addEventListener('DOMContentLoaded', function() {
    // Product Image Gallery
    const mainImg = document.getElementById('main-img');
    const thumbnails = document.querySelectorAll('.thumbnail');

    thumbnails.forEach(function(thumbnail) {
        thumbnail.addEventListener('click', function() {
            // Update main image
            const imgUrl = this.getAttribute('data-img');
            mainImg.src = imgUrl;

            // Update active thumbnail
            thumbnails.forEach(function(thumb) {
                thumb.classList.remove('active');
            });
            this.classList.add('active');
        });
    });

    // Quantity Selector
    const quantityInput = document.querySelector('.quantity-input');
    const decreaseBtn = document.getElementById('decrease-quantity');
    const increaseBtn = document.getElementById('increase-quantity');

    if (quantityInput && decreaseBtn && increaseBtn) {
        decreaseBtn.addEventListener('click', function() {
            let value = parseInt(quantityInput.value);
            if (value > 1) {
                value--;
                quantityInput.value = value;
            }
        });

        increaseBtn.addEventListener('click', function() {
            let value = parseInt(quantityInput.value);
            const max = parseInt(quantityInput.getAttribute('max'));
            if (value < max) {
                value++;
                quantityInput.value = value;
            }
        });

        quantityInput.addEventListener('change', function() {
            let value = parseInt(this.value);
            const min = parseInt(this.getAttribute('min'));
            const max = parseInt(this.getAttribute('max'));

            if (value < min) {
                this.value = min;
            } else if (value > max) {
                this.value = max;
            }
        });
    }

    // Product Options
    const optionBtns = document.querySelectorAll('.option-btn');

    optionBtns.forEach(function(btn) {
        btn.addEventListener('click', function() {
            // Find parent option group
            const optionGroup = this.closest('.option-group');

            // Remove active class from all buttons in this group
            const groupBtns = optionGroup.querySelectorAll('.option-btn');
            groupBtns.forEach(function(groupBtn) {
                groupBtn.classList.remove('active');
            });

            // Add active class to clicked button
            this.classList.add('active');

            // Here you would typically update price, SKU, etc. based on selected options
            updateProductDetails();
        });
    });

    // Function to update product details based on selected options
    function updateProductDetails() {
        // Get selected options
        const selectedOptions = [];
        document.querySelectorAll('.option-group').forEach(function(group) {
            const activeBtn = group.querySelector('.option-btn.active');
            if (activeBtn) {
                selectedOptions.push(activeBtn.textContent);
            }
        });

        console.log('Selected options:', selectedOptions);

        // In a real implementation, you would:
        // 1. Look up the variant based on selected options
        // 2. Update price, availability, SKU, etc.
        // 3. Update the add to cart button state
    }

    // Initialize tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));

    // Declare bootstrap variable
    let bootstrap = window.bootstrap;

    tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Product Tabs
    const tabLinks = document.querySelectorAll('.product-tabs .nav-link');
    const tabContents = document.querySelectorAll('.product-tab-content .tab-pane');

    tabLinks.forEach(function(tabLink) {
        tabLink.addEventListener('click', function(e) {
            e.preventDefault();

            // Remove active class from all tab links
            tabLinks.forEach(function(link) {
                link.classList.remove('active');
            });

            // Add active class to clicked tab link
            this.classList.add('active');

            // Hide all tab contents
            tabContents.forEach(function(content) {
                content.classList.remove('show', 'active');
            });

            // Show the corresponding tab content
            const targetId = this.getAttribute('data-bs-target');
            const targetContent = document.querySelector(targetId);
            if (targetContent) {
                targetContent.classList.add('show', 'active');
            }
        });
    });

    // Review Filter Buttons
    const filterBtns = document.querySelectorAll('.filter-btn');

    filterBtns.forEach(function(btn) {
        btn.addEventListener('click', function() {
            // Remove active class from all filter buttons
            filterBtns.forEach(function(filterBtn) {
                filterBtn.classList.remove('active');
            });

            // Add active class to clicked filter button
            this.classList.add('active');

            // Here you would typically filter reviews based on selected filter
            const filter = this.textContent;
            console.log('Filter reviews by:', filter);

            // For demo purposes, we'll just log the filter
            // In a real implementation, you would:
            // 1. Send an AJAX request to get filtered reviews
            // 2. Or filter the existing reviews on the client side
        });
    });

    // Add to Cart Button
    const addToCartBtn = document.querySelector('.product-actions-btn .btn-outline-success');

    if (addToCartBtn) {
        addToCartBtn.addEventListener('click', function() {
            // Get product details
            const productName = document.querySelector('.product-title').textContent;
            const productPrice = document.querySelector('.current-price').textContent;
            const quantity = parseInt(document.querySelector('.quantity-input').value);

            // Get selected options
            const selectedOptions = [];
            document.querySelectorAll('.option-group').forEach(function(group) {
                const activeBtn = group.querySelector('.option-btn.active');
                if (activeBtn) {
                    selectedOptions.push(activeBtn.textContent);
                }
            });

            // Create cart item object
            const cartItem = {
                name: productName,
                price: productPrice,
                quantity: quantity,
                options: selectedOptions,
                image: mainImg.src
            };

            console.log('Adding to cart:', cartItem);

            // Here you would typically:
            // 1. Add the item to the cart (localStorage, sessionStorage, or send to server)
            // 2. Update the cart count in the header
            // 3. Show a success message

            // For demo purposes, we'll just show an alert
            alert('Sản phẩm đã được thêm vào giỏ hàng!');
        });
    }

    // Buy Now Button
    const buyNowBtn = document.querySelector('.product-actions-btn .btn-success');

    if (buyNowBtn) {
        buyNowBtn.addEventListener('click', function() {
            // Similar to add to cart, but redirect to checkout
            console.log('Buy now clicked');

            // For demo purposes, we'll just show an alert
            alert('Đang chuyển đến trang thanh toán...');

            // In a real implementation, you would:
            // 1. Add the item to the cart
            // 2. Redirect to the checkout page
            // window.location.href = 'checkout.html';
        });
    }
});