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
                <div class="w-9 h-9 bg-white text-pdam-blue rounded-full flex items-center justify-center font-black text-lg shadow-sm">
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
        
        <!-- Message Area -->
        <div id="chat-messages" class="flex-1 p-4 overflow-y-auto bg-slate-50 space-y-4 chat-scroll">
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
        <div class="p-3.5 bg-white border-t border-gray-100">
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

        // URL API ke FastAPI Python Backend Anda
        const API_URL = 'http://localhost:8001/api/chat';
        
        // URL Webhook n8n Anda
        const N8N_WEBHOOK_URL = 'https://glandular-thrash-mutable.ngrok-free.dev/webhook-test/28b42cd8-5b7e-4773-b3b6-d96cef432bdd';

        let isOpen = false;
        
        // State Machine untuk Pelaporan Keluhan Lokal
        let reportState = 'NORMAL'; // NORMAL, WAITING_NAME, WAITING_ADDRESS, WAITING_PHONE, WAITING_COMPLAINT
        let reportData = {
            nama: '',
            alamat: '',
            hp: '',
            keluhan: ''
        };

        // Toggle Chat Widget (Buka / Tutup)
        function toggleChatWidget() {
            isOpen = !isOpen;
            if (isOpen) {
                // Tampilkan Widget
                chatWidget.classList.remove('opacity-0', 'translate-y-4', 'pointer-events-none');
                chatWidget.classList.add('opacity-100', 'translate-y-0', 'pointer-events-auto');
                
                // Ganti Icon FAB menjadi Silang
                fabIcon.className = 'fa-solid fa-xmark text-2xl';
                
                // Focus ke input field
                setTimeout(() => messageInput.focus(), 100);
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
            if (!isOpen) toggleChatWidget();
            messageInput.value = query;
            messageInput.focus();
        }

        // Mulai alur keluhan lokal
        function startLocalLaporFlow() {
            reportState = 'WAITING_NAME';
            reportData = { nama: '', alamat: '', hp: '', keluhan: '' };
            appendMessage(
                "📝 **Formulir Pengaduan Keluhan Pelanggan**\n\n" +
                "Silakan ikuti instruksi berikut untuk mengirim keluhan.\n" +
                "*(Ketik 'batal' kapan saja untuk membatalkan)*\n\n" +
                "Silakan masukkan **Nama Lengkap** Anda:",
                false
            );
        }

        // Jalankan alur keluhan otomatis jika user menekan tombol pengaduan
        function openLaporFlow() {
            if (!isOpen) toggleChatWidget();
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
            const message = messageInput.value.trim();
            if (!message) return;

            // 1. Tampilkan pesan user di widget
            appendMessage(message, true);
            messageInput.value = '';
            
            // Cek jika user membatalkan alur pengaduan
            if (reportState !== 'NORMAL' && message.toLowerCase() === 'batal') {
                reportState = 'NORMAL';
                reportData = { nama: '', alamat: '', hp: '', keluhan: '' };
                appendMessage("❌ Alur pelaporan telah dibatalkan. Bot kembali ke mode normal.", false);
                return;
            }

            // 2. State Machine Pengaduan (Lokal)
            if (reportState !== 'NORMAL') {
                if (reportState === 'WAITING_NAME') {
                    reportData.nama = message;
                    reportState = 'WAITING_ADDRESS';
                    showTyping();
                    setTimeout(() => {
                        hideTyping();
                        appendMessage("📍 Terima kasih. Sekarang masukkan **Alamat Lengkap** Anda:", false);
                    }, 500);
                    return;
                }
                
                if (reportState === 'WAITING_ADDRESS') {
                    reportData.alamat = message;
                    reportState = 'WAITING_PHONE';
                    showTyping();
                    setTimeout(() => {
                        hideTyping();
                        appendMessage("📞 Masukkan **Nomor HP** Anda yang aktif:", false);
                    }, 500);
                    return;
                }
                
                if (reportState === 'WAITING_PHONE') {
                    reportData.hp = message;
                    reportState = 'WAITING_COMPLAINT';
                    showTyping();
                    setTimeout(() => {
                        hideTyping();
                        appendMessage("💬 Tuliskan **Detail Keluhan** Anda dengan jelas:", false);
                    }, 500);
                    return;
                }
                
                if (reportState === 'WAITING_COMPLAINT') {
                    reportData.keluhan = message;
                    reportState = 'NORMAL';
                    showTyping();
                    
                    // Kirim ke n8n
                    try {
                        const payload = {
                            "ComplianerName": reportData.nama,
                            "ComplianerAddress": reportData.alamat,
                            "PhoneNumber": reportData.hp,
                            "CompliantContent": reportData.keluhan,
                            "InputedBy": "web_chatbot" // Ditandai dari web_chatbot
                        };
                        
                        const n8nResponse = await fetch(N8N_WEBHOOK_URL, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify(payload)
                        });
                        
                        hideTyping();
                        
                        if (n8nResponse.ok) {
                            appendMessage(
                                "✅ **Laporan Berhasil Terkirim!**\n\n" +
                                "Terima kasih atas laporan Anda. Keluhan Anda telah kami teruskan ke sistem pusat untuk ditindaklanjuti.",
                                false
                            );
                        } else {
                            appendMessage(
                                "⚠️ **Gagal Mengirim Laporan**\n\n" +
                                "Terjadi respons tidak terduga dari server. Silakan coba beberapa saat lagi.",
                                false
                            );
                        }
                    } catch (error) {
                        console.error("Error sending to n8n:", error);
                        hideTyping();
                        appendMessage(
                            "⚠️ **Gagal Terhubung ke Server**\n\n" +
                            "Koneksi sedang bermasalah. Mohon coba beberapa saat lagi.",
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
