import pandas as pd
import os

# ======================================================
# GENERATE AUGMENTED DATASET
# Menambah data sintetis yang realistis berdasarkan
# pola dataset asli untuk meningkatkan performa model
# ======================================================

entries = []

# ============================================================
# HELPER: Hitung ER dan Label otomatis
# ============================================================
def add(pillar, topic, title, script, posting_hour, hashtag_count, views, likes, comments, shares):
    er = round((likes + comments + shares) / views * 100, 2) if views > 0 else 0
    label = 'HIGH' if er >= 2.0 else 'LOW'
    entries.append({
        'pillar': pillar,
        'topic': topic,
        'title': title,
        'script': script,
        'platform': 'instagram',
        'posting_hour': posting_hour,
        'hashtag_count': hashtag_count,
        'views': views,
        'likes': likes,
        'comments': comments,
        'shares': shares,
        'er': er,
        'label': label
    })


# ============================================================
# 1. EDUKASI — ACOUSTICA (10 entries)
# ============================================================

add('Edukasi', 'Cara kerja panel akustik',
    'Gimana sih panel akustik meredam suara?',
    'HOOK:\nBanyak yang pasang panel akustik tapi gak ngerti cara kerjanya\n\nBODY:\nPanel akustik bekerja dengan menyerap energi gelombang suara yang mengenai permukaannya. Material berpori seperti foam atau rockwool menangkap getaran udara dan mengubahnya menjadi energi panas yang sangat kecil. Semakin tebal dan padat materialnya, semakin banyak suara yang diserap.\n\nCLOSING:\nSekarang udah paham kan? Share ke yang masih bingung!',
    18, 5, 145, 4, 1, 0)

add('Edukasi', 'Perbedaan STC dan NRC',
    'STC vs NRC, apa bedanya?',
    'HOOK:\nSering denger istilah STC sama NRC tapi bingung bedanya?\n\nBODY:\nSTC atau Sound Transmission Class itu ukuran seberapa bagus material menghalangi suara tembus ke sisi lain. Semakin tinggi STC, semakin kedap.\n\nNRC atau Noise Reduction Coefficient itu ukuran seberapa bagus material menyerap suara di dalam ruangan. Nilainya dari 0 sampai 1.\n\nJadi STC buat blocking, NRC buat absorbing. Dua-duanya penting buat hasil maksimal.\n\nCLOSING:\nSave postingan ini biar gak lupa ya!',
    19, 4, 210, 3, 0, 1)

add('Edukasi', 'Bahaya kebisingan jangka panjang',
    'Kebisingan bisa bikin kamu sakit lho',
    'HOOK:\nTau gak? Paparan bising di atas 85 dB selama 8 jam bisa merusak pendengaran secara permanen\n\nBODY:\nMenurut WHO, kebisingan lingkungan adalah salah satu ancaman kesehatan yang paling underrated. Dampaknya mulai dari gangguan tidur, stres kronis, hipertensi, sampai gangguan jantung. Anak-anak yang tinggal di lingkungan bising juga cenderung punya kemampuan membaca yang lebih rendah.\n\nCLOSING:\nYuk mulai peduli sama kualitas suara di sekitar kita',
    18, 3, 320, 5, 1, 0)

add('Edukasi', 'Kenapa ruangan bisa gema',
    'Ruanganmu gema? Ini penyebabnya',
    'HOOK:\nPernah ngomong di ruangan kosong terus suaranya mantul kemana-mana?\n\nBODY:\nGema terjadi karena gelombang suara memantul di permukaan keras seperti dinding beton, lantai keramik, dan kaca. Kalau ruangan gak punya material penyerap suara, pantulan ini terus berulang dan bikin suara gak jelas.\n\nSolusinya? Pasang panel akustik, karpet, atau gorden tebal untuk menyerap pantulan suara.\n\nCLOSING:\nTag temen kamu yang ruangannya gema parah!',
    18, 4, 178, 5, 2, 0)

add('Edukasi', 'Material peredam terbaik',
    'Material mana yang paling bagus buat redam suara?',
    'HOOK:\nMau pasang peredam tapi bingung pilih material yang mana?\n\nBODY:\nIni dia ranking material peredam berdasarkan efektivitasnya:\n\n1. Mass Loaded Vinyl (MLV) - paling efektif buat blocking suara\n2. Rockwool - penyerap suara yang tahan api\n3. GFI Insulation - alternatif rockwool yang lebih ringan\n4. Acoustic Foam - cocok buat treatment studio\n5. Karpet tebal - solusi paling simple tapi terbatas\n\nCLOSING:\nMau tau lebih detail? DM kita aja!',
    17, 6, 95, 3, 1, 0)

add('Edukasi', 'Isolasi suara vs treatment akustik',
    'Dua hal ini sering ketuker, padahal beda banget',
    'HOOK:\nIsolasi suara dan treatment akustik itu BEDA lho\n\nBODY:\nIsolasi suara itu tentang mencegah suara masuk atau keluar ruangan. Treatment akustik itu tentang mengontrol kualitas suara di DALAM ruangan. Banyak yang pasang foam akustik berharap suara gak tembus keluar, padahal foam itu fungsinya buat mengurangi gema di dalam.\n\nKalau mau kedap, harus treatment dinding dengan material blocking kayak MLV atau double drywall.\n\nCLOSING:\nJangan sampai salah treatment ya!',
    18, 5, 250, 3, 1, 0)

add('Edukasi', 'Desibel dalam kehidupan sehari-hari',
    'Seberapa bising sih lingkungan kamu?',
    'HOOK:\nCoba tebak, berapa desibel suara AC di kamar kamu?\n\nBODY:\nIni perbandingan level kebisingan sehari-hari:\n- Bisikan: 30 dB\n- AC rumah: 40-50 dB\n- Percakapan normal: 60 dB\n- Lalu lintas: 70-80 dB\n- Konser musik: 100-110 dB\n- Pesawat take off: 130 dB\n\nDi atas 85 dB udah mulai berbahaya buat pendengaran kalau terpapar lama.\n\nCLOSING:\nCek level kebisingan di sekitarmu pake app di HP!',
    20, 3, 280, 4, 0, 1)

add('Edukasi', 'Pentingnya akustik ruang meeting',
    'Meeting online tapi suara gak jelas? Ini solusinya',
    'HOOK:\nCapek meeting online tapi suara echo kemana-mana?\n\nBODY:\nRuang meeting yang gak ditreatment akustiknya bikin suara jadi gak jelas, echo, dan peserta meeting jadi susah fokus. Solusinya gak harus mahal. Bisa mulai dari pasang panel akustik di dinding belakang, karpet di lantai, dan gorden tebal di jendela.\n\nKalau mau hasil maksimal, konsultasi sama ahli akustik biar treatment-nya tepat sasaran.\n\nCLOSING:\nUdah pernah ngalamin meeting yang suaranya gak jelas? Cerita di komentar!',
    18, 4, 312, 4, 2, 0)

add('Edukasi', 'Fungsi bass trap di studio',
    'Kenapa studio kamu butuh bass trap?',
    'HOOK:\nStudio udah dipasang foam tapi bass-nya masih numpuk di sudut?\n\nBODY:\nBass trap itu panel akustik khusus yang dipasang di sudut ruangan buat menyerap frekuensi rendah. Suara bass cenderung menumpuk di sudut dan bikin mixing gak akurat. Tanpa bass trap, lo bakal dengerin bass yang lebih besar dari seharusnya.\n\nCLOSING:\nPasang bass trap di keempat sudut ruangan buat hasil mixing yang lebih akurat!',
    21, 3, 88, 3, 0, 0)

add('Edukasi', 'Akustik untuk home theater',
    'Home theater kamu kurang greget? Cek ini',
    'HOOK:\n\n\nBODY:\nPunya home theater tapi suaranya gak kayak di bioskop? Masalahnya mungkin bukan di speaker, tapi di akustik ruangannya. Tanpa treatment yang tepat, suara bakal mantul kemana-mana dan dialog jadi gak jelas.\n\nCLOSING:\nMau bikin home theater yang beneran immersive? Konsultasi gratis di DM!',
    18, 2, 175, 2, 0, 0)


# ============================================================
# 2. TIPS & HOW-TO — ACOUSTICA (10 entries)
# ============================================================

add('Tips & How-To', 'Tips kedapkan kamar tidur',
    '5 cara bikin kamar tidur lebih kedap tanpa renovasi besar',
    'HOOK:\nKamar tidur berisik tapi gak mau renovasi besar-besaran?\n\nBODY:\nIni 5 tips simpel yang bisa langsung kamu lakuin:\n\n1. Pasang gorden tebal di jendela\n2. Taruh karpet tebal di lantai\n3. Seal celah pintu pake door sweep\n4. Tempel weatherstrip di kusen jendela\n5. Tambah rak buku di dinding yang berbatasan sama sumber bising\n\nCLOSING:\nDari 5 tips ini, mana yang paling pengen kamu coba duluan?',
    18, 5, 130, 4, 2, 1)

add('Tips & How-To', 'Cara pasang panel akustik sendiri',
    'DIY pasang panel akustik, gampang kok!',
    'HOOK:\nMau pasang panel akustik sendiri? Gampang banget!\n\nBODY:\nYang kamu butuhkan:\n- Panel akustik\n- Lem konstruksi atau bracket\n- Meteran\n- Level air\n\nLangkah-langkahnya:\n1. Ukur dinding dan tentukan posisi panel\n2. Tandai titik pemasangan pake pensil\n3. Oleskan lem atau pasang bracket\n4. Tempel panel dan tekan selama 30 detik\n5. Pastikan rata pake level air\n\nCLOSING:\nGampang kan? Coba sendiri dan share hasilnya!',
    18, 7, 112, 3, 1, 1)

add('Tips & How-To', 'Cara memilih jendela kedap suara',
    'Jendela mana yang paling efektif redam bising?',
    'HOOK:\nJendela biasa vs UPVC triple glass, beda banget hasilnya!\n\nBODY:\nKalau mau jendela yang beneran kedap, perhatiin ini:\n\n1. Pilih frame UPVC, bukan aluminium biasa\n2. Minimal pake double glass, idealnya triple glass\n3. Pastikan ada gas argon di antara kaca\n4. Seal harus rapat, gak boleh ada celah\n5. Cek rating STC-nya minimal 30\n\nUPVC triple glass bisa ngurangin kebisingan sampai 40 dB!\n\nCLOSING:\nMau ganti jendela? Konsultasi dulu biar gak salah pilih!',
    18, 5, 198, 5, 1, 0)

add('Tips & How-To', 'Cara treatment pintu biar kedap',
    'Pintu kamu bocor suara? Fix pake cara ini',
    'HOOK:\nUdah treatment dinding tapi suara masih bocor lewat pintu?\n\nBODY:\nPintu adalah titik terlemah dalam kedap suara. Ini cara treatment-nya:\n\n1. Pasang door sweep di bawah pintu\n2. Tempel weatherstrip di sekeliling kusen\n3. Kalau bisa, ganti ke pintu solid core\n4. Tambah mass loaded vinyl di permukaan pintu\n\nDengan treatment ini, kebocoran suara lewat pintu bisa berkurang drastis.\n\nCLOSING:\nSave tips ini buat nanti!',
    19, 4, 165, 4, 0, 1)

add('Tips & How-To', 'Tips bikin studio rekaman di rumah',
    'Mau bikin studio di rumah? Baca ini dulu',
    'HOOK:\nBikin studio di rumah gak harus mahal, tapi harus bener\n\nBODY:\nIni checklist sebelum bikin studio:\n\n1. Pilih ruangan yang jauh dari sumber bising\n2. Treatment dinding dengan rockwool + drywall\n3. Pasang panel akustik buat kontrol gema\n4. Ganti pintu ke solid core door\n5. Seal semua celah udara\n6. Pisahkan lantai dari struktur bangunan kalau bisa\n\nBudget mulai dari 15 jutaan tergantung ukuran ruangan.\n\nCLOSING:\nMau mulai? DM kita buat konsultasi gratis!',
    18, 6, 340, 5, 2, 1)

add('Tips & How-To', 'Cara rawat panel akustik',
    'Panel akustik juga butuh dirawat lho',
    'HOOK:\nUdah pasang panel akustik tapi gak pernah dibersihin?\n\nBODY:\nPanel akustik yang kotor performanya bisa turun. Ini cara rawatnya:\n\n1. Vacuum permukaan panel sebulan sekali\n2. Jangan pake air atau cairan pembersih\n3. Hindari paparan sinar matahari langsung\n4. Cek mounting secara berkala\n5. Ganti kalau udah lebih dari 10 tahun\n\nCLOSING:\nSimple kan? Jangan lupa rawat panel kamu ya!',
    18, 3, 287, 3, 1, 0)

add('Tips & How-To', 'Tips meeting room kedap suara',
    'Meeting room kantor masih berisik? Coba ini',
    'HOOK:\n\n\nBODY:\nMeeting room yang gak kedap bikin pembicaraan rahasia bisa kedengeran orang luar. Ini tips treatment-nya:\n\nPasang panel akustik di dinding\nGunakan karpet tebal\nPasang acoustic ceiling tiles\nSeal celah pintu\n\nCLOSING:\nPrivasi meeting kamu penting. Jangan diabaikan!',
    18, 2, 380, 4, 1, 0)

add('Tips & How-To', 'Cara ukur tingkat kebisingan ruangan',
    'Sebelum treatment, ukur dulu kebisingannya',
    'HOOK:\nSebelum pasang peredam, kamu harus tau dulu ruanganmu seberapa bising\n\nBODY:\nCaranya gampang:\n1. Download app sound meter di HP\n2. Matikan semua peralatan di ruangan\n3. Ukur ambient noise selama 5 menit\n4. Catat rata-ratanya\n5. Nyalakan sumber bising dan ukur lagi\n6. Selisihnya adalah noise level yang perlu ditangani\n\nHasil pengukuran ini penting buat nentuin treatment yang tepat.\n\nCLOSING:\nCoba sekarang dan share hasilnya di komentar!',
    18, 4, 142, 2, 0, 0)

