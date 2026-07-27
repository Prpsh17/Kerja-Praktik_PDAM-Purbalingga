
<!-- Quick Actions -->
<section class="bg-gray-50 py-12 lg:py-16 relative overflow-hidden dark:bg-gray-800">
    <!-- Subtle decorative elements -->
    <div class="absolute top-10 left-10 w-20 h-20 bg-blue-100 rounded-full opacity-30 animate-pulse"></div>
    <div class="absolute bottom-10 right-10 w-16 h-16 bg-cyan-100 rounded-full opacity-20 animate-pulse" style="animation-delay: 2s;"></div>
    <div class="absolute top-1/2 left-1/4 w-2 h-2 bg-blue-300 rounded-full opacity-40"></div>
    <div class="absolute top-1/3 right-1/3 w-1 h-1 bg-cyan-300 rounded-full opacity-50"></div>

    <div class="container-custom relative z-10">
        <div class="text-center mb-12">
            <div class="inline-flex items-center justify-center w-14 h-14 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-full mb-6 shadow-lg">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
            </div>
            <h2 class="text-3xl lg:text-4xl font-bold mb-4 text-gray-900 dark:text-white">Akses Cepat</h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto leading-relaxed dark:text-gray-400">
                Layanan digital untuk kemudahan transaksi dan komunikasi Anda
            </p>
        </div>

        <!-- Quick Action Buttons - Modern Pill Style -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center items-stretch max-w-4xl mx-auto">
            <!-- Cek Tagihan -->
            <a href="#" onclick="openChatWithQuery('cek tagihan'); return false;" class="group flex-1">
                <div class="bg-white hover:bg-blue-50 rounded-2xl px-6 py-5 transition-all duration-300 shadow-lg hover:shadow-xl border border-blue-100 hover:border-blue-200 dark:border-gray-700 dark:hover:border-gray-600 hover:-translate-y-1 h-full dark:bg-gray-900">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center group-hover:scale-105 transition-all duration-300 flex-shrink-0">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-lg font-bold text-gray-900 group-hover:text-blue-600 transition-colors duration-200 dark:text-white">Cek Tagihan</h3>
                            <p class="text-sm text-gray-600 mt-1 dark:text-gray-400">Lihat tagihan air bulanan</p>
                        </div>
                    </div>
                </div>
            </a>

            <!-- Pengaduan -->
            <a href="#" onclick="openLaporFlow(); return false;" class="group flex-1">
                <div class="bg-white hover:bg-red-50 rounded-2xl px-6 py-5 transition-all duration-300 shadow-lg hover:shadow-xl border border-red-100 hover:border-red-200 dark:border-gray-700 dark:hover:border-gray-600 hover:-translate-y-1 h-full dark:bg-gray-900">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-red-600 rounded-xl flex items-center justify-center group-hover:scale-105 transition-all duration-300 flex-shrink-0">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-lg font-bold text-gray-900 group-hover:text-red-600 transition-colors duration-200 dark:text-white">Pengaduan</h3>
                            <p class="text-sm text-gray-600 mt-1 dark:text-gray-400">Laporkan keluhan Anda</p>
                        </div>
                    </div>
                </div>
            </a>

            <!-- Sambungan Baru -->
            <a href="#" onclick="openChatWithQuery('sambungan baru'); return false;" class="group flex-1">
                <div class="bg-white hover:bg-green-50 rounded-2xl px-6 py-5 transition-all duration-300 shadow-lg hover:shadow-xl border border-green-100 hover:border-green-200 dark:border-gray-700 dark:hover:border-gray-600 hover:-translate-y-1 h-full dark:bg-gray-900">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center group-hover:scale-105 transition-all duration-300 flex-shrink-0">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-lg font-bold text-gray-900 group-hover:text-green-600 transition-colors duration-200 dark:text-white">Sambungan Baru</h3>
                            <p class="text-sm text-gray-600 mt-1 dark:text-gray-400">Daftar pemasangan baru</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        
        <!-- Info Pelanggan Ticker -->
            </div>
</section>
