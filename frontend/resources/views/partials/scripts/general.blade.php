    }
});

// Update the progress bar on scroll
document.addEventListener('scroll', () => {
    const scrollTop = window.scrollY || document.documentElement.scrollTop;
    const docHeight = document.documentElement.scrollHeight - document.documentElement.clientHeight;
    const scrollPercent = (scrollTop / docHeight) * 100;

    const progressBar = document.getElementById('progress-bar');
    if (progressBar) {
        progressBar.style.width = `${scrollPercent}%`;
    }
});
</script>

    <!-- Enhanced JavaScript for better UX -->
    <script>
        // Enhanced smooth scrolling
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    const headerOffset = 80;
                    const elementPosition = target.offsetTop;
                    const offsetPosition = elementPosition - headerOffset;

                    window.scrollTo({
                        top: offsetPosition,
                        behavior: 'smooth'
                    });
                }
            });
        });

        // Add loading animation to numbers
        function animateNumbers() {
            const numbers = document.querySelectorAll('.stat-number');
            numbers.forEach(number => {
                const target = parseInt(number.innerText);
                let current = 0;
                const increment = target / 100;
                const timer = setInterval(() => {
                    current += increment;
                    if (current >= target) {
                        current = target;
                        clearInterval(timer);
                    }
                    number.innerText = Math.floor(current).toLocaleString('id-ID');
                }, 20);
            });
        }

        // Intersection Observer for animations
        const layoutObserverOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const layoutObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-fadeInUp');
                    
                    // Animate numbers if they exist
                    const numbers = entry.target.querySelectorAll('.stat-number');
                    if (numbers.length > 0) {
                        animateNumbers();
                    }
                }
            });
        }, layoutObserverOptions);

        // Observe elements for animation
        document.querySelectorAll('.card, .service-card, .news-card').forEach(el => {
            layoutObserver.observe(el);
        });
    </script>

    <!-- Font Awesome: loaded after page is interactive (non-render-blocking) -->
    <script>
        // Load FontAwesome after browser is idle (non-blocking)
        function loadFA() {
            var fa = document.createElement('link');
            fa.rel = 'stylesheet';
            fa.href = 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css';
            fa.crossOrigin = 'anonymous';
            document.head.appendChild(fa);
        }
        if ('requestIdleCallback' in window) {
            requestIdleCallback(loadFA, { timeout: 2000 });
        } else {
            setTimeout(loadFA, 200);
        }

        // Mark document as JS-loaded so animations can play
        // Use rAF to ensure it runs AFTER first paint (not during)
        requestAnimationFrame(function() {
            requestAnimationFrame(function() {
                document.documentElement.classList.add('js-loaded');
                document.body.classList.add('js-loaded');
                // Add carousel transitions after first paint
                var hero = document.getElementById('hero');
                if (hero) hero.classList.add('carousel-ready');
            });
        });
    </script>

