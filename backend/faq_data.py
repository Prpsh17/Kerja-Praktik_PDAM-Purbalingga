# File: backend/faq_data.py
# Simpan daftar Tanya Jawab FAQ resmi PDAM Purbalingga di sini.
# Anda bisa langsung menambah, mengedit, atau menghapus item di bawah ini.

FAQ_LIST = [
    {
        "keywords": ["pasang baru", "sambungan baru", "daftar pdam", "pendaftaran"],
        "question": "Bagaimana cara mendaftar pasang baru sambungan PDAM?",
        "answer": (
            "Untuk mendaftar sambungan baru PDAM Purbalingga, Anda perlu melengkapi persyaratan berikut:\n"
            "1. Fotokopi KTP calon pelanggan (1 lembar).\n"
            "2. Fotokopi rekening air tetangga terdekat.\n"
            "3. Stopmap dan denah lokasi rumah.\n"
            "4. Mengisi formulir pendaftaran di kantor PDAM terdekat.\n"
            "5. Membayar biaya pendaftaran dan administrasi setelah disurvei petugas."
        )
    },
    {
        "keywords": ["tarif", "biaya air", "harga air", "golongan"],
        "question": "Berapa tarif air PDAM Purbalingga?",
        "answer": (
            "Tarif air PDAM Purbalingga dihitung per meter kubik (m3) dan disesuaikan berdasarkan golongan pelanggan:\n"
            "• Golongan Sosial: Tarif mulai dari Rp 1.500/m3.\n"
            "• Golongan Rumah Tangga: Mulai dari Rp 3.000/m3 untuk pemakaian dasar (1-10 m3).\n"
            "• Golongan Niaga/Industri: Disesuaikan berdasarkan klasifikasi usaha.\n"
            "Detail lengkap tarif per kubik dapat ditanyakan langsung di kantor pelayanan terdekat."
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
        "keywords": ["jam pelayanan", "buka kantor", "loket", "jam kerja"],
        "question": "Kapan jam pelayanan kantor dan loket pembayaran PDAM?",
        "answer": (
            "Jam operasional pelayanan kantor PDAM Purbalingga adalah:\n"
            "• Senin - Kamis: Pukul 07:00 s.d 15:00 WIB\n"
            "• Jumat: Pukul 07:00 s.d 11:00 WIB\n"
            "• Sabtu & Minggu: Kantor pelayanan libur. Pengaduan darurat tetap dilayani melalui media sosial/chatbot."
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
        "keywords": ["lokasi pdam", "alamat pdam", "kantor pdam", "pdam purbalingga dimana", "lokasi kantor", "alamat kantor", "alamat pusat"],
        "question": "Alamat lokasi kantor pusat dan kontak resmi PDAM Purbalingga.",
        "answer": (
            "Kantor pusat Perumda Air Minum (PDAM) Tirta Perwira Kabupaten Purbalingga berlokasi di:\n"
            "📍 Jl. Letjen S. Parman No. 62, Purbalingga, Jawa Tengah 53311.\n"
            "📞 Telepon: (0281) 891706\n"
            "📧 Email: mail@pdampurbalingga.co.id\n"
            "🌐 Website Resmi: https://pdampurbalingga.co.id"
        )
    }
]
