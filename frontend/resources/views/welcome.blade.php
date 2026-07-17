<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perumdam Tirta Perwira Purbalingga</title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    },
                    colors: {
                        pdam: {
                            blue: '#1d4ed8',
                            bluelight: '#3b82f6',
                            bluedark: '#1e3a8a',
                            accent: '#ef4444',
                            success: '#10b981',
                            navy: '#0f172a',
                        }
                    }
                }
            }
        }
    </script>
    
    <style>
        /* Custom scrollbar for chat */
        .chat-scroll::-webkit-scrollbar {
            width: 5px;
        }
        .chat-scroll::-webkit-scrollbar-track {
            background: #f1f1f1; 
        }
        .chat-scroll::-webkit-scrollbar-thumb {
            background: #cbd5e1; 
            border-radius: 4px;
        }
        .chat-scroll::-webkit-scrollbar-thumb:hover {
            background: #94a3b8; 
        }
        
        .typing-indicator span {
            display: inline-block;
            width: 6px;
            height: 6px;
            background-color: #3b82f6;
            border-radius: 50%;
            margin: 0 1px;
            animation: bounce 1.4s infinite ease-in-out both;
        }
        .typing-indicator span:nth-child(1) { animation-delay: -0.32s; }
        .typing-indicator span:nth-child(2) { animation-delay: -0.16s; }
        @keyframes bounce {
            0%, 80%, 100% { transform: scale(0); }
            40% { transform: scale(1); }
        }
    </style>
