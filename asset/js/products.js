document.addEventListener('DOMContentLoaded', function() {
    // Grid/List View Toggle
    const gridViewBtn = document.querySelector('.grid-view');
    const listViewBtn = document.querySelector('.list-view');
    const productsGrid = document.querySelector('.products-grid');

    if (gridViewBtn && listViewBtn) {
        // Grid View
        gridViewBtn.addEventListener('click', function(e) {
            e.preventDefault();

            gridViewBtn.classList.add('active');
            listViewBtn.classList.remove('active');

            productsGrid.classList.remove('products-list');

            // Update product cards for grid view
            const productCards = document.querySelectorAll('.product-card');
            productCards.forEach(function(card) {
                // Remove list view specific elements
                const description = card.querySelector('.product-description');
                if (description) {
                    description.remove();
                }

                // Reset product info styles
                const productInfo = card.querySelector('.product-info');
                if (productInfo) {
                    productInfo.style.textAlign = '';
                }
            });
        });

        // List View
        listViewBtn.addEventListener('click', function(e) {
            e.preventDefault();

            listViewBtn.classList.add('active');
            gridViewBtn.classList.remove('active');

            productsGrid.classList.add('products-list');

            // Update product cards for list view
            const productCards = document.querySelectorAll('.product-card');
            productCards.forEach(function(card) {
                // Add description if it doesn't exist
                if (!card.querySelector('.product-description')) {
                    const productInfo = card.querySelector('.product-info');
                    const productTitle = card.querySelector('.product-title');

                    if (productInfo && productTitle) {
                        const description = document.createElement('p');
                        description.className = 'product-description';
                        description.textContent = 'Sản phẩm nông nghiệp hữu cơ, được trồng và thu hoạch theo tiêu chuẩn an toàn, không sử dụng thuốc trừ sâu và phân bón hóa học.';

                        productInfo.insertBefore(description, productTitle.nextSibling);

                        // Add "Add to Cart" button at the bottom
                        const addToCartBtn = document.createElement('a');
                        addToCartBtn.href = '#';
                        addToCartBtn.className = 'btn btn-success mt-3';
                        addToCartBtn.innerHTML = '<i class="fas fa-shopping-cart me-2"></i>Thêm vào giỏ hàng';

                        productInfo.appendChild(addToCartBtn);
                    }
                }
            });
        });
    }

    // Price Range Slider
    const priceRangeInput = document.querySelector('.price-range-slider input[type="range"]');
    const minPriceInput = document.querySelector('.price-range-slider input[type="number"]:first-of-type');
    const maxPriceInput = document.querySelector('.price-range-slider input[type="number"]:last-of-type');

    if (priceRangeInput && minPriceInput && maxPriceInput) {
        // Update range input when min/max inputs change
        minPriceInput.addEventListener('change', function() {
            updatePriceRange();
        });

        maxPriceInput.addEventListener('change', function() {
            updatePriceRange();
        });

        // Update min/max inputs when range input changes
        priceRangeInput.addEventListener('input', function() {
            const value = this.value;
            maxPriceInput.value = value;
        });

        function updatePriceRange() {
            const minValue = parseInt(minPriceInput.value);
            const maxValue = parseInt(maxPriceInput.value);

            if (minValue > maxValue) {
                // Swap values if min is greater than max
                minPriceInput.value = maxValue;
                maxPriceInput.value = minValue;
            }

            priceRangeInput.value = maxPriceInput.value;
        }
    }

    // Filter Checkboxes
    const filterCheckboxes = document.querySelectorAll('.sidebar-widget input[type="checkbox"]');

    filterCheckboxes.forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            // Here you would typically implement filtering logic
            // For demo purposes, we'll just log the selected filters
            console.log('Filter changed:', this.id, 'Checked:', this.checked);

            // You could trigger an AJAX request here to fetch filtered products
            // or filter the existing products on the client side
        });
    });

    // Sort By Dropdown
    const sortBySelect = document.querySelector('.sort-by select');

    if (sortBySelect) {
        sortBySelect.addEventListener('change', function() {
            const selectedOption = this.value;
            console.log('Sort by:', selectedOption);

            // Here you would implement sorting logic
            // For a real implementation, you might want to:
            // 1. Send an AJAX request to get sorted products
            // 2. Or sort the existing products on the client side
        });
    }
});