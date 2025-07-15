document.addEventListener('DOMContentLoaded', function() {

    // --- Navbar Scroll Effect ---
    const navbar = document.querySelector('.navbar');
    window.addEventListener('scroll', () => {
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });

    // --- Active Nav Link Highlighting on Scroll ---
    const sections = document.querySelectorAll('section[id]');
    const navLinks = document.querySelectorAll('.navbar-nav .nav-link');

    const observerOptions = {
        root: null,
        rootMargin: '0px',
        threshold: 0.6 
    };

    const sectionObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                navLinks.forEach(link => {
                    link.classList.remove('active');
                    if (link.getAttribute('href').substring(1) === entry.target.id) {
                        link.classList.add('active');
                    }
                });
            }
        });
    }, observerOptions);

    sections.forEach(section => {
        sectionObserver.observe(section);
    });
    
    // --- Fade-in Animation on Scroll ---
    const fadeElements = document.querySelectorAll('.fade-in');

    const fadeInObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1 });

    fadeElements.forEach(el => {
        fadeInObserver.observe(el);
    });

    // --- Certificate Modal Logic ---
    const certModal = new bootstrap.Modal(document.getElementById('certModal'));
    const modalImage = document.getElementById('modalImage');
    document.querySelectorAll('.cert-thumbnail').forEach(thumbnail => {
        thumbnail.addEventListener('click', function() {
            modalImage.src = this.src;
            certModal.show();
        });
    });

    // --- Auto-update Footer Year ---
    document.getElementById('year').textContent = new Date().getFullYear();

});