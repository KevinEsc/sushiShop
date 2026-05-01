// ─── Mobile Menu Toggle ───────────────────────────────────────────────────────
const menuBtn  = document.getElementById('menu-btn');
const mobileMenu = document.getElementById('mobile-menu');
const iconOpen = document.getElementById('icon-open');
const iconClose = document.getElementById('icon-close');

if (menuBtn) {
    menuBtn.addEventListener('click', () => {
        const isHidden = mobileMenu.classList.toggle('hidden');
        menuBtn.setAttribute('aria-expanded', !isHidden);
        iconOpen.classList.toggle('hidden', !isHidden);
        iconClose.classList.toggle('hidden', isHidden);
    });
}

// ─── Navbar scroll effect ────────────────────────────────────────────────────
const navbar = document.getElementById('navbar');
if (navbar) {
    window.addEventListener('scroll', () => {
        if (window.scrollY > 50) {
            navbar.classList.add('navbar-scrolled');
        } else {
            navbar.classList.remove('navbar-scrolled');
        }
    }, { passive: true });
}

// ─── Scroll-triggered reveal animations ──────────────────────────────────────
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px',
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.opacity = '1';
            entry.target.style.transform = 'translateY(0)';
            observer.unobserve(entry.target);
        }
    });
}, observerOptions);

// Apply to cards and articles
document.querySelectorAll('.glass-card, .product-card, article').forEach(el => {
    if (!el.closest('#navbar') && !el.closest('footer')) {
        el.style.opacity = '0';
        el.style.transform = 'translateY(20px)';
        el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(el);
    }
});