</head>
<body class="bg-gray-50 text-slate-800 font-sans min-h-screen antialiased flex flex-col">

    <!-- ─────────────────────────────────────────────
         NAVBAR HEADER
         ───────────────────────────────────────────── -->
    <header class="bg-white border-b border-gray-100 sticky top-0 z-40 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <!-- PDAM Logo represented as modern Water Drop Icon -->
                <div class="w-12 h-12 bg-pdam-blue rounded-full flex items-center justify-center text-white shadow-md">
                    <i class="fa-solid fa-droplet text-2xl"></i>
                </div>
                <div>
                    <h1 class="font-extrabold text-pdam-bluedark text-base tracking-tight leading-tight">Perumdam Tirta Perwira</h1>
                    <p class="text-xs text-slate-400 font-medium tracking-wider uppercase">Kabupaten Purbalingga</p>
                </div>
            </div>
            
            <nav class="hidden md:flex space-x-8 font-semibold text-sm text-slate-600">
                <a href="#" class="text-pdam-blue hover:text-pdam-bluelight transition-colors">Beranda</a>
                <a href="#" class="hover:text-pdam-blue transition-colors">Tentang Kami</a>
                <a href="#" class="hover:text-pdam-blue transition-colors">Layanan</a>
                <a href="#" class="hover:text-pdam-blue transition-colors">Berita</a>
                <a href="#" class="hover:text-pdam-blue transition-colors">Kontak</a>
            </nav>
            
            <div class="flex items-center space-x-3">
                <a href="#chat" onclick="toggleChatWidget(); return false;" class="bg-pdam-blue hover:bg-pdam-bluelight text-white font-bold text-xs uppercase tracking-wider px-5 py-2.5 rounded-full shadow-md hover:shadow-lg transition-all">
                    Bantuan AI
                </a>
            </div>
        </div>
    </header>

    <!-- ─────────────────────────────────────────────
         HERO BANNER
         ───────────────────────────────────────────── -->
    <section class="relative bg-gradient-to-br from-pdam-bluedark via-pdam-blue to-pdam-bluelight py-20 lg:py-24 text-white overflow-hidden">
        <div class="absolute inset-0 opacity-15 bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:16px_16px]"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            
            <div class="lg:col-span-7 space-y-6">
                <div class="inline-block bg-white/10 backdrop-blur-md border border-white/20 px-4 py-1.5 rounded-full text-xs font-semibold tracking-wider uppercase text-blue-100">
                    💧 Pelayanan Prima Air Bersih
                </div>
                <h2 class="text-4xl sm:text-5xl font-extrabold tracking-tight leading-tight">
                    Selamat datang
                </h2>
                <p class="text-lg sm:text-xl font-medium text-blue-100 leading-relaxed max-w-2xl">
                    Halaman Resmi Perusahaan Umum Daerah Air Minum Tirta Perwira Kabupaten Purbalingga
                </p>
                <p class="text-sm text-blue-50/80 leading-relaxed max-w-xl">
                    Komitmen kami memberikan pelayanan air bersih yang berkualitas, lancar, dan higienis untuk memenuhi segala kebutuhan masyarakat Kabupaten Purbalingga.
                </p>
                <div class="flex flex-wrap gap-4 pt-2">
                    <a href="#" onclick="openLaporFlow(); return false;" class="bg-pdam-accent hover:bg-red-600 text-white font-bold text-sm px-8 py-3.5 rounded-full shadow-lg transition-all transform hover:-translate-y-0.5">
                        Pengaduan
                    </a>
                    <a href="#" onclick="toggleChatWidget(); return false;" class="bg-white/10 hover:bg-white/20 border border-white/30 text-white font-bold text-sm px-8 py-3.5 rounded-full shadow-md transition-all">
                        Cek Tagihan
                    </a>
                </div>
            </div>
            
            <!-- Hero Image representing the office -->
            <div class="lg:col-span-5 relative">
                <div class="absolute -inset-1 rounded-2xl bg-gradient-to-tr from-pdam-bluelight to-white/20 blur-lg opacity-30"></div>
                <div class="relative rounded-2xl overflow-hidden shadow-2xl border-4 border-white/10">
                    <img src="https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=800&q=80" alt="Gedung Perumdam Tirta Perwira" class="w-full h-80 object-cover transform hover:scale-105 transition-transform duration-500">
                </div>
            </div>
        </div>
    </section>

    <!-- ─────────────────────────────────────────────
         AKSES CEPAT (QUICK ACCESS CARDS)
         ───────────────────────────────────────────── -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-10 relative z-10">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <!-- Card 1: Cek Tagihan -->
            <div onclick="openChatWithQuery('cek tagihan')" class="bg-white rounded-2xl p-6 shadow-xl hover:shadow-2xl transition-all border border-gray-100 flex items-center space-x-5 cursor-pointer transform hover:-translate-y-1 duration-300">
                <div class="w-14 h-14 bg-blue-50 text-pdam-blue rounded-xl flex items-center justify-center shrink-0">
                    <i class="fa-solid fa-file-invoice-dollar text-2xl"></i>
                </div>
                <div>
                    <h3 class="font-extrabold text-slate-800 text-lg leading-tight">Cek Tagihan</h3>
                    <p class="text-xs text-slate-400 mt-1 font-medium">Informasi jumlah tagihan rekening air</p>
                </div>
            </div>
            
            <!-- Card 2: Pengaduan (Pemicu Chatbot) -->
            <div onclick="openLaporFlow()" class="bg-white rounded-2xl p-6 shadow-xl hover:shadow-2xl transition-all border border-gray-100 flex items-center space-x-5 cursor-pointer transform hover:-translate-y-1 duration-300">
                <div class="w-14 h-14 bg-red-50 text-pdam-accent rounded-xl flex items-center justify-center shrink-0">
                    <i class="fa-solid fa-bullhorn text-2xl"></i>
                </div>
                <div>
                    <h3 class="font-extrabold text-slate-800 text-lg leading-tight">Pengaduan</h3>
                    <p class="text-xs text-slate-400 mt-1 font-medium">Layanan aduan keluhan pelanggan</p>
                </div>
            </div>
            
            <!-- Card 3: Sambungan Baru -->
            <div onclick="openChatWithQuery('sambungan baru')" class="bg-white rounded-2xl p-6 shadow-xl hover:shadow-2xl transition-all border border-gray-100 flex items-center space-x-5 cursor-pointer transform hover:-translate-y-1 duration-300">
                <div class="w-14 h-14 bg-green-50 text-pdam-success rounded-xl flex items-center justify-center shrink-0">
                    <i class="fa-solid fa-faucet-drip text-2xl"></i>
                </div>
                <div>
                    <h3 class="font-extrabold text-slate-800 text-lg leading-tight">Sambungan Baru</h3>
                    <p class="text-xs text-slate-400 mt-1 font-medium">Daftar pemasangan instalasi air baru</p>
                </div>
            </div>
            
        </div>
    </section>

    <!-- ─────────────────────────────────────────────
         PROFILE SECTION
         ───────────────────────────────────────────── -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
        <div class="space-y-6">
            <span class="text-xs font-bold uppercase tracking-wider text-pdam-blue">Tentang Kami</span>
            <h2 class="text-3xl font-extrabold text-pdam-bluedark tracking-tight leading-tight">
                Perumdam Tirta Perwira Purbalingga
            </h2>
            <div class="h-1 w-20 bg-pdam-blue rounded-full"></div>
            <p class="text-sm text-slate-600 leading-relaxed">
                Perusahaan Umum Daerah Air Minum (Perumdam) Tirta Perwira Purbalingga adalah badan usaha milik daerah yang berdedikasi tinggi dalam penyediaan pelayanan air bersih untuk seluruh wilayah administratif Kabupaten Purbalingga.
            </p>
            <p class="text-sm text-slate-600 leading-relaxed">
                Dengan didukung oleh teknologi pengolahan air bersih yang modern, tim reaksi cepat pengaduan, dan jaringan perpipaan yang luas, kami terus berkomitmen meningkatkan kepuasan pelanggan serta mendukung kesehatan masyarakat.
            </p>
            <div class="grid grid-cols-2 gap-6 pt-4">
                <div class="border-l-4 border-pdam-blue pl-4">
                    <h4 class="text-2xl font-bold text-pdam-bluedark">99.9%</h4>
                    <p class="text-xs text-slate-400 font-semibold mt-1">Air Teruji Klinis</p>
                </div>
                <div class="border-l-4 border-pdam-accent pl-4">
                    <h4 class="text-2xl font-bold text-pdam-bluedark">24/7</h4>
                    <p class="text-xs text-slate-400 font-semibold mt-1">Dukungan Responsif</p>
                </div>
            </div>
        </div>
        
        <div class="relative">
            <div class="absolute -inset-1 rounded-2xl bg-gradient-to-tr from-pdam-blue to-pdam-accent blur-lg opacity-10"></div>
            <img src="https://images.unsplash.com/photo-1554469384-e58fac16e23a?auto=format&fit=crop&w=800&q=80" alt="Instalasi PDAM" class="rounded-2xl shadow-xl w-full h-80 object-cover">
        </div>
    </section>

    <!-- ─────────────────────────────────────────────
         LAYANAN UTAMA
         ───────────────────────────────────────────── -->
    <section class="bg-slate-50 py-16 border-y border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center space-y-3 max-w-2xl mx-auto mb-12">
                <span class="text-xs font-bold uppercase tracking-wider text-pdam-blue">Pelayanan</span>
                <h2 class="text-3xl font-extrabold text-pdam-bluedark">Layanan Utama Kami</h2>
                <p class="text-sm text-slate-500">Kami menyediakan berbagai layanan administrasi dan teknis berdasarkan kebutuhan kebutuhan masyarakat Purbalingga.</p>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Layanan 1 -->
                <div class="bg-white rounded-2xl overflow-hidden shadow-md hover:shadow-xl transition-all border border-gray-100 flex flex-col">
                    <img src="https://images.unsplash.com/photo-1527330263443-47743b5c8e20?auto=format&fit=crop&w=400&q=80" alt="Sambungan Baru" class="h-40 w-full object-cover">
                    <div class="p-5 flex-1 flex flex-col justify-between">
                        <div class="space-y-2">
                            <h3 class="font-extrabold text-slate-800 text-base leading-snug">Pemasaran & Sambungan Baru</h3>
                            <p class="text-xs text-slate-500 leading-relaxed">Pengajuan instalasi saluran air bersih baru untuk rumah tinggal maupun komersial.</p>
                        </div>
                        <a href="#" class="text-pdam-blue hover:text-pdam-bluelight text-xs font-bold mt-4 inline-flex items-center">Selengkapnya <i class="fa-solid fa-arrow-right ml-1"></i></a>
                    </div>
                </div>
                <!-- Layanan 2 -->
                <div class="bg-white rounded-2xl overflow-hidden shadow-md hover:shadow-xl transition-all border border-gray-100 flex flex-col">
                    <img src="https://images.unsplash.com/photo-1455390582262-044cdead277a?auto=format&fit=crop&w=400&q=80" alt="Balik Nama" class="h-40 w-full object-cover">
                    <div class="p-5 flex-1 flex flex-col justify-between">
                        <div class="space-y-2">
                            <h3 class="font-extrabold text-slate-800 text-base leading-snug">Balik Nama Pelanggan</h3>
                            <p class="text-xs text-slate-500 leading-relaxed">Pengurusan perubahan nama kepemilikan rekening instalasi air pdam.</p>
                        </div>
                        <a href="#" class="text-pdam-blue hover:text-pdam-bluelight text-xs font-bold mt-4 inline-flex items-center">Selengkapnya <i class="fa-solid fa-arrow-right ml-1"></i></a>
                    </div>
                </div>
                <!-- Layanan 3 -->
                <div class="bg-white rounded-2xl overflow-hidden shadow-md hover:shadow-xl transition-all border border-gray-100 flex flex-col">
                    <img src="https://images.unsplash.com/photo-1585338107529-13afc5f02586?auto=format&fit=crop&w=400&q=80" alt="Penyambungan Kembali" class="h-40 w-full object-cover">
                    <div class="p-5 flex-1 flex flex-col justify-between">
                        <div class="space-y-2">
                            <h3 class="font-extrabold text-slate-800 text-base leading-snug">Penyambungan Kembali</h3>
                            <p class="text-xs text-slate-500 leading-relaxed">Penyambungan kembali aliran pipa air yang sempat terputus atau dinonaktifkan.</p>
                        </div>
                        <a href="#" class="text-pdam-blue hover:text-pdam-bluelight text-xs font-bold mt-4 inline-flex items-center">Selengkapnya <i class="fa-solid fa-arrow-right ml-1"></i></a>
                    </div>
                </div>
                <!-- Layanan 4 -->
                <div class="bg-white rounded-2xl overflow-hidden shadow-md hover:shadow-xl transition-all border border-gray-100 flex flex-col">
                    <img src="https://images.unsplash.com/photo-1508962914676-134849a727f0?auto=format&fit=crop&w=400&q=80" alt="Pasang Kembali" class="h-40 w-full object-cover">
                    <div class="p-5 flex-1 flex flex-col justify-between">
                        <div class="space-y-2">
                            <h3 class="font-extrabold text-slate-800 text-base leading-snug">Pasang Kembali</h3>
                            <p class="text-xs text-slate-500 leading-relaxed">Penggantian meteran air yang rusak dengan instalasi baru yang aman.</p>
                        </div>
                        <a href="#" class="text-pdam-blue hover:text-pdam-bluelight text-xs font-bold mt-4 inline-flex items-center">Selengkapnya <i class="fa-solid fa-arrow-right ml-1"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ─────────────────────────────────────────────
         MITRA PEMBAYARAN (PAYMENT PARTNERS)
         ───────────────────────────────────────────── -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="text-center mb-8">
            <h3 class="text-sm font-extrabold text-slate-400 uppercase tracking-widest">Mitra Pembayaran Resmi</h3>
            <p class="text-xs text-slate-400 mt-1">Kami terhubung dengan berbagai perbankan, retail, dan dompet digital terpercaya</p>
        </div>
        <div class="flex flex-wrap items-center justify-center gap-8 md:gap-12 opacity-50 grayscale hover:opacity-85 transition-opacity duration-300">
            <div class="text-center font-bold text-lg text-slate-600 tracking-tight"><i class="fa-solid fa-mail-reply mr-2"></i>Pos Indonesia</div>
            <div class="text-center font-bold text-lg text-slate-600 tracking-tight"><i class="fa-solid fa-bag-shopping mr-2"></i>Shopee</div>
            <div class="text-center font-bold text-lg text-slate-600 tracking-tight"><i class="fa-solid fa-shop mr-2"></i>Tokopedia</div>
            <div class="text-center font-bold text-lg text-slate-600 tracking-tight"><i class="fa-solid fa-store mr-2"></i>Bukalapak</div>
            <div class="text-center font-bold text-lg text-slate-600 tracking-tight"><i class="fa-solid fa-mobile-screen mr-2"></i>GoPay</div>
        </div>
    </section>

    <!-- ─────────────────────────────────────────────
         BERITA TERKINI
         ───────────────────────────────────────────── -->
    <section class="bg-white py-16 border-t border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-10">
                <div class="space-y-2">
                    <span class="text-xs font-bold uppercase tracking-wider text-pdam-blue">Informasi</span>
                    <h2 class="text-3xl font-extrabold text-pdam-bluedark">Berita Terkini</h2>
                </div>
                <a href="#" class="text-pdam-blue hover:text-pdam-bluelight text-sm font-bold mt-2 md:mt-0 flex items-center">Lihat Semua Berita <i class="fa-solid fa-arrow-right ml-1"></i></a>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Berita 1 -->
                <div class="bg-gray-50 rounded-2xl overflow-hidden border border-gray-100 shadow-sm flex flex-col">
                    <img src="https://images.unsplash.com/photo-1593526492327-b071f3d5333e?auto=format&fit=crop&w=400&q=80" alt="News 1" class="h-48 w-full object-cover">
                    <div class="p-6 flex-1 flex flex-col justify-between">
                        <div class="space-y-3">
                            <div class="flex items-center space-x-2 text-xs font-bold text-pdam-blue uppercase">
                                <span>Pelayanan</span>
                                <span class="text-slate-300">•</span>
                                <span class="text-slate-400">14 Juli 2026</span>
                            </div>
                            <h3 class="font-extrabold text-slate-800 text-lg leading-snug hover:text-pdam-blue cursor-pointer transition-colors">PDAM Purbalingga Mendapatkan Penghargaan Layanan Terbaik</h3>
                            <p class="text-xs text-slate-500 leading-relaxed">Perumdam Tirta Perwira mendapat piagam penghargaan atas dedikasi tinggi penyediaan fasilitas pengolahan air bersih yang higienis.</p>
                        </div>
                        <a href="#" class="text-pdam-blue hover:text-pdam-bluelight text-xs font-bold mt-4 inline-block">Baca Selengkapnya</a>
                    </div>
                </div>
                <!-- Berita 2 -->
                <div class="bg-gray-50 rounded-2xl overflow-hidden border border-gray-100 shadow-sm flex flex-col">
                    <img src="https://images.unsplash.com/photo-1521791136364-728647526959?auto=format&fit=crop&w=400&q=80" alt="News 2" class="h-48 w-full object-cover">
                    <div class="p-6 flex-1 flex flex-col justify-between">
                        <div class="space-y-3">
                            <div class="flex items-center space-x-2 text-xs font-bold text-pdam-blue uppercase">
                                <span>Karir</span>
                                <span class="text-slate-300">•</span>
                                <span class="text-slate-400">10 Juli 2026</span>
                            </div>
                            <h3 class="font-extrabold text-slate-800 text-lg leading-snug hover:text-pdam-blue cursor-pointer transition-colors">Penerimaan Rekrutmen Anggota Dewan Pengawas PDAM</h3>
                            <p class="text-xs text-slate-500 leading-relaxed">Pengumuman resmi seleksi rekrutmen terbuka Dewan Pengawas Perusahaan Umum Daerah Air Minum Tirta Perwira tahun periode 2026-2030.</p>
                        </div>
                        <a href="#" class="text-pdam-blue hover:text-pdam-bluelight text-xs font-bold mt-4 inline-block">Baca Selengkapnya</a>
                    </div>
                </div>
                <!-- Berita 3 -->
                <div class="bg-gray-50 rounded-2xl overflow-hidden border border-gray-100 shadow-sm flex flex-col">
                    <img src="https://images.unsplash.com/photo-1540910419892-4a36d2c3266c?auto=format&fit=crop&w=400&q=80" alt="News 3" class="h-48 w-full object-cover">
                    <div class="p-6 flex-1 flex flex-col justify-between">
                        <div class="space-y-3">
                            <div class="flex items-center space-x-2 text-xs font-bold text-pdam-blue uppercase">
                                <span>Sosial</span>
                                <span class="text-slate-300">•</span>
                                <span class="text-slate-400">08 Juli 2026</span>
                            </div>
                            <h3 class="font-extrabold text-slate-800 text-lg leading-snug hover:text-pdam-blue cursor-pointer transition-colors">Program Bakti Sosial PDAM Berbagi Air Bersih Gratis</h3>
                            <p class="text-xs text-slate-500 leading-relaxed">Bantuan distribusi tangki air bersih darurat gratis kepada warga yang terdampak kekeringan musiman di wilayah Purbalingga utara.</p>
                        </div>
                        <a href="#" class="text-pdam-blue hover:text-pdam-bluelight text-xs font-bold mt-4 inline-block">Baca Selengkapnya</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ─────────────────────────────────────────────
         FOOTER
         ───────────────────────────────────────────── -->
    <footer class="bg-pdam-navy text-slate-300 mt-auto border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 grid grid-cols-1 md:grid-cols-4 gap-8">
            <div class="space-y-4">
                <div class="flex items-center space-x-2 text-white">
                    <i class="fa-solid fa-droplet text-2xl text-pdam-bluelight"></i>
                    <span class="font-extrabold text-lg tracking-tight">Tirta Perwira</span>
                </div>
                <p class="text-xs text-slate-400 leading-relaxed">Penyedia pelayanan air bersih berkualitas tinggi dan handal di wilayah Kabupaten Purbalingga.</p>
                <p class="text-xs text-slate-500">© 2026 Perumdam Tirta Perwira. All Rights Reserved.</p>
            </div>
            
            <div class="space-y-4">
                <h4 class="text-sm font-extrabold text-white uppercase tracking-wider">Akses Cepat</h4>
                <ul class="space-y-2 text-xs">
                    <li><a href="#" class="hover:text-white transition-colors">Tentang Kami</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Layanan Pelanggan</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Hubungi Kami</a></li>
                    <li><a href="/chat" class="hover:text-white transition-colors">Bantuan Chatbot</a></li>
                </ul>
            </div>
            
            <div class="space-y-4">
                <h4 class="text-sm font-extrabold text-white uppercase tracking-wider">Layanan Utama</h4>
                <ul class="space-y-2 text-xs">
                    <li><a href="#" class="hover:text-white transition-colors">Sambungan Baru</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Balik Nama Pelanggan</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Keluhan & Pengaduan</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Pasang Meteran Baru</a></li>
                </ul>
            </div>
            
            <div class="space-y-4">
                <h4 class="text-sm font-extrabold text-white uppercase tracking-wider">Hubungi Kami</h4>
                <p class="text-xs text-slate-400"><i class="fa-solid fa-location-dot mr-2"></i>Jl. Let. Jend. S. Parman No.42, Purbalingga Kulon, Kec. Purbalingga, Kabupaten Purbalingga, Jawa Tengah 53313</p>
                <p class="text-xs text-slate-400"><i class="fa-solid fa-phone mr-2"></i>(0281) 891011</p>
                <div class="flex space-x-3 pt-2">
                    <a href="#" class="w-8 h-8 rounded-full bg-slate-800 hover:bg-pdam-blue transition-colors flex items-center justify-center text-white"><i class="fa-brands fa-facebook-f text-sm"></i></a>
                    <a href="#" class="w-8 h-8 rounded-full bg-slate-800 hover:bg-pdam-bluelight transition-colors flex items-center justify-center text-white"><i class="fa-brands fa-twitter text-sm"></i></a>
                    <a href="#" class="w-8 h-8 rounded-full bg-slate-800 hover:bg-pink-600 transition-colors flex items-center justify-center text-white"><i class="fa-brands fa-instagram text-sm"></i></a>
                    <a href="#" class="w-8 h-8 rounded-full bg-slate-800 hover:bg-green-600 transition-colors flex items-center justify-center text-white"><i class="fa-brands fa-whatsapp text-sm"></i></a>
                </div>
            </div>
        </div>
    </footer>

    <!-- ─────────────────────────────────────────────
         FLOATING CHAT WIDGET
         ───────────────────────────────────────────── -->
    
    <!-- Floating Action Button (FAB) -->
    <div id="chat-fab" onclick="toggleChatWidget()" class="fixed bottom-6 right-6 w-14 h-14 bg-pdam-blue hover:bg-pdam-bluelight rounded-full shadow-2xl flex items-center justify-center text-white cursor-pointer transition-all hover:scale-105 duration-300 z-50">
        <i class="fa-solid fa-comments text-2xl" id="fab-icon"></i>
    </div>
    
    <!-- Chat Popup Dialog -->
    <div id="chat-widget" class="fixed bottom-24 right-6 w-96 h-[520px] bg-white rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.15)] flex flex-col overflow-hidden transition-all duration-350 transform translate-y-4 opacity-0 pointer-events-none z-50 border border-gray-100">
        
        <!-- Widget Header -->
        <div class="bg-gradient-to-r from-pdam-blue to-pdam-bluelight px-4 py-3.5 text-white flex items-center justify-between shadow-md">
            <div class="flex items-center space-x-3">
                <!-- Tombol Kembali, disembunyikan di dashboard -->
                <button id="btn-back-to-menu" onclick="showDashboard()" class="hidden w-7 h-7 bg-white/10 hover:bg-white/20 rounded-full flex items-center justify-center transition-colors text-white focus:outline-none mr-0.5">
                    <i class="fa-solid fa-arrow-left text-xs"></i>
                </button>
                <div class="w-9 h-9 bg-white text-pdam-blue rounded-full flex items-center justify-center font-black text-lg shadow-sm shrink-0">
                    P
                </div>
                <div>
                    <h3 class="font-extrabold text-sm tracking-tight leading-tight">Asisten Virtual PDAM</h3>
                    <p class="text-[10px] text-blue-100 font-semibold flex items-center">
                        <span class="inline-block w-1.5 h-1.5 rounded-full bg-green-400 mr-1.5 animate-pulse"></span> Online
                    </p>
                </div>
            </div>
            <button onclick="toggleChatWidget()" class="w-7 h-7 bg-white/10 hover:bg-white/20 rounded-full flex items-center justify-center transition-colors text-white focus:outline-none">
                <i class="fa-solid fa-xmark text-sm"></i>
            </button>
        </div>

        <!-- Menu / Dashboard Area -->
        <div id="chat-dashboard" class="flex-1 p-5 overflow-y-auto bg-slate-50 flex flex-col justify-between chat-scroll">
            <div class="space-y-4">
                <!-- Welcome text -->
                <div class="text-center py-2">
                    <h4 class="font-extrabold text-slate-800 text-sm">Selamat Datang di PDAM Purbalingga</h4>
                    <p class="text-slate-500 text-[11px] mt-1">Silakan pilih layanan yang Anda butuhkan di bawah ini:</p>
                </div>
                
                <!-- Quick Action Buttons -->
                <div class="space-y-2.5">
                    <button onclick="selectDashboardMenu('cek_tagihan')" class="w-full text-left bg-white hover:bg-slate-100 border border-slate-200 hover:border-pdam-blue text-slate-700 p-3 rounded-xl transition-all duration-200 flex items-center space-x-3 shadow-sm group focus:outline-none">
                        <div class="w-8 h-8 rounded-lg bg-blue-50 text-pdam-blue flex items-center justify-center group-hover:bg-pdam-blue group-hover:text-white transition-colors duration-200 shrink-0">
                            <i class="fa-solid fa-file-invoice-dollar text-sm"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-bold text-slate-800">Cek Tagihan Air</p>
                            <p class="text-[10px] text-slate-400 truncate">Lihat tunggakan tagihan rekening air Anda</p>
                        </div>
                        <i class="fa-solid fa-chevron-right text-[10px] text-slate-350 group-hover:text-pdam-blue transition-colors shrink-0"></i>
                    </button>
                    
                    <button onclick="selectDashboardMenu('lapor_keluhan')" class="w-full text-left bg-white hover:bg-slate-100 border border-slate-200 hover:border-pdam-blue text-slate-700 p-3 rounded-xl transition-all duration-200 flex items-center space-x-3 shadow-sm group focus:outline-none">
                        <div class="w-8 h-8 rounded-lg bg-red-50 text-red-500 flex items-center justify-center group-hover:bg-red-500 group-hover:text-white transition-colors duration-200 shrink-0">
                            <i class="fa-solid fa-bullhorn text-sm"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-bold text-slate-800">Laporkan Keluhan Layanan</p>
                            <p class="text-[10px] text-slate-400 truncate">Adukan kendala air mati, pipa bocor, dll</p>
                        </div>
                        <i class="fa-solid fa-chevron-right text-[10px] text-slate-350 group-hover:text-pdam-blue transition-colors shrink-0"></i>
                    </button>
                    
                    <button onclick="selectDashboardMenu('cek_status')" class="w-full text-left bg-white hover:bg-slate-100 border border-slate-200 hover:border-pdam-blue text-slate-700 p-3 rounded-xl transition-all duration-200 flex items-center space-x-3 shadow-sm group focus:outline-none">
                        <div class="w-8 h-8 rounded-lg bg-green-50 text-green-600 flex items-center justify-center group-hover:bg-green-600 group-hover:text-white transition-colors duration-200 shrink-0">
                            <i class="fa-solid fa-magnifying-glass text-sm"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-bold text-slate-800">Cek Status Laporan</p>
                            <p class="text-[10px] text-slate-400 truncate">Pantau perkembangan tindak lanjut keluhan Anda</p>
                        </div>
                        <i class="fa-solid fa-chevron-right text-[10px] text-slate-350 group-hover:text-pdam-blue transition-colors shrink-0"></i>
                    </button>
                    
                    <button onclick="selectDashboardMenu('chat_bebas')" class="w-full text-left bg-white hover:bg-slate-100 border border-slate-200 hover:border-pdam-blue text-slate-700 p-3 rounded-xl transition-all duration-200 flex items-center space-x-3 shadow-sm group focus:outline-none">
                        <div class="w-8 h-8 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center group-hover:bg-purple-600 group-hover:text-white transition-colors duration-200 shrink-0">
                            <i class="fa-solid fa-comments text-sm"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-bold text-slate-800">Tanya Asisten (Chat Bebas)</p>
                            <p class="text-[10px] text-slate-400 truncate">Mengobrol langsung dengan AI Agent kami</p>
                        </div>
                        <i class="fa-solid fa-chevron-right text-[10px] text-slate-350 group-hover:text-pdam-blue transition-colors shrink-0"></i>
                    </button>
                </div>
            </div>
            <!-- Footer brand / small note inside widget -->
            <div class="text-center pt-3 border-t border-slate-150 shrink-0">
                <span class="text-[9px] text-slate-400 font-medium">Perumda Air Minum Tirta Perwira</span>
            </div>
        </div>
        
        <!-- Message Area -->
        <div id="chat-messages" class="hidden flex-1 p-4 overflow-y-auto bg-slate-50 space-y-4 chat-scroll">
            <!-- Bot Initial Message -->
            <div class="flex">
                <div class="bg-white border border-gray-150 text-slate-700 rounded-2xl rounded-tl-none py-2.5 px-4 max-w-[85%] shadow-sm text-xs leading-relaxed">
                    👋 Halo! Saya adalah Asisten Virtual PDAM Purbalingga.
                    <br><br>
                    Ada yang bisa saya bantu?
                    <br>
                    • Ketik *nomor pelanggan* untuk cek tagihan rekening air.
                    <br>
                    • Ketik *"cara bayar"* untuk petunjuk pembayaran.
                    <br>
                    • Ketik *"lapor keluhan"* jika ingin membuat laporan keluhan layanan PDAM.
                </div>
            </div>
        </div>
        
        <!-- Typing Indicator -->
        <div id="typing-indicator" class="hidden px-4 py-2 bg-slate-50">
            <div class="flex">
                <div class="bg-white border border-gray-200 rounded-2xl rounded-tl-none py-2 px-3 shadow-sm">
                    <div class="typing-indicator">
                        <span></span><span></span><span></span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Input Area -->
        <div id="chat-input-area" class="hidden p-3.5 bg-white border-t border-gray-100">
            <form id="chat-form" class="flex items-center space-x-2">
                <input 
                    type="text" 
                    id="message-input" 
                    class="flex-1 border border-gray-200 bg-slate-50 rounded-full px-4 py-2.5 text-xs focus:outline-none focus:bg-white focus:ring-2 focus:ring-pdam-blue focus:border-transparent transition-all" 
                    placeholder="Ketik pesan di sini..." 
                    autocomplete="off"
                >
                <button 
                    type="submit" 
                    class="bg-pdam-blue hover:bg-pdam-bluelight text-white rounded-full w-9 h-9 flex items-center justify-center transition-colors shadow-md shrink-0 focus:outline-none"
                >
                    <i class="fa-solid fa-paper-plane text-xs"></i>
                </button>
            </form>
        </div>
        
    </div>

    <!-- ─────────────────────────────────────────────
         JAVASCRIPT LOGIC
         ───────────────────────────────────────────── -->
    <script>
        const chatWidget = document.getElementById('chat-widget');
        const chatFab = document.getElementById('chat-fab');
        const fabIcon = document.getElementById('fab-icon');
        const chatForm = document.getElementById('chat-form');
        const messageInput = document.getElementById('message-input');
        const chatMessages = document.getElementById('chat-messages');
        const typingIndicator = document.getElementById('typing-indicator');

        // Elemen UI Baru untuk Dashboard & Navigasi
        const chatDashboard = document.getElementById('chat-dashboard');
        const chatInputArea = document.getElementById('chat-input-area');
        const btnBackToMenu = document.getElementById('btn-back-to-menu');

        // URL API ke FastAPI Python Backend Anda
        const API_URL = 'http://localhost:8001/api/chat';
        
        // URL API ke FastAPI Python Backend Anda
        const COMPLAINT_API_URL = 'http://localhost:8001/api/complaints';
        const STATUS_API_URL = 'http://localhost:8001/api/complaints/status';

        let isOpen = false;
        
        // State Machine untuk Pelaporan Keluhan Lokal
        let reportState = 'NORMAL'; // NORMAL, WAITING_NAME, WAITING_ADDRESS, WAITING_PHONE, WAITING_COMPLAINT, WAITING_TICKET_STATUS, WAITING_BILL_CHECK
        let reportData = {
            nama: '',
            alamat: '',
            hp: '',
            keluhan: ''
        };

        // Menampilkan Menu Utama (Dashboard)
        function showDashboard() {
            chatDashboard.classList.remove('hidden');
            chatMessages.classList.add('hidden');
            chatInputArea.classList.add('hidden');
            btnBackToMenu.classList.add('hidden');
            
            messageInput.value = '';
            reportState = 'NORMAL';
            enableChatInput();
        }

        // Menampilkan Area Percakapan Aktif
        function showChatArea(initialGreeting) {
            chatDashboard.classList.add('hidden');
            chatMessages.classList.remove('hidden');
            chatInputArea.classList.remove('hidden');
            btnBackToMenu.classList.remove('hidden');
            
            chatMessages.innerHTML = '';
            enableChatInput();
            
            if (initialGreeting) {
                appendMessage(initialGreeting, false);
            }
            
            setTimeout(() => messageInput.focus(), 100);
        }

        // Pemicu Klik Menu Dashboard
        function selectDashboardMenu(menuType) {
            if (menuType === 'cek_tagihan') {
                showChatArea("💳 **Cek Tagihan Air**\n\nSilakan masukkan **Nomor Pelanggan** Anda (8 digit) untuk mengecek tagihan rekening air:\n\nKetik **\"batal\"** untuk kembali ke menu utama.");
                reportState = 'WAITING_BILL_CHECK';
            } else if (menuType === 'lapor_keluhan') {
                showChatArea();
                startLocalLaporFlow();
            } else if (menuType === 'cek_status') {
                showChatArea("🔍 **Cek Status Laporan Keluhan**\n\nSilakan masukkan **Nomor Tiket Laporan** Anda (contoh: 19122021-1):\n Pastikan penulisan nomor tiket benar.\n\nKetik **\"batal\"** untuk kembali ke menu utama.");
                reportState = 'WAITING_TICKET_STATUS';
            } else if (menuType === 'chat_bebas') {
                showChatArea("💬 **Tanya Asisten Virtual**\n\nHalo! Saya adalah Asisten Virtual PDAM Purbalingga. Ada yang bisa saya bantu terkait layanan air atau tagihan? Silakan tanyakan di bawah ini.");
            }
        }

        // Toggle Chat Widget (Buka / Tutup)
        function toggleChatWidget() {
            isOpen = !isOpen;
            if (isOpen) {
                // Tampilkan Widget
                chatWidget.classList.remove('opacity-0', 'translate-y-4', 'pointer-events-none');
                chatWidget.classList.add('opacity-100', 'translate-y-0', 'pointer-events-auto');
                
                // Ganti Icon FAB menjadi Silang
                fabIcon.className = 'fa-solid fa-xmark text-2xl';
                
                // Selalu buka menu utama dashboard saat pertama dibuka
                showDashboard();
            } else {
                // Sembunyikan Widget
                chatWidget.classList.remove('opacity-100', 'translate-y-0', 'pointer-events-auto');
                chatWidget.classList.add('opacity-0', 'translate-y-4', 'pointer-events-none');
                
                // Ganti Icon FAB kembali ke Comments
                fabIcon.className = 'fa-solid fa-comments text-2xl';
            }
        }

        // Buka chat dan isi input dengan query tertentu
        function openChatWithQuery(query) {
            if (!isOpen) {
                isOpen = true;
                chatWidget.classList.remove('opacity-0', 'translate-y-4', 'pointer-events-none');
                chatWidget.classList.add('opacity-100', 'translate-y-0', 'pointer-events-auto');
                fabIcon.className = 'fa-solid fa-xmark text-2xl';
            }
            
            if (query === 'cek tagihan') {
                selectDashboardMenu('cek_tagihan');
            } else {
                showChatArea("💬 **Tanya Asisten Virtual (Chat Bebas)**");
                messageInput.value = query;
                messageInput.focus();
            }
        }

        function disableChatInput() {
            messageInput.disabled = true;
            messageInput.placeholder = "Silakan isi formulir keluhan di atas...";
            messageInput.classList.remove('bg-slate-50', 'focus:bg-white', 'focus:ring-2', 'focus:ring-pdam-blue');
            messageInput.classList.add('bg-slate-100', 'text-slate-400', 'cursor-not-allowed');
            
            const submitBtn = chatForm.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.classList.remove('bg-pdam-blue', 'hover:bg-pdam-bluelight');
                submitBtn.classList.add('bg-slate-300', 'cursor-not-allowed', 'opacity-60');
            }
        }

        function enableChatInput() {
            messageInput.disabled = false;
            messageInput.placeholder = "Ketik pesan di sini...";
            messageInput.classList.remove('bg-slate-100', 'text-slate-400', 'cursor-not-allowed');
            messageInput.classList.add('bg-slate-50', 'focus:bg-white');
            
            const submitBtn = chatForm.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.classList.remove('bg-slate-300', 'cursor-not-allowed', 'opacity-60');
                submitBtn.classList.add('bg-pdam-blue', 'hover:bg-pdam-bluelight');
            }
        }

        // Mulai alur keluhan lokal dengan menampilkan formulir langsung
        function startLocalLaporFlow() {
            reportState = 'NORMAL';
            disableChatInput();
            
            const formId = 'lapor-form-' + Date.now();
            const formHtml = `
                <div class="p-1.5 text-slate-700 bg-white">
                    <h4 class="font-bold text-xs mb-1.5 text-pdam-blue flex items-center gap-1.5">
                        <i class="fa-solid fa-file-invoice"></i> Formulir Pengaduan Keluhan
                    </h4>
                    <p class="text-[10px] text-gray-500 mb-2.5 leading-snug">Silakan isi formulir resmi berikut untuk mengirimkan pengaduan ke database PDAM Purbalingga.</p>
                    <form id="${formId}" class="space-y-2" onsubmit="handleFormLaporSubmit(event, '${formId}')">
                        <div>
                            <label class="block text-[10px] font-semibold text-gray-600 mb-0.5">Nama Lengkap</label>
                            <input type="text" name="nama" required class="w-full px-2.5 py-1.5 text-xs border border-gray-200 rounded-lg focus:outline-none focus:border-pdam-blue" placeholder="Contoh: Budi Susanto">
                        </div>
                        <div>
                            <label class="block text-[10px] font-semibold text-gray-600 mb-0.5">Alamat Lengkap</label>
                            <input type="text" name="alamat" required class="w-full px-2.5 py-1.5 text-xs border border-gray-200 rounded-lg focus:outline-none focus:border-pdam-blue" placeholder="Contoh: RT 02/RW 04, Purbalingga Kidul">
                        </div>
                        <div>
                            <label class="block text-[10px] font-semibold text-gray-600 mb-0.5">Nomor HP / WhatsApp</label>
                            <input type="text" name="hp" required class="w-full px-2.5 py-1.5 text-xs border border-gray-200 rounded-lg focus:outline-none focus:border-pdam-blue" placeholder="Contoh: 08123456789">
                        </div>
                        <div>
                            <label class="block text-[10px] font-semibold text-gray-600 mb-0.5">Detail Keluhan</label>
                            <textarea name="keluhan" required rows="3" class="w-full px-2.5 py-1.5 text-xs border border-gray-200 rounded-lg focus:outline-none focus:border-pdam-blue resize-none" placeholder="Contoh: Air mati sejak kemarin sore..."></textarea>
                        </div>
                        <div class="pt-1 flex gap-2">
                            <button type="submit" class="flex-1 bg-pdam-blue hover:bg-blue-600 text-white font-bold py-1.5 px-3 rounded-lg text-xs transition-colors flex items-center justify-center gap-1">
                                <i class="fa-solid fa-paper-plane"></i> Kirim Laporan
                            </button>
                            <button type="button" onclick="cancelFormLapor(this)" class="bg-gray-100 hover:bg-gray-200 text-gray-500 font-semibold py-1.5 px-3 rounded-lg text-xs transition-colors">
                                Batal
                            </button>
                        </div>
                    </form>
                </div>
            `;
            
            appendRawHtmlMessage(formHtml);
        }

        function appendRawHtmlMessage(html) {
            const messageDiv = document.createElement('div');
            messageDiv.className = 'flex justify-start';
            
            const innerDiv = document.createElement('div');
            innerDiv.className = 'bg-white border border-gray-200 text-slate-700 rounded-2xl rounded-tl-none py-3 px-4 w-[90%] shadow-sm text-xs leading-relaxed';
            innerDiv.innerHTML = html;
            
            messageDiv.appendChild(innerDiv);
            chatMessages.appendChild(messageDiv);
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        function cancelFormLapor(btn) {
            const container = btn.closest('form').parentNode;
            container.innerHTML = `
                <div class="text-slate-400 italic text-xs py-1 flex items-center gap-1.5">
                    <i class="fa-solid fa-circle-xmark"></i> Pengisian formulir laporan dibatalkan.
                </div>
            `;
            enableChatInput();
        }

        async function handleFormLaporSubmit(event, formId) {
            event.preventDefault();
            const form = document.getElementById(formId);
            const submitBtn = form.querySelector('button[type="submit"]');
            const cancelBtn = form.querySelector('button[type="button"]');
            
            // Ubah button state jadi loading
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Mengirim...';
            if (cancelBtn) cancelBtn.style.display = 'none';
            
            const formData = new FormData(form);
            const payload = {
                "ComplianerName": formData.get('nama'),
                "ComplianerAddress": formData.get('alamat'),
                "PhoneNumber": formData.get('hp'),
                "CompliantContent": formData.get('keluhan'),
                "InputedBy": "web_chatbot"
            };
            
            showTyping();
            
            try {
                const response = await fetch(COMPLAINT_API_URL, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(payload)
                });
                
                hideTyping();
                
                if (response.ok) {
                    const resData = await response.json();
                    const ticketNum = resData.ticket_number;
                    form.parentNode.innerHTML = `
                        <div class="text-center py-2 text-slate-700">
                            <div class="text-emerald-500 text-2xl mb-1"><i class="fa-solid fa-circle-check"></i></div>
                            <h5 class="font-bold text-xs text-emerald-600 mb-1">Laporan Keluhan Terkirim!</h5>
                            <p class="text-[10px] text-gray-500 mb-2 leading-relaxed">Keluhan Anda telah dicatat oleh sistem dengan nomor tiket:</p>
                            <div class="inline-block bg-emerald-50 text-emerald-700 font-bold px-3 py-1.5 rounded-lg border border-emerald-200 text-xs tracking-wider select-all mb-1">
                                ${ticketNum}
                            </div>
                            <p class="text-[10px] text-gray-400 mt-2 leading-snug">Simpan nomor tiket ini untuk melacak status penanganan keluhan Anda. Terima kasih! 🙏</p>
                        </div>
                    `;
                    enableChatInput();
                } else {
                    throw new Error("Gagal menyimpan ke server");
                }
            } catch (error) {
                console.error("Error submitting complaint:", error);
                hideTyping();
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fa-solid fa-paper-plane"></i> Kirim Laporan';
                if (cancelBtn) cancelBtn.style.display = 'inline-block';
                alert("Gagal mengirim laporan keluhan. Silakan cek koneksi server backend Anda.");
            }
        }

        // Jalankan alur keluhan otomatis jika user menekan tombol pengaduan
        function openLaporFlow() {
            if (!isOpen) {
                isOpen = true;
                chatWidget.classList.remove('opacity-0', 'translate-y-4', 'pointer-events-none');
                chatWidget.classList.add('opacity-100', 'translate-y-0', 'pointer-events-auto');
                fabIcon.className = 'fa-solid fa-xmark text-2xl';
            }
            showChatArea();
            startLocalLaporFlow();
        }

        // Tambahkan pesan ke UI
        function appendMessage(text, isUser = false) {
            const messageDiv = document.createElement('div');
            messageDiv.className = `flex ${isUser ? 'justify-end' : ''}`;
            
            const innerDiv = document.createElement('div');
            innerDiv.className = isUser 
                ? 'bg-pdam-blue text-white rounded-2xl rounded-tr-none py-2.5 px-4 max-w-[85%] shadow-sm text-xs leading-relaxed'
                : 'bg-white border border-gray-150 text-slate-700 rounded-2xl rounded-tl-none py-2.5 px-4 max-w-[85%] shadow-sm text-xs leading-relaxed';
            
            // Konversi format Markdown tebal (*) atau (**) ke <b>
            let formattedText = text
                .replace(/\*\*(.*?)\*\*/g, '<b>$1</b>')
                .replace(/\*(.*?)\*/g, '<b>$1</b>')
                .replace(/\n/g, '<br>');
                
            // Konversi [text](url) ke <a href="url">
            formattedText = formattedText.replace(/\[(.*?)\]\((.*?)\)/g, '<a href="$2" target="_blank" class="text-pdam-blue hover:underline font-bold">$1</a>');
            
            innerDiv.innerHTML = formattedText;
            messageDiv.appendChild(innerDiv);
            chatMessages.appendChild(messageDiv);
            
            // Auto scroll ke bawah
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        function showTyping() {
            typingIndicator.classList.remove('hidden');
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        function hideTyping() {
            typingIndicator.classList.add('hidden');
        }

        // Handle Pengiriman Pesan Form
        chatForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            if (messageInput.disabled) return;
            const message = messageInput.value.trim();
            if (!message) return;

            // 1. Tampilkan pesan user di widget
            appendMessage(message, true);
            messageInput.value = '';
            
            // Cek jika user membatalkan alur pengaduan
            if (reportState !== 'NORMAL' && message.toLowerCase() === 'batal') {
                showDashboard();
                appendMessage("❌ Alur saat ini telah dibatalkan. Kembali ke menu utama.", false);
                return;
            }

            // 2. State Machine Pengaduan (Lokal)
            if (reportState !== 'NORMAL') {
                if (reportState === 'WAITING_TICKET_STATUS') {
                    const ticketNumber = message;
                    showTyping();
                    
                    try {
                        const response = await fetch(STATUS_API_URL, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({ ticket_number: ticketNumber })
                        });
                        
                        hideTyping();
                        
                        if (response.ok) {
                            let data = await response.json();
                            
                            // Jika respons dibungkus dalam array, ambil objek pertama
                            if (Array.isArray(data) && data.length > 0) {
                                data = data[0];
                            }
                            
                            const statusId = data.status_id;
                            let statusText = "Sedang Diproses ⏳";
                            if (statusId == 1) {
                                statusText = "Dilaporkan 📝";
                            } else if (statusId == 2) {
                                statusText = "Pengecekan 🔍";
                            } else if (statusId == 3) {
                                statusText = "Pengerjaan 🛠️";
                            } else if (statusId == 4) {
                                statusText = "Selesai / Teratasi ✅";
                            } else if (statusId === null || statusId === undefined || statusId === '') {
                                statusText = "Tidak Ditemukan ❌";
                            }
                            const msgText = data.message || "Laporan Anda sedang berada dalam penanganan oleh tim teknis kami.";
                            
                            appendMessage(
                                `🔍 **Hasil Pelacakan Laporan Keluhan**\n\n` +
                                `• Nomor Laporan: **${ticketNumber}**\n` +
                                `• Status: **${statusText}**\n\n` +
                                `${msgText}\n\n` +
                                `---\n` +
                                `Silakan masukkan **Nomor Tiket Laporan** lainnya untuk mengecek kembali, atau ketik **"batal"** untuk kembali ke menu utama.`,
                                false
                            );
                        } else {
                            throw new Error("Gagal mengambil data dari backend");
                        }
                    } catch (error) {
                        console.error("Error fetching status from backend:", error);
                        hideTyping();
                        appendMessage(
                            `⚠️ **Sistem Pelacakan Sedang Gangguan**\n\n` +
                            `Maaf, sistem pelacakan status keluhan saat ini sedang offline atau mengalami gangguan. Mohon mencoba kembali beberapa saat lagi.`,
                            false
                        );
                    }
                    return;
                } else if (reportState === 'WAITING_BILL_CHECK') {
                    // Bersihkan spasi jika ada
                    const cleanMsg = message.replace(/\s+/g, '');
                    // Validasi: cari minimal 8 digit angka
                    const numMatch = cleanMsg.match(/\b\d{8,}\b/);
                    
                    if (!numMatch) {
                        appendMessage(
                            `⚠️ **Format Salah**\n\n` +
                            `Nomor pelanggan harus berupa angka minimal 8 digit.\n` +
                            `Silakan masukkan **Nomor Pelanggan** Anda kembali, atau ketik **"batal"** untuk kembali ke menu utama.`,
                            false
                        );
                        return;
                    }
                    
                    const noPelanggan = numMatch[0];
                    showTyping();
                    
                    try {
                        // Kirim pesan dengan format cek tagihan ke API FastAPI
                        const response = await fetch(API_URL, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({ message: "cek tagihan " + noPelanggan })
                        });

                        const data = await response.json();
                        hideTyping();
                        
                        if (data && data.reply) {
                            appendMessage(
                                `${data.reply}\n\n` +
                                `---\n` +
                                `Silakan masukkan **Nomor Pelanggan** lainnya untuk mengecek kembali, atau ketik **"batal"** untuk kembali ke menu utama.`,
                                false
                            );
                        } else {
                            appendMessage("Maaf, format respons dari server tidak dikenali.", false);
                        }
                    } catch (error) {
                        console.error("Error checking bill from backend:", error);
                        hideTyping();
                        appendMessage(
                            `⚠️ **Koneksi Bermasalah**\n\n` +
                            `Gagal menghubungkan ke database tagihan. Silakan cek koneksi backend Anda.`,
                            false
                        );
                    }
                    return;
                }
            }

            // 3. Jalankan alur normal (Ollama AI) jika state NORMAL
            showTyping();

            try {
                // Kirim ke API FastAPI Python
                const response = await fetch(API_URL, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ message: message })
                });

                const data = await response.json();
                
                // Sembunyikan typing loading
                hideTyping();
                
                if (data && data.reply) {
                    appendMessage(data.reply, false);
                    
                    // Cek jika AI mendeteksi intent LAPOR_KELUHAN
                    if (data.intent === 'LAPOR_KELUHAN') {
                        showTyping();
                        setTimeout(() => {
                            hideTyping();
                            startLocalLaporFlow();
                        }, 1000);
                    }
                } else {
                    appendMessage("Maaf, format respons dari server tidak dikenali.", false);
                }

            } catch (error) {
                console.error("Error connecting to backend:", error);
                hideTyping();
                appendMessage("Maaf, tidak dapat terhubung ke server asisten virtual. Pastikan API backend python pada port 8001 sudah menyala.", false);
            }
        });
    </script>

</body>
</html>
