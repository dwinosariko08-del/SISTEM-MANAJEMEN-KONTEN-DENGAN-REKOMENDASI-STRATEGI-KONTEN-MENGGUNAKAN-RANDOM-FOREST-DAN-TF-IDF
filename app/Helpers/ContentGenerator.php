<?php

namespace App\Helpers;

class ContentGenerator
{
    /**
     * Peta kategori → pillar → topic template → title template
     */
    protected static array $map = [
        'Technology' => [
            'Problem Solving' => [
                ['topic' => 'Cara Menghilangkan Echo Saat Live Streaming',   'title' => 'Masih Echo Saat Live? Ini Solusinya!'],
                ['topic' => 'Mengatasi Lag Video Konten Creator',             'title' => '7 Cara Ampuh Hilangkan Lag di Video Kamu'],
                ['topic' => 'Setting Audio Jernih Tanpa Alat Mahal',         'title' => 'Audio Jernih Modal Minim, Ini Caranya!'],
            ],
            'Tutorial' => [
                ['topic' => 'Setup Lighting Studio Sederhana di Rumah',      'title' => 'Studio Keren di Rumah? Bisa Banget!'],
                ['topic' => 'Edit Video Cepat di HP Tanpa PC',               'title' => 'Edit Video Pro Langsung dari HP'],
                ['topic' => 'Cara Backup Konten Otomatis ke Cloud',          'title' => 'Konten Aman, Auto Backup ke Cloud'],
            ],
            'Review' => [
                ['topic' => 'Perbandingan Mic Budget Terbaik 2024',          'title' => 'Mic Budget vs Mahal, Mana Lebih Worth It?'],
                ['topic' => 'Kamera HP Terbaik untuk Konten Vertikal',       'title' => 'HP Ini Bikin Kontenmu Makin Cinematic!'],
                ['topic' => 'Software Edit Video Gratis Terbaik',            'title' => 'Edit Gratis tapi Hasilnya Profesional!'],
            ],
        ],
        'Fitness' => [
            'Motivasi' => [
                ['topic' => 'Mulai Olahraga dari Nol Tanpa Gym',            'title' => 'Mulai Fit Sekarang, Tanpa Harus ke Gym!'],
                ['topic' => 'Konsisten Olahraga 30 Hari Challenge',         'title' => '30 Hari Challenge yang Bikin Badanmu Berubah'],
                ['topic' => 'Mindset Sebelum Mulai Diet dan Olahraga',      'title' => 'Ubah Mindset Dulu, Baru Ubah Badan!'],
            ],
            'Tutorial' => [
                ['topic' => 'Gerakan Pemanasan 5 Menit Sebelum Olahraga',   'title' => '5 Menit Pemanasan yang Wajib Kamu Lakukan'],
                ['topic' => 'Workout Full Body Tanpa Alat di Rumah',        'title' => 'Full Body Workout Cukup 20 Menit di Rumah'],
                ['topic' => 'Program Latihan Pemula 3x Seminggu',           'title' => 'Program Pemula yang Terbukti Efektif!'],
            ],
            'Nutrition' => [
                ['topic' => 'Meal Prep Sehat untuk Seminggu',               'title' => 'Meal Prep Anti Ribet, Sehat Seharian!'],
                ['topic' => 'Makanan Pre-Workout yang Terbaik',             'title' => 'Makan Ini Sebelum Olahraga, Performa Naik!'],
                ['topic' => 'Protein Shake Homemade Murah dan Enak',        'title' => 'Protein Shake Enak, Bikin Sendiri di Rumah!'],
            ],
        ],
        'Beauty' => [
            'Tutorial' => [
                ['topic' => 'Makeup Natural untuk Sehari-hari',             'title' => 'Makeup Natural yang Bikin Glowing Seharian'],
                ['topic' => 'Skincare Routine Pagi yang Simpel',            'title' => 'Morning Skincare 5 Langkah, Kulit Cerah!'],
                ['topic' => 'Cara Pakai Blush On agar Tidak Menor',        'title' => 'Blush On yang Bikin Wajah Fresh, Bukan Badut!'],
            ],
            'Review' => [
                ['topic' => 'Skincare Drugstore Terbaik di Bawah 100rb',    'title' => 'Budget 100rb buat Skincare? Worth It!'],
                ['topic' => 'Foundation Lokal vs Import, Mana Lebih Bagus', 'title' => 'Lokal vs Import: Foundation Battle!'],
                ['topic' => 'Serum Vitamin C Terbaik untuk Kulit Kusam',    'title' => 'Bye Kusam! Ini Serum Vitamin C Terbaik'],
            ],
            'Tips & Tricks' => [
                ['topic' => 'Trik Makeup Tahan Lama Seharian',              'title' => 'Rahasia Makeup Awet dari Pagi sampai Malam'],
                ['topic' => 'Cara Atasi Kulit Berminyak Saat Makeup',       'title' => 'Kulit Berminyak? Ini Trik Makeup Anti Luntur'],
                ['topic' => 'Double Cleansing yang Benar untuk Pemula',     'title' => 'Double Cleansing: Cara Benar yang Jarang Tahu'],
            ],
        ],
        'Music' => [
            'Tutorial' => [
                ['topic' => 'Chord Dasar Gitar untuk Pemula',               'title' => 'Belajar Gitar dari Nol, Mulai dari Sini!'],
                ['topic' => 'Cara Rekam Vokal di Rumah Tanpa Studio',       'title' => 'Rekam Vokal Jernih di Rumah, Tanpa Ribet!'],
                ['topic' => 'Mixing Lagu Sederhana dengan HP',              'title' => 'Mixing Track Sendiri Cukup Pakai HP!'],
            ],
            'Motivasi' => [
                ['topic' => 'Perjalanan Musisi Indie dari Nol',             'title' => 'Dari Kamar ke Panggung, Perjalanan Nyata!'],
                ['topic' => 'Konsisten Latihan Musik Setiap Hari',          'title' => 'Latihan 10 Menit Sehari, Hasilnya Mengejutkan!'],
                ['topic' => 'Cara Dapetin Gig Pertama sebagai Musisi',      'title' => 'Gig Pertama? Ini Cara Dapatkannya!'],
            ],
            'Review' => [
                ['topic' => 'Headphone Monitoring Terbaik Budget 500rb',    'title' => 'Headphone Monitor Budget? Ini yang Terbaik!'],
                ['topic' => 'Interface Audio Entry Level yang Worth It',    'title' => 'Interface Audio Pemula, Ini Rekomendasinya!'],
                ['topic' => 'DAW Gratis Terbaik untuk Produser Pemula',     'title' => 'DAW Gratis yang Bikin Musik Profesional'],
            ],
        ],
        'Photography' => [
            'Tutorial' => [
                ['topic' => 'Komposisi Foto Rule of Thirds untuk Pemula',   'title' => 'Foto Makin Estetik dengan Rule of Thirds!'],
                ['topic' => 'Setting Kamera Manual untuk Foto Portrait',    'title' => 'Setting Manual ini Bikin Portrait Dramatis!'],
                ['topic' => 'Cara Foto Makanan yang Aesthetic',             'title' => 'Food Photo Aesthetic, Ini Rahasianya!'],
            ],
            'Review' => [
                ['topic' => 'Kamera Mirrorless Entry Level Terbaik 2024',   'title' => 'Mirrorless Pertama? Ini Pilihan Terbaiknya!'],
                ['topic' => 'Lensa Kit vs Lensa Fix, Mana Lebih Bagus',    'title' => 'Kit vs Fix: Duel Lensa untuk Pemula!'],
                ['topic' => 'Preset Lightroom Gratis yang Populer',         'title' => 'Preset Gratis yang Bikin Foto Instagramable!'],
            ],
            'Tips & Tricks' => [
                ['topic' => 'Editing Foto Natural dengan Lightroom Mobile', 'title' => 'Edit Natural di HP, Hasilnya Bikin Iri!'],
                ['topic' => 'Golden Hour: Waktu Terbaik untuk Foto',        'title' => 'Foto di Waktu Ini, Hasilnya Selalu Bagus!'],
                ['topic' => 'Trik Foto Minimalis yang Mudah Ditiru',        'title' => 'Minimalis tapi Kena Banget! Ini Triknya'],
            ],
        ],
        'Food' => [
            'Resep' => [
                ['topic' => 'Resep Mie Ayam Rumahan yang Autentik',         'title' => 'Mie Ayam Legendaris, Bikin Sendiri di Rumah!'],
                ['topic' => 'Snack Viral yang Mudah Dibuat Sendiri',        'title' => 'Snack Viral Ini Bisa Kamu Bikin Sendiri!'],
                ['topic' => 'Sarapan Sehat 5 Menit Tanpa Ribet',           'title' => 'Sarapan Sehat, Siap dalam 5 Menit!'],
            ],
            'Review' => [
                ['topic' => 'Review Restoran Hits Baru di Kota',            'title' => 'Restoran Baru Ini Worth It atau Overhyped?'],
                ['topic' => 'Street Food Tersembunyi yang Wajib Dicoba',    'title' => 'Street Food Hidden Gem yang Wajib Kamu Coba!'],
                ['topic' => 'Perbandingan Bubble Tea Populer',              'title' => 'Bubble Tea Battle! Mana yang Paling Enak?'],
            ],
            'Tutorial' => [
                ['topic' => 'Teknik Dasar Memasak yang Wajib Dikuasai',    'title' => 'Teknik Masak Dasar yang Bikin Masakan Enak!'],
                ['topic' => 'Cara Plating Makanan agar Terlihat Mewah',    'title' => 'Plating Simpel yang Bikin Makanan Kelihatan Mahal'],
                ['topic' => 'Bumbu Dasar Masakan Nusantara',               'title' => 'Kuasai 3 Bumbu Ini, Masakan Apapun Jadi Enak!'],
            ],
        ],
        'Lifestyle' => [
            'Produktivitas' => [
                ['topic' => 'Morning Routine yang Bikin Hari Lebih Produktif', 'title' => 'Morning Routine ini Ubah Hidupku!'],
                ['topic' => 'Cara Berhenti Procrastinate Selamanya',        'title' => 'Stop Procrastinate dengan Teknik Sederhana ini!'],
                ['topic' => 'Digital Detox 7 Hari, Ini Hasilnya',          'title' => '7 Hari Tanpa Sosmed, Ini yang Terjadi!'],
            ],
            'Minimalism' => [
                ['topic' => 'Declutter Kamar dengan Metode KonMari',        'title' => 'Kamar Berantakan? Coba Metode KonMari!'],
                ['topic' => 'Capsule Wardrobe untuk Gaya Simpel Elegan',    'title' => 'Lemari Sedikit tapi Tetap Stylish, Ini Caranya!'],
                ['topic' => 'Hidup Minimalis, Kebahagiaan Maksimal',        'title' => 'Lebih Sedikit, Lebih Bahagia. Ini Buktinya!'],
            ],
            'Self Development' => [
                ['topic' => 'Kebiasaan Kecil yang Berdampak Besar',         'title' => 'Mulai Kebiasaan Kecil ini, Hidupmu Berubah!'],
                ['topic' => 'Cara Membangun Kepercayaan Diri',              'title' => 'Dari Minder Jadi Percaya Diri, Ini Caranya!'],
                ['topic' => 'Journaling untuk Kesehatan Mental',            'title' => 'Journaling Sebentar Setiap Hari, Efeknya Luar Biasa!'],
            ],
        ],
        'Travel' => [
            'Destinasi' => [
                ['topic' => 'Hidden Gem di Jawa Tengah yang Belum Ramai',   'title' => 'Tempat Indah di Jateng yang Belum Banyak Tahu!'],
                ['topic' => 'Wisata Budget di Bali ala Backpacker',         'title' => 'Bali dengan Budget Minim? Bisa Banget!'],
                ['topic' => 'Spot Sunrise Terbaik di Indonesia',            'title' => 'Nonton Sunrise di Sini, Dijamin Nggak Menyesal!'],
            ],
            'Tips Travel' => [
                ['topic' => 'Packing Efisien untuk Perjalanan 1 Minggu',    'title' => 'Koper Kecil, Semua Muat! Ini Cara Packingnya'],
                ['topic' => 'Cara Dapat Tiket Pesawat Murah',               'title' => 'Trik Dapet Tiket Pesawat Murah yang Jarang Tahu!'],
                ['topic' => 'Itinerary 3 Hari 2 Malam di Jogja',           'title' => '3 Hari di Jogja, Ini Itinerary Lengkapnya!'],
            ],
            'Review' => [
                ['topic' => 'Review Hotel Budget yang Worth It',            'title' => 'Hotel Budget ini Kualitasnya Bikin Kaget!'],
                ['topic' => 'Maskapai Domestik Terbaik untuk Backpacker',   'title' => 'Pilih Maskapai ini untuk Hemat Perjalanan!'],
                ['topic' => 'Restoran Lokal Wajib Coba di Bali',           'title' => 'Warung Lokal di Bali yang Wajib Kamu Coba!'],
            ],
        ],
        'Fashion' => [
            'OOTD' => [
                ['topic' => 'OOTD Kasual untuk Sehari-hari dengan Budget Minim', 'title' => 'OOTD Keren, Budget Minim, Ini Rahasianya!'],
                ['topic' => 'Styling Baju Polos Biar Tidak Membosankan',    'title' => 'Baju Polos jadi Keren dengan Trik ini!'],
                ['topic' => 'Mix and Match Warna yang Aman dan Stylish',    'title' => 'Kombinasi Warna ini Selalu Kelihatan Elegan!'],
            ],
            'Review' => [
                ['topic' => 'Review Brand Lokal Fashion yang Worth It',     'title' => 'Brand Lokal ini Kualitasnya Setara Import!'],
                ['topic' => 'Thrift Shopping Tips untuk Pemula',            'title' => 'Thrifting Pertama? Ini Tips Biar Nggak Nyesel!'],
                ['topic' => 'Perbandingan Sneakers Populer 2024',           'title' => 'Sneakers Battle 2024: Mana yang Paling Worth?'],
            ],
            'Tutorial' => [
                ['topic' => 'Cara Merawat Pakaian agar Awet dan Tahan Lama', 'title' => 'Baju Awet Bertahun-tahun dengan Cara ini!'],
                ['topic' => 'Cara Setrika Baju Tanpa Merusak Kain',        'title' => 'Setrika Aman Tanpa Takut Kain Rusak!'],
                ['topic' => 'Teknik Melipat Baju Hemat Lemari',            'title' => 'Lemari Lebih Rapi dengan Teknik Lipat ini!'],
            ],
        ],
        'Comedy' => [
            'Relatable' => [
                ['topic' => 'Momen Awkward yang Dialami Semua Orang',       'title' => 'Siapa yang Relate? Awkward Moment ini POV Kita!'],
                ['topic' => 'Kehidupan Mahasiswa yang Selalu Relate',       'title' => 'Hidup Mahasiswa itu Ya Kayak Gini Adanya!'],
                ['topic' => 'Drama Sehari-hari yang Bikin Ngakak',          'title' => 'Drama Receh Harian yang Auto Bikin Ngakak!'],
            ],
            'Parody' => [
                ['topic' => 'Parodi Iklan Produk Viral',                    'title' => 'Kalau Iklan Ini Jujur, Kira-kira Begini!'],
                ['topic' => 'Parodi Tips Hidup yang Tidak Berguna',        'title' => 'Tips Hidup yang 100% Tidak Akan Membantu!'],
                ['topic' => 'Bahasa Gaul vs Bahasa Formal di Kantor',      'title' => 'Kalau Chat WA Pakai Bahasa Kantor, Jadinya Gini!'],
            ],
            'Storytelling' => [
                ['topic' => 'Cerita Horror Kocak yang Bikin Bingung Mau Takut atau Ketawa', 'title' => 'Horror tapi Ngakak? Ini Ceritanya!'],
                ['topic' => 'Pengalaman Memalukan yang Sekarang Jadi Lucu', 'title' => 'Waktu itu Malu Banget, Sekarang Malah Jadi Konten!'],
                ['topic' => 'Kisah Salah Kirim Chat yang Mengubah Hidup',  'title' => 'Salah Kirim Chat, Hidupku Berubah Selamanya!'],
            ],
        ],
    ];