add('Tips & How-To', 'Tips akustik ruang podcast',
    'Rekaman podcast dari rumah? Perhatiin ini',
    'HOOK:\nMau bikin podcast dari rumah tapi takut suaranya jelek?\n\nBODY:\nIni tips simpel buat akustik ruang podcast:\n\n1. Pilih ruangan kecil, suara lebih mudah dikontrol\n2. Hindari ruangan dengan banyak kaca\n3. Pasang panel akustik minimal di belakang mic\n4. Taruh karpet tebal di lantai\n5. Gunakan reflection filter di mic\n\nDengan tips ini, kualitas audio podcast kamu bisa naik drastis tanpa harus sewa studio.\n\nCLOSING:\nUdah punya podcast? Drop link-nya di komentar!',
    20, 5, 168, 5, 3, 0)

add('Tips & How-To', 'Tips hemat budget soundproofing',
    'Soundproofing gak harus mahal, ini buktinya',
    'HOOK:\nSiapa bilang kedap suara harus jutaan?\n\nBODY:\nIni solusi budget-friendly:\n\nDoor sweep: 50 ribuan\nWeatherstrip: 30 ribuan\nGorden tebal: 200 ribuan\nKarpet: 150 ribuan\nRak buku di dinding: pake yang udah ada\n\nTotal cuma 400-500 ribuan tapi udah lumayan ngurangin kebisingan.\n\nCLOSING:\nBudget terbatas bukan alasan buat terus-terusan kena bising!',
    18, 3, 92, 3, 0, 0)


# ============================================================
# 3. PROJECT COMPLETION — ACOUSTICA (8 entries)
# ============================================================

add('Project Completion', 'Studio musik selesai',
    'Before after studio musik client kami',
    'HOOK:\nDari ruangan kosong jadi studio musik impian, cuma butuh 3 minggu!\n\nBODY:\nProject kali ini kita kerjain di daerah Jakarta Selatan. Ruangan 4x3 meter yang tadinya cuma gudang, sekarang jadi studio musik yang fully soundproofed.\n\nTreatment yang dilakukan:\n- Soundblocking semua dinding\n- Panel akustik di sekeliling ruangan\n- Pintu peredam custom\n- LED ambient lighting\n- Wall panel motif kayu\n\nCLOSING:\nHasilnya? Suara gak bocor sama sekali! Kalau mau lihat prosesnya, cek highlight kita ya',
    18, 5, 92, 3, 1, 0)

add('Project Completion', 'Home theater selesai',
    'Home theater mewah di rumah client',
    'HOOK:\nSiapa yang mau punya bioskop pribadi di rumah?\n\nBODY:\nProject home theater kali ini beneran next level. Kita treatment full dari dinding sampai ceiling. Akustiknya didesain biar suara surround terasa imersif tanpa bocor ke ruangan lain. Client bilang sekarang nonton film jadi kayak di bioskop beneran!\n\nCLOSING:\nMau bikin home theater juga? Kita siap bantu dari desain sampai jadi!',
    18, 4, 76, 3, 0, 0)

add('Project Completion', 'Ruang meeting kedap',
    'Ruang meeting yang privasi 100%',
    'HOOK:\nRuang meeting ini sekarang beneran kedap, percakapan rahasia aman!\n\nBODY:\nClient kantor ini butuh ruang meeting yang super kedap buat diskusi confidential. Kita pasang double drywall dengan rockwool di antaranya, pintu solid core dengan seal rapat, dan acoustic ceiling tiles. Hasilnya, suara dari dalam gak kedengeran sama sekali dari luar.\n\nCLOSING:\nKantor kamu butuh ruang meeting kayak gini? Hubungi kita!',
    18, 3, 125, 2, 0, 0)

add('Project Completion', 'Ruang podcast selesai',
    'Studio podcast keren ini cuma 3x3 meter',
    'HOOK:\nRuangan kecil bukan halangan buat bikin studio podcast yang keren\n\nBODY:\nProject ini buktinya. Dengan ruangan 3x3 meter, kita berhasil bikin studio podcast yang suaranya jernih dan kedap. Panel akustik warna hitam dipadu sama LED warm white bikin suasananya profesional banget.\n\nCLOSING:\nKecil tapi powerful! Gimana menurut kalian?',
    19, 4, 64, 2, 1, 0)

add('Project Completion', 'Renovasi kamar tidur kedap',
    'Kamar tidur yang tadinya berisik sekarang hening',
    'HOOK:\n\n\nBODY:\nClient ini tinggal di pinggir jalan raya dan gak bisa tidur nyenyak karena suara kendaraan. Setelah kita treatment jendelanya pakai UPVC triple glass dan dindingnya pakai peredam, sekarang kamarnya hening banget. Client bilang tidurnya jadi jauh lebih berkualitas.\n\nCLOSING:\nTidur nyenyak itu investasi kesehatan!',
    18, 2, 230, 3, 0, 0)

add('Project Completion', 'Studio drum selesai',
    'Studio drum yang gak ganggu tetangga',
    'HOOK:\nMain drum di rumah tanpa ganggu tetangga? Bisa banget!\n\nBODY:\nProject studio drum ini tantangannya besar karena drum itu salah satu instrumen paling keras. Kita pakai floating floor, double wall construction, dan pintu ganda buat mastiin suara bener-bener gak tembus. Sekarang client bisa latihan drum jam berapapun tanpa complaint dari tetangga.\n\nCLOSING:\nDrummer mana nih yang butuh studio kayak gini? Tag orangnya!',
    18, 6, 105, 4, 2, 0)

add('Project Completion', 'Ruang karaoke keluarga',
    'Ruang karaoke di rumah yang kedap maksimal',
    'HOOK:\n\n\nBODY:\nKonten project completion\nProject ruang karaoke keluarga di Surabaya. Treatment soundproofing semua sisi termasuk ceiling. Hasilnya kedap banget, mau nyanyi sekeras apapun gak bakal ganggu tetangga. Tampilannya juga keren dengan LED dan wall panel.\n\nCLOSING:\n',
    18, 3, 350, 4, 1, 1)

add('Project Completion', 'Kantor startup kedap',
    'Treatment akustik kantor startup ini hasilnya luar biasa',
    'HOOK:\nKantor open space tapi butuh privasi? Ini solusinya\n\nBODY:\nStartup ini punya masalah klasik: kantor open space yang berisik banget. Kita bikin beberapa phone booth kedap suara dan treatment ruang meeting. Sekarang karyawan bisa meeting dan telpon tanpa ganggu yang lain. Produktivitas naik karena lingkungan kerja jadi lebih nyaman.\n\nCLOSING:\nKantor kamu juga open space? Kita bisa bantu bikin lebih nyaman!',
    18, 4, 195, 3, 0, 0)


# ============================================================
# 4. PROJECT LAUNCH — ACOUSTICA (8 entries)
# ============================================================

add('Project Launch', 'Project studio musik baru',
    'Project baru! Kita mau bikin studio musik di Bandung',
    'HOOK:\nProject baru alert! Kali ini kita bikin studio musik di Bandung\n\nBODY:\nClient kita seorang musisi yang udah lama pengen punya studio sendiri di rumah. Ruangannya 5x4 meter dan kita bakal treatment full soundproofing plus akustik. Stay tuned buat liat prosesnya!\n\nCLOSING:\nExcited gak nih? Kita juga excited banget!',
    18, 4, 89, 3, 1, 0)

add('Project Launch', 'Project home theater client',
    'Mulai project home theater di PIK',
    'HOOK:\n\n\nBODY:\nProject home theater baru nih guys! Kali ini di daerah PIK. Ruangannya lumayan gede, 6x5 meter. Kita bakal bikin full treatment biar pengalaman nontonnya kayak di bioskop premium. Pantengin terus ya prosesnya!\n\nCLOSING:\nAda yang punya ruangan nganggur juga di rumah?',
    18, 3, 72, 2, 1, 0)

add('Project Launch', 'Project ruang meeting',
    'New project: ruang meeting kedap untuk law firm',
    'HOOK:\nKantor hukum ini butuh ruangan yang bener-bener kedap\n\nBODY:\nDi kantor hukum, privasi itu segalanya. Kita dapet project buat bikin ruang meeting yang kedap total. Gak boleh ada suara yang bocor keluar. Tantangannya seru nih, kita bakal pake material terbaik buat hasil maksimal.\n\nCLOSING:\nStay tuned buat prosesnya!',
    18, 2, 156, 2, 0, 0)

add('Project Launch', 'Project studio podcast',
    'Kita mau bikin studio podcast buat content creator!',
    'HOOK:\nContent creator ini akhirnya mau bikin studio podcast di rumah!\n\nBODY:\nSelama ini dia rekaman di kamar biasa dan kualitas audionya kurang optimal. Sekarang kita mau bikin studio podcast khusus dengan akustik yang proper. Ruangannya 3x3 meter, compact tapi kita pastiin hasilnya maksimal.\n\nCLOSING:\nPenasaran hasilnya? Follow dulu biar gak ketinggalan update!',
    20, 5, 115, 4, 1, 0)

add('Project Launch', 'Project sekolah musik',
    'Sekolah musik ini mau upgrade ruangannya',
    'HOOK:\nSekolah musik ini punya masalah: suara dari satu ruangan tembus ke ruangan lain\n\nBODY:\nBayangin lagi belajar piano tapi kedengeran suara drum dari ruangan sebelah. Itu yang dialami murid-murid di sekolah musik ini. Kita bakal treatment setiap ruangan biar saling kedap.\n\nCLOSING:\nProject ini bakal seru! Pantengin terus ya',
    18, 3, 204, 2, 1, 0)

add('Project Launch', 'Project apartemen mewah',
    'Penghuni apartemen ini capek sama bising',
    'HOOK:\nBayar mahal buat apartemen tapi gak bisa istirahat tenang\n\nBODY:\nClient ini tinggal di lantai rendah apartemen premium tapi terus-terusan keganggu suara dari lobby dan jalan raya. Kita bakal treatment jendela, dinding, dan pintu biar ruangannya bener-bener hening.\n\nCLOSING:\nRelate gak nih sama kalian yang tinggal di apartemen?',
    18, 4, 168, 2, 0, 0)

add('Project Launch', 'Project ruang terapi',
    'Bikin ruang terapi yang tenang dan nyaman',
    'HOOK:\n\n\nBODY:\nPsikolog ini butuh ruang praktik yang kedap dan nyaman supaya pasiennya bisa curhat tanpa khawatir kedengeran orang luar. Kita bakal bikin treatment yang maximalin privasi tapi tetap bikin suasana hangat.\n\nCLOSING:\n',
    18, 2, 290, 3, 1, 0)

add('Project Launch', 'Project renovasi musholla',
    'Musholla di kantor ini mau ditreatment akustik',
    'HOOK:\nMusholla kantor yang suaranya tembus kemana-mana\n\nBODY:\nMusholla di kantor ini dindingnya tipis dan suara dari luar sering ganggu jamaah yang lagi sholat. Kita mau treatment dindingnya supaya lebih kedap dan juga pasang panel akustik biar suara imam lebih jelas.\n\nCLOSING:\nProject yang meaningfull banget nih',
    18, 0, 98, 3, 0, 0)


# ============================================================
# 5. INFOGRAPHICS — ACOUSTICA (8 entries)
# ============================================================

add('Infographics', 'Level kebisingan di berbagai tempat',
    'Kamu tinggal di level kebisingan berapa?',
    'HOOK:\nCek nih, kamu tinggal di zona kebisingan yang mana?\n\nBODY:\nInfografis level kebisingan:\n- Perpustakaan: 30 dB (Tenang)\n- Rumah biasa: 40-50 dB (Normal)\n- Pinggir jalan: 70-80 dB (Bising)\n- Dekat industri: 85-100 dB (Bahaya)\n- Dekat bandara: 100+ dB (Sangat bahaya)\n\nKalau kamu di zona kuning ke atas, saatnya mikirin peredam suara.\n\nCLOSING:\nShare ke temen yang tinggal di daerah bising!',
    18, 4, 145, 5, 1, 1)

add('Infographics', 'Perbandingan material peredam',
    'Tabel perbandingan material peredam suara',
    'HOOK:\nBingung pilih material peredam? Lihat perbandingannya di sini\n\nBODY:\nInfografis perbandingan material peredam:\nRockwool: NRC 0.95, tahan api, harga sedang\nGFI: NRC 0.85, ringan, harga terjangkau\nFoam akustik: NRC 0.70, mudah pasang, harga murah\nMLV: STC 26, paling efektif blocking, harga mahal\n\nCLOSING:\nSave infografis ini buat referensi nanti!',
    18, 5, 210, 3, 0, 1)

add('Infographics', 'Dampak kebisingan pada produktivitas',
    'Kebisingan bisa turunkan produktivitas 66%',
    'HOOK:\nTau gak? Kebisingan bisa nurunin produktivitas kerja sampai 66%!\n\nBODY:\nData menunjukkan:\n- Butuh 23 menit untuk kembali fokus setelah terganggu suara\n- Karyawan di kantor bising 66% kurang produktif\n- 58% pekerja butuh lingkungan tenang untuk deep work\n- Kebisingan juga meningkatkan level stres 34%\n\nCLOSING:\nKantor kamu gimana? Bising juga?',
    18, 3, 302, 4, 2, 0)

add('Infographics', 'Cara suara merambat',
    'Gimana suara bisa tembus dinding?',
    'HOOK:\nPernah heran kenapa suara tetangga bisa kedengeran di kamar?\n\nBODY:\nSuara merambat lewat:\n1. Udara - lewat celah pintu, jendela, ventilasi\n2. Struktur - lewat dinding, lantai, ceiling yang terhubung\n3. Getaran - mesin AC, elevator yang menempel ke struktur\n\nMakanya treatment kedap suara harus mencakup semua jalur ini.\n\nCLOSING:\nTag temen yang sering komplain tetangganya berisik!',
    18, 4, 175, 4, 1, 0)

