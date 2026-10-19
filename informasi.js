document.addEventListener('DOMContentLoaded', function () {
    // Initialize AOS with enhanced settings
    if (window.AOS) {
        AOS.init({
            duration: 1000,
            easing: 'ease-out-cubic',
            once: true,
            offset: 50,
            delay: 100
        });
    }

    // Smooth scroll for all internal links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const href = this.getAttribute('href');
            if (href.length > 1) {
                const target = document.querySelector(href);
                if (target) {
                    e.preventDefault();
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            }
        });
    });

    // Enhanced contact items interaction
    const contactItems = document.querySelectorAll('.contact-item');
    contactItems.forEach(item => {
        item.addEventListener('click', function () {
            const text = this.getAttribute('data-text') || this.textContent.trim();
            fallbackCopyText(text);
        });

        // Add hover effect
        item.addEventListener('mouseenter', function () {
            this.style.cursor = 'pointer';
            this.style.backgroundColor = 'rgba(102, 126, 234, 0.1)';
            this.style.borderRadius = '8px';
            this.style.padding = '5px';
        });

        item.addEventListener('mouseleave', function () {
            this.style.backgroundColor = 'transparent';
            this.style.padding = '0';
        });
    });

    // Fallback copy function
    function fallbackCopyText(text) {
        const textArea = document.createElement('textarea');
        textArea.value = text;
        textArea.style.position = 'fixed';
        textArea.style.left = '-999999px';
        textArea.style.top = '-999999px';
        document.body.appendChild(textArea);
    // Fallback copy function using Clipboard API if available, else fallback to textarea method
    function fallbackCopyText(text) {
        if (navigator.clipboard && window.isSecureContext) {
            navigator.clipboard.writeText(text).then(() => {
                showToast('✓ Tersalin!', 'success');
            }).catch(() => {
                showToast('Gagal menyalin teks', 'error');
            });
        } else {
            const textArea = document.createElement('textarea');
            textArea.value = text;
            textArea.style.position = 'fixed';
            textArea.style.left = '-999999px';
            textArea.style.top = '-999999px';
            document.body.appendChild(textArea);
            textArea.focus();
            textArea.select();

            try {
                document.execCommand && document.execCommand('copy');
                showToast('✓ Tersalin!', 'success');
            } catch (err) {
                showToast('Gagal menyalin teks', 'error');
            }

            document.body.removeChild(textArea);
        }
    }
        toast.innerHTML = `
            <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i>
            <span>${message}</span>
        `;
        toast.style.opacity = '0';
        toast.style.transform = 'translateY(-20px)';
        toast.style.transition = 'opacity 0.3s, transform 0.3s';
        document.body.appendChild(toast);

        requestAnimationFrame(() => {
            toast.style.opacity = '1';
            toast.style.transform = 'translateY(0)';
        });

        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transform = 'translateY(-20px)';
            setTimeout(() => {
                if (toast.parentNode) toast.remove();
            }, 300);
        }, 2700);
    }

    // Intersection Observer for scroll animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('show');
            }
        });
    }, observerOptions);

    document.querySelectorAll('.info-card, .footer-section').forEach(el => {
        observer.observe(el);
    });

    // Add loading animation
    window.addEventListener('load', function () {
        document.body.classList.add('loaded');
    });

    // Add keyboard navigation
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            document.querySelectorAll('.toast').forEach(toast => toast.remove());
        }
    });

    // Add focus management for accessibility
    document.querySelectorAll('a, button, input, select, textarea, [tabindex]:not([tabindex="-1"])')
        .forEach(element => {
            element.addEventListener('focus', function () {
                this.style.outline = '2px solid #667eea';
                this.style.outlineOffset = '2px';
            });
            element.addEventListener('blur', function () {
                this.style.outline = 'none';
            });
        });

    // Error handling for external scripts
    window.addEventListener('error', function (e) {
        console.warn('Script error handled:', e.error);
    });

    // Add preload for critical resources and apply as stylesheet after load
    const preloadLinks = [
        'https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css'
    ];
    preloadLinks.forEach(href => {
        const link = document.createElement('link');
        link.rel = 'preload';
        link.as = 'style';
        link.href = href;
        link.onload = function () {
            this.rel = 'stylesheet';
        };
        document.head.appendChild(link);
    });

    // Initialize page visibility API for performance
    document.addEventListener('visibilitychange', function () {
        document.body.style.animationPlayState = document.hidden ? 'paused' : 'running';
    });

    // Feedback form reveal animation
    const feedbackSection = document.querySelector('.feedback-section');
    if (feedbackSection) {
        const observerFeedback = new IntersectionObserver(entries => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    feedbackSection.classList.add('show');
                }
            });
        }, { threshold: 0.2 });
        observerFeedback.observe(feedbackSection);
    }

    console.log('InkuLearn initialized successfully');
});

// Service Worker registration for better performance (optional)
if ('serviceWorker' in navigator) {
    window.addEventListener('load', function () {
        // Uncomment below to register service worker if sw.js exists
        // navigator.serviceWorker.register('/sw.js');
    });
}