    /**
     * Template script berdasarkan pillar/tipe konten
     */
    protected static array $scriptTemplates = [
        'Problem Solving' => [
            'hook'    => "Kamu pernah ngalamin [MASALAH]? Kalau iya, kamu nggak sendirian. Banyak creator yang struggle dengan hal ini, tapi ada solusi simpel yang sering banget dilewatin.",
            'body'    => "Pertama, kita harus ngerti dulu kenapa [MASALAH] terjadi. Penyebab utamanya biasanya adalah [PENYEBAB]. Nah, solusinya ada beberapa langkah: langkah satu, [LANGKAH 1]. Langkah dua, [LANGKAH 2]. Dan langkah tiga yang paling penting, [LANGKAH 3]. Gampang kan? Dan ini udah terbukti berhasil buat ribuan creator!",
            'closing' => "Coba sekarang dan komen di bawah hasilnya ya! Kalau ada pertanyaan, langsung tanyain. Jangan lupa follow untuk tips lainnya setiap hari.",
        ],
        'Tutorial' => [
            'hook'    => "Dalam [WAKTU] menit, kamu bakal bisa [SKILL/HASIL]. Nggak perlu alat mahal, nggak perlu pengalaman sebelumnya. Tonton sampai habis!",
            'body'    => "Step 1: [LANGKAH 1]. Pastiin kamu [DETAIL]. Step 2: [LANGKAH 2]. Banyak orang skip ini padahal penting banget. Step 3: [LANGKAH 3]. Ini bagian yang bikin hasilnya beda dari yang lain. Pro tip: [TIPS BONUS] buat hasil yang lebih maksimal.",
            'closing' => "Gimana? Mudah kan? Save video ini biar nggak lupa. Dan kalau berhasil, tag aku di story kamu! Link tools yang aku pakai ada di bio.",
        ],
        'Review' => [
            'hook'    => "Aku udah coba [PRODUK/TEMPAT] selama [DURASI] dan ini jujur review-nya. Nggak disponsori, nggak lebay, murni pengalaman aku.",
            'body'    => "Dari segi [ASPEK 1], nilai aku [NILAI]/10 karena [ALASAN]. Untuk [ASPEK 2], ini yang bikin aku impressed: [DETAIL]. Tapi ada juga yang kurang, yaitu [KEKURANGAN]. Overall, apakah worth it? Untuk kamu yang [TARGET AUDIENS], ini [REKOMENDASI].",
            'closing' => "Mau tau harga dan di mana beli? Cek link di bio! Kalau kamu udah pernah coba juga, share pengalamanmu di kolom komen. Drop emoji ⭐ kalau video ini helpful!",
        ],
        'Motivasi' => [
            'hook'    => "Satu tahun yang lalu aku di posisi yang mungkin sama kayak kamu sekarang. Ngerasa stuck, nggak tau harus mulai dari mana. Ini yang akhirnya mengubah segalanya.",
            'body'    => "Hal pertama yang aku sadari adalah [INSIGHT 1]. Ini berat, tapi jujur. Terus aku mulai [AKSI 1], dan hasilnya [HASIL 1]. Yang bikin beda bukan talent atau modal, tapi [PRINSIP KUNCI]. Setiap orang yang sukses yang aku kenal, mereka semua punya satu kesamaan: [KESAMAAN].",
            'closing' => "Mulai dari langkah terkecil hari ini. Komen 'MULAI' di bawah kalau kamu siap. Aku bakal support perjalanan kamu!",
        ],
        'Nutrition' => [
            'hook'    => "Stop makan [MAKANAN BURUK]. Serius. Setelah aku tau ini, aku nggak pernah balik lagi ke kebiasaan lama.",
            'body'    => "Fakta yang jarang orang tau: [FAKTA NUTRISI]. Seharusnya kamu makan [MAKANAN BAIK] karena [ALASAN]. Ini meal plan simpel yang bisa kamu coba: pagi [SARAPAN], siang [MAKAN SIANG], malam [MAKAN MALAM]. Total kalori sekitar [KALORI] dan protein [PROTEIN]g. Bisa disesuaikan budget dan selera ya!",
            'closing' => "Save ini dan screenshot meal plan-nya! Kalau mau versi yang lebih detail, aku bisa bikin. Comment 'MEAL PLAN' di bawah.",
        ],
        'Resep' => [
            'hook'    => "Resep [NAMA MASAKAN] ini cuma butuh [JUMLAH] bahan dan [WAKTU] menit. Hasilnya? Persis kayak yang dijual [REFERENSI]. Serius!",
            'body'    => "Bahan-bahannya: [DAFTAR BAHAN]. Cara bikinnya super gampang. Pertama, [LANGKAH 1]. Habis itu [LANGKAH 2]. Dan yang bikin beda dari resep lain adalah [TIPS RAHASIA]. Kunci utamanya ada di [TEKNIK KUNCI].",
            'closing' => "Coba bikin dan foto hasilnya! Tag aku atau kirim di DM biar aku bisa lihat. Save resep ini sebelum kehalang postingan lain!",
        ],
        'Destinasi' => [
            'hook'    => "Tempat ini literally ada di [LOKASI] tapi hampir nggak ada yang tau. Aku hampir nggak percaya ini ada di Indonesia.",
            'body'    => "Lokasinya di [DETAIL LOKASI], sekitar [JARAK] dari [KOTA TERDEKAT]. Yang bikin spesial adalah [KEUNIKAN]. Waktu terbaik buat kesini adalah [WAKTU] karena [ALASAN]. Budget yang kamu butuhin: transport [BIAYA], tiket masuk [BIAYA], total bisa [ESTIMASI] per orang. Aksesnya [DESKRIPSI AKSES].",
            'closing' => "Simpan video ini untuk rencana liburan kamu! Drop emoji 📍 kalau kamu mau kesini. DM aku kalau butuh info lebih detail.",
        ],
        'OOTD' => [
            'hook'    => "Outfit ini total harganya cuma [HARGA] dan aku pake ini ke [EVENT]. Reaksi orang-orang? Nggak nyangka harganya segitu.",
            'body'    => "Atasan dari [BRAND] harga [HARGA]. Bawahan dari [BRAND] harga [HARGA]. Sepatu dari [BRAND] harga [HARGA]. Tips styling: [TIP 1]. Kunci outfit ini adalah [TIP 2]. Kalau kamu mau versi yang lebih [VARIATIF], kamu bisa [ALTERNATIF].",
            'closing' => "Mana favoritmu? Komen di bawah! Full details dan link semua item ada di bio. Save dulu biar nggak lupa!",
        ],
        'Relatable' => [
            'hook'    => "Siapa yang pernah ngalamin ini? Kalau iya, kamu normal. Kalau nggak, kamu mungkin aliens.",
            'body'    => "Jadi gini ceritanya. [SITUASI]. Dan yang paling menyebalkan adalah [DETAIL LUCU]. Setiap kali [TRIGGER], yang ada di kepala itu pasti [PIKIRAN KOCAK]. Padahal di luar kita keliatan [KESAN LUAR]. Tapi dalam hati [KENYATAAN DALAM].",
            'closing' => "Tag temen yang pasti relate! Komen pengalaman paling parah kamu di bawah. Subscribe biar nggak ketinggalan konten receh lainnya!",
        ],
        'Tips & Tricks' => [
            'hook'    => "[JUMLAH] trik [TOPIK] yang aku nyesel baru tau sekarang. Kalau tau ini dari dulu, [MANFAAT YANG DILEWATKAN].",
            'body'    => "Trik pertama: [TRIK 1]. Kenapa ini works? Karena [ALASAN 1]. Trik kedua: [TRIK 2]. Ini yang paling jarang orang tau. Trik ketiga, dan ini favorit aku: [TRIK 3]. Kombinasikan ketiganya dan hasilnya [HASIL KOMBINASI].",
            'closing' => "Yang mana yang langsung mau kamu coba? Komen nomornya! Save dulu sebelum lupa. Dan kalau ada trik lain yang kamu tau, share di komen ya!",
        ],
        'Produktivitas' => [
            'hook'    => "Aku hapus satu kebiasaan ini dan produktivitasku naik [PERSENTASE]%. Kedengarannya lebay, tapi ini nyata.",
            'body'    => "Kebiasaan yang aku maksud adalah [KEBIASAAN BURUK]. Riset dari [SUMBER] bilang ini menghabiskan [WAKTU] waktu kamu per hari tanpa sadar. Penggantinya? [KEBIASAAN BARU]. Cara implementasinya: [LANGKAH PRAKTIS]. Setelah [WAKTU] minggu, yang aku rasakan adalah [PERUBAHAN].",
            'closing' => "Coba selama 7 hari dan laporkan hasilnya ke aku! Save ini sebagai pengingat. Komen 'PRODUKTIF' kalau kamu mau coba!",
        ],
        'Parody' => [
            'hook'    => "POV: Kalau [SITUASI] itu jujur. Bersiap-siap karena ini relatable banget.",
            'body'    => "Scene 1: [SITUASI PARODI 1]. Kalau jujur harusnya bilang [VERSI JUJUR 1]. Scene 2: [SITUASI PARODI 2]. Padahal yang beneran terjadi adalah [VERSI JUJUR 2]. Dan scene paling parah: [SITUASI PARODI 3]. Realitanya? [VERSI JUJUR 3].",
            'closing' => "Tag temen yang selalu [PERILAKU YANG DIPARODI]! Komentar paling jujur di bawah dapetin di-reply aku!",
        ],
        'Self Development' => [
            'hook'    => "Aku baca [JUMLAH] buku self-help dan ini satu-satunya pelajaran yang benar-benar mengubah hidupku.",
            'body'    => "Pelajarannya sederhana tapi kuat: [PRINSIP UTAMA]. Cara mengaplikasikannya dalam kehidupan sehari-hari: pertama [APLIKASI 1], kedua [APLIKASI 2], dan ketiga [APLIKASI 3]. Yang bikin kebanyakan orang gagal adalah [KESALAHAN UMUM]. Tapi kalau kamu bisa [KUNCI KEBERHASILAN], hasilnya akan [HASIL].",
            'closing' => "Satu langkah kecil yang bisa kamu mulai hari ini adalah [AKSI SPESIFIK]. Komen dan cerita progresmu ke aku!",
        ],
        'Storytelling' => [
            'hook'    => "Ini beneran terjadi. Dan sampai sekarang aku masih nggak nyangka.",
            'body'    => "Jadi waktu itu [SETTING CERITA]. Awalnya [KEJADIAN AWAL]. Tapi terus tiba-tiba [PLOT TWIST]. Yang bikin makin parah adalah [KOMPLIKASI]. Dan klimaksnya? [KLIMAKS CERITA]. Sampai sekarang kalau aku inget ini, aku [REAKSI SEKARANG].",
            'closing' => "Ada yang pernah ngalamin hal serupa? Cerita di komentar! Share ke temen yang perlu ketawa hari ini.",
        ],
        'Minimalism' => [
            'hook'    => "Aku buang [JUMLAH] barang bulan lalu. Dan hidupku terasa jauh lebih ringan.",
            'body'    => "Ini yang aku sadari: kita sering beli barang bukan karena butuh, tapi karena [ALASAN PSIKOLOGIS]. Metode yang aku pakai untuk declutter: [METODE]. Pertanyaan yang harus kamu tanya untuk setiap barang: [PERTANYAAN KUNCI]. Hasilnya? [HASIL KONKRET]. Dan yang paling mengejutkan adalah [INSIGHT TIDAK TERDUGA].",
            'closing' => "Mulai dari satu laci hari ini. Foto hasilnya dan tag aku! Komen berapa barang yang kamu buang minggu ini.",
        ],
        'Tips Travel' => [
            'hook'    => "Aku hemat [JUMLAH] juta untuk perjalanan [DESTINASI] dengan trik ini. Dan nggak ada yang aku korbankan dari kenyamanan.",
            'body'    => "Trik pertama soal tiket: [TRIK TIKET]. Timing terbaiknya adalah [TIMING]. Untuk akomodasi, [STRATEGI AKOMODASI] bisa hemat sampai [PERSENTASE]%. Soal makan di sana: [TIPS MAKAN LOKAL]. Dan ini yang paling sering dilupain: [TIPS TERSEMBUNYI].",
            'closing' => "Save ini sebelum liburan berikutnya! Mau tau itinerary lengkapnya? Komen kota tujuanmu dan aku buatin!",
        ],
    ];