add('Infographics', 'Budget treatment per ruangan',
    'Estimasi budget treatment kedap suara',
    'HOOK:\nMau treatment ruangan tapi gak tau budgetnya berapa?\n\nBODY:\nEstimasi budget treatment per jenis ruangan:\n- Kamar tidur (4x3m): mulai 8-15 juta\n- Studio musik (4x4m): mulai 25-50 juta\n- Home theater (5x4m): mulai 30-60 juta\n- Ruang meeting (4x3m): mulai 15-25 juta\n\nBudget tergantung level kedap yang diinginkan dan material yang dipilih.\n\nCLOSING:\nMau estimasi yang lebih detail? DM kita aja!',
    18, 5, 98, 3, 1, 0)

add('Infographics', 'Standar kebisingan WHO',
    'WHO bilang ini batas aman kebisingan',
    'HOOK:\n\n\nBODY:\nInfografis standar kebisingan menurut WHO:\n- Kamar tidur malam: max 30 dB\n- Ruang kelas: max 35 dB\n- Kantor: max 45 dB\n- Area industri: max 85 dB\n\nDi Indonesia, banyak area yang melebihi standar ini.\n\nCLOSING:\nYuk mulai peduli kesehatan pendengaran!',
    18, 2, 410, 5, 0, 1)

add('Infographics', 'Proses kerja soundproofing',
    'Tahapan lengkap soundproofing dari A sampai Z',
    'HOOK:\nMau tau gimana proses soundproofing dari awal sampai selesai?\n\nBODY:\nTahapannya:\n1. Survey dan pengukuran kebisingan\n2. Desain treatment\n3. Persiapan material\n4. Instalasi sound blocking\n5. Pemasangan panel akustik\n6. Treatment pintu dan jendela\n7. Finishing dan testing\n\nSemua tahap penting dan gak boleh diskip.\n\nCLOSING:\nMau mulai dari tahap survey? Hubungi kita!',
    18, 3, 252, 3, 0, 0)

add('Infographics', 'Fakta kebisingan di kota besar Indonesia',
    'Kota-kota di Indonesia yang paling bising',
    'HOOK:\nKota kamu masuk daftar kota terbising di Indonesia gak?\n\nBODY:\nJakarta, Surabaya, dan Medan tercatat sebagai kota dengan tingkat kebisingan tertinggi. Di beberapa area di Jakarta, level kebisingan bisa mencapai 80-90 dB yang sudah melebihi batas aman.\n\nCLOSING:\nKota mana yang menurut kamu paling bising? Tulis di komentar!',
    18, 3, 185, 2, 1, 0)


# ============================================================
# 6. FACTS & MYTHS — ACOUSTICA (8 entries)
# ============================================================

add('Facts & Myths', 'Telur bisa redam suara',
    'Mitos: tempat telur bisa jadi peredam suara?',
    'HOOK:\nMasih pake tempat telur buat peredam suara? Stop sekarang!\n\nBODY:\nMITOS! Tempat telur BUKAN peredam suara. Bentuknya yang bergelombang memang bisa sedikit mengurangi pantulan suara di dalam ruangan, tapi kemampuannya sangat terbatas. Dia gak bisa menghalangi suara tembus ke luar ruangan. Malah bisa jadi sarang debu dan serangga.\n\nCLOSING:\nMasih ada yang pake tempat telur? Tag orangnya!',
    18, 4, 135, 4, 3, 1)

add('Facts & Myths', 'Foam akustik = kedap suara',
    'Foam akustik bisa bikin ruangan kedap? Fakta atau mitos?',
    'HOOK:\nBanyak yang beli foam akustik terus berharap ruangan jadi kedap. Bener gak sih?\n\nBODY:\nMITOS! Foam akustik itu fungsinya menyerap pantulan suara di DALAM ruangan, bukan menghalangi suara masuk atau keluar. Kalau mau kedap, kamu butuh material blocking seperti mass loaded vinyl, drywall tebal, atau rockwool di dalam dinding.\n\nCLOSING:\nJangan sampai salah beli ya! Share biar yang lain juga tau',
    18, 5, 160, 5, 2, 1)

add('Facts & Myths', 'Dinding tebal otomatis kedap',
    'Dinding tebal pasti kedap suara, bener gak?',
    'HOOK:\nDinding beton 15cm pasti kedap suara dong? Hmm belum tentu\n\nBODY:\nFAKTA SETENGAH. Dinding tebal memang lebih bagus dalam memblokir suara dibanding dinding tipis. TAPI, kalau ada celah sekecil apapun di sambungan, kusen, atau instalasi listrik, suara tetap bisa tembus. Ibaratnya kayak ember bocor, mau ditambahin air sebanyak apapun tetap bocor kalau lubangnya gak ditutup.\n\nCLOSING:\nJadi, ketebalan aja gak cukup! Sealing sama pentingnya',
    18, 3, 188, 3, 1, 0)

add('Facts & Myths', 'Kayu bagus untuk akustik',
    'Kayu itu material akustik yang bagus, mitos atau fakta?',
    'HOOK:\nSering lihat studio musik pake panel kayu? Emang kayu bagus buat akustik?\n\nBODY:\nFAKTA! Kayu memang punya karakteristik akustik yang unik. Kayu bisa memantulkan suara dengan warmth yang natural, makanya banyak concert hall premium yang pakai kayu. Tapi kayu sendiri bukan penyerap suara yang bagus. Kombinasi kayu dengan material penyerap di belakangnya itu yang bikin akustik optimal.\n\nCLOSING:\nPantesan banyak studio yang pakai wall panel kayu ya!',
    18, 4, 112, 3, 0, 0)

add('Facts & Myths', 'AC bikin ruangan kedap',
    'Ruangan ber-AC pasti lebih kedap?',
    'HOOK:\n\n\nBODY:\nMITOS! AC gak bikin ruangan lebih kedap. Malah, saluran AC bisa jadi jalur suara masuk ke ruangan. Ductwork AC yang gak di-treatment bisa mentransmisikan suara antar ruangan. Kalau mau tetap adem tapi kedap, gunakan AC split dan seal semua celah di sekitar unit.\n\nCLOSING:\nAC kamu udah di-seal belum?',
    18, 2, 265, 3, 0, 0)

add('Facts & Myths', 'Styrofoam bisa redam suara',
    'Styrofoam efektif buat peredam suara?',
    'HOOK:\nAda yang bilang styrofoam bisa redam suara, bener gak sih?\n\nBODY:\nMITOS BESAR! Styrofoam itu insulator PANAS, bukan insulator SUARA. Strukturnya yang kaku dan ringan justru gak efektif buat menyerap atau memblokir suara. Malah bisa membuat pantulan suara lebih buruk karena permukaannya yang keras.\n\nCLOSING:\nJangan asal pasang ya, konsultasi dulu!',
    18, 3, 148, 4, 1, 0)

add('Facts & Myths', 'Cat anti bising',
    'Ada cat yang bisa redam suara? Fakta atau mitos?',
    'HOOK:\nKatanya ada cat khusus yang bisa bikin dinding kedap suara\n\nBODY:\nFAKTA, tapi jangan berharap banyak. Acoustic paint atau sound dampening paint memang ada dan mengandung material yang bisa sedikit mengurangi transmisi suara. Tapi efeknya minimal, cuma sekitar 3-5 dB. Jauh dari cukup kalau masalah kebisingannya serius.\n\nCLOSING:\nCat bisa bantu sedikit, tapi bukan solusi utama!',
    19, 3, 320, 4, 1, 0)

add('Facts & Myths', 'Ruangan kedap berbahaya',
    'Ruangan kedap suara bikin susah napas?',
    'HOOK:\nAda mitos kalau ruangan kedap suara itu bikin sesak napas\n\nBODY:\nMITOS! Ruangan kedap suara yang didesain dengan benar tetap punya sirkulasi udara yang baik. Treatment kedap suara itu soal memblokir suara, bukan memblokir udara. Ventilasi tetap ada tapi ditreatment supaya suara gak masuk lewat situ. Jadi aman dan tetap nyaman.\n\nCLOSING:\nTenang, ruangan kedap itu aman kok!',
    18, 2, 175, 2, 0, 0)


# ============================================================
# 7. QUESTIONS & FAQs — ACOUSTICA (8 entries)
# ============================================================

add('Questions & FAQs', 'Berapa lama proses soundproofing',
    'FAQ: Berapa lama sih proses soundproofing?',
    'HOOK:\nPertanyaan yang paling sering ditanya: berapa lama?\n\nBODY:\nJawabannya tergantung ukuran dan kompleksitas ruangan:\n\n- Kamar tidur biasa: 3-5 hari kerja\n- Studio musik kecil: 1-2 minggu\n- Home theater: 1-2 minggu\n- Ruang meeting: 3-5 hari kerja\n- Full floor treatment: 2-4 minggu\n\nIni belum termasuk waktu desain dan persiapan material ya.\n\nCLOSING:\nAda pertanyaan lain? Tulis di komentar!',
    18, 3, 125, 3, 2, 0)

add('Questions & FAQs', 'Apakah soundproofing permanen',
    'FAQ: Kalau udah pasang peredam, awet berapa lama?',
    'HOOK:\nSoundproofing itu sekali pasang bisa awet berapa lama sih?\n\nBODY:\nKalau instalasinya bener dan materialnya berkualitas, soundproofing bisa awet 15-25 tahun bahkan lebih. Material kayak rockwool dan mass loaded vinyl gak mudah degradasi. Yang paling penting adalah perawatan seal di pintu dan jendela karena itu yang paling cepat aus.\n\nCLOSING:\nInvestasi jangka panjang yang worth it banget!',
    18, 3, 195, 2, 1, 0)

add('Questions & FAQs', 'Apa bisa treatment tanpa bongkar dinding',
    'FAQ: Treatment kedap tanpa bongkar dinding, bisa gak?',
    'HOOK:\nGak mau bongkar dinding tapi mau kedap suara?\n\nBODY:\nBISA! Ada beberapa metode yang gak perlu bongkar dinding:\n\n1. Tempel mass loaded vinyl langsung di dinding existing\n2. Tambah lapisan drywall di atas dinding yang udah ada\n3. Pasang panel akustik dekoratif\n4. Treatment pintu dan jendela\n5. Seal celah-celah\n\nHasilnya memang gak se-optimal bongkar total, tapi udah lumayan signifikan.\n\nCLOSING:\nMau konsultasi metode yang paling cocok? DM kita!',
    18, 4, 108, 3, 2, 0)

add('Questions & FAQs', 'Apakah bisa kedap 100 persen',
    'FAQ: Ruangan bisa kedap 100% gak?',
    'HOOK:\nBisa gak sih bikin ruangan yang kedap 100%?\n\nBODY:\nSecara teori, kedap suara 100% itu hampir mustahil tanpa ruangan anechoic chamber yang biayanya miliaran. Tapi untuk kebutuhan sehari-hari, kita bisa mencapai reduksi 40-60 dB yang udah lebih dari cukup buat studio musik, home theater, atau kamar tidur.\n\nCLOSING:\nYang penting hasilnya nyaman dan sesuai kebutuhan!',
    18, 2, 230, 3, 0, 0)

add('Questions & FAQs', 'Perbedaan peredam dan penyerap',
    'FAQ: Peredam suara sama penyerap suara itu beda?',
    'HOOK:\n\n\nBODY:\nBEDA BANGET!\n\nPeredam suara (soundproofing): menghalangi suara masuk/keluar ruangan. Material: MLV, drywall, rockwool.\n\nPenyerap suara (acoustic treatment): mengurangi pantulan dan gema DI DALAM ruangan. Material: foam akustik, panel akustik, bass trap.\n\nKeduanya saling melengkapi, bukan saling menggantikan.\n\nCLOSING:\nSekarang udah gak bingung lagi kan?',
    18, 3, 305, 3, 1, 0)

add('Questions & FAQs', 'Apakah lantai perlu ditreatment',
    'FAQ: Lantai juga perlu ditreatment gak?',
    'HOOK:\nUdah treatment dinding tapi lupa lantai?\n\nBODY:\nLantai itu jalur transmisi suara yang sering diabaikan. Impact noise kayak langkah kaki, barang jatuh, atau getaran mesin itu merambat lewat struktur lantai. Solusinya bisa pakai floating floor, underlayment khusus, atau minimal karpet tebal.\n\nCLOSING:\nJangan lupa treatment lantai juga ya!',
    18, 2, 185, 2, 0, 0)

add('Questions & FAQs', 'Material apa yang paling murah',
    'FAQ: Material peredam yang paling murah apa?',
    'HOOK:\nBudget tipis tapi butuh peredam?\n\nBODY:\nMaterial paling affordable:\n1. Weatherstrip - mulai 25rb/meter\n2. Door sweep - mulai 40rb\n3. Karpet tebal - mulai 100rb/m2\n4. Gorden blackout - mulai 150rb/meter\n5. Acoustic foam - mulai 50rb/piece\n\nMulai dari yang paling murah dulu, upgrade pelan-pelan.\n\nCLOSING:\nBudget bukan halangan! Yang penting mulai dulu',
    18, 4, 148, 2, 1, 0)

add('Questions & FAQs', 'Ruangan mana yang perlu diprioritaskan',
    'FAQ: Kalau budget terbatas, ruangan mana duluan?',
    'HOOK:\nMau treatment tapi budgetnya cuma cukup satu ruangan, prioritasin yang mana?\n\nBODY:\nPrioritasnya:\n1. Kamar tidur - karena kualitas tidur itu segalanya\n2. Ruang kerja - buat produktivitas\n3. Studio/ruang hobi - kalau kamu musisi atau content creator\n\nKalau emang cuma bisa satu, pilih ruangan yang paling sering kamu pake dan paling terdampak kebisingan.\n\nCLOSING:\nKalau kamu, ruangan mana yang paling butuh ditreatment?',
    18, 3, 160, 3, 1, 0)


# ============================================================
# 8. INDUSTRY INSIGHTS — ACOUSTICA (8 entries)
# ============================================================

