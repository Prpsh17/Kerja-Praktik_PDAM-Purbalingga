# File: backend/faq_data.py
# Simpan daftar Tanya Jawab FAQ resmi PDAM Purbalingga di sini.
# Anda bisa langsung menambah, mengedit, atau menghapus item di bawah ini.

FAQ_LIST = [
    {
        "keywords": ["pasang baru", "sambungan baru", "daftar pdam", "pendaftaran"],
        "question": "Bagaimana cara mendaftar pasang baru sambungan PDAM?",
        "answer": (
            "Untuk mendaftar sambungan baru PDAM Purbalingga, Anda perlu melengkapi persyaratan berikut:\n"
            "1. Mengisi Surat Permohonan Pelanggan. \n"
            "2. Meterai Rp 10.000.\n"
            "3. Fotokopi KTP Pemohon yang masih berlaku\n"
            "4. Fotokopi Kartu Keluarga.\n"
            "5. Mendownload dan mengisi formulir SPL PDAM 2025 di [halaman ini](https://pdampurbalingga.co.id/layanan/pemasangan-sambungan-baru)"
        )
    },
    {
        "keywords": ["tarif", "biaya air", "harga air", "golongan", "biaya tetap", "biaya layanan"],
        "question": "Berapa tarif air PDAM Purbalingga?",
        "answer": (
            "Tarif air PDAM Purbalingga dihitung per meter kubik (m3) dan disesuaikan berdasarkan golongan pelanggan:\n"
            "• Golongan Sosial: Tarif mulai dari Rp 1.500/m3.\n"
            "• Golongan Rumah Tangga: Mulai dari Rp 3.000/m3 untuk pemakaian dasar (1-10 m3).\n"
            "• Golongan Niaga/Industri: Disesuaikan berdasarkan klasifikasi usaha.\n"
            "Detail lengkap tarif per kubik dapat dilihat di [Website Resmi PDAM Purbalingga](https://pdampurbalingga.co.id/tarif)"
        )
    },
    {
        "keywords": ["ganti nama", "balik nama", "nama rekening", "pemilik"],
        "question": "Bagaimana syarat dan cara melakukan ganti nama (balik nama) pelanggan?",
        "answer": (
            "Untuk melakukan balik nama rekening PDAM (misal karena pembelian rumah atau warisan), persyaratannya adalah:\n"
            "1. Fotokopi KTP pemilik baru.\n"
            "2. Fotokopi sertifikat kepemilikan rumah (sertifikat/akte jual beli/surat hibah).\n"
            "3. Bukti lunas tagihan air bulan terakhir.\n"
            "4. Mengisi formulir balik nama di kantor PDAM terdekat."
        )
    },
    {
        "keywords": ["cabang", "alamat cabang", "lokasi cabang", "kantor cabang", "cabang pdam dimana"],
        "question": "Di mana saja alamat kantor cabang PDAM Purbalingga?",
        "answer": (
            "Berikut adalah daftar Cabang Pelayanan PDAM Purbalingga (Perumdam Tirta Perwira):\n"
            "1. Cabang Kota Bangga\n   📍 Jl. Letjend S. Parman No. 62, Purbalingga\n   🗺️ [Buka di Google Maps](https://maps.google.com/?q=PDAM+Purbalingga+Cabang+Kota+Bangga)\n"
            "2. Cabang Jenderal Soedirman\n   📍 Jl. Raya Rupakpicis, Klapasawit, Kec. Kalimanah\n   🗺️ [Buka di Google Maps](https://maps.google.com/?q=PDAM+Purbalingga+Cabang+Jenderal+Soedirman)\n"
            "3. Cabang Usman Janatin\n   📍 Jl. Raya Karangnangka, Kec. Mrebet\n   🗺️ [Buka di Google Maps](https://maps.google.com/?q=PDAM+Purbalingga+Cabang+Usman+Janatin)\n"
            "4. Cabang Goentoer Darjono\n   📍 Jl. Kalikajar, Dusun 1, Kaligondang\n   🗺️ [Buka di Google Maps](https://maps.google.com/?q=PDAM+Purbalingga+Cabang+Goentoer+Darjono)\n"
            "5. Cabang Ardilawet\n   📍 Jl. Raya Tobong, Dusun I, Karanglewas, Kec. Kutasari\n   🗺️ [Buka di Google Maps](https://maps.google.com/?q=PDAM+Purbalingga+Cabang+Ardilawet)"
        )
    },
    {
        "keywords": ["jam pelayanan", "buka kantor", "loket", "jam kerja", "operasional", "jam berapa buka", "kapan tutup", "jadwal buka", "jam buka pdam", "buka jam"],
        "question": "Kapan jam operasional pelayanan kantor PDAM Purbalingga?",
        "answer": (
            "Jam Operasional Pelayanan Kantor PDAM Purbalingga adalah sebagai berikut:\n"
            "• Senin - Kamis: 07:30 - 15:00 WIB\n"
            "• Jumat: 07:30 - 11:00 WIB\n"
            "• Sabtu: 07:30 - 13:00 WIB\n"
            "• Minggu & Hari Libur Nasional: Tutup"
        )
    },
    {
        "keywords": ["denda", "terlambat bayar", "jatuh tempo", "putus"],
        "question": "Bagaimana ketentuan denda keterlambatan dan pemutusan air?",
        "answer": (
            "Batas pembayaran tagihan air setiap bulan adalah tanggal 20. Jika terlambat, ketentuan dendanya adalah:\n"
            "1. Keterlambatan setelah tanggal 20 dikenakan denda administrasi.\n"
            "2. Tunggakan selama 2 bulan berturut-turut akan mendapatkan surat peringatan.\n"
            "3. Tunggakan lebih dari 3 bulan akan dilakukan pemutusan sementara sambungan air."
        )
    },
    {
        "keywords": ["aliran air mengecil", "air mati", "air kecil", "mati air", "mengecil", "kecil", "mati"],
        "question": "Langkah yang harus dilakukan saat aliran air mengecil atau mati.",
        "answer": (
            "Pertama, pastikan stop kran (engkol) di dekat meteran air dalam posisi terbuka penuh.\n"
            "Cek media sosial atau website resmi PDAM untuk melihat apakah ada pengumuman perbaikan pipa atau pemadaman listrik yang memengaruhi pompa distribusi di wilayah Anda.\n"
            "Jika tidak ada informasi gangguan massal, segera buat laporan melalui Call Center, WhatsApp pengaduan, atau aplikasi layanan dengan menyertakan Nomor Pelanggan dan alamat lengkap agar petugas bisa melakukan pengecekan lapangan."
        )
    },
    {
        "keywords": ["air keruh", "air bau", "keruh", "berbau", "kotor", "coklat", "berwarna", "berwarna coklat"],
        "question": "Penyebab dan solusi penanganan saat air keluar dalam kondisi keruh atau berbau.",
        "answer": (
            "Kekeruhan biasanya bersifat sementara dan sering terjadi setelah petugas selesai melakukan perbaikan kebocoran pipa utama. Saat aliran air dinyalakan kembali, endapan di dalam pipa bisa terbawa arus.\n"
            "Solusi: Buka kran air yang letaknya paling dekat dengan meteran. Biarkan air mengalir (di-flushing) selama beberapa saat hingga kotorannya terbuang dan air kembali jernih. Jika kondisi keruh/berbau tidak kunjung hilang setelah beberapa jam, segera laporkan ke layanan pengaduan."
        )
    },
    {
        "keywords": ["biaya pasang baru", "estimasi biaya", "alur pemasangan", "pasang fisik", "rab"],
        "question": "Estimasi biaya dan alur proses pendaftaran hingga pemasangan fisik.",
        "answer": (
            "Alur Proses: Pendaftaran (penyerahan berkas) -> Petugas melakukan survei lokasi dan pengukuran -> PDAM menerbitkan Rencana Anggaran Biaya (RAB) -> Calon pelanggan membayar RAB ke loket/bank resmi -> Petugas melakukan pemasangan instalasi dan meteran air di lokasi.\n"
            "Estimasi Biaya: Biaya pasang baru bervariasi bergantung pada golongan tarif pelanggan (Sosial, Rumah Tangga, Niaga) serta panjang pipa yang dibutuhkan dari jaringan utama (retikulasi) ke titik meteran rumah. Pembayaran wajib dilakukan di loket resmi, bukan dititipkan ke petugas survei."
        )
    },
    {
        "keywords": ["tanggung jawab pipa", "pemeliharaan pipa", "kebocoran pipa", "batas pipa", "tanggung jawab pelanggan"],
        "question": "Penjelasan batas tanggung jawab pemeliharaan instalasi pipa.",
        "answer": (
            "Tanggung Jawab PDAM: Mulai dari sumber air, jaringan perpipaan distribusi di jalan, hingga tepat di unit meteran air milik pelanggan. Segala kebocoran di area ini adalah tanggung jawab PDAM.\n"
            "Tanggung Jawab Pelanggan: Seluruh instalasi perpipaan setelah meteran air (pipa yang masuk ke dalam rumah, kran, tandon, dll). Jika ada kebocoran di area ini, pelanggan bertanggung jawab penuh atas biaya perbaikan dan lonjakan tagihan air yang ditimbulkan."
        )
    },
    {
        "keywords": ["air belum mengalir", "perbaikan selesai", "laporan selesai", "air lambat", "recovery", "air mampet", "aliran lambat"],
        "question": "Mengapa air tidak langsung mengalir normal meskipun perbaikan pipa sudah diumumkan selesai?",
        "answer": (
            "Setelah proses perbaikan selesai, khususnya pada perbaikan pipa distribusi utama, aliran air tidak bisa langsung menyala deras di kran pelanggan. Hal ini dikarenakan air membutuhkan waktu untuk mengalir dari sumber atau reservoir dan mengisi kembali seluruh jaringan pipa yang sebelumnya dikosongkan (proses recovery jaringan)."
        )
    },
    {
        "keywords": ["lokasi pdam", "alamat pdam", "kantor pdam", "pdam purbalingga dimana", "lokasi kantor", "alamat kantor", "alamat pusat", "pusat", "dimana"],
        "question": "Di mana alamat lokasi kantor pusat PDAM Purbalingga?",
        "answer": (
            "Kantor pusat Perumda Air Minum (PDAM) Tirta Perwira Kabupaten Purbalingga berlokasi di:\n"
            "📍 Jl. Letjen S. Parman No. 62, Purbalingga, Jawa Tengah 53311.\n"
            "🗺️ [Buka di Google Maps](https://maps.google.com/?q=PDAM+Purbalingga+Kantor+Pusat)\n"
            "📞 Telepon: (0281) 891706\n"
            "📧 Email: mail@pdampurbalingga.co.id\n"
            "🌐 Website Resmi: [pdampurbalingga.co.id](https://pdampurbalingga.co.id)"
        )
    },
    {
        "keywords": ["baca meteran", "angka meteran", "cara baca", "meteran air", "angka hitam", "angka merah"],
        "question": "Bagaimana cara membaca meteran air PDAM sendiri di rumah?",
        "answer": (
            "Untuk membaca meteran air, perhatikan angka pada register meteran:\n"
            "1. Angka berwarna HITAM: Menunjukkan volume pemakaian dalam meter kubik (m3). Angka inilah yang dicatat oleh petugas dan digunakan sebagai dasar perhitungan tagihan.\n"
            "2. Angka berwarna MERAH: Menunjukkan volume dalam satuan liter. Angka merah ini biasanya diabaikan saat pencatatan tagihan bulanan.\n"
            "Mencatat angka hitam secara berkala membantu Anda memantau konsumsi air mandiri."
        )
    },
    {
        "keywords": ["catat meter", "petugas catat", "jadwal catat", "tanggal catat", "pencatatan"],
        "question": "Kapan jadwal petugas melakukan pencatatan meteran air ke rumah?",
        "answer": (
            "Petugas pembaca meter PDAM biasanya datang ke rumah pelanggan antara tanggal 1 sampai 10 setiap bulannya.\n"
            "Mohon pastikan area sekitar meteran air di rumah Anda mudah diakses (tidak terhalang barang, pintu pagar tidak dikunci, atau anjing peliharaan diikat) agar petugas dapat mencatat angka meter dengan akurat."
        )
    },
    {
        "keywords": ["tagihan melonjak", "tagihan naik", "tagihan mahal", "bengkak", "naik drastis", "mahal sekali", "tinggi sekali"],
        "question": "Mengapa tagihan air bulan ini melonjak tinggi secara drastis?",
        "answer": (
            "Lonjakan tagihan air umumnya disebabkan oleh beberapa faktor berikut:\n"
            "1. Kebocoran pipa instalasi setelah meteran (tanggung jawab pelanggan). Cobalah tutup semua kran, jika jarum meteran tetap berputar, berarti ada kebocoran.\n"
            "2. Kran air atau shower lupa ditutup rapat.\n"
            "3. Adanya akumulasi koreksi angka meteran pada bulan-bulan sebelumnya jika rumah sempat terkunci saat petugas datang.\n"
            "Silakan hubungi kantor pelayanan untuk melakukan kroscek fisik jika Anda mencurigai adanya kesalahan catat."
        )
    },
    {
        "keywords": ["pindah meteran", "geser meteran", "mindah meter", "posisi meteran"],
        "question": "Bagaimana prosedur memindahkan atau menggeser posisi meteran air?",
        "answer": (
            "Pelanggan dilarang keras memindahkan, menggeser, atau membongkar meteran air sendiri karena merupakan aset PDAM.\n"
            "Prosedur yang benar:\n"
            "1. Ajukan permohonan pemindahan meteran ke kantor pelayanan PDAM terdekat dengan membawa KTP dan rekening air.\n"
            "2. Petugas teknis akan melakukan survei kelayakan lokasi baru.\n"
            "3. Pelanggan membayar biaya pemindahan sesuai RAB yang diterbitkan.\n"
            "4. Petugas resmi PDAM akan melakukan relokasi meteran secara resmi."
        )
    },
    {
        "keywords": ["langsung minum", "aman diminum", "diminum langsung", "air minum", "merebus"],
        "question": "Apakah air PDAM Purbalingga aman untuk langsung diminum?",
        "answer": (
            "Air yang didistribusikan PDAM telah melalui proses sterilisasi dan memenuhi standar kebersihan untuk MCK (Mandi, Cuci, Kakus).\n"
            "Namun, air PDAM TIDAK direkomendasikan untuk langsung diminum langsung dari kran tanpa dimasak terlebih dahulu. Demi kesehatan, pastikan Anda merebus air hingga mendidih (100°C) sebelum dikonsumsi."
        )
    },
    {
        "keywords": ["sejarah", "kapan berdiri", "didirikan", "asal usul", "tirta perwira"],
        "question": "Bagaimana sejarah berdirinya PDAM Purbalingga?",
        "answer": (
            "Perumda Air Minum Tirta Perwira (PDAM Purbalingga) didirikan pada tahun 1968. "
            "Namun, pelayanan air minum di Purbalingga sebenarnya sudah dimulai sejak tahun 1928 pada masa kolonial Belanda, dengan kapasitas awal 28,6 L/detik dari sumber Kawung Carang.\n"
            "Pada tahun 2019, status hukumnya resmi berubah menjadi Perusahaan Umum Daerah (Perumdam) Air Minum Tirta Perwira. "
            "Saat ini kami telah melayani lebih dari 60.000 pelanggan dan terus berekspansi memproduksi Air Minum Dalam Kemasan (AMDK)."
        )
    },
    {
        "keywords": ["sumber air", "mata air", "sumber mata air", "air baku", "darimana air"],
        "question": "Dari mana sumber mata air yang dikelola PDAM Purbalingga?",
        "answer": (
            "PDAM Purbalingga mengelola beberapa sumber mata air utama, di antaranya:\n"
            "1. Mata Air Teleng Walik (Kutasari) - 171,94 L/detik\n"
            "2. Mulang 1 & 2 (Karangcegak) - >100 L/detik\n"
            "3. Situ Kajongan (Bojongsari) - 67,28 L/detik\n"
            "4. Pajerukan 1 & 2 (Padamara) - 52,05 L/detik\n"
            "5. Limpak Dau (Munjul) - 45,92 L/detik\n"
            "6. Bata Putih (Cipaku) - 40,76 L/detik\n"
            "7. Tuk Arus (Sangkanayu) - 32,98 L/detik\n"
            "8. Wadas Kelir (Candiwulan) - 17,39 L/detik\n"
            "9. Tlagayasa (Bobotsari) - 8,00 L/detik\n"
            "Serta sumber cadangan/lainnya seperti Si Kopyah, Mudal Teleng, Mudal Picung, Kali Gintung, Pingen, dan Tuk Ringin."
        )
    }
]
