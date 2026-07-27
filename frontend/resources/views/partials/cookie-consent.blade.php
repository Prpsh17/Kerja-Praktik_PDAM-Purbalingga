    <div id="cookie-consent-banner" class="fixed bottom-0 left-0 right-0 z-50 transform translate-y-full transition-transform duration-500 ease-in-out hidden">
    <div class="bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 shadow-[0_-10px_40px_rgba(0,0,0,0.1)] px-4 py-6 md:py-5 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
            
            <div class="flex-1 pr-4">
                <div class="flex items-center gap-2 mb-2">
                    <h3 class="text-base font-bold text-gray-900 dark:text-white">Mari Bicarakan Cookies</h3>
                </div>
                <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed">
                    Kami menggunakan <em>cookies</em> untuk meningkatkan pengalaman penjelajahan Anda, menyajikan konten yang disesuaikan, serta menganalisis performa situs web kami. Dengan mengklik <strong>"Terima Semua"</strong>, Anda menyetujui penggunaan <em>cookies</em> yang membantu kami memberikan layanan terbaik.
                </p>
            </div>

            <div class="flex flex-shrink-0 flex-row gap-3 w-full md:w-auto mt-2 md:mt-0">
                <button id="btn-decline-cookies" class="flex-1 md:flex-none px-5 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-300 rounded-lg hover:bg-gray-50 focus:ring-4 focus:outline-none focus:ring-gray-100 transition-colors">
                    Tolak
                </button>
                <button id="btn-accept-cookies" class="flex-1 md:flex-none px-5 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 transition-colors shadow-sm">
                    Terima Semua
                </button>
            </div>
            
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const banner = document.getElementById('cookie-consent-banner');
        const acceptBtn = document.getElementById('btn-accept-cookies');
        const declineBtn = document.getElementById('btn-decline-cookies');
        
        // Check if user has already made a choice
        const consent = localStorage.getItem('cookie_consent');
        
        if (!consent) {
            // Show banner with a small delay for better UX
            setTimeout(() => {
                banner.classList.remove('hidden');
                // Use setTimeout to ensure the browser registers the display:block before transitioning
                setTimeout(() => {
                    banner.classList.remove('translate-y-full');
                }, 50);
            }, 1500);
        }

        function hideBanner() {
            banner.classList.add('translate-y-full');
            setTimeout(() => {
                banner.classList.add('hidden');
            }, 500); // Wait for transition to finish
        }

        acceptBtn.addEventListener('click', function() {
            localStorage.setItem('cookie_consent', 'accepted');
            hideBanner();
        });

        declineBtn.addEventListener('click', function() {
            localStorage.setItem('cookie_consent', 'declined');
            hideBanner();
        });
    });
</script>
</body>