add('Industry Insights', 'Tren soundproofing di Indonesia',
    'Kenapa demand soundproofing makin tinggi?',
    'HOOK:\nDemand soundproofing di Indonesia naik 200% dalam 5 tahun terakhir\n\nBODY:\nIni faktor-faktornya:\n1. Makin banyak orang WFH\n2. Urbanisasi yang bikin kota makin bising\n3. Tren home studio dan podcast\n4. Kesadaran akan kesehatan mental dan kualitas hidup\n5. Developer properti mulai include fitur kedap suara\n\nIndustri soundproofing di Indonesia masih punya potensi pertumbuhan yang besar.\n\nCLOSING:\nMenurut kamu, faktor mana yang paling berpengaruh?',
    18, 5, 235, 3, 1, 0)

add('Industry Insights', 'Regulasi kebisingan di Indonesia',
    'Indonesia ternyata punya aturan soal kebisingan lho',
    'HOOK:\nTau gak kalau Indonesia punya regulasi tentang batas kebisingan?\n\nBODY:\nPeraturan Menteri Lingkungan Hidup mengatur baku mutu kebisingan:\n- Perumahan: max 55 dB\n- Komersial: max 70 dB\n- Industri: max 70 dB\n- Rumah sakit: max 55 dB\n\nTapi enforcement-nya masih sangat lemah. Kebanyakan area di kota besar udah melebihi standar ini.\n\nCLOSING:\nKita harus mulai dari diri sendiri dulu!',
    18, 3, 420, 4, 2, 1)

add('Industry Insights', 'Material akustik lokal vs impor',
    'Material akustik buatan lokal vs impor, mana lebih bagus?',
    'HOOK:\nHarus impor material akustik dari luar negeri gak sih?\n\nBODY:\nSebenarnya, material akustik buatan lokal udah cukup bagus buat kebanyakan kebutuhan. Rockwool dan GFI lokal kualitasnya udah memenuhi standar. Yang biasanya masih perlu impor cuma material spesifik kayak MLV grade tinggi atau acoustic sealant tertentu.\n\nCLOSING:\nDukung produk lokal kalau bisa!',
    18, 2, 312, 3, 1, 0)

add('Industry Insights', 'WFH dan kebutuhan akustik',
    'Era WFH bikin orang sadar pentingnya akustik rumah',
    'HOOK:\nSemenjak WFH, berapa banyak dari kalian yang terganggu suara tetangga saat meeting?\n\nBODY:\nFenomena WFH memunculkan kebutuhan baru: ruang kerja di rumah yang kedap dan nyaman. Banyak pekerja yang akhirnya invest di treatment akustik buat ruang kerja mereka. Dari yang simpel kayak pasang gorden tebal sampai yang serius kayak bikin ruangan khusus.\n\nCLOSING:\nWFH warriors, relate gak?',
    18, 4, 275, 3, 2, 0)

add('Industry Insights', 'Perkembangan teknologi akustik',
    'Material akustik makin canggih, ini contohnya',
    'HOOK:\n\n\nBODY:\nTeknologi material akustik terus berkembang. Sekarang ada panel akustik yang bisa berubah transparansi, material nano-porous yang super tipis tapi efektif, dan sistem active noise cancellation yang terintegrasi ke dalam bangunan. Indonesia perlu catch up dengan perkembangan ini.\n\nCLOSING:\nTeknologi mana yang paling menarik menurut kamu?',
    18, 2, 350, 4, 0, 0)

add('Industry Insights', 'Green building dan akustik',
    'Green building certification sekarang include akustik',
    'HOOK:\nGreen building bukan cuma soal hemat energi, tapi juga soal kenyamanan akustik\n\nBODY:\nSertifikasi green building internasional sekarang punya kriteria akustik. Bangunan harus memenuhi standar kebisingan tertentu buat dapetin sertifikasi. Ini mendorong developer buat lebih serius soal treatment akustik di gedung mereka.\n\nCLOSING:\nAkustik sekarang udah jadi standar, bukan lagi kemewahan!',
    18, 3, 190, 2, 0, 0)

add('Industry Insights', 'Kebisingan di sekolah',
    'Kebisingan di sekolah ganggu konsentrasi siswa',
    'HOOK:\nRiset menunjukkan siswa di sekolah bising nilainya lebih rendah\n\nBODY:\nPenelitian di beberapa negara menunjukkan bahwa tingkat kebisingan di kelas yang melebihi 35 dB bisa mengurangi kemampuan siswa memahami pelajaran hingga 25%. Sayangnya, banyak sekolah di Indonesia belum memperhatikan aspek akustik dalam desain ruang kelas mereka.\n\nCLOSING:\nBagaimana kondisi sekolah anak kamu?',
    18, 2, 280, 3, 0, 0)

add('Industry Insights', 'Properti premium dan fitur akustik',
    'Developer properti premium mulai jual fitur kedap suara',
    'HOOK:\nBeberapa developer premium sekarang jadiin kedap suara sebagai selling point\n\nBODY:\nDeveloper kayak Alam Sutera dan BSD udah mulai incorporate fitur akustik di unit premium mereka. Jendela double glass, dinding dengan insulasi akustik, dan pintu yang lebih tebal. Ini menunjukkan bahwa pasar mulai sadar bahwa kenyamanan akustik itu penting banget.\n\nCLOSING:\nKalau beli properti, jangan lupa cek fitur akustiknya!',
    18, 3, 165, 2, 0, 0)


# ============================================================
# 9. SOCIAL PROOF — ACOUSTICA (8 entries)
# ============================================================

add('Social Proof', 'Testimoni client studio',
    'Client bilang studio buatan kita lebih bagus dari yang dia bayar 2x lipat',
    'HOOK:\nClient ini pernah bikin studio di tempat lain tapi kecewa, sekarang dia dateng ke kita\n\nBODY:\nCeritanya dia udah habis puluhan juta buat bikin studio di vendor lain tapi hasilnya kurang kedap. Akhirnya dia cari second opinion dan ketemu Acoustica. Setelah kita redesain dan treatment ulang, hasilnya jauh lebih bagus. Dia bilang nyesel gak dari awal ke kita.\n\nCLOSING:\nJangan sampai salah pilih vendor ya!',
    18, 4, 88, 3, 1, 0)

add('Social Proof', 'Review client apartemen',
    'Penghuni apartemen ini akhirnya bisa tidur nyenyak',
    'HOOK:\nSetahun gak bisa tidur nyenyak, sekarang tidurnya pulas banget\n\nBODY:\nClient ini tinggal di apartemen lantai 3 yang langsung menghadap jalan raya. Suara kendaraan 24 jam bikin dia susah tidur. Setelah kita treatment jendela dan dinding, dia bilang sekarang kayak tinggal di kampung yang tenang. Tidurnya jadi berkualitas dan kesehatannya membaik.\n\nCLOSING:\nTestimoni kayak gini yang bikin kita semangat kerja!',
    18, 3, 132, 4, 1, 0)

add('Social Proof', 'Cerita musisi lokal',
    'Musisi ini akhirnya bisa rekaman di rumah sendiri',
    'HOOK:\nDulu harus sewa studio buat rekaman, sekarang cukup di kamar\n\nBODY:\nMusisi indie ini selama ini harus booking studio yang mahal buat rekaman. Setelah kita bikinin studio kecil di salah satu kamar di rumahnya, sekarang dia bisa rekaman kapanpun tanpa biaya tambahan. Katanya, kualitas rekamannya bahkan lebih bagus karena dia bisa ambil take sebanyak yang dia mau tanpa tekanan waktu.\n\nCLOSING:\nMusisi mana nih yang pengen studio sendiri?',
    18, 5, 115, 4, 2, 0)

add('Social Proof', 'Review podcaster',
    'Podcaster ini upgrade audio quality-nya 10x lipat',
    'HOOK:\n\n\nBODY:\nPodcaster ini awalnya rekaman di kamar biasa. Suaranya echo dan banyak noise. Setelah kita treatment ruangannya, kualitas audio podcastnya naik drastis. Listener-nya pada notice perbedaannya dan dia bilang subscriber-nya naik 40% setelah upgrade akustik.\n\nCLOSING:\nGood audio = good content!',
    18, 3, 95, 3, 0, 0)

add('Social Proof', 'Testimoni kantor hukum',
    'Privasi percakapan jadi prioritas utama',
    'HOOK:\nKantor hukum ini butuh privasi 100% dan kita deliver\n\nBODY:\nKantor hukum ini punya masalah serius: percakapan rahasia dengan klien bisa kedengeran dari luar ruangan. Setelah treatment soundproofing dari Acoustica, sekarang ruang konsultasi mereka bener-bener kedap. Managing partner bilang klien jadi lebih comfortable sharing informasi sensitif.\n\nCLOSING:\nPrivasi itu bukan kemewahan, itu kebutuhan!',
    18, 3, 178, 2, 1, 0)

add('Social Proof', 'Before after treatment dinding',
    'Denger sendiri perbedaannya sebelum dan sesudah treatment',
    'HOOK:\nMau denger langsung perbedaan sebelum dan sesudah treatment?\n\nBODY:\nVideo ini kita rekam sebelum dan sesudah treatment dinding. Sebelumnya, suara lalu lintas di luar jelas banget kedengeran. Sesudahnya? Hampir gak kedengeran sama sekali. Perbedaannya dramatis banget.\n\nCLOSING:\nKomen mana yang lebih bikin kamu tertarik, before atau after?',
    18, 4, 68, 3, 1, 0)

add('Social Proof', 'Rating Google Maps 5 bintang',
    'Alhamdulillah rating kita 5 bintang di Google Maps',
    'HOOK:\n\n\nBODY:\nTerima kasih buat semua client yang udah kasih review positif. Rating 5 bintang di Google Maps ini jadi motivasi buat kita terus memberikan pelayanan terbaik. Setiap project kita kerjain dengan sepenuh hati.\n\nCLOSING:\nKalau udah jadi client kita, jangan lupa tinggalin review ya!',
    18, 0, 220, 2, 0, 0)

add('Social Proof', 'Portofolio 100 project',
    'Udah 100+ project dan counting!',
    'HOOK:\nAlhamdulillah, Acoustica udah selesaiin 100+ project!\n\nBODY:\nDari studio musik, home theater, ruang meeting, kamar tidur, sampai pabrik. Setiap project punya tantangannya masing-masing dan kita selalu belajar jadi lebih baik. Terima kasih buat semua client yang udah percaya sama Acoustica.\n\nCLOSING:\nMau jadi project selanjutnya? Hubungi kita!',
    18, 3, 142, 4, 0, 0)


# ============================================================
# 10. POLLS & QUIZZES — ACOUSTICA (6 entries)
# ============================================================

add('Polls & Quizzes', 'Pilih material peredam favoritmu',
    'Kamu tim rockwool atau tim foam akustik?',
    'HOOK:\n\n\nBODY:\nPolling time!\n\nA. Rockwool - performanya lebih bagus, tahan api\nB. Foam akustik - lebih murah, mudah pasang\n\nPilih A atau B di komentar!\n\nCLOSING:\n',
    18, 2, 165, 5, 4, 0)

add('Polls & Quizzes', 'Quiz tebak desibel',
    'Tebak berapa desibel suara ini!',
    'HOOK:\nMain game yuk! Tebak berapa desibel suara-suara ini\n\nBODY:\nSlide 1: Suara bisikan = ? dB\nSlide 2: Suara blender = ? dB\nSlide 3: Suara konser = ? dB\nSlide 4: Jawaban!\n\nCLOSING:\nBerapa yang bener? Tulis skormu di komentar!',
    18, 3, 142, 4, 3, 1)

add('Polls & Quizzes', 'Ruangan mana yang paling butuh peredam',
    'Kalau cuma bisa treatment satu ruangan, pilih yang mana?',
    'HOOK:\nCuma bisa pilih satu! Ruangan mana yang paling butuh ditreatment?\n\nBODY:\nA. Kamar tidur - biar tidur nyenyak\nB. Ruang kerja - biar fokus WFH\nC. Studio musik - biar bebas berkarya\nD. Ruang TV - biar nonton nyaman\n\nCLOSING:\nKomen jawaban kamu!',
    18, 2, 198, 6, 5, 0)

add('Polls & Quizzes', 'Quiz mitos atau fakta',
    'Quiz: Mitos atau Fakta soal kedap suara',
    'HOOK:\nTest pengetahuan kamu soal kedap suara!\n\nBODY:\nSlide 1: Tempat telur bisa jadi peredam suara - Mitos atau Fakta?\nSlide 2: Cat bisa bantu redam suara - Mitos atau Fakta?\nSlide 3: Kaca double lebih kedap dari kaca single - Mitos atau Fakta?\n\nCLOSING:\nBerapa skor kamu? Tulis di komentar!',
    18, 4, 135, 5, 3, 0)

add('Polls & Quizzes', 'Pilih desain panel akustik',
    'Kamu suka panel akustik warna apa?',
    'HOOK:\n\n\nBODY:\nPolling desain!\nA. Panel akustik hitam - sleek dan modern\nB. Panel akustik abu-abu - elegant dan netral\nC. Panel akustik motif kayu - hangat dan natural\nD. Panel akustik warna custom - sesuai personality\n\nCLOSING:\nKomen pilihan kamu!',
    18, 0, 180, 4, 6, 0)

add('Polls & Quizzes', 'Seberapa bising lingkunganmu',
    'Rate kebisingan tempat tinggal kamu 1-10',
    'HOOK:\nSeberapa bising sih tempat tinggal kamu?\n\nBODY:\nPake skala 1-10:\n1-3: Tenang banget kayak di desa\n4-6: Lumayan, masih bisa tidur\n7-8: Bising, sering terganggu\n9-10: Parah, gak bisa istirahat\n\nTulis angka kamu di komentar!\n\nCLOSING:\n',
    18, 0, 210, 3, 7, 0)


# ============================================================
# 11. SHOWCASED SOLUTIONS — ACOUSTICA (7 entries)
# ============================================================

add('Showcased Solutions', 'Solusi kedap untuk apartemen',
    'Treatment kedap suara yang cocok buat apartemen',
    'HOOK:\nTinggal di apartemen tapi pengen tenang? Ini solusi kita\n\nBODY:\nUntuk apartemen, kita biasanya treatment:\n1. Jendela - ganti ke UPVC double/triple glass\n2. Dinding yang berbatasan sama koridor - tambah peredam\n3. Pintu - seal semua celah, upgrade ke pintu solid\n4. Lantai - pasang underlayment di bawah lantai\n\nSemua tanpa merubah struktur bangunan jadi aman buat unit apartemen.\n\nCLOSING:\nPenghuni apartemen, ini solusi buat kalian!',
    18, 5, 110, 3, 1, 0)

add('Showcased Solutions', 'Solusi noise barrier pabrik',
    'Noise barrier buat area industri',
    'HOOK:\nPabrik yang berdekatan sama pemukiman wajib punya noise barrier\n\nBODY:\nKita udah ngerjain beberapa project noise barrier untuk pabrik. Materinya biasanya kombinasi beton, mass loaded vinyl, dan panel absorber. Tujuannya mengurangi kebisingan yang sampai ke area pemukiman sekitar pabrik.\n\nCLOSING:\nPunya pabrik yang berdekatan sama perumahan? Konsultasi sama kita!',
    18, 2, 240, 2, 1, 0)

add('Showcased Solutions', 'Solusi akustik masjid',
    'Treatment akustik masjid biar suara imam lebih jelas',
    'HOOK:\nSering gak jelas denger khutbah di masjid? Ini masalah akustiknya\n\nBODY:\nMasjid dengan kubah tinggi dan lantai keramik biasanya punya masalah gema yang parah. Suara imam jadi gak jelas dan bikin jamaah susah fokus. Solusinya pasang panel akustik di dinding dan ceiling buat mengurangi pantulan tanpa mengubah estetika masjid.\n\nCLOSING:\nMasjid di daerah kamu juga gema gak?',
    18, 3, 155, 4, 2, 0)

add('Showcased Solutions', 'Solusi genset kedap',
    'Genset berisik? Bikin enclosure kedap aja!',
    'HOOK:\nGenset kantor berisik banget? Ada solusinya!\n\nBODY:\nKita bikin enclosure khusus buat genset yang bisa ngurangin kebisingan sampai 30 dB. Materialnya rockwool di dalam dan steel di luar. Tetap ada ventilasi buat sirkulasi udara tapi suaranya teredam. Cocok buat genset di area kantor atau perumahan.\n\nCLOSING:\nGenset kamu udah di-enclose belum?',
    18, 3, 98, 3, 1, 0)

add('Showcased Solutions', 'Solusi sekat ruangan kedap',
    'Partisi ruangan yang bisa redam suara',
    'HOOK:\n\n\nBODY:\nButuh bagi ruangan tapi tetap kedap suara? Kita punya solusi moveable partition yang soundproof. Materialnya acoustic panel dengan isi rockwool. Bisa dipindah-pindah sesuai kebutuhan tapi tetap efektif redam suara. Cocok buat kantor yang butuh fleksibilitas ruangan.\n\nCLOSING:\nFleksibel dan kedap, kombinasi yang sempurna!',
    18, 2, 185, 2, 0, 0)

add('Showcased Solutions', 'Solusi kamar anak kedap',
    'Kamar anak yang kedap biar gak ganggu tetangga',
    'HOOK:\nAnak suka main musik tapi tetangga complain?\n\nBODY:\nSolusi yang kita tawarkan buat kamar anak:\n- Treatment dinding dengan peredam yang aman (non-toxic)\n- Jendela UPVC\n- Door sweep dan seal\n- Panel akustik dengan desain warna-warni yang kid-friendly\n\nAnak bebas berkreasi, tetangga tetap tenang.\n\nCLOSING:\nOrtu mana nih yang relate?',
    19, 4, 78, 3, 1, 0)

add('Showcased Solutions', 'Solusi cafe kedap',
    'Cafe ini treatment akustik biar customer nyaman',
    'HOOK:\nNgobrol di cafe tapi harus teriak karena terlalu berisik?\n\nBODY:\nCafe ini punya masalah akustik yang parah. Suara music, mesin kopi, dan obrolan customer campur jadi satu bikin gak nyaman. Setelah kita pasang panel akustik di ceiling dan beberapa spot di dinding, sekarang customer bisa ngobrol normal tanpa harus angkat suara.\n\nCLOSING:\nPunya cafe dan mau bikin customer lebih nyaman? DM kita!',
    18, 4, 126, 3, 0, 1)


# ============================================================
# 12. ROOM TYPE BREAKDOWN — ACOUSTICA (7 entries)
# ============================================================

add('Room Type Breakdown', 'Treatment studio musik lengkap',
    'Apa aja yang perlu ditreatment di studio musik?',
    'HOOK:\nMau bikin studio musik? Ini semua yang perlu ditreatment\n\nBODY:\nDinding: double drywall + rockwool + MLV\nLantai: floating floor\nCeiling: suspended ceiling dengan insulasi\nPintu: solid core door + double seal\nJendela: UPVC double glass minimum\nAkustik: panel absorber + diffuser + bass trap\nElektrikal: isolasi conduit\n\nCLOSING:\nLengkap kan? Save buat referensi nanti!',
    18, 6, 132, 4, 0, 1)

add('Room Type Breakdown', 'Treatment kamar tidur',
    'Kamar tidur kedap, ini yang perlu ditangani',
    'HOOK:\nKamar tidur yang tenang itu kunci kesehatan!\n\nBODY:\nYang perlu ditreatment di kamar tidur:\n- Jendela: ganti ke UPVC atau tambahin secondary glazing\n- Dinding (yang menghadap jalan): tambah insulasi\n- Pintu: seal celah + upgrade ke solid door\n- Lantai: karpet tebal\n- AC: seal sekeliling unit\n\nCLOSING:\nKamar kamu udah ditreatment belum?',
    18, 3, 195, 3, 1, 0)

add('Room Type Breakdown', 'Treatment home theater',
    'Breakdown lengkap treatment home theater',
    'HOOK:\n\n\nBODY:\nBuat home theater yang beneran immersive, ini yang perlu diperhatikan:\n\nSoundproofing: semua dinding, ceiling, dan lantai\nAcoustic treatment: panel absorber di titik refleksi, diffuser di dinding belakang, bass trap di sudut\nPintu: solid core minimal, idealnya pintu ganda\n\nCLOSING:\nMau nonton kayak di bioskop? Treatment dulu ruangannya!',
    18, 4, 280, 3, 1, 0)

add('Room Type Breakdown', 'Treatment ruang meeting',
    'Ruang meeting yang ideal itu seperti ini',
    'HOOK:\nRuang meeting yang bagus bukan cuma soal meja dan kursi\n\nBODY:\nAkustik ruang meeting yang ideal:\n- STC dinding minimal 45\n- Background noise max 35 dB\n- Reverberation time 0.6-0.8 detik\n- Panel akustik di dinding dan ceiling\n- Karpet di lantai\n- Seal rapat di pintu\n\nCLOSING:\nMeeting produktif dimulai dari ruangan yang nyaman!',
    18, 3, 170, 2, 0, 0)

add('Room Type Breakdown', 'Treatment ruang voice over',
    'Setup ruang voice over yang proper',
    'HOOK:\nVoice over artist wajib baca ini!\n\nBODY:\nRuang voice over butuh:\n- Noise floor di bawah 30 dB\n- Panel akustik tebal di semua dinding\n- Bass trap di sudut\n- Ceiling treatment\n- Lantai berkarpet\n- Pintu seal rapat\n\nRuangan kecil justru lebih mudah ditreatment buat VO.\n\nCLOSING:\nVO artist mana nih? Drop komentar!',
    20, 4, 84, 3, 1, 0)

add('Room Type Breakdown', 'Treatment studio dance',
    'Studio dance juga butuh treatment akustik lho',
    'HOOK:\nStudio dance yang suaranya mantul kemana-mana bikin latihan gak enak\n\nBODY:\nStudio dance butuh treatment khusus:\n- Panel akustik di dinding buat ngurangin pantulan\n- Floating floor buat impact noise dari gerakan\n- Ceiling absorber\n- Sound system yang disesuaikan sama akustik ruangan\n\nCLOSING:\nPunya studio dance? Yuk konsultasi!',
    18, 3, 240, 2, 1, 0)

add('Room Type Breakdown', 'Treatment ruang gaming',
    'Setup ruang gaming yang akustiknya mantap',
    'HOOK:\nGamer sejati harus punya ruang gaming dengan akustik yang proper\n\nBODY:\nRuang gaming ideal:\n- Panel akustik buat ngurangin echo saat voice chat\n- Soundproofing biar gak ganggu orang rumah\n- Bass management buat immersive gaming\n- LED ambient buat vibes\n\nCLOSING:\nGamer mana nih yang pengen ruangan kayak gini?',
    21, 5, 108, 4, 2, 0)


# ============================================================
# 13. BRAND AWARENESS — ACOUSTICA (6 entries)
# ============================================================

add('Brand Awareness', 'Kenalan sama Acoustica',
    'Acoustica - Solusi kedap suara nomor 1',
    'HOOK:\nKenalan dulu yuk sama Acoustica!\n\nBODY:\nAcoustica hadir sebagai solusi kedap suara profesional. Dari konsultasi, desain, sampai instalasi, semua kita handle. Udah ratusan project yang kita selesaikan dengan hasil yang memuaskan. Kualitas material terjamin dan ada garansi pekerjaannya.\n\nCLOSING:\nMau tau lebih lanjut? Kunjungi website kita atau DM langsung!',
    18, 5, 135, 4, 0, 0)

add('Brand Awareness', 'Tim Acoustica',
    'Di balik layar: kenalan sama tim Acoustica',
    'HOOK:\nPenasaran siapa aja yang ngerjain project Acoustica?\n\nBODY:\nTim kita terdiri dari engineer akustik berpengalaman, desainer interior, dan installer terlatih. Setiap project kita kerjain bareng-bareng biar hasilnya maksimal. Dari survei awal sampai testing akhir, semua dikerjakan dengan standar tinggi.\n\nCLOSING:\nTim profesional buat hasil profesional!',
    18, 3, 185, 3, 0, 0)

add('Brand Awareness', 'Acoustica di Bali',
    'Dewata Swara - partner Acoustica di Bali',
    'HOOK:\nYang di Bali, kita juga ada lho!\n\nBODY:\nDewata Swara adalah partner resmi Acoustica di Bali. Melayani treatment kedap suara dan akustik di seluruh area Bali. Dari villa, hotel, restoran, sampai rumah pribadi. Material dan standar kerjanya sama dengan Acoustica pusat.\n\nCLOSING:\nYang di Bali, langsung aja hubungi Dewata Swara!',
    18, 4, 98, 3, 0, 0)

add('Brand Awareness', 'Visi misi Acoustica',
    'Kenapa kita peduli soal kebisingan',
    'HOOK:\n\n\nBODY:\nAcoustica percaya bahwa setiap orang berhak mendapatkan ruangan yang tenang dan nyaman. Kebisingan bukan cuma soal kenyamanan, tapi juga kesehatan. Makanya kita berkomitmen memberikan solusi terbaik dengan harga yang reasonable.\n\nCLOSING:\nBersama Acoustica, wujudkan ruangan impianmu!',
    18, 2, 350, 3, 1, 0)

add('Brand Awareness', 'Milestone Acoustica',
    '3 tahun Acoustica, ini pencapaian kita',
    'HOOK:\nHappy birthday Acoustica! 3 tahun dan counting\n\nBODY:\nDalam 3 tahun:\n- 100+ project selesai\n- Rating 5 bintang di Google\n- Expanding ke Bali\n- 0 complaint yang gak terselesaikan\n\nTerima kasih buat semua client dan followers yang udah support Acoustica dari awal!\n\nCLOSING:\nHere is to many more years!',
    18, 5, 120, 5, 1, 0)

add('Brand Awareness', 'Workshop akustik gratis',
    'Ikutan workshop akustik gratis dari Acoustica',
    'HOOK:\nAcoustica mau ngadain workshop gratis soal akustik ruangan!\n\nBODY:\nTopik yang bakal dibahas:\n- Dasar-dasar akustik ruangan\n- Cara identifikasi masalah kebisingan\n- DIY treatment yang bisa kamu lakuin sendiri\n- Q&A langsung sama tim engineer\n\nTanggal dan tempat menyusul. Stay tuned!\n\nCLOSING:\nYang minat, tulis DAFTAR di komentar!',
    18, 4, 72, 3, 4, 0)


# ============================================================
# 14. GARANSI & LAYANAN PURNA JUAL — ACOUSTICA (6 entries)
# ============================================================

add('Garansi & Layanan Purna Jual', 'Garansi pekerjaan Acoustica',
    'Garansi 1 tahun untuk semua project Acoustica',
    'HOOK:\nDi Acoustica, setiap project punya garansi!\n\nBODY:\nSemua project Acoustica bergaransi 1 tahun. Kalau ada masalah dengan hasil pekerjaan, entah itu panel yang lepas, seal yang bocor, atau apapun yang terkait kualitas kerja, kita perbaiki GRATIS. Karena kepuasan client itu prioritas utama kita.\n\nCLOSING:\nTenang, di sini ada garansinya!',
    18, 3, 95, 3, 1, 0)

add('Garansi & Layanan Purna Jual', 'Layanan maintenance akustik',
    'Layanan maintenance berkala dari Acoustica',
    'HOOK:\nSetelah project selesai, kita gak lepas tangan begitu aja\n\nBODY:\nAcoustica punya layanan maintenance berkala buat client. Kita cek kondisi panel, seal, dan komponen lainnya secara rutin. Kalau ada yang perlu diperbaiki atau di-upgrade, kita kasih rekomendasi terbaik.\n\nCLOSING:\nAfter sales service yang beneran serius!',
    18, 2, 225, 3, 0, 0)

add('Garansi & Layanan Purna Jual', 'Konsultasi gratis',
    'Konsultasi GRATIS sebelum project dimulai',
    'HOOK:\nBelum yakin mau treatment? Konsultasi dulu aja, GRATIS!\n\nBODY:\nKita kasih konsultasi gratis buat semua yang pengen tau:\n- Apa masalah akustik di ruanganmu\n- Treatment apa yang cocok\n- Estimasi budget\n- Timeline pengerjaan\n\nGak ada commitment, gak ada tekanan. Konsultasi dulu baru putuskan.\n\nCLOSING:\nDM kita buat jadwalin konsultasi!',
    18, 4, 62, 2, 1, 0)

