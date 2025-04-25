document.addEventListener('DOMContentLoaded', function() {
    // Form validation
    const registerForm = document.getElementById('registerForm');
    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('confirmPassword');
    const strengthIndicator = document.getElementById('strengthIndicator');
    const strengthText = document.getElementById('strengthText');

    // Initialize Bootstrap modal
    let bootstrap = window.bootstrap;
    let registrationSuccessModal;

    try {
        registrationSuccessModal = new bootstrap.Modal(document.getElementById('registrationSuccessModal'));
    } catch (error) {
        console.error("Bootstrap modal initialization failed:", error);
    }

    // Password strength checker
    if (password) {
        password.addEventListener('input', function() {
            const value = this.value;
            let strength = 0;
            let color = '';
            let text = '';

            if (value.length === 0) {
                strength = 0;
                color = '#eee';
                text = 'Chưa nhập';
            } else if (value.length < 6) {
                strength = 20;
                color = '#ff4d4d';
                text = 'Rất yếu';
            } else if (value.length < 8) {
                strength = 40;
                color = '#ffa64d';
                text = 'Yếu';
            } else {
                // Check for mixed case
                if (value.match(/[a-z]/) && value.match(/[A-Z]/)) {
                    strength += 20;
                }

                // Check for numbers
                if (value.match(/\d/)) {
                    strength += 20;
                }

                // Check for special characters
                if (value.match(/[^a-zA-Z\d]/)) {
                    strength += 20;
                }

                if (strength <= 60) {
                    color = '#ffff4d';
                    text = 'Trung bình';
                } else if (strength <= 80) {
                    color = '#4dff4d';
                    text = 'Mạnh';
                } else {
                    color = '#33cc33';
                    text = 'Rất mạnh';
                }
            }

            strengthIndicator.style.width = strength + '%';
            strengthIndicator.style.backgroundColor = color;
            strengthText.textContent = 'Độ mạnh: ' + text;
        });
    }

    // Form submission
    if (registerForm) {
        registerForm.addEventListener('submit', function(e) {
            e.preventDefault();

            if (!validateForm()) {
                return false;
            }

            // In a real implementation, you would:
            // 1. Collect form data
            // 2. Submit the data via AJAX to your server
            // 3. Handle the response

            // For demo purposes, we'll just show the success modal
            if (registrationSuccessModal) {
                registrationSuccessModal.show();
            } else {
                alert('Đăng ký thành công! Vui lòng kiểm tra email để xác nhận tài khoản.');
            }
        });
    }

    // Form validation function
    function validateForm() {
        let isValid = true;

        // Add validation classes
        registerForm.classList.add('was-validated');

        // Validate password strength
        if (password.value.length < 8) {
            password.setCustomValidity('Mật khẩu phải có ít nhất 8 ký tự');
            isValid = false;
        } else if (!password.value.match(/[a-z]/)) {
            password.setCustomValidity('Mật khẩu phải chứa ít nhất một chữ cái thường');
            isValid = false;
        } else if (!password.value.match(/[A-Z]/)) {
            password.setCustomValidity('Mật khẩu phải chứa ít nhất một chữ cái hoa');
            isValid = false;
        } else if (!password.value.match(/\d/)) {
            password.setCustomValidity('Mật khẩu phải chứa ít nhất một chữ số');
            isValid = false;
        } else {
            password.setCustomValidity('');
        }

        // Validate password confirmation
        if (password.value !== confirmPassword.value) {
            confirmPassword.setCustomValidity('Mật khẩu xác nhận không khớp');
            isValid = false;
        } else {
            confirmPassword.setCustomValidity('');
        }

        // Validate email format
        const email = document.getElementById('email');
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email.value)) {
            email.setCustomValidity('Vui lòng nhập địa chỉ email hợp lệ');
            isValid = false;
        } else {
            email.setCustomValidity('');
        }

        // Validate phone number
        const phone = document.getElementById('phone');
        const phoneRegex = /^[0-9]{10,11}$/;
        if (!phoneRegex.test(phone.value)) {
            phone.setCustomValidity('Vui lòng nhập số điện thoại hợp lệ (10-11 chữ số)');
            isValid = false;
        } else {
            phone.setCustomValidity('');
        }

        return isValid;
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
});