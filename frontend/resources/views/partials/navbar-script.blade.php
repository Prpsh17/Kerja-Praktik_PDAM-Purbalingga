<!-- Unified Styling -->

<script>
// Navbar Mobile Menu Handler - Unified for all pages
(function() {
    'use strict';
    
    let mobileMenuButton, mobileMenu;
    const isHomePage = true;
    
    // Global navbar functionality
    function initializeNavbar() {
        mobileMenuButton = document.getElementById('mobile-menu-button');
        mobileMenu = document.getElementById('mobile-menu');

        // Ensure elements exist before adding listeners
        if (!mobileMenuButton || !mobileMenu) {
            setTimeout(initializeNavbar, 200);
            return;
        }

        // Mobile menu toggle with enhanced reliability
        mobileMenuButton.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const isHidden = mobileMenu.classList.contains('hidden');
            
            if (isHidden) {
                mobileMenu.classList.remove('hidden');
                mobileMenuButton.setAttribute('aria-expanded', 'true');
            } else {
                mobileMenu.classList.add('hidden');
                mobileMenuButton.setAttribute('aria-expanded', 'false');
            }
        });

        // Mobile dropdown functionality
        const mobileDropdownTriggers = document.querySelectorAll('.mobile-dropdown-trigger');
        
        mobileDropdownTriggers.forEach(trigger => {
            trigger.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                const targetId = this.getAttribute('data-target');
                const dropdownContent = document.getElementById(targetId);
                const chevron = this.querySelector('.fa-chevron-down');
                
                if (dropdownContent && chevron) {
                    // Toggle current dropdown
                    const isHidden = dropdownContent.classList.contains('hidden');
                    
                    if (isHidden) {
                        // Show dropdown
                        dropdownContent.classList.remove('hidden');
                        chevron.style.transform = 'rotate(180deg)';
                    } else {
                        // Hide dropdown
                        dropdownContent.classList.add('hidden');
                        chevron.style.transform = 'rotate(0deg)';
                    }
                    
                    // Close other dropdowns
                    mobileDropdownTriggers.forEach(otherTrigger => {
                        if (otherTrigger !== this) {
                            const otherTargetId = otherTrigger.getAttribute('data-target');
                            const otherDropdownContent = document.getElementById(otherTargetId);
                            const otherChevron = otherTrigger.querySelector('.fa-chevron-down');
                            
                            if (otherDropdownContent && otherChevron) {
                                otherDropdownContent.classList.add('hidden');
                                otherChevron.style.transform = 'rotate(0deg)';
                            }
                        }
                    });
                }
            });
        });

        // Close mobile menu when clicking on links
        const mobileNavLinks = document.querySelectorAll('#mobile-menu a');
        mobileNavLinks.forEach(link => {
            link.addEventListener('click', function() {
                // Only close if it's not a dropdown trigger
                if (!this.classList.contains('mobile-dropdown-trigger')) {
                    if (mobileMenu && !mobileMenu.classList.contains('hidden')) {
                        mobileMenu.classList.add('hidden');
                        mobileMenuButton.setAttribute('aria-expanded', 'false');
                    }
                }
            });
        });

        // Close mobile menu when clicking outside
        document.addEventListener('click', function(e) {
            if (mobileMenu && !mobileMenu.classList.contains('hidden')) {
                if (!mobileMenu.contains(e.target) && !mobileMenuButton.contains(e.target)) {
                    mobileMenu.classList.add('hidden');
                    mobileMenuButton.setAttribute('aria-expanded', 'false');
                }
            }
        });

        // Handle escape key for closing menus
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                // Close mobile menu
                if (mobileMenu && !mobileMenu.classList.contains('hidden')) {
                    mobileMenu.classList.add('hidden');
                    mobileMenuButton.setAttribute('aria-expanded', 'false');
                }
            }
        });

        // Hide navbar on scroll down, show on scroll up
        let lastScrollTop = 0;
        const navbarElement = document.getElementById('main-navbar');
        const scrollThreshold = 10;
        
        window.addEventListener('scroll', function() {
            if (!navbarElement) return;
            
            // Don't hide if mobile menu is open
            if (mobileMenu && !mobileMenu.classList.contains('hidden')) {
                return;
            }
            
            let scrollTop = window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop || 0;
            
            // Ignore small scrolls to prevent jitter
            if (Math.abs(lastScrollTop - scrollTop) <= scrollThreshold) {
                return;
            }
            
            if (scrollTop > lastScrollTop && scrollTop > 100) {
                // Scrolling down
                navbarElement.style.top = '-150px';
            } else {
                // Scrolling up
                navbarElement.style.top = '0px';
            }
            lastScrollTop = Math.max(0, scrollTop);
        }, { passive: true });

        // Initialize home page functionality after navbar is ready
        if (isHomePage) {
            initializeHomePage();
        } else {
            initializeInternalPages();
        }
    }

    // Home page specific functionality
    function initializeHomePage() {
        const sectionLinks = document.querySelectorAll('.home-section-link');
        const sectionDots = document.querySelectorAll('.section-dot');

        // Smooth scroll functionality with a single reliable calculation
        function scrollToSection(sectionId) {
            const section = document.getElementById(sectionId);
            
            if (!section) {
                return;
            }
            
            const navbar = document.getElementById('main-navbar');
            const navbarHeight = navbar ? navbar.getBoundingClientRect().height : 80;
            const adjustment = 20; // Extra padding
            
            // Get section position relative to viewport, then add current scroll position
            const sectionTop = section.getBoundingClientRect().top + window.pageYOffset;
            const scrollPosition = sectionTop - navbarHeight - adjustment;
            
            window.scrollTo({
                top: Math.max(0, scrollPosition),
                behavior: 'smooth'
            });
        }

        // Handle section link clicks
        sectionLinks.forEach(function(link) {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                const sectionId = this.getAttribute('data-section');
                
                // Close mobile menu if open
                if (mobileMenu && !mobileMenu.classList.contains('hidden')) {
                    mobileMenu.classList.add('hidden');
                    mobileMenuButton.setAttribute('aria-expanded', 'false');
                }
                
                // Scroll to section
                if (sectionId === 'hero') {
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                } else {
                    scrollToSection(sectionId);
                }
            });
        });

        // Handle section dot clicks
        sectionDots.forEach(function(dot) {
            dot.addEventListener('click', function() {
                const sectionId = this.getAttribute('data-section');
                
                if (sectionId === 'hero') {
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                } else {
                    scrollToSection(sectionId);
                }
            });
        });

        // Update active states based on scroll position
        function updateActiveStates() {
            const navbar = document.querySelector('header');
            const navbarHeight = navbar ? navbar.getBoundingClientRect().height : 80;
            const scrollPos = window.scrollY + navbarHeight + 50; // Adjust for absolute navbar
            const sections = ['hero', 'about-preview', 'services-preview', 'news-preview']; // Removed contact-preview as it doesn't exist
            
            let activeSection = 'hero';
            
            // Check if we're at the top (accounting for hero viewport)
            if (window.scrollY < window.innerHeight / 2) {
                activeSection = 'hero';
            } else {
                // Find current section
                sections.forEach(sectionId => {
                    const section = document.getElementById(sectionId);
                    if (section && scrollPos >= section.offsetTop) {
                        activeSection = sectionId;
                    }
                });
            }

            // Update section links
            sectionLinks.forEach(link => {
                const linkSection = link.getAttribute('data-section');
                if (linkSection === activeSection) {
                    link.classList.add('active');
                } else {
                    link.classList.remove('active');
                }
            });

            // Update section dots
            sectionDots.forEach(dot => {
                const dotSection = dot.getAttribute('data-section');
                if (dotSection === activeSection) {
                    dot.classList.add('active');
                } else {
                    dot.classList.remove('active');
                }
            });
        }

        // Scroll event listener dengan throttling untuk performance
        let ticking = false;
        window.addEventListener('scroll', function() {
            if (!ticking) {
                requestAnimationFrame(function() {
                    updateActiveStates();
                    ticking = false;
                });
                ticking = true;
            }
        });

        // Initial setup
        setTimeout(updateActiveStates, 500);
    }

    // Internal pages functionality
    function initializeInternalPages() {
        // Internal pages - Add scroll shadow to navbar
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('header');
            if (window.scrollY > 10) {
                navbar.classList.add('shadow-lg');
                navbar.classList.remove('shadow-sm');
            } else {
                navbar.classList.add('shadow-sm');
                navbar.classList.remove('shadow-lg');
            }
        });
    }

    // Initialize when DOM is ready
    function initWhenReady() {
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', function() {
                setTimeout(initializeNavbar, 100);
            });
        } else {
            setTimeout(initializeNavbar, 100);
        }
    }
    
    // Start initialization
    initWhenReady();
})();
</script>