add('Garansi & Layanan Purna Jual', 'Garansi material',
    'Material yang kita pakai bergaransi pabrik',
    'HOOK:\n\n\nBODY:\nSelain garansi pekerjaan, material yang kita gunakan juga punya garansi dari pabrik. Rockwool, panel akustik, UPVC, semua dari brand terpercaya yang punya track record bagus. Jadi kamu gak cuma dapet hasil kerja yang bagus, tapi juga material yang tahan lama.\n\nCLOSING:\nKualitas material = hasil berkualitas!',
    18, 2, 290, 3, 0, 0)

add('Garansi & Layanan Purna Jual', 'Service darurat',
    'Ada masalah mendesak? Hubungi service darurat kita',
    'HOOK:\nPanel lepas? Seal bocor? Jangan panik!\n\nBODY:\nAcoustica punya layanan service darurat buat client yang punya masalah mendesak. Respon cepat dalam 24 jam. Kita prioritaskan kenyamanan client di atas segalanya.\n\nCLOSING:\nSave nomor kita buat jaga-jaga!',
    18, 2, 105, 3, 0, 0)

add('Garansi & Layanan Purna Jual', 'Upgrade treatment',
    'Mau upgrade treatment yang udah ada? Bisa banget!',
    'HOOK:\nTreatment lama udah gak cukup? Upgrade aja!\n\nBODY:\nKebutuhan akustik bisa berubah seiring waktu. Mungkin dulu cuma butuh basic treatment, sekarang butuh yang lebih serius. Kita bisa upgrade treatment yang udah ada tanpa harus bongkar total. Hemat biaya dan waktu.\n\nCLOSING:\nKonsultasi upgrade treatment sekarang!',
    18, 3, 158, 4, 0, 0)


# ============================================================
# 15. PROJECT IMPACT — ACOUSTICA (6 entries)
# ============================================================

add('Project Impact', 'Dampak studio musik pada musisi',
    'Musisi ini sekarang bisa rekaman kapanpun dia mau',
    'HOOK:\nProject studio musik ini beneran mengubah hidup client kita\n\nBODY:\nSebelumnya, dia harus booking studio komersial yang biayanya ratusan ribu per jam. Sekarang dengan studio sendiri di rumah, dia bisa rekaman kapanpun tanpa biaya tambahan. Dalam 6 bulan, dia udah rilis 2 EP dan bilang kualitasnya jauh lebih bagus karena bisa ambil take sebanyak yang dia mau.\n\nCLOSING:\nInvestasi yang beneran berbuah!',
    18, 4, 82, 3, 1, 0)

add('Project Impact', 'Testimoni tidur berkualitas',
    'Gak nyangka treatment jendela bisa segini ngaruhnya',
    'HOOK:\nClient ini bilang kualitas tidurnya meningkat drastis setelah treatment\n\nBODY:\nSetelah treatment jendela pakai UPVC triple glass, client ini bilang tidurnya jadi jauh lebih nyenyak. Dia gak perlu lagi pake earplug atau white noise machine. Energinya di siang hari juga meningkat karena tidurnya lebih berkualitas. Sometimes solusi simpel punya dampak yang luar biasa.\n\nCLOSING:\nTidur nyenyak = hidup berkualitas!',
    18, 3, 125, 4, 1, 0)

add('Project Impact', 'Impact pada produktivitas kantor',
    'Setelah treatment, produktivitas karyawan naik',
    'HOOK:\n\n\nBODY:\nKantor startup ini laporan kalau setelah treatment akustik, karyawan jadi lebih fokus dan produktif. Meeting gak ganggu tim yang lagi kerja di luar ruangan meeting. Phone calls jadi lebih jelas. HR bilang complaint soal noise turun 90%.\n\nCLOSING:\nInvestasi di akustik = investasi di karyawan!',
    18, 2, 265, 3, 0, 0)

add('Project Impact', 'Sekolah musik lebih efektif',
    'Murid sekolah musik ini jadi lebih cepat belajar',
    'HOOK:\nSekolah musik ini bilang muridnya belajar lebih cepat setelah treatment\n\nBODY:\nSuara antar ruangan yang gak saling ganggu bikin murid lebih fokus. Guru juga gak perlu teriak-teriak. Kualitas pengajaran naik dan murid lebih enjoy belajar musik. Pemilik sekolah bilang ini investasi terbaik yang pernah dia lakuin.\n\nCLOSING:\nDampak positif yang gak ternilai!',
    18, 3, 78, 3, 0, 0)

add('Project Impact', 'Nilai properti naik',
    'Treatment soundproofing bisa naikin nilai properti lho',
    'HOOK:\nTau gak kalau rumah yang udah ditreatment soundproofing nilainya lebih tinggi?\n\nBODY:\nMenurut beberapa agen properti, rumah atau apartemen yang punya fitur kedap suara bisa dihargai 10-15% lebih tinggi. Apalagi kalau lokasinya di area yang bising. Treatment soundproofing bukan cuma soal kenyamanan, tapi juga investasi properti.\n\nCLOSING:\nDouble benefit: nyaman sekarang, untung nanti!',
    18, 4, 148, 4, 0, 1)

add('Project Impact', 'Youtuber upgrade konten',
    'Youtuber ini bilang viewersnya naik setelah upgrade akustik',
    'HOOK:\nYoutuber ini upgrade akustik ruangannya dan hasilnya...\n\nBODY:\nSetelah treatment studio rekaman, kualitas audio video-videonya naik drastis. Subscriber dan viewers juga ikut naik karena orang lebih betah nonton konten dengan audio yang jernih. Dia bilang ROI treatment akustiknya udah balik dalam 3 bulan dari peningkatan revenue AdSense.\n\nCLOSING:\nContent quality matters!',
    18, 5, 92, 3, 1, 0)


# ============================================================
# 16. PSYCHOLOGI — ACOUSTICA (5 entries)
# ============================================================

add('Psychologi', 'Efek kebisingan pada kesehatan mental',
    'Kebisingan dan kesehatan mental, apa hubungannya?',
    'HOOK:\nKebisingan bisa bikin kamu anxiety dan gak sadar\n\nBODY:\nPaparan kebisingan kronis bisa meningkatkan level cortisol yang bikin kamu terus-menerus dalam mode fight or flight. Dampaknya: anxiety, irritability, gangguan tidur, dan penurunan kemampuan konsentrasi. Riset menunjukkan orang yang tinggal di area tenang punya level kebahagiaan yang lebih tinggi.\n\nCLOSING:\nLingkungan tenang = mental sehat!',
    18, 3, 195, 5, 1, 0)

add('Psychologi', 'Kebisingan dan produktivitas',
    'Kenapa kamu gak bisa fokus di kantor? Mungkin ini sebabnya',
    'HOOK:\nSusah fokus di kantor? Bisa jadi bukan kamu yang kurang disiplin\n\nBODY:\nRiset menunjukkan bahwa paparan kebisingan 50 dB aja udah bisa nurunin kemampuan kognitif. Di kantor open space yang levelnya bisa 60-70 dB, wajar banget kalau kamu susah fokus. Solusinya bukan cuma headphone, tapi treatment akustik ruangan kerja.\n\nCLOSING:\nJangan salahkan diri sendiri, salahkan akustiknya!',
    18, 4, 160, 4, 2, 0)

add('Psychologi', 'Musik dan mood',
    'Kenapa kamu butuh ruangan yang akustiknya bagus buat dengerin musik',
    'HOOK:\n\n\nBODY:\nDengerin musik di ruangan yang akustiknya bagus itu pengalaman yang beda banget. Bass-nya terasa, vokal-nya jelas, detail-detailnya kedengeran. Ini bisa meningkatkan mood dan bikin kamu lebih rileks. Ruangan yang akustiknya jelek bikin musik kedengerin flat dan gak menyenangkan.\n\nCLOSING:\nCoba deh rasain sendiri perbedaannya!',
    18, 2, 310, 3, 1, 0)

add('Psychologi', 'Kebisingan pada anak',
    'Efek kebisingan pada perkembangan anak',
    'HOOK:\nAnak kamu tinggal di lingkungan bising? Hati-hati dampaknya\n\nBODY:\nPenelitian menunjukkan anak yang terpapar kebisingan kronis cenderung:\n- Kemampuan membaca lebih rendah\n- Daya ingat lebih lemah\n- Level stres lebih tinggi\n- Kualitas tidur lebih buruk\n\nLingkungan yang tenang sangat penting buat perkembangan kognitif anak.\n\nCLOSING:\nOrtu, yuk mulai perhatiin kenyamanan akustik rumah!',
    18, 3, 175, 4, 1, 0)

add('Psychologi', 'Suara alam dan relaksasi',
    'Kenapa suara alam bikin tenang?',
    'HOOK:\nSuara hujan, ombak, atau burung berkicau selalu bikin rileks, kenapa ya?\n\nBODY:\nSuara alam punya frekuensi dan pola yang menenangkan otak. Gak kayak kebisingan buatan yang acak dan mengganggu, suara alam punya irama yang konsisten. Makanya banyak orang pake white noise machine atau sound machine buat tidur. Tapi akan lebih bagus lagi kalau ruangan kamu udah kedap dari kebisingan buatan.\n\nCLOSING:\nNature sounds + ruangan kedap = tidur terbaik!',
    18, 4, 88, 3, 0, 0)


# ============================================================
# 17. DISCOUNT & OFFERS — ACOUSTICA (5 entries)
# ============================================================

add('Discount & Offers', 'Promo akhir tahun',
    'Promo akhir tahun! Diskon 20% semua treatment',
    'HOOK:\nPROMO AKHIR TAHUN! Diskon 20% buat semua jenis treatment\n\nBODY:\nBerlaku sampai 31 Desember. Diskon 20% untuk semua jenis treatment soundproofing dan akustik. Berlaku untuk project baru. Konsultasi tetap GRATIS. Slot terbatas, first come first served!\n\nCLOSING:\nJangan sampai kelewatan! DM sekarang buat booking!',
    18, 5, 65, 2, 1, 0)

add('Discount & Offers', 'Paket bundling treatment',
    'Paket hemat treatment kamar tidur + ruang kerja',
    'HOOK:\nMau treatment 2 ruangan sekaligus? Ada paket hematnya!\n\nBODY:\nPaket bundling treatment:\nKamar tidur + Ruang kerja\nDapat diskon 15% dari harga satuan!\n\nSudah termasuk:\n- Survey dan konsultasi\n- Material premium\n- Instalasi profesional\n- Garansi 1 tahun\n\nCLOSING:\nSlot terbatas! Hubungi kita sekarang!',
    18, 6, 55, 2, 0, 0)

add('Discount & Offers', 'Flash sale panel akustik',
    'FLASH SALE panel akustik cuma hari ini!',
    'HOOK:\nFLASH SALE! Panel akustik diskon 30% CUMA HARI INI!\n\nBODY:\nPanel akustik premium dengan diskon 30%. Tersedia berbagai warna dan ukuran. Stok terbatas, siapa cepat dia dapat. Sudah termasuk panduan pemasangan.\n\nCLOSING:\nOrder sekarang sebelum kehabisan!',
    12, 8, 48, 2, 0, 0)

add('Discount & Offers', 'Referral program',
    'Ajak temen, dapet diskon!',
    'HOOK:\nMau dapet diskon treatment? Ajak temenmu aja!\n\nBODY:\nReferral program Acoustica:\n- Rekomendasiin Acoustica ke temen\n- Kalau temen kamu deal, kamu dan temen kamu masing-masing dapet diskon 10%\n- Gak ada batasan berapa banyak referral\n\nCLOSING:\nTag temen yang butuh treatment sekarang!',
    18, 4, 82, 3, 2, 0)

add('Discount & Offers', 'Promo Ramadan',
    'Promo spesial Ramadan dari Acoustica',
    'HOOK:\n\n\nBODY:\nSpesial Ramadan! Diskon 15% untuk treatment musholla, masjid, dan ruang ibadah. Berlaku sepanjang bulan Ramadan. Yuk bikin ruang ibadah jadi lebih nyaman dan khusyuk.\n\nCLOSING:\nHubungi kita buat info lebih lanjut!',
    18, 3, 185, 2, 1, 0)


# ============================================================
# 18. CINEMATIC — ACOUSTICA (5 entries)
# ============================================================

add('Cinematic', 'Proses instalasi time-lapse',
    'Satisfying banget! Proses instalasi soundproofing time-lapse',
    'HOOK:\nSatisfying alert! Tonton proses instalasi ini dari awal sampai akhir\n\nBODY:\nTime-lapse proses instalasi soundproofing studio musik dari nol sampai jadi. Dari pasang rangka, isi rockwool, tutup drywall, sampai finishing panel akustik. 2 minggu kerja dimampatkan jadi 60 detik.\n\nCLOSING:\nPuas gak lihatnya? Like kalau suka!',
    18, 3, 125, 4, 1, 0)

add('Cinematic', 'ASMR pasang panel',
    'ASMR: suara pasang panel akustik',
    'HOOK:\n\n\nBODY:\nASMR version pemasangan panel akustik. Dengerin suara klik panel saat dipasang, suara foam yang disentuh, dan perubahan akustik ruangan dari gema jadi hening.\n\nCLOSING:\n',
    20, 2, 210, 3, 0, 0)

add('Cinematic', 'Story telling client',
    'POV: kamu capek sama bising tapi gak tau harus gimana',
    'HOOK:\n\n\nBODY:\nPOV: Kamu tinggal di apartemen lantai 2 yang langsung menghadap jalan raya. Setiap malam suara motor dan truk gak pernah berhenti. Kamu udah coba pake earplug, white noise, bahkan pindah kamar. Tapi gak ada yang work. Sampai akhirnya kamu nemuin Acoustica...\n\nCLOSING:\nTo be continued...',
    21, 2, 340, 4, 1, 0)

