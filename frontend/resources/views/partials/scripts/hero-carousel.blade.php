    <script>
// Hero Carousel Functionality
class HeroCarousel {
    constructor() {
        this.carousel = document.querySelector('.hero-carousel');
        this.slides = document.querySelectorAll('.hero-slide');
        this.dots = document.querySelectorAll('.hero-dot');
        this.prevBtn = document.querySelector('.hero-prev');
        this.nextBtn = document.querySelector('.hero-next');
        this.currentSlide = 0;
        this.slideCount = this.slides.length;
        this.autoPlayInterval = null;
        this.autoPlayDelay = 5000; // 5 seconds

        if (this.slideCount > 1) {
            this.init();
        }
    }

    init() {
               // Set initial state
        this.showSlide(0);

        // Add event listeners
        if (this.prevBtn) {
            this.prevBtn.addEventListener('click', () => {
                this.addClickFeedback(this.prevBtn);
                this.prevSlide();
            });
        }

        if (this.nextBtn) {
            this.nextBtn.addEventListener('click', () => {
                this.addClickFeedback(this.nextBtn);
                this.nextSlide();
            });
        }

        // Dot navigation
        this.dots.forEach((dot, index) => {
            dot.addEventListener('click', () => this.goToSlide(index));
        });

        // Keyboard navigation
        document.addEventListener('keydown', (e) => {
            if (e.key === 'ArrowLeft') this.prevSlide();
            if (e.key === 'ArrowRight') this.nextSlide();
        });

        // Touch/swipe support
        this.addTouchSupport();

        // Auto-play
        this.startAutoPlay();

        // Initialize navigation hint
        this.initNavigationHint();

        // Pause auto-play on hover with delay
        if (this.carousel) {
            let hoverTimeout;

            this.carousel.addEventListener('mouseenter', () => {
                clearTimeout(hoverTimeout);
                this.stopAutoPlay();
                this.hideNavigationHint();
            });

            this.carousel.addEventListener('mouseleave', () => {
                // Delay restart to avoid flickering when moving between elements
                hoverTimeout = setTimeout(() => {
                    this.startAutoPlay();
                }, 300);
            });
        }
    }

    initNavigationHint() {
        // Hide navigation hint after first interaction
        const hint = document.querySelector('.hero-nav-hint');
        if (hint) {
            // Auto-hide after 5 seconds
            setTimeout(() => {
                hint.style.opacity = '0';
                setTimeout(() => {
                    hint.style.display = 'none';
                }, 300);
            }, 7000);

            // Hide on any navigation interaction
            const hideHint = () => {
                hint.style.opacity = '0';
                setTimeout(() => {
                    hint.style.display = 'none';
                }, 300);
            };

            // Hide hint on any navigation button click
            if (this.prevBtn) this.prevBtn.addEventListener('click', hideHint, { once: true });
            if (this.nextBtn) this.nextBtn.addEventListener('click', hideHint, { once: true });
            
            // Hide hint on dot click
            this.dots.forEach(dot => {
                dot.addEventListener('click', hideHint, { once: true });
            });

            // Hide hint on touch/swipe
            if (this.carousel) {
                this.carousel.addEventListener('touchstart', hideHint, { once: true });
            }
        }
    }

    hideNavigationHint() {
        const hint = document.querySelector('.hero-nav-hint');
        if (hint && hint.style.display !== 'none') {
            hint.style.opacity = '0';
        }
    }

    showSlide(index) {
        // Add loading state to navigation buttons
        if (this.prevBtn) this.prevBtn.classList.add('loading');
        if (this.nextBtn) this.nextBtn.classList.add('loading');

        // Hide all slides
        this.slides.forEach((slide, i) => {
            slide.classList.remove('active');
            slide.style.opacity = '0';
            slide.style.transform = 'translateX(100%)';

            if (i === index) {
                slide.classList.add('active');
                slide.style.opacity = '1';
                slide.style.transform = 'translateX(0)';
            } else if (i < index) {
                slide.style.transform = 'translateX(-100%)';
            }
        });

        // Update dots
        this.dots.forEach((dot, i) => {
            dot.classList.toggle('active', i === index);
            dot.classList.toggle('bg-opacity-100', i === index);
            dot.classList.toggle('bg-opacity-50', i !== index);
        });

        this.currentSlide = index;

        // Remove loading state after transition
        setTimeout(() => {
            if (this.prevBtn) this.prevBtn.classList.remove('loading');
            if (this.nextBtn) this.nextBtn.classList.remove('loading');
        }, 400);
    }

    nextSlide() {
        const next = (this.currentSlide + 1) % this.slideCount;
        this.showSlide(next);
    }

    prevSlide() {
        const prev = (this.currentSlide - 1 + this.slideCount) % this.slideCount;
        this.showSlide(prev);
    }

    addClickFeedback(button) {
        // Add visual feedback for button clicks
        button.style.transform = 'translateY(-50%) translateX(0) scale(0.95)';
        
        setTimeout(() => {
            button.style.transform = '';
        }, 150);
        
        // Add temporary glow effect
        const glowClass = 'hero-nav-clicked';
        button.classList.add(glowClass);
        
        setTimeout(() => {
            button.classList.remove(glowClass);
        }, 300);
    }