    /**
     * Generate pillar dari kategori
     */
    public static function getPillar(string $category): string
    {
        $pillars = array_keys(self::$map[$category] ?? ['General' => []]);
        return $pillars[array_rand($pillars)];
    }

    /**
     * Generate topic dan title berdasarkan kategori & pillar
     */
    public static function getTopicAndTitle(string $category, string $pillar): array
    {
        $options = self::$map[$category][$pillar] ?? [
            ['topic' => "Tips $category untuk Pemula", 'title' => "Panduan Lengkap $category untuk Pemula"],
        ];
        return $options[array_rand($options)];
    }

    /**
     * Generate script (HOOK + BODY + CLOSING) berdasarkan pillar
     */
    public static function getScript(string $pillar, string $topic, string $title): string
    {
        $template = self::$scriptTemplates[$pillar]
            ?? self::$scriptTemplates['Tutorial'];

        $hook    = "🎬 HOOK\n" . $template['hook'];
        $body    = "\n📌 BODY\n" . $template['body'];
        $closing = "\n✅ CLOSING\n" . $template['closing'];

        return "$hook\n$body\n$closing";
    }

    /**
     * Generate konten lengkap dari satu baris CSV
     */
    public static function generate(string $category): array
    {
        $pillar              = self::getPillar($category);
        $topicTitle          = self::getTopicAndTitle($category, $pillar);
        $topic               = $topicTitle['topic'];
        $title               = $topicTitle['title'];
        $script              = self::getScript($pillar, $topic, $title);

        return compact('pillar', 'topic', 'title', 'script');
    }
}