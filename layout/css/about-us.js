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

    // Team Member Hover Effect
    const teamMembers = document.querySelectorAll('.team-member');

    teamMembers.forEach(function(member) {
        member.addEventListener('mouseenter', function() {
            const socialLinks = this.querySelector('.member-social');
            if (socialLinks) {
                socialLinks.style.bottom = '0';
            }
        });

        member.addEventListener('mouseleave', function() {
            const socialLinks = this.querySelector('.member-social');
            if (socialLinks) {
                socialLinks.style.bottom = '-50px';
            }
        });
    });

    // Animate elements on scroll
    function animateOnScroll() {
        const elements = document.querySelectorAll('.stat-item, .mission-box, .value-item, .team-member, .certification-item, .farm-item, .testimonial-item');

        elements.forEach(function(element) {
            const elementPosition = element.getBoundingClientRect().top;
            const screenPosition = window.innerHeight / 1.3;

            if (elementPosition < screenPosition) {
                element.style.opacity = '1';
                element.style.transform = 'translateY(0)';
            }
        });
    }

    // Set initial state for animation
    const animatedElements = document.querySelectorAll('.stat-item, .mission-box, .value-item, .team-member, .certification-item, .farm-item, .testimonial-item');

    animatedElements.forEach(function(element) {
        element.style.opacity = '0';
        element.style.transform = 'translateY(20px)';
        element.style.transition = 'all 0.5s ease';
    });

    // Run animation on page load and scroll
    window.addEventListener('load', animateOnScroll);
    window.addEventListener('scroll', animateOnScroll);

    // Smooth scroll for anchor links
    const anchorLinks = document.querySelectorAll('a[href^="#"]');

    anchorLinks.forEach(function(link) {
        link.addEventListener('click', function(e) {
            const targetId = this.getAttribute('href');

            if (targetId === '#') return;

            e.preventDefault();

            const targetElement = document.querySelector(targetId);

            if (targetElement) {
                window.scrollTo({
                    top: targetElement.offsetTop - 100,
                    behavior: 'smooth'
                });
            }
        });
    });

    // Newsletter form submission
    const newsletterForm = document.querySelector('.cta-form form');

    if (newsletterForm) {
        newsletterForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const emailInput = this.querySelector('input[type="email"]');
            const email = emailInput.value.trim();

            if (email) {
                // In a real implementation, you would:
                // 1. Validate the email
                // 2. Submit the form via AJAX
                // 3. Show a success message

                // For demo purposes, we'll just show an alert
                alert('Cảm ơn bạn đã đăng ký nhận bản tin của Nông Sản Xanh!');
                emailInput.value = '';
            }
        });
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
});