/**
 * CampusFinder - Main JavaScript
 * Handles: responsive nav, scroll effects, UI interactions
 */

document.addEventListener('DOMContentLoaded', function () {

    // ========================================
    // NAVBAR: Scroll effect + Mobile toggle
    // ========================================
    const navbar = document.querySelector('.navbar');
    const navToggler = document.querySelector('.navbar-toggler');
    const mobileMenu = document.querySelector('.mobile-menu');

    // Scroll effect
    function handleScroll() {
        if (window.scrollY > 20) {
            navbar && navbar.classList.add('scrolled');
        } else {
            navbar && navbar.classList.remove('scrolled');
        }
    }
    window.addEventListener('scroll', handleScroll, { passive: true });
    handleScroll();

    // Mobile menu toggle
    if (navToggler && mobileMenu) {
        navToggler.addEventListener('click', function () {
            mobileMenu.classList.toggle('open');
            // Animate hamburger
            const spans = navToggler.querySelectorAll('span');
            navToggler.classList.toggle('active');
            if (navToggler.classList.contains('active')) {
                if (spans[0]) { spans[0].style.transform = 'rotate(45deg) translate(5px, 5px)'; }
                if (spans[1]) { spans[1].style.opacity = '0'; }
                if (spans[2]) { spans[2].style.transform = 'rotate(-45deg) translate(5px, -5px)'; }
            } else {
                if (spans[0]) { spans[0].style.transform = ''; }
                if (spans[1]) { spans[1].style.opacity = '1'; }
                if (spans[2]) { spans[2].style.transform = ''; }
            }
        });

        // Close mobile menu on outside click
        document.addEventListener('click', function (e) {
            if (!navToggler.contains(e.target) && !mobileMenu.contains(e.target)) {
                mobileMenu.classList.remove('open');
                navToggler.classList.remove('active');
                const spans = navToggler.querySelectorAll('span');
                spans.forEach(s => s.style = '');
            }
        });
    }

    // ========================================
    // FILTER PILLS: Active toggle
    // ========================================
    document.querySelectorAll('.filter-pills').forEach(function (group) {
        group.querySelectorAll('.filter-pill').forEach(function (pill) {
            pill.addEventListener('click', function () {
                group.querySelectorAll('.filter-pill').forEach(p => p.classList.remove('active'));
                pill.classList.add('active');
            });
        });
    });

    // ========================================
    // TAGS: Active toggle
    // ========================================
    document.querySelectorAll('.search-tags').forEach(function (group) {
        group.querySelectorAll('.tag').forEach(function (tag) {
            tag.addEventListener('click', function () {
                tag.classList.toggle('active');
            });
        });
    });

    // ========================================
    // FAVORITE BUTTON
    // ========================================
    document.querySelectorAll('.campus-fav-btn').forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            btn.classList.toggle('active');
            const svg = btn.querySelector('svg');
            if (btn.classList.contains('active')) {
                if (svg) svg.style.color = '#EF4444';
            } else {
                if (svg) svg.style.color = '';
            }
        });
    });

    // ========================================
    // DETAIL TABS
    // ========================================
    document.querySelectorAll('.detail-tabs').forEach(function (tabGroup) {
        const tabs = tabGroup.querySelectorAll('.detail-tab');
        tabs.forEach(function (tab) {
            tab.addEventListener('click', function () {
                tabs.forEach(t => t.classList.remove('active'));
                tab.classList.add('active');

                // Show/hide panels
                const target = tab.dataset.tab;
                document.querySelectorAll('.tab-panel').forEach(function (panel) {
                    panel.style.display = 'none';
                });
                if (target) {
                    const targetPanel = document.getElementById(target);
                    if (targetPanel) targetPanel.style.display = 'block';
                }
            });
        });
    });

    // ========================================
    // SMOOTH SCROLL for anchor links
    // ========================================
    document.querySelectorAll('a[href^="#"]').forEach(function (anchor) {
        anchor.addEventListener('click', function (e) {
            const href = anchor.getAttribute('href');
            if (href === '#') return;
            const target = document.querySelector(href);
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });

    // ========================================
    // INTERSECTION OBSERVER: Animate on scroll
    // ========================================
    const animateEls = document.querySelectorAll('.campus-card, .stat-card, .prodi-card, .testimonial-card, .step-card');
    if ('IntersectionObserver' in window) {
        const observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });

        animateEls.forEach(function (el) {
            el.style.opacity = '0';
            el.style.transform = 'translateY(24px)';
            el.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            observer.observe(el);
        });
    }

    // ========================================
    // COUNTER ANIMATION
    // ========================================
    function animateCounter(el) {
        const target = parseInt(el.dataset.count || el.textContent.replace(/\D/g, ''));
        const suffix = el.dataset.suffix || '';
        const duration = 2000;
        const start = performance.now();
        function update(now) {
            const elapsed = now - start;
            const progress = Math.min(elapsed / duration, 1);
            const ease = 1 - Math.pow(1 - progress, 3);
            el.textContent = Math.floor(target * ease).toLocaleString() + suffix;
            if (progress < 1) requestAnimationFrame(update);
        }
        requestAnimationFrame(update);
    }

    const counterEls = document.querySelectorAll('.stat-number[data-count]');
    if ('IntersectionObserver' in window && counterEls.length > 0) {
        const counterObserver = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    animateCounter(entry.target);
                    counterObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });
        counterEls.forEach(el => counterObserver.observe(el));
    }

    // ========================================
    // SEARCH FORM: Basic validation
    // ========================================
    const searchForms = document.querySelectorAll('.search-form');
    searchForms.forEach(function (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            // Redirect to kampus list page with query params
            const input = form.querySelector('.search-input');
            const val = input ? input.value.trim() : '';
            if (val) {
                window.location.href = '/kampus?q=' + encodeURIComponent(val);
            }
        });
    });

    // ========================================
    // RESPONSIVE: Window resize handler
    // ========================================
    window.addEventListener('resize', function () {
        if (window.innerWidth > 768 && mobileMenu) {
            mobileMenu.classList.remove('open');
            if (navToggler) {
                navToggler.classList.remove('active');
                navToggler.querySelectorAll('span').forEach(s => s.style = '');
            }
        }
    });

    // ========================================
    // TOOLTIP: Simple hover tooltip
    // ========================================
    document.querySelectorAll('[data-tooltip]').forEach(function (el) {
        const tip = document.createElement('div');
        tip.className = 'tooltip-box';
        tip.textContent = el.dataset.tooltip;
        tip.style.cssText = 'position:absolute;background:#0F172A;color:white;padding:6px 12px;border-radius:6px;font-size:0.78rem;white-space:nowrap;z-index:9999;pointer-events:none;opacity:0;transition:opacity 0.2s;';
        document.body.appendChild(tip);

        el.style.position = 'relative';
        el.addEventListener('mouseenter', function (e) {
            const rect = el.getBoundingClientRect();
            tip.style.top = (rect.top + window.scrollY - tip.offsetHeight - 8) + 'px';
            tip.style.left = (rect.left + window.scrollX + rect.width / 2 - tip.offsetWidth / 2) + 'px';
            tip.style.opacity = '1';
        });
        el.addEventListener('mouseleave', function () {
            tip.style.opacity = '0';
        });
    });

    // ========================================
    // AUTH FORM: Password toggle
    // ========================================
    document.querySelectorAll('.password-toggle').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const input = btn.previousElementSibling || document.getElementById(btn.dataset.target);
            if (!input) return;
            if (input.type === 'password') {
                input.type = 'text';
                btn.textContent = 'Sembunyikan';
            } else {
                input.type = 'password';
                btn.textContent = 'Tampilkan';
            }
        });
    });

    // ========================================
    // ACTIVE NAV LINK
    // ========================================
    const currentPath = window.location.pathname;
    document.querySelectorAll('.navbar-nav a, .mobile-menu a').forEach(function (link) {
        const href = link.getAttribute('href');
        if (href && href !== '#' && currentPath.startsWith(href)) {
            link.classList.add('active');
        }
        if (currentPath === '/' && href === '/') {
            link.classList.add('active');
        }
    });

});