add('Cinematic', 'Before after dramatic',
    'Before vs After yang bikin merinding',
    'HOOK:\nDengerin perbedaannya, before vs after treatment\n\nBODY:\nBagian pertama video: rekaman suara di ruangan SEBELUM treatment. Suara bising jalan raya jelas banget kedengeran.\n\nBagian kedua: rekaman dari posisi yang sama SETELAH treatment. Hening. Perbedaannya dramatic banget.\n\nCLOSING:\nMerinding gak dengernya? Share ke yang butuh!',
    18, 4, 92, 4, 1, 0)

add('Cinematic', 'Day in the life installer',
    'Sehari jadi installer soundproofing',
    'HOOK:\n\n\nBODY:\nPOV: Sehari jadi installer soundproofing di Acoustica. Mulai dari briefing pagi, loading material, perjalanan ke site, instalasi seharian, sampai testing di akhir. Kerja keras tapi satisfying banget kalau liat hasilnya.\n\nCLOSING:\nRespect buat semua tim installer!',
    18, 3, 275, 3, 0, 0)


# ============================================================
# 19. BRANDING — OKE MEBEL (6 entries)
# ============================================================

add('Branding', 'Kenapa pilih Oke Mebel',
    'Kenapa harus pilih Oke Mebel? Ini alasannya',
    'HOOK:\nMasih bingung mau bikin furniture dimana?\n\nBODY:\nIni alasan kenapa Oke Mebel jadi pilihan terbaik:\n1. Full custom sesuai ukuran dan desain kamu\n2. Material berkualitas tinggi\n3. Finishing rapi dan detail\n4. Harga transparan, gak ada biaya tersembunyi\n5. Garansi pekerjaan\n6. Free konsultasi desain\n\nCLOSING:\nFurniture impian kamu, kita wujudkan!',
    18, 5, 118, 4, 1, 0)

add('Branding', 'Proses kerja Oke Mebel',
    'Gimana sih proses bikin furniture custom di Oke Mebel?',
    'HOOK:\nPenasaran gimana proses bikin furniture custom?\n\nBODY:\nProsesnya:\n1. Konsultasi dan ukur ruangan\n2. Desain 3D biar kamu bisa lihat hasilnya\n3. Pemilihan material dan warna\n4. Produksi di workshop\n5. Quality control\n6. Instalasi di rumah kamu\n7. After sales service\n\nSemua step transparan dan kamu bisa pantau progresnya.\n\nCLOSING:\nStart to finish, kita handle semua!',
    18, 4, 195, 3, 0, 0)

add('Branding', 'Material premium Oke Mebel',
    'Oke Mebel cuma pakai material terbaik',
    'HOOK:\nKenapa furniture Oke Mebel lebih awet?\n\nBODY:\nJawabannya ada di material. Kita cuma pakai:\n- Multiplex grade A\n- HPL berkualitas tinggi\n- Hardware dari brand terpercaya\n- Finishing yang tahan lama\n\nGak kayak furniture jadi yang pakai MDF atau particle board yang gampang rusak kena air.\n\nCLOSING:\nKualitas material = kualitas furniture!',
    18, 3, 158, 2, 1, 0)

add('Branding', 'Oke Mebel vs marketplace',
    'Bedanya furniture custom Oke Mebel vs beli di marketplace',
    'HOOK:\n\n\nBODY:\nCustom di Oke Mebel:\n+ Ukuran pas sama ruangan\n+ Material premium\n+ Desain sesuai selera\n+ Awet bertahun-tahun\n\nBeli di marketplace:\n+ Harga murah\n+ Langsung kirim\n- Ukuran standar\n- Material MDF/particle board\n- Cepat rusak\n\nCLOSING:\nPilih yang mana? Komentar ya!',
    18, 3, 280, 3, 2, 0)

add('Branding', 'Workshop Oke Mebel',
    'Intip workshop Oke Mebel, tempat furniture kamu dibuat',
    'HOOK:\nMau lihat tempat furniture kamu diproduksi?\n\nBODY:\nWorkshop Oke Mebel dilengkapi mesin-mesin modern buat memastikan presisi dan kualitas. Setiap furniture dikerjain oleh tukang berpengalaman yang udah terlatih. Quality control ketat di setiap tahap produksi.\n\nCLOSING:\nKualitas dimulai dari workshop!',
    18, 2, 142, 2, 0, 0)

add('Branding', 'Garansi Oke Mebel',
    'Furniture Oke Mebel bergaransi!',
    'HOOK:\nFurniture custom juga ada garansinya lho!\n\nBODY:\nOke Mebel kasih garansi buat setiap produk yang kita buat. Kalau ada masalah dengan konstruksi, engsel, rel, atau finishing, kita perbaiki tanpa biaya tambahan. Karena kepuasan customer adalah prioritas utama.\n\nCLOSING:\nTenang, di Oke Mebel ada garansinya!',
    18, 3, 95, 3, 0, 0)


# ============================================================
# 20. USE CASE — OKE MEBEL (6 entries)
# ============================================================

add('Use Case', 'Kitchen set custom',
    'Kitchen set custom yang bikin masak jadi menyenangkan',
    'HOOK:\nDapur rapi = mood masak naik!\n\nBODY:\nKitchen set custom ini kita desain sesuai kebutuhan client. Ada area prep, storage yang cukup, dan layout yang efisien. Semua diukur presisi biar pas sama ruangan. Material tahan air dan tahan panas. Hasilnya? Dapur jadi organized dan enak dipake masak.\n\nCLOSING:\nMau dapur kayak gini? DM kita buat konsultasi!',
    18, 5, 75, 2, 1, 0)

add('Use Case', 'Lemari sliding custom',
    'Lemari sliding custom buat kamar yang lebih lega',
    'HOOK:\nKamar sempit tapi butuh lemari besar? Solusinya lemari sliding!\n\nBODY:\nLemari sliding gak butuh ruang buat buka pintu, jadi cocok banget buat kamar yang sempit. Kita custom ukurannya dari lantai sampai ceiling biar storage-nya maksimal. Dalamnya bisa disesuaikan mau gantungan, laci, atau rak.\n\nCLOSING:\nHemat ruang, storage maksimal!',
    18, 4, 130, 3, 0, 1)

add('Use Case', 'Meja kerja custom WFH',
    'Meja kerja custom buat WFH yang produktif',
    'HOOK:\nWFH tapi mejanya gak proper? No wonder produktivitas turun\n\nBODY:\nMeja kerja ini kita custom sesuai kebutuhan client yang WFH. Ada cable management, laci storage, dan ukuran yang pas sama ruangannya. Materialnya solid dan stabil, gak goyang kalau dipake ngetik. Tampilannya minimalis dan clean.\n\nCLOSING:\nMeja yang proper = kerja yang produktif!',
    18, 3, 188, 2, 0, 0)

add('Use Case', 'Walk-in closet custom',
    'Walk-in closet impian jadi kenyataan',
    'HOOK:\nSiapa yang mau punya walk-in closet di rumah?\n\nBODY:\nClient ini punya ruangan kosong yang mau dijadiin walk-in closet. Kita desain dan buatin storage yang organized: area gantungan untuk baju formal, rak untuk sepatu, laci untuk accessories, dan cermin full-body. Semuanya custom sesuai koleksi client.\n\nCLOSING:\nOrganized wardrobe, organized life!',
    18, 5, 68, 2, 1, 0)

add('Use Case', 'Rak TV floating custom',
    'Rak TV floating yang bikin ruang tamu makin aesthetic',
    'HOOK:\n\n\nBODY:\nRak TV floating ini kita bikin dari multiplex yang difinishing HPL motif kayu. Desainnya minimalis tapi fungsional. Ada tempat buat set-top box, speaker, dan kabel yang tersembunyi. Dipasang floating biar kesan ruangan lebih lega dan modern.\n\nCLOSING:\nSimple tapi keren kan?',
    18, 3, 240, 3, 0, 0)

add('Use Case', 'Instalasi furniture rumah lengkap',
    'Full furnished satu rumah oleh Oke Mebel',
    'HOOK:\nSatu rumah full furnished oleh Oke Mebel! Lihat hasilnya\n\nBODY:\nProject kali ini kita handle seluruh furniture di satu rumah:\n- Kitchen set\n- 3 set lemari kamar\n- Rak TV ruang tamu\n- Meja kerja\n- Vanity kamar mandi\n\nSemua didesain dengan tema yang konsisten supaya terlihat harmonis.\n\nCLOSING:\nOne stop solution buat furniture rumah kamu!',
    18, 4, 92, 3, 0, 0)


# ============================================================
# 21. BTS — OKE MEBEL (6 entries)
# ============================================================

add('BTS', 'Proses potong material',
    'Behind the scene: proses potong material di workshop',
    'HOOK:\nSatisfying banget ngeliat proses potong material di workshop Oke Mebel\n\nBODY:\nSetiap potongan diukur presisi biar hasilnya pas. Mesin potong modern yang kita pakai bisa potong dengan akurasi sampai 0.1mm. Gak boleh ada salah ukur karena itu berarti material terbuang dan waktu terbuang.\n\nCLOSING:\nPrecision is key!',
    18, 2, 135, 2, 0, 0)

add('BTS', 'Proses finishing furniture',
    'Proses finishing yang bikin furniture jadi cantik',
    'HOOK:\nFinishing itu yang bikin furniture dari biasa jadi luar biasa\n\nBODY:\nProses finishing di Oke Mebel:\n1. Amplas halus semua permukaan\n2. Aplikasi HPL atau cat dengan rapi\n3. Cek detail di setiap sudut\n4. Poles sampai halus\n\nHasil finishing yang rapi itu gak dateng dari keberuntungan, tapi dari skill dan ketelitian.\n\nCLOSING:\nDetail matters!',
    18, 3, 105, 3, 0, 0)

add('BTS', 'Quality control di workshop',
    'Ini cara kita pastikan setiap furniture berkualitas',
    'HOOK:\nSebelum dikirim ke client, setiap furniture harus lulus QC dulu\n\nBODY:\nQuality control Oke Mebel meliputi:\n- Cek dimensi sesuai desain\n- Cek finishing tanpa cacat\n- Test engsel dan rel laci\n- Cek kerapihan sambungan\n- Simulasi pemasangan\n\nKalau ada yang kurang, balik ke produksi buat diperbaiki.\n\nCLOSING:\nNo compromise on quality!',
    18, 3, 88, 3, 0, 0)

add('BTS', 'Suasana workshop',
    'Day in the life di workshop Oke Mebel',
    'HOOK:\n\n\nBODY:\nPOV: Sehari di workshop Oke Mebel. Dari briefing pagi, bagi tugas, potong material, rakit, finishing, sampai packing. Satu hari penuh tapi hasilnya worth it kalau liat furniture jadi yang cantik.\n\nCLOSING:\nRespect buat semua tukang yang kerja keras tiap hari!',
    18, 2, 270, 3, 0, 0)

add('BTS', 'Packing dan loading',
    'Proses packing furniture sebelum dikirim ke client',
    'HOOK:\nPacking furniture itu gak boleh asal-asalan\n\nBODY:\nSetiap furniture kita packing dengan bubble wrap dan karton biar aman selama perjalanan. Loading ke truck juga harus hati-hati, gak boleh tumpuk sembarangan. Semua biar furniture sampai ke client dalam kondisi sempurna.\n\nCLOSING:\nSafe delivery, happy client!',
    18, 2, 165, 2, 0, 0)

add('BTS', 'Tim produksi Oke Mebel',
    'Kenalan sama tim produksi Oke Mebel',
    'HOOK:\nDi balik furniture keren kamu, ada tim produksi yang kerja keras\n\nBODY:\nTim produksi Oke Mebel terdiri dari tukang-tukang berpengalaman yang udah bertahun-tahun di bidang furniture. Mereka gak cuma jago bikin, tapi juga paham soal material dan finishing. Tiap orang punya keahlian spesifik yang bikin hasil kerja makin maksimal.\n\nCLOSING:\nBehind every great furniture, there is a great team!',
    18, 3, 148, 2, 0, 0)


# ============================================================
# 22. PRODUCT HIGHLIGHT — OKE MEBEL (6 entries)
# ============================================================

add('Product Highlight', 'HPL vs Duco finish',
    'HPL atau Duco? Mana yang lebih cocok buat furniture kamu?',
    'HOOK:\nHPL vs Duco, kamu harus tau bedanya sebelum bikin furniture!\n\nBODY:\nHPL (High Pressure Laminate):\n+ Tahan gores dan air\n+ Banyak pilihan motif\n+ Harga lebih terjangkau\n+ Low maintenance\n\nDuco:\n+ Tampilan mewah dan glossy\n+ Warna bisa custom\n- Lebih mahal\n- Perlu perawatan ekstra\n\nCLOSING:\nKamu tim HPL atau tim Duco?',
    18, 4, 108, 3, 2, 0)

add('Product Highlight', 'Engsel soft close',
    'Furniture premium pake engsel soft close, apa bedanya?',
    'HOOK:\nPernah kesel pintu lemari ditutup bunyi BRAK?\n\nBODY:\nDi Oke Mebel, kita pake engsel soft close buat semua furniture. Pintu lemari nutup pelan dan halus tanpa bunyi. Selain lebih nyaman, juga bikin furniture lebih awet karena gak ada impact keras tiap kali nutup pintu.\n\nCLOSING:\nDetail kecil tapi bikin perbedaan besar!',
    18, 3, 82, 3, 0, 0)

add('Product Highlight', 'Kitchen set anti rayap',
    'Kitchen set Oke Mebel anti rayap!',
    'HOOK:\nTakut furniture dimakan rayap?\n\nBODY:\nKitchen set Oke Mebel menggunakan material yang sudah ditreatment anti rayap. Multiplex yang kita pakai udah melewati proses treatment khusus jadi lebih tahan terhadap serangan rayap dan jamur. Plus, finishing HPL yang menutupi semua permukaan bikin material di dalamnya terlindungi.\n\nCLOSING:\nAnti rayap, anti worry!',
    18, 4, 175, 2, 1, 0)

