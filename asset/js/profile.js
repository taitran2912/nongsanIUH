document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    
    // Declare bootstrap variable
    let bootstrap = window.bootstrap;
    
    try {
        tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    } catch (error) {
        console.error("Bootstrap tooltip initialization failed:", error);
    }
    
    
    // Profile form submission
    const profileForm = document.getElementById('profileForm');
    
    if (profileForm) {
        profileForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // In a real implementation, you would:
            // 1. Collect form data
            // 2. Submit the data via AJAX to your server
            // 3. Handle the response
            
            // For demo purposes, we'll just show an alert
            alert('Thông tin cá nhân đã được cập nhật thành công!');
        });
    }
    
    // Password form submission
    const passwordForm = document.getElementById('passwordForm');
    
    if (passwordForm) {
        passwordForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const currentPassword = document.getElementById('currentPassword').value;
            const newPassword = document.getElementById('newPassword').value;
            const confirmNewPassword = document.getElementById('confirmNewPassword').value;
            
            // Simple validation
            if (!currentPassword || !newPassword || !confirmNewPassword) {
                alert('Vui lòng điền đầy đủ thông tin');
                return;
            }
            
            if (newPassword !== confirmNewPassword) {
                alert('Mật khẩu mới và xác nhận mật khẩu không khớp');
                return;
            }
            
            // In a real implementation, you would:
            // 1. Validate the current password
            // 2. Submit the data via AJAX to your server
            // 3. Handle the response
            
            // For demo purposes, we'll just show an alert
            alert('Mật khẩu đã được cập nhật thành công!');
            
            // Reset form
            passwordForm.reset();
        });
    }
    
    // Notification form submission
    const notificationForm = document.getElementById('notificationForm');
    
    if (notificationForm) {
        notificationForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // In a real implementation, you would:
            // 1. Collect form data
            // 2. Submit the data via AJAX to your server
            // 3. Handle the response
            
            // For demo purposes, we'll just show an alert
            alert('Cài đặt thông báo đã được cập nhật thành công!');
        });
    }
    
    // Delete account confirmation
    const deleteAccountModal = document.getElementById('deleteAccountModal');
    const deleteConfirmInput = document.getElementById('deleteConfirm');
    const deleteAccountBtn = document.querySelector('#deleteAccountModal .btn-danger');
    
    if (deleteConfirmInput && deleteAccountBtn) {
        deleteConfirmInput.addEventListener('input', function() {
            if (this.value === 'XÓA TÀI KHOẢN') {
                deleteAccountBtn.disabled = false;
            } else {
                deleteAccountBtn.disabled = true;
            }
        });
        
        deleteAccountBtn.addEventListener('click', function() {
            // In a real implementation, you would:
            // 1. Submit the request via AJAX to your server
            // 2. Handle the response
            
            // For demo purposes, we'll just show an alert
            alert('Tài khoản của bạn đã được xóa thành công!');
            
            // Close modal
            const modal = bootstrap.Modal.getInstance(deleteAccountModal);
            if (modal) {
                modal.hide();
            }
            
            // Redirect to home page
            window.location.href = 'index.html';
        });
    }
    
    // Address form submission
    const addressForm = document.querySelector('#addAddressModal .btn-success');
    
    if (addressForm) {
        addressForm.addEventListener('click', function() {
            // In a real implementation, you would:
            // 1. Collect form data
            // 2. Submit the data via AJAX to your server
            // 3. Handle the response
            
            // For demo purposes, we'll just show an alert
            alert('Địa chỉ mới đã được thêm thành công!');
            
            // Close modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('addAddressModal'));
            if (modal) {
                modal.hide();
            }
            
            // Reset form
            document.getElementById('addressForm').reset();
        });
    }
    
    // Province, District, Ward selects
    const provinceSelect = document.getElementById('province');
    const districtSelect = document.getElementById('district');
    const wardSelect = document.getElementById('ward');
    
    if (provinceSelect && districtSelect) {
        provinceSelect.addEventListener('change', function() {
            // Clear previous options
            districtSelect.innerHTML = '<option selected>Chọn...</option>';
            if (wardSelect) {
                wardSelect.innerHTML = '<option selected>Chọn...</option>';
            }
            
            // In a real implementation, you would:
            // 1. Fetch districts based on the selected province
            // 2. Populate the district select
            
            // For demo purposes, we'll add some dummy data
            if (this.value === 'TP. Hồ Chí Minh') {
                const districts = ['Quận 1', 'Quận 2', 'Quận 3', 'Quận 4', 'Quận 5'];
                
                districts.forEach(function(district) {
                    const option = document.createElement('option');
                    option.text = district;
                    option.value = district;
                    districtSelect.add(option);
                });
            }
        });
        
        districtSelect.addEventListener('change', function() {
            if (wardSelect) {
                // Clear previous options
                wardSelect.innerHTML = '<option selected>Chọn...</option>';
                
                // In a real implementation, you would:
                // 1. Fetch wards based on the selected district
                // 2. Populate the ward select
                
                // For demo purposes, we'll add some dummy data
                if (this.value === 'Quận 1') {
                    const wards = ['Phường Bến Nghé', 'Phường Bến Thành', 'Phường Cầu Kho', 'Phường Cầu Ông Lãnh'];
                    
                    wards.forEach(function(ward) {
                        const option = document.createElement('option');
                        option.text = ward;
                        option.value = ward;
                        wardSelect.add(option);
                    });
                }
            }
        });
    }
    
    // Toggle password visibility
    window.togglePassword = function(inputId) {
        const input = document.getElementById(inputId);
        const icon = input.nextElementSibling.querySelector('i');
        
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    };
    
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
    
    // Handle tab navigation from URL hash
    function handleTabNavigation() {
        const hash = window.location.hash;
        
        if (hash) {
            const tabId = hash.substring(1); // Remove the # character
            const tabElement = document.querySelector(`.profile-nav .nav-link[href="#${tabId}"]`);
            
            if (tabElement) {
                tabElement.click();
            }
        }
    }
    
    // Run on page load
    handleTabNavigation();
    
    // Run when hash changes
    window.addEventListener('hashchange', handleTabNavigation);
});