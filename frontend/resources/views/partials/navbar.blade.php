<body class="bg-gray-50 dark:bg-gray-900 dark:text-gray-100 font-sans antialiased">
    <!-- Home Navigation -->
        <!-- Navigation -->
    <header id="main-navbar" class="bg-white dark:bg-gray-900 shadow-lg fixed top-0 z-50 transition-all duration-300 home-navbar w-full bg-opacity-90 dark:bg-opacity-90 backdrop-blur-sm">
    <div class="container-custom">
        <div class="flex items-center justify-between h-16 lg:h-20">
            <!-- Logo -->
            <a href="https://pdampurbalingga.co.id" class="flex items-center space-x-3 flex-shrink-0" group>
                                <img src="https://pdampurbalingga.co.id//storage/131/01KXF5CAK743C8JV0DZ8A331CN.webp"
                     alt="Logo Perumdam Tirta Perwira"
                     class="h-10 w-10 lg:h-12 lg:w-12 object-contain"
                     fetchpriority="high"
                     width="48" height="48">
                                <div class="hidden sm:block">
                    <div class="text-lg lg:text-xl font-bold text-blue-900">
                        Perumdam Tirta Perwira
                    </div>
                    <div class="text-xs lg:text-sm text-blue-600">
                        Kabupaten Purbalingga
                    </div>
                </div>
            </a>

            <!-- Desktop Navigation -->
            <div class="hidden lg:flex items-center space-x-6 flex-1 justify-end">
                                    <!-- Home Page Navigation - dengan smooth scroll -->
                    <a href="#hero" class="nav-link active home-section-link" data-section="hero">
                        Beranda
                    </a>
                    <a href="#about-preview" class="nav-link home-section-link" data-section="about-preview">
                        Tentang Kami
                    </a>
                    <a href="#services-preview" class="nav-link home-section-link" data-section="services-preview">
                        Layanan
                    </a>
                    <a href="#news-preview" class="nav-link home-section-link" data-section="news-preview">
                        Berita
                    </a>
                    <a href="https://pdampurbalingga.co.id/kontak" class="nav-link ">
                        Kontak
                    </a>
                                
                
                <!-- Bantuan AI Button -->
                <a href="#" id="btn-bantuan-ai" class="bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm px-5 py-2.5 rounded-full shadow-md transition-all mr-2">
                    <i class="fa-solid fa-robot mr-1.5"></i> Bantuan AI
                </a>
    
                <!-- Dark Mode Toggle Desktop -->
                <button type="button" onclick="toggleDarkMode()" aria-label="Toggle Dark Mode" class="flex items-center justify-center p-2.5 rounded-lg bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-600 dark:text-gray-400 transition-all duration-200 ml-2 focus:outline-none">
                    <svg class="w-5 h-5 dark:hidden" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
                    <svg class="w-5 h-5 hidden dark:block" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" fill-rule="evenodd" clip-rule="evenodd"></path></svg>
                </button>
            </div>

            <!-- Mobile Menu and Theme Mode -->
            <div class="lg:hidden flex items-center flex-shrink-0">
                <!-- Dark Mode Toggle Mobile -->
                <button type="button" onclick="toggleDarkMode()" aria-label="Toggle Dark Mode" class="flex items-center justify-center w-10 h-10 rounded-full bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-600 dark:text-gray-300 transition-all duration-200 mr-2 dark:text-gray-400">
                    <svg class="w-5 h-5 dark:hidden" fill="currentColor" viewBox="0 0 20 20"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
                    <svg class="w-5 h-5 hidden dark:block" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" fill-rule="evenodd" clip-rule="evenodd"></path></svg>
                </button>
                <!-- Mobile Menu Button -->
                <button 
                    type="button" 
                    id="mobile-menu-button" 
                    class="flex items-center justify-center w-10 h-10 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-600 hover:text-gray-900 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:bg-gray-700 dark:text-gray-400"
                    aria-expanded="false"
                    aria-controls="mobile-menu"
                    aria-label="Toggle mobile menu"
                >
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Navigation Menu -->
    <div class="lg:hidden hidden" id="mobile-menu" role="navigation" aria-label="Mobile navigation">
        
        <div class="bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 dark:bg-gray-900">
                            <!-- Home Page Mobile Navigation - with smooth scroll -->
                <div class="space-y-1 p-2">
                    <a href="#hero" class="mobile-nav-link home-section-link active" data-section="hero">
                        <i class="fas fa-home w-5 text-blue-600 mr-3"></i>
                        Beranda
                    </a>
                    <a href="#about-preview" class="mobile-nav-link home-section-link" data-section="about-preview">
                        <i class="fas fa-building w-5 text-green-600 mr-3"></i>
                        Tentang Kami
                    </a>
                    <a href="#services-preview" class="mobile-nav-link home-section-link" data-section="services-preview">
                        <i class="fas fa-cogs w-5 text-purple-600 mr-3"></i>
                        Layanan
                    </a>
                    <a href="#news-preview" class="mobile-nav-link home-section-link" data-section="news-preview">
                        <i class="fas fa-newspaper w-5 text-orange-600 mr-3"></i>
                        Berita
                    </a>
                    <a href="https://pdampurbalingga.co.id/kontak" class="mobile-nav-link">
                        <i class="fas fa-envelope w-5 text-red-600 mr-3"></i>
                        Kontak
                    </a>
                </div>

                <!-- Divider -->
                <div class="border-t border-gray-200 dark:border-gray-700"></div>

                <!-- Quick Links untuk Home Page -->
                <div class="p-2">
                    <div class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-3 px-3 dark:text-gray-400">Menu Lengkap</div>
                    
                    <!-- Tentang Kami Group -->
                    <div class="mobile-dropdown mb-2">
                        <button class="mobile-dropdown-trigger w-full flex items-center justify-between px-3 py-2 text-gray-700 hover:bg-gray-100 rounded-lg dark:text-gray-300" data-target="about-menu">
                            <div class="flex items-center">
                                <i class="fas fa-building w-5 text-blue-600 mr-3"></i>
                                <span class="font-medium">Tentang Kami</span>
                            </div>
                            <i class="fas fa-chevron-down w-4 transition-transform duration-200"></i>
                        </button>
                        <div class="mobile-dropdown-content hidden bg-gray-50 dark:bg-gray-900 rounded-lg mt-1 ml-6 overflow-hidden dark:bg-gray-800" id="about-menu">
                            <a href="https://pdampurbalingga.co.id/tentang" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 dark:text-gray-300">
                                <i class="fas fa-info-circle w-4 text-blue-500 mr-2"></i>
                                Profil Perusahaan
                            </a>
                            <a href="https://pdampurbalingga.co.id/tentang/sejarah" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 dark:text-gray-300">
                                <i class="fas fa-history w-4 text-green-500 mr-2"></i>
                                Sejarah
                            </a>
                            <a href="https://pdampurbalingga.co.id/tentang/visi-misi" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 dark:text-gray-300">
                                <i class="fas fa-eye w-4 text-purple-500 mr-2"></i>
                                Visi & Misi
                            </a>
                            <a href="https://pdampurbalingga.co.id/tentang/struktur-organisasi" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 dark:text-gray-300">
                                <i class="fas fa-sitemap w-4 text-orange-500 mr-2"></i>
                                Struktur Organisasi
                            </a>
                            <a href="https://pdampurbalingga.co.id/tentang/cabang" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 dark:text-gray-300">
                                <i class="fas fa-map-marker-alt w-4 text-red-500 mr-2"></i>
                                Cabang & Unit IKK
                            </a>
                            <a href="https://pdampurbalingga.co.id/sumber-mata-air" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 dark:text-gray-300">
                                <i class="fas fa-tint w-4 text-cyan-500 mr-2"></i>
                                Sumber Mata Air
                            </a>
                        </div>
                    </div>

                    <!-- Layanan Group -->
                    <div class="mobile-dropdown mb-2">
                        <button class="mobile-dropdown-trigger w-full flex items-center justify-between px-3 py-2 text-gray-700 hover:bg-gray-100 rounded-lg dark:text-gray-300" data-target="services-menu">
                            <div class="flex items-center">
                                <i class="fas fa-cogs w-5 text-purple-600 mr-3"></i>
                                <span class="font-medium">Layanan</span>
                            </div>
                            <i class="fas fa-chevron-down w-4 transition-transform duration-200"></i>
                        </button>
                        <div class="mobile-dropdown-content hidden bg-gray-50 dark:bg-gray-900 rounded-lg mt-1 ml-6 overflow-hidden dark:bg-gray-800" id="services-menu">
                            <a href="https://pdampurbalingga.co.id/layanan" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 dark:text-gray-300">
                                <i class="fas fa-list w-4 text-blue-500 mr-2"></i>
                                Semua Layanan
                            </a>
                            <a href="https://tagihan.pdampurbalingga.co.id/" target="_blank" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 dark:text-gray-300">
                                <i class="fas fa-credit-card w-4 text-green-500 mr-2"></i>
                                Cek Tagihan
                            </a>
                            <a href="https://pdampurbalingga.co.id/layanan" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 dark:text-gray-300">
                                <i class="fas fa-plus-circle w-4 text-purple-500 mr-2"></i>
                                Sambungan Baru
                            </a>
                            <a href="https://pengaduan.pdampurbalingga.co.id/" target="_blank" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 dark:text-gray-300">
                                <i class="fas fa-exclamation-triangle w-4 text-red-500 mr-2"></i>
                                Pengaduan Online
                            </a>
                            <a href="https://pdampurbalingga.co.id/tarif" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 dark:text-gray-300">
                                <i class="fas fa-dollar-sign w-4 text-indigo-500 mr-2"></i>
                                Tarif Air
                            </a>
                        </div>
                    </div>

                    <!-- Informasi Group -->
                    <div class="mobile-dropdown mb-2">
                        <button class="mobile-dropdown-trigger w-full flex items-center justify-between px-3 py-2 text-gray-700 hover:bg-gray-100 rounded-lg dark:text-gray-300" data-target="info-menu">
                            <div class="flex items-center">
                                <i class="fas fa-newspaper w-5 text-orange-600 mr-3"></i>
                                <span class="font-medium">Informasi</span>
                            </div>
                            <i class="fas fa-chevron-down w-4 transition-transform duration-200"></i>
                        </button>
                        <div class="mobile-dropdown-content hidden bg-gray-50 dark:bg-gray-900 rounded-lg mt-1 ml-6 overflow-hidden dark:bg-gray-800" id="info-menu">
                            <a href="https://pdampurbalingga.co.id/berita" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 dark:text-gray-300">
                                <i class="fas fa-newspaper w-4 text-purple-500 mr-2"></i>
                                Semua Berita
                            </a>
                            <a href="https://pdampurbalingga.co.id/kontak" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 dark:text-gray-300">
                                <i class="fas fa-envelope w-4 text-blue-500 mr-2"></i>
                                Kontak Kami
                            </a>
                        </div>
                    </div>
                </div>
                    </div>
    </div>

    <!-- Section Indicator Dots (hanya untuk home page) -->
        <div class="hidden lg:block fixed right-6 top-1/2 transform -translate-y-1/2 z-40 space-y-3" id="section-indicators">
        <div class="section-dot active" data-section="hero" title="Beranda">
            <div class="section-dot-inner"></div>
        </div>
        <div class="section-dot" data-section="about-preview" title="Tentang Kami">
            <div class="section-dot-inner"></div>
        </div>
        <div class="section-dot" data-section="services-preview" title="Layanan">
            <div class="section-dot-inner"></div>
        </div>
        <div class="section-dot" data-section="news-preview" title="Berita">
            <div class="section-dot-inner"></div>
        </div>
    </div>
    </header>