add('Product Highlight', 'Meja lipat multifungsi',
    'Meja lipat custom buat ruangan kecil',
    'HOOK:\nRuangan kecil butuh furniture yang multifungsi\n\nBODY:\nMeja lipat custom ini bisa dilipat ke dinding kalau gak dipake. Hemat ruang banget buat apartment atau kos-kosan. Kuat buat laptop, buku, atau makan. Desainnya clean dan gak norak. Bisa custom ukuran sesuai kebutuhan.\n\nCLOSING:\nSmall space, big solution!',
    18, 5, 65, 2, 1, 0)

add('Product Highlight', 'Vanity custom kamar mandi',
    'Vanity kamar mandi custom yang cantik dan fungsional',
    'HOOK:\n\n\nBODY:\nVanity kamar mandi custom dari Oke Mebel. Material tahan air, finishing anti lembab, dan desain yang disesuaikan sama ukuran kamar mandi kamu. Ada tempat wastafel, mirror cabinet, dan storage buat toiletries.\n\nCLOSING:\nKamar mandi cantik dimulai dari vanity yang tepat!',
    18, 3, 195, 2, 0, 0)

add('Product Highlight', 'Backdrop TV custom',
    'Backdrop TV yang bikin ruang tamu makin mewah',
    'HOOK:\nRuang tamu kamu masih polos tanpa backdrop TV?\n\nBODY:\nBackdrop TV custom ini kita desain dengan panel kayu dan LED backlight. Hasilnya ruang tamu jadi lebih mewah dan punya focal point yang keren. Ada built-in storage buat sembunyiin kabel dan perangkat. Material multiplex premium dengan finishing HPL motif kayu.\n\nCLOSING:\nUpgrade ruang tamu kamu sekarang!',
    18, 5, 72, 3, 0, 0)


# ============================================================
# 23. ENGAGEMENT — OKE MEBEL (6 entries)
# ============================================================

add('Engagement', 'Pilih warna kitchen set',
    'Kalau kamu bisa custom warna kitchen set, pilih yang mana?',
    'HOOK:\nMau bikin kitchen set, pilih warna yang mana nih?\n\nBODY:\nA. Putih klasik - clean dan timeless\nB. Abu-abu modern - sleek dan elegan\nC. Motif kayu natural - hangat dan cozy\nD. Hitam bold - berani dan premium\n\nCLOSING:\nKomen pilihan kamu!',
    18, 3, 110, 3, 5, 0)

add('Engagement', 'Tebak harga furniture',
    'Tebak berapa harga furniture custom ini!',
    'HOOK:\nMain game yuk! Tebak harga furniture ini\n\nBODY:\nLihat kitchen set custom ini:\n- Panjang 3 meter\n- Material multiplex\n- Finishing HPL\n- Include island\n\nTebak harganya berapa? Yang paling deket dapet voucher diskon!\n\nCLOSING:\nTulis tebakan kamu di komentar!',
    18, 2, 95, 3, 4, 0)

add('Engagement', 'Before after ruangan',
    'Before vs After ruangan yang di-furnish Oke Mebel',
    'HOOK:\nBefore after yang satisfying banget!\n\nBODY:\nRuangan kosong yang tadinya biasa aja, sekarang jadi aesthetic dan fungsional setelah di-furnish Oke Mebel. Dari kitchen set, lemari, sampai rak TV semua matching dan harmonis.\n\nCLOSING:\nMau ruangan kamu jadi kayak gini? DM kita!',
    18, 4, 55, 2, 1, 0)

add('Engagement', 'Cerita pengalaman beli furniture',
    'Share pengalaman kamu beli furniture!',
    'HOOK:\nPernah punya pengalaman buruk beli furniture?\n\nBODY:\nBanyak yang cerita:\n- Beli online ternyata beda sama gambar\n- Ukurannya gak pas sama ruangan\n- Baru setahun udah rusak\n- Finishing berantakan\n\nNah makanya furniture custom itu worth it karena kamu bisa tentuin semuanya sesuai keinginan.\n\nCLOSING:\nShare pengalaman kamu di komentar!',
    18, 3, 180, 3, 3, 0)

add('Engagement', 'Desain favorit 2025',
    'Trend desain furniture 2025, kamu suka yang mana?',
    'HOOK:\nIni trend desain furniture 2025, kamu suka yang mana?\n\nBODY:\nA. Minimalis Japandi - simpel dan fungsional\nB. Industrial - raw dan maskulin\nC. Scandinavian - clean dan cozy\nD. Modern luxury - mewah dan elegan\n\nCLOSING:\nKomen jawaban kamu dan tag temen yang lagi mau bikin furniture!',
    18, 5, 88, 3, 3, 1)

add('Engagement', 'Spot favorit di rumah',
    'Spot favorit kamu di rumah yang mana?',
    'HOOK:\nKalau di rumah, kamu paling sering di ruangan mana?\n\nBODY:\nA. Dapur - chef rumahan sejati\nB. Kamar tidur - rebahan is life\nC. Ruang kerja - hustle mode on\nD. Ruang TV - binge watching\n\nRuangan favorit = ruangan yang harus dibikin senyaman mungkin!\n\nCLOSING:\nKomen jawaban kamu!',
    18, 2, 135, 4, 4, 0)


# ============================================================
# ADDITIONAL MIXED ENTRIES (12 entries for more variety)
# ============================================================

add('Edukasi', 'Perbedaan kaca single vs double vs triple',
    'Single glass, double glass, triple glass - apa bedanya?',
    'HOOK:\nMasih pake kaca single? Pantesan berisik!\n\nBODY:\nSingle glass: 1 lapis kaca, hampir gak ada kemampuan redam suara\nDouble glass: 2 lapis kaca dengan rongga udara, reduksi 25-30 dB\nTriple glass: 3 lapis kaca dengan gas argon, reduksi 35-40 dB\n\nSemakin banyak lapis, semakin kedap. Triple glass juga lebih hemat energi.\n\nCLOSING:\nUpgrade kaca jendela kamu sekarang!',
    18, 4, 155, 4, 1, 0)

add('Tips & How-To', 'Tips akustik ruang kelas',
    'Guru-guru harus tau ini biar murid lebih fokus',
    'HOOK:\nGuru sering harus teriak di kelas? Mungkin masalahnya bukan di muridnya\n\nBODY:\nRuang kelas yang akustiknya buruk bikin guru harus angkat suara dan murid susah fokus. Tips treatment simpel buat ruang kelas:\n1. Karpet di lantai\n2. Gorden tebal di jendela\n3. Cork board di dinding belakang\n4. Acoustic ceiling tiles\n\nCLOSING:\nTag guru yang kamu kenal!',
    18, 3, 198, 3, 1, 0)

add('Social Proof', 'Client repeat order',
    'Client ini udah 3x order treatment ke Acoustica',
    'HOOK:\nKalau udah cocok, pasti balik lagi!\n\nBODY:\nClient ini pertama kali order treatment kamar tidur. Hasilnya bagus, dia order lagi buat ruang kerja. Sekarang dia order lagi buat ruang tamu. Total udah 3 project dan dia bilang gak mau cari vendor lain lagi.\n\nCLOSING:\nRepeat customer = bukti kualitas!',
    18, 3, 105, 4, 0, 0)

add('Infographics', 'Perbandingan jenis pintu',
    'Pintu hollow vs solid core vs pintu peredam',
    'HOOK:\nPintu kamu jenis yang mana?\n\nBODY:\nPintu Hollow Core: murah, ringan, TAPI suara tembus gampang (STC 15-20)\nPintu Solid Core: lebih berat, lebih kedap (STC 25-30)\nPintu Peredam: khusus akustik, paling kedap (STC 35-45)\n\nPilih sesuai kebutuhan dan budget kamu.\n\nCLOSING:\nMau upgrade pintu? Konsultasi sama kita!',
    18, 4, 168, 4, 0, 1)

add('Project Launch', 'Project villa di Bali',
    'Dewata Swara mulai project villa di Ubud',
    'HOOK:\nProject baru Dewata Swara di Bali! Villa di Ubud yang mau dibikin super kedap\n\nBODY:\nVilla ini letaknya di area yang cukup ramai turis. Pemiliknya mau ruangan-ruangannya kedap biar tamu bisa istirahat dengan tenang. Kita bakal treatment bedroom dan living area. Material lokal yang berkualitas bakal kita pake sebisa mungkin.\n\nCLOSING:\nStay tuned buat update progressnya!',
    18, 4, 142, 2, 1, 0)

add('Questions & FAQs', 'Treatment bisa dicabut gak',
    'FAQ: Treatment soundproofing bisa dibongkar gak?',
    'HOOK:\nNgontrak tapi mau treatment kedap suara, bisa gak ya?\n\nBODY:\nBISA! Ada metode treatment non-permanen:\n- Panel akustik yang ditempel pakai velcro\n- Portable bass trap\n- Heavy curtains\n- Removable door sweep\n\nSemua bisa dipasang dan dicabut tanpa merusak dinding. Cocok buat yang ngontrak.\n\nCLOSING:\nSekarang ngontrak bukan alasan buat gak treatment!',
    18, 5, 108, 3, 2, 0)

add('Showcased Solutions', 'Solusi coworking space',
    'Treatment akustik coworking space yang bikin betah',
    'HOOK:\nCoworking space yang berisik bikin member kabur\n\nBODY:\nCoworking space ini punya masalah: member sering complaint soal kebisingan. Setelah kita treatment dengan panel akustik di ceiling dan partisi, plus bikin beberapa phone booth kedap, member-nya jadi lebih betah. Bahkan member baru bertambah karena denger soal kenyamanan akustiknya.\n\nCLOSING:\nInvestasi di akustik = investasi di member satisfaction!',
    18, 3, 170, 3, 0, 0)

add('Facts & Myths', 'Ruangan kecil lebih mudah dikedapin',
    'Ruangan kecil lebih gampang dikedapin, mitos atau fakta?',
    'HOOK:\nKatanya ruangan kecil lebih gampang dibikin kedap, bener gak?\n\nBODY:\nFAKTA! Ruangan kecil memang relatif lebih mudah dan murah untuk ditreatment karena area permukaan yang perlu dicover lebih sedikit. Tapi tantangannya, ruangan kecil juga lebih rentan masalah bass buildup dan standing waves. Jadi tetap butuh treatment yang tepat.\n\nCLOSING:\nKecil bukan berarti gampang ya!',
    18, 3, 135, 3, 0, 0)

add('Product Highlight', 'Exhaust fan dapur',
    'Exhaust fan buat dapur yang pengap',
    'HOOK:\nDapur pengap dan bau masakan nempel kemana-mana?\n\nBODY:\nExhaust fan solusinya! Kita bisa pasang exhaust fan yang sesuai dengan ukuran dapur kamu. Udara pengap dan bau masakan langsung keluar. Dapur jadi segar dan nyaman buat masak lama-lama.\n\nCLOSING:\nDapur nyaman = masak jadi semangat!',
    18, 3, 152, 2, 1, 0)

add('BTS', 'Proses survey lokasi',
    'BTS: proses survey sebelum mulai project',
    'HOOK:\nSebelum mulai project, kita selalu survey dulu ke lokasi\n\nBODY:\nProses survey meliputi:\n- Ukur dimensi ruangan\n- Identifikasi sumber kebisingan\n- Cek kondisi dinding, lantai, dan ceiling\n- Ukur level kebisingan existing\n- Diskusi kebutuhan sama client\n\nHasil survey ini jadi dasar buat bikin desain treatment yang tepat.\n\nCLOSING:\nSurvey yang teliti = hasil yang maksimal!',
    18, 2, 205, 2, 0, 0)

add('Cinematic', 'Transformasi ruangan 60 detik',
    '60 detik transformasi ruangan kosong jadi studio',
    'HOOK:\nDari kosong melompong jadi studio impian dalam 60 detik!\n\nBODY:\nTime-lapse transformasi ruangan kosong jadi studio musik yang fully treated. Dari nol sampai jadi dengan semua treatment terpasang. Satisfying banget lihat prosesnya.\n\nCLOSING:\nSatisfying gak? Double tap kalau suka!',
    18, 4, 78, 3, 1, 0)

add('Engagement', 'Rate setup studio kita',
    'Rate setup studio ini 1-10!',
    'HOOK:\nRate studio ini dari 1 sampai 10!\n\nBODY:\nStudio musik ini baru aja selesai kita kerjain:\n- Full soundproofing\n- Panel akustik premium\n- LED ambient lighting\n- Wall panel motif kayu\n- Pintu peredam custom\n\nMenurut kamu worth it gak?\n\nCLOSING:\nTulis rating kamu di komentar!',
    18, 5, 62, 3, 3, 0)


# ============================================================
# CREATE COMBINED DATASET
# ============================================================

print(f"Jumlah data sintetis: {len(entries)}")

# Hitung distribusi label sintetis
high_count = sum(1 for e in entries if e['label'] == 'HIGH')
low_count = sum(1 for e in entries if e['label'] == 'LOW')
print(f"Distribusi sintetis - HIGH: {high_count}, LOW: {low_count}")

# Buat DataFrame sintetis
df_synthetic = pd.DataFrame(entries)

# Baca dataset asli
original_path = os.path.join(os.path.dirname(__file__), "dataset_ml (7).csv")
df_original = pd.read_csv(original_path)
df_original = df_original.dropna()

print(f"Jumlah data asli (setelah dropna): {len(df_original)}")

# Gabungkan
df_combined = pd.concat([df_original, df_synthetic], ignore_index=True)

# Shuffle agar data asli dan sintetis tercampur
df_combined = df_combined.sample(frac=1, random_state=42).reset_index(drop=True)

print(f"\nTotal data gabungan: {len(df_combined)}")
print(f"\nDistribusi Label Gabungan:")
print(df_combined['label'].value_counts())
print(f"\nDistribusi Pillar:")
print(df_combined['pillar'].value_counts())

# Simpan
output_path = os.path.join(os.path.dirname(__file__), "dataset_ml_augmented.csv")
df_combined.to_csv(output_path, index=False)
print(f"\n✅ Dataset augmented berhasil disimpan ke: {output_path}")
