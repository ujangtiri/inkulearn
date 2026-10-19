document.addEventListener('DOMContentLoaded', function () {
    // Active navigation link handler
    const navLinks = document.querySelectorAll('.nav-link');
    const currentPage = window.location.pathname.split('/').pop();

    navLinks.forEach(link => {
        const href = link.getAttribute('href');
        if (href === currentPage) {
            link.classList.add('active');
        } else {
            link.classList.remove('active');
        }
    });

    // Initialize animations after DOM is loaded
    initScrollAnimations();
});

// Intersection Observer configuration
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
};

// Basic scroll animation for elements with .scroll-animate class
function addScrollAnimation() {
    const elements = document.querySelectorAll('.scroll-animate');
    if (elements.length === 0) return;
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-in');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    elements.forEach(element => {
        observer.observe(element);
    });
}

// Feature cards animation with staggered delay
function animateFeatureCards() {
    const featureItems = document.querySelectorAll('.feature-item');
    if (featureItems.length === 0) return;
    
    const cardObserver = new IntersectionObserver((entries) => {
        entries.forEach((entry, index) => {
            if (entry.isIntersecting) {
                setTimeout(() => {
                    entry.target.classList.add('card-animate-in');
                }, index * 200);
                cardObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.2 });

    featureItems.forEach(item => {
        item.classList.add('card-hidden');
        cardObserver.observe(item);
    });
}

// Directional reveal animation
function directionalReveal() {
    const revealElements = document.querySelectorAll('.reveal-left, .reveal-right, .reveal-up, .reveal-down');
    if (revealElements.length === 0) return;
    
    const revealObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('revealed');
                revealObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.15 });

    revealElements.forEach(element => {
        revealObserver.observe(element);
    });
}

// Smooth scroll for anchor links
function smoothScrollLinks() {
    const scrollLinks = document.querySelectorAll('a[href^="#"]');
    
    scrollLinks.forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
            
            const targetId = link.getAttribute('href');
            const targetElement = document.querySelector(targetId);
            
            if (targetElement) {
                const offsetTop = targetElement.offsetTop - 80;
                
                window.scrollTo({
                    top: offsetTop,
                    behavior: 'smooth'
                });
            }
        });
    });
}

// Scroll to top button functionality
function initScrollToTop() {
    const scrollBtn = document.querySelector('.scroll-to-top');
    
    if (scrollBtn) {
        window.addEventListener('scroll', () => {
            if (window.pageYOffset > 300) {
                scrollBtn.classList.add('show-scroll-btn');
            } else {
                scrollBtn.classList.remove('show-scroll-btn');
            }
        }, { passive: true });

        scrollBtn.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }
}

// Initialize all animations and functionality
function initScrollAnimations() {
    addScrollAnimation();
    animateFeatureCards();
    directionalReveal();
    smoothScrollLinks();
    initNavbarScroll();
    initScrollToTop();
    
    console.log('🎉 InkuLearn Optimized Animations Initialized!');
}

// CSS styles for animations (only essential ones)
const essentialCSS = `
/* Essential scroll animation classes */
.scroll-animate {
    opacity: 0;
    transform: translateY(30px);
    transition: all 0.6s ease-out;
}

.scroll-animate.animate-in {
    opacity: 1;
    transform: translateY(0);
}

/* Feature cards animation */
.card-hidden {
    opacity: 0;
    transform: translateY(50px) scale(0.9);
    transition: all 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}

.card-animate-in {
    opacity: 1 !important;
    transform: translateY(0) scale(1) !important;
}

/* Directional reveals */
.reveal-left {
    opacity: 0;
    transform: translateX(-50px);
    transition: all 0.8s ease-out;
}

.reveal-right {
    opacity: 0;
    transform: translateX(50px);
    transition: all 0.8s ease-out;
}

.reveal-up {
    opacity: 0;
    transform: translateY(50px);
    transition: all 0.8s ease-out;
}

.reveal-down {
    opacity: 0;
    transform: translateY(-50px);
    transition: all 0.8s ease-out;
}

.revealed {
    opacity: 1 !important;
    transform: translate(0) !important;
}

/* Scroll to top button */
.scroll-to-top {
    position: fixed;
    bottom: 30px;
    right: 30px;
    width: 50px;
    height: 50px;
    background: linear-gradient(45deg, #667eea, #764ba2);
    color: white;
    border: none;
    border-radius: 50%;
    cursor: pointer;
    opacity: 0;
    transform: translateY(20px);
    transition: all 0.3s ease;
    z-index: 1000;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
}

.show-scroll-btn {
    opacity: 1;
    transform: translateY(0);
}

.scroll-to-top:hover {
    transform: translateY(-5px) scale(1.1);
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
}

/* Header transition */
header {
    transition: all 0.3s ease;
}
`;

// Inject essential CSS if not already present
if (!document.querySelector('#optimized-scroll-styles')) {
    const styleSheet = document.createElement('style');
    styleSheet.id = 'optimized-scroll-styles';
    styleSheet.textContent = essentialCSS;
    document.head.appendChild(styleSheet);
}