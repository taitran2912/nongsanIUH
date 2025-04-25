document.addEventListener('DOMContentLoaded', function() {
    // Checkout Steps Navigation
    const checkoutSteps = document.querySelectorAll('.checkout-step');
    const progressItems = document.querySelectorAll('.progress-item');
    const nextButtons = document.querySelectorAll('.btn-next');
    const prevButtons = document.querySelectorAll('.btn-prev');
    const editButtons = document.querySelectorAll('.btn-edit');

    // Next Step Buttons
    nextButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            const nextStep = parseInt(this.getAttribute('data-next'));
            goToStep(nextStep);
        });
    });

    // Previous Step Buttons
    prevButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            const prevStep = parseInt(this.getAttribute('data-prev'));
            goToStep(prevStep);
        });
    });

    // Edit Step Buttons
    editButtons.forEach(function(button) {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const editStep = parseInt(this.getAttribute('data-step'));
            goToStep(editStep);
        });
    });

    // Function to navigate to a specific step
    function goToStep(stepNumber) {
        // Hide all steps
        checkoutSteps.forEach(function(step) {
            step.classList.remove('active');
        });

        // Show the target step
        document.getElementById('step-' + stepNumber).classList.add('active');

        // Update progress indicators
        progressItems.forEach(function(item, index) {
            const itemStep = index + 1;

            if (itemStep < stepNumber) {
                item.classList.add('completed');
                item.classList.remove('active');
            } else if (itemStep === stepNumber) {
                item.classList.add('active');
                item.classList.remove('completed');
            } else {
                item.classList.remove('active', 'completed');
            }
        });

        // Scroll to top of the checkout section
        document.querySelector('.checkout-section').scrollIntoView({ behavior: 'smooth' });
    }

    // Address Selection
    const addressRadios = document.querySelectorAll('input[name="address"]');

    addressRadios.forEach(function(radio) {
        radio.addEventListener('change', function() {
            // Remove selected class from all address items
            document.querySelectorAll('.address-item').forEach(function(item) {
                item.classList.remove('selected');
            });

            // Add selected class to the parent of the checked radio
            this.closest('.address-item').classList.add('selected');

            // Update the address in the order summary
            updateOrderSummary();
        });
    });

    // Add New Address
    const btnAddAddress = document.getElementById('btn-add-address');
    const btnCancelAddress = document.getElementById('btn-cancel-address');
    const newAddressForm = document.querySelector('.new-address-form');

    if (btnAddAddress && newAddressForm) {
        btnAddAddress.addEventListener('click', function() {
            newAddressForm.style.display = 'block';
            btnAddAddress.style.display = 'none';
        });
    }

    if (btnCancelAddress && newAddressForm) {
        btnCancelAddress.addEventListener('click', function() {
            newAddressForm.style.display = 'none';
            btnAddAddress.style.display = 'block';
        });
    }

    // Address Form Submission
    const addressForm = document.getElementById('address-form');

    if (addressForm) {
        addressForm.addEventListener('submit', function(e) {
            e.preventDefault();

            // Here you would typically:
            // 1. Validate the form
            // 2. Submit the data via AJAX
            // 3. Add the new address to the list
            // 4. Hide the form

            // For demo purposes, we'll just hide the form
            newAddressForm.style.display = 'none';
            btnAddAddress.style.display = 'block';

            // Show a success message
            alert('Địa chỉ mới đã được thêm thành công!');
        });
    }

    // Province, District, Ward Selectors
    const provinceSelect = document.getElementById('province');
    const districtSelect = document.getElementById('district');
    const wardSelect = document.getElementById('ward');

    if (provinceSelect && districtSelect) {
        provinceSelect.addEventListener('change', function() {
            // Clear district and ward selects
            districtSelect.innerHTML = '<option value="">Chọn Quận/Huyện</option>';
            if (wardSelect) {
                wardSelect.innerHTML = '<option value="">Chọn Phường/Xã</option>';
            }

            const provinceValue = this.value;

            if (provinceValue) {
                // In a real implementation, you would:
                // 1. Make an AJAX request to get districts for the selected province
                // 2. Populate the district select with the results

                // For demo purposes, we'll add some dummy data
                if (provinceValue === 'HCM') {
                    addOption(districtSelect, 'Q1', 'Quận 1');
                    addOption(districtSelect, 'Q2', 'Quận 2');
                    addOption(districtSelect, 'Q3', 'Quận 3');
                } else if (provinceValue === 'HN') {
                    addOption(districtSelect, 'HBT', 'Hai Bà Trưng');
                    addOption(districtSelect, 'HK', 'Hoàn Kiếm');
                    addOption(districtSelect, 'CG', 'Cầu Giấy');
                } else if (provinceValue === 'DN') {
                    addOption(districtSelect, 'HC', 'Hải Châu');
                    addOption(districtSelect, 'LCh', 'Liên Chiểu');
                    addOption(districtSelect, 'ST', 'Sơn Trà');
                }
            }
        });
    }

    if (districtSelect && wardSelect) {
        districtSelect.addEventListener('change', function() {
            // Clear ward select
            wardSelect.innerHTML = '<option value="">Chọn Phường/Xã</option>';

            const districtValue = this.value;

            if (districtValue) {
                // In a real implementation, you would:
                // 1. Make an AJAX request to get wards for the selected district
                // 2. Populate the ward select with the results

                // For demo purposes, we'll add some dummy data
                if (districtValue === 'Q1') {
                    addOption(wardSelect, 'BN', 'Bến Nghé');
                    addOption(wardSelect, 'CK', 'Cầu Kho');
                    addOption(wardSelect, 'DK', 'Đa Kao');
                } else if (districtValue === 'HBT') {
                    addOption(wardSelect, 'BT', 'Bách Khoa');
                    addOption(wardSelect, 'QB', 'Quỳnh Lôi');
                    addOption(wardSelect, 'TM', 'Thanh Nhàn');
                } else {
                    // Add some generic wards for other districts
                    addOption(wardSelect, 'P1', 'Phường 1');
                    addOption(wardSelect, 'P2', 'Phường 2');
                    addOption(wardSelect, 'P3', 'Phường 3');
                }
            }
        });
    }

    // Helper function to add options to a select element
    function addOption(selectElement, value, text) {
        const option = document.createElement('option');
        option.value = value;
        option.textContent = text;
        selectElement.appendChild(option);
    }

    // Shipping Method Selection
    const shippingRadios = document.querySelectorAll('input[name="shipping"]');

    shippingRadios.forEach(function(radio) {
        radio.addEventListener('change', function() {
            // Remove selected class from all shipping method items
            document.querySelectorAll('.shipping-method-item').forEach(function(item) {
                item.classList.remove('selected');
            });

            // Add selected class to the parent of the checked radio
            this.closest('.shipping-method-item').classList.add('selected');

            // Update shipping method in the order summary
            updateOrderSummary();
        });
    });

    // Payment Method Selection
    const paymentRadios = document.querySelectorAll('input[name="payment"]');
    const creditCardForm = document.querySelector('.credit-card-form');
    const bankTransferInfo = document.querySelector('.bank-transfer-info');

    paymentRadios.forEach(function(radio) {
        radio.addEventListener('change', function() {
            // Remove selected class from all payment method items
            document.querySelectorAll('.payment-method-item').forEach(function(item) {
                item.classList.remove('selected');
            });

            // Add selected class to the parent of the checked radio
            this.closest('.payment-method-item').classList.add('selected');

            // Show/hide additional payment forms
            const paymentMethod = this.id;

            if (creditCardForm) {
                creditCardForm.style.display = paymentMethod === 'payment-2' ? 'block' : 'none';
            }

            if (bankTransferInfo) {
                bankTransferInfo.style.display = paymentMethod === 'payment-3' ? 'block' : 'none';
            }

            // Update payment method in the order summary
            updateOrderSummary();
        });
    });

    // Coupon Code
    const couponForm = document.querySelector('.coupon-form');
    const appliedCoupons = document.querySelector('.applied-coupons');
    const removeCouponBtn = document.querySelector('.btn-remove-coupon');

    if (couponForm) {
        couponForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const couponInput = this.querySelector('input');
            const couponCode = couponInput.value.trim();

            if (couponCode) {
                // In a real implementation, you would:
                // 1. Validate the coupon code via AJAX
                // 2. Apply the discount to the order
                // 3. Update the order summary

                // For demo purposes, we'll just show a success message
                alert('Mã giảm giá đã được áp dụng!');
                couponInput.value = '';

                // Update the order summary
                updateOrderSummary();
            }
        });
    }

    if (removeCouponBtn) {
        removeCouponBtn.addEventListener('click', function() {
            // In a real implementation, you would:
            // 1. Remove the coupon from the order
            // 2. Update the order summary

            // For demo purposes, we'll just hide the coupon item
            this.closest('.coupon-item').style.display = 'none';

            // Update the order summary
            updateOrderSummary();
        });
    }

    // Place Order Button
    const placeOrderBtn = document.getElementById('btn-place-order');
    let orderSuccessModal;
    try {
        orderSuccessModal = new bootstrap.Modal(document.getElementById('orderSuccessModal'));
    } catch (error) {
        console.error("Bootstrap modal initialization failed:", error);
        orderSuccessModal = null;
    }

    if (placeOrderBtn) {
        placeOrderBtn.addEventListener('click', function() {
            // In a real implementation, you would:
            // 1. Validate all required fields
            // 2. Submit the order via AJAX
            // 3. Show a success message or redirect to a confirmation page

            // For demo purposes, we'll just show the success modal
            if (orderSuccessModal) {
                orderSuccessModal.show();
            } else {
                alert("Order placed successfully (modal failed to load).");
            }
        });
    }

    // Function to update the order summary based on selected options
    function updateOrderSummary() {
        // In a real implementation, you would:
        // 1. Get the selected address, shipping method, and payment method
        // 2. Calculate the order total
        // 3. Update the order summary

        // For demo purposes, we'll just log the selected options
        const selectedAddress = document.querySelector('input[name="address"]:checked');
        const selectedShipping = document.querySelector('input[name="shipping"]:checked');
        const selectedPayment = document.querySelector('input[name="payment"]:checked');

        console.log('Selected Address:', selectedAddress ? selectedAddress.id : 'None');
        console.log('Selected Shipping:', selectedShipping ? selectedShipping.id : 'None');
        console.log('Selected Payment:', selectedPayment ? selectedPayment.id : 'None');
    }

    // Initialize the checkout page
    function initCheckout() {
        // Start at step 1
        goToStep(1);

        // Update the order summary
        updateOrderSummary();
    }

    // Initialize the checkout page
    initCheckout();
});