/**
 * EchoForgeX Theme - Main JavaScript
 *
 * @package EchoForgeX
 * @version 1.0.0
 */

(function() {
    'use strict';

    /**
     * DOM Ready
     */
    document.addEventListener('DOMContentLoaded', function() {
        initSmoothScroll();
        initHeaderScroll();
        initMobileMenu();
        initNewsletterForm();
    });

    /**
     * Smooth scroll for anchor links
     */
    function initSmoothScroll() {
        document.querySelectorAll('a[href^="#"]').forEach(function(anchor) {
            anchor.addEventListener('click', function(e) {
                const targetId = this.getAttribute('href');
                if (targetId === '#') return;

                const targetElement = document.querySelector(targetId);
                if (targetElement) {
                    e.preventDefault();
                    targetElement.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    }

    /**
     * Header background change on scroll
     */
    function initHeaderScroll() {
        const header = document.querySelector('.site-header');
        if (!header) return;

        let lastScroll = 0;

        window.addEventListener('scroll', function() {
            const currentScroll = window.pageYOffset;

            // Add/remove scrolled class
            if (currentScroll > 50) {
                header.classList.add('header-scrolled');
            } else {
                header.classList.remove('header-scrolled');
            }

            // Hide/show header on scroll direction (optional)
            // if (currentScroll > lastScroll && currentScroll > 100) {
            //     header.classList.add('header-hidden');
            // } else {
            //     header.classList.remove('header-hidden');
            // }

            lastScroll = currentScroll;
        });
    }

    /**
     * Mobile menu toggle
     */
    function initMobileMenu() {
        const menuToggle = document.querySelector('.menu-toggle');
        const mobileMenu = document.querySelector('.main-navigation');

        if (!menuToggle || !mobileMenu) return;

        menuToggle.addEventListener('click', function() {
            this.classList.toggle('toggled');
            mobileMenu.classList.toggle('toggled');
            document.body.classList.toggle('menu-open');
        });

        // Close menu when clicking outside
        document.addEventListener('click', function(e) {
            if (!mobileMenu.contains(e.target) && !menuToggle.contains(e.target)) {
                menuToggle.classList.remove('toggled');
                mobileMenu.classList.remove('toggled');
                document.body.classList.remove('menu-open');
            }
        });
    }

    /**
     * Newsletter form handling
     */
    function initNewsletterForm() {
        const forms = document.querySelectorAll('.newsletter-form');

        forms.forEach(function(form) {
            form.addEventListener('submit', function(e) {
                // If using custom endpoint, handle here
                // Otherwise, let the form submit normally

                const emailInput = form.querySelector('input[type="email"]');
                const submitBtn = form.querySelector('button[type="submit"]');

                if (!emailInput.value) {
                    e.preventDefault();
                    emailInput.focus();
                    return;
                }

                // Add loading state
                if (submitBtn) {
                    submitBtn.textContent = 'Subscribing...';
                    submitBtn.disabled = true;
                }
            });
        });
    }

    /**
     * Animate elements on scroll (optional)
     */
    function initScrollAnimations() {
        const animatedElements = document.querySelectorAll('[data-animate]');

        if (!animatedElements.length) return;

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animated');
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        });

        animatedElements.forEach(function(el) {
            observer.observe(el);
        });
    }

    /**
     * Lazy load images (if not using native loading="lazy")
     */
    function initLazyLoad() {
        const lazyImages = document.querySelectorAll('img[data-src]');

        if (!lazyImages.length) return;

        const imageObserver = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.removeAttribute('data-src');
                    imageObserver.unobserve(img);
                }
            });
        });

        lazyImages.forEach(function(img) {
            imageObserver.observe(img);
        });
    }

})();