    goToSlide(index) {
        if (index >= 0 && index < this.slideCount) {
            this.showSlide(index);
        }
    }

    startAutoPlay() {
        this.stopAutoPlay();
        if (this.slideCount > 1) {
            this.autoPlayInterval = setInterval(() => {
                this.nextSlide();
            }, this.autoPlayDelay);
        }
    }

    stopAutoPlay() {
        if (this.autoPlayInterval) {
            clearInterval(this.autoPlayInterval);
            this.autoPlayInterval = null;
        }
    }

    addTouchSupport() {
        if (!this.carousel) return;

        let startX = 0;
        let endX = 0;
        let startY = 0;
        let endY = 0;

        this.carousel.addEventListener('touchstart', (e) => {
            startX = e.touches[0].clientX;
            startY = e.touches[0].clientY;
        });

        this.carousel.addEventListener('touchend', (e) => {
            endX = e.changedTouches[0].clientX;
            endY = e.changedTouches[0].clientY;
            this.handleSwipe();
        });

        const handleSwipe = () => {
            const deltaX = startX - endX;
            const deltaY = Math.abs(startY - endY);

            // Only handle horizontal swipes (not vertical scrolling)
            if (Math.abs(deltaX) > 50 && deltaY < 100) {
                if (deltaX > 0) {
                    this.nextSlide(); // Swipe left - next slide
                } else {
                    this.prevSlide(); // Swipe right - prev slide
                }
            }
        };

        this.handleSwipe = handleSwipe;
    }
}

// Counter animation for stats
function animateCounter(element) {
    const target = parseInt(element.getAttribute('data-count'));
    const duration = 2000;
    const step = target / (duration / 16);
    let current = 0;

    const timer = setInterval(() => {
        current += step;
        if (current >= target) {
            current = target;
            clearInterval(timer);
        }
        element.textContent = Math.floor(current).toLocaleString();
    }, 16);
}

// Intersection Observer for stats animation
const observerOptions = {
    threshold: 0.5,
    rootMargin: '0px 0px -100px 0px'
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            const counters = entry.target.querySelectorAll('[data-count]');
            counters.forEach(counter => {
                if (!counter.classList.contains('animated')) {
                    counter.classList.add('animated');
                    animateCounter(counter);
                }
            });
        }
    });
}, observerOptions);

// Partnership Rolling Slider Class
class PartnershipRollingSlider {
    constructor() {
        this.track = document.getElementById('partnershipTrack');
        this.container = document.querySelector('.partnership-slider-container');
        this.items = this.track ? this.track.querySelectorAll('.partnership-item') : [];
        this.isAnimating = true;
        this.animationId = null;
        this.speed = 0.5; // Slower speed for more elegant movement
        this.currentX = 0;

        if (this.track && this.items.length > 0) {
            this.init();
        }
    }

    init() {
        // Calculate actual width of one set of items (we have 3 duplicates, so divide by 3)
        const originalItemsCount = this.items.length / 3;
        
        // Get actual width by measuring elements
        if (this.items.length > 0) {
            const firstItem = this.items[0];
            const itemWidth = firstItem.offsetWidth;
            const gap = 48; // 3rem = 48px gap
            
            this.itemWidth = itemWidth + gap;
            this.totalWidth = originalItemsCount * this.itemWidth;
        } else {
            this.itemWidth = 176; // fallback
            this.totalWidth = originalItemsCount * this.itemWidth;
        }
        
        // Set initial position
        this.currentX = 0;
        
        // Start animation
        this.startAnimation();
        
        // Pause on hover
        if (this.container) {
            this.container.addEventListener('mouseenter', () => this.pauseAnimation());
            this.container.addEventListener('mouseleave', () => this.resumeAnimation());
        }
    }

    startAnimation() {
        if (this.animationId) return;
        
        const animate = () => {
            if (this.isAnimating) {
                this.currentX -= this.speed;
                
                // Reset position when first set of items completely scrolled out
                // This creates seamless infinite loop
                if (Math.abs(this.currentX) >= this.totalWidth) {
                    this.currentX = 0;
                }
                
                this.track.style.transform = `translateX(${this.currentX}px)`;
            }
            
            this.animationId = requestAnimationFrame(animate);
        };
        
        animate();
    }

    pauseAnimation() {
        this.isAnimating = false;
    }

    resumeAnimation() {
        this.isAnimating = true;
    }

    stopAnimation() {
        if (this.animationId) {
            cancelAnimationFrame(this.animationId);
            this.animationId = null;
        }
    }
}

// Initialize everything when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    // Initialize hero carousel
    new HeroCarousel();

    // Initialize partnership rolling slider
    new PartnershipRollingSlider();

    // Observe stats section
    const statsSection = document.querySelector('.stat-item')?.closest('section');
    if (statsSection) {
        observer.observe(statsSection);
    }
