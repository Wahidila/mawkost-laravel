<?php

namespace Database\Seeders;

use App\Models\Article;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        $articles = [
            [
                'title' => 'Tips Memilih Kost untuk Mahasiswa Baru',
                'slug' => 'tips-memilih-kost-untuk-mahasiswa-baru',
                'excerpt' => 'Panduan lengkap memilih kost yang tepat untuk mahasiswa baru. Dari lokasi, harga, fasilitas, hingga keamanan lingkungan.',
                'author' => 'Tim Mawkost',
                'meta_description' => 'Tips dan panduan memilih kost terbaik untuk mahasiswa baru. Pertimbangkan lokasi, harga, fasilitas, dan keamanan.',
                'content' => '<h2>Kenapa Memilih Kost Itu Penting?</h2>
<p>Bagi mahasiswa baru, kost bukan sekadar tempat tidur. Ini adalah rumah kedua yang akan menemani perjalanan kuliahmu selama bertahun-tahun. Memilih kost yang tepat bisa mempengaruhi produktivitas belajar, kesehatan mental, dan bahkan prestasi akademikmu.</p>

<h2>1. Lokasi adalah Segalanya</h2>
<p>Prioritaskan kost yang dekat dengan kampus. Idealnya dalam radius <strong>500 meter hingga 2 km</strong> dari gerbang utama kampus. Pertimbangkan juga:</p>
<ul>
<li>Akses ke minimarket dan warung makan</li>
<li>Jalur angkutan umum</li>
<li>Jarak ke fasilitas kesehatan (klinik/apotek)</li>
<li>Keamanan lingkungan sekitar</li>
</ul>

<h2>2. Sesuaikan dengan Budget</h2>
<p>Jangan memaksakan diri mengambil kost mahal. Aturan umumnya, biaya kost sebaiknya <strong>tidak lebih dari 30%</strong> dari total uang bulananmu. Bandingkan harga di beberapa platform seperti mawkost untuk mendapatkan harga terbaik.</p>

<blockquote>Tips: Di mawkost, harga yang ditampilkan adalah harga langsung dari pemilik kost tanpa markup agen. Jadi kamu bisa yakin mendapat harga terbaik.</blockquote>

<h2>3. Cek Fasilitas Penting</h2>
<p>Fasilitas minimum yang sebaiknya ada:</p>
<ul>
<li><strong>WiFi</strong> — wajib untuk kuliah online dan tugas</li>
<li><strong>Kamar mandi dalam</strong> — lebih nyaman dan higienis</li>
<li><strong>Kasur dan lemari</strong> — hemat biaya beli furniture</li>
<li><strong>Parkir</strong> — jika kamu bawa kendaraan</li>
</ul>

<h2>4. Survey Langsung Sebelum Deal</h2>
<p>Jangan pernah bayar DP tanpa melihat langsung kondisi kost. Foto bisa menipu! Datangi langsung, cek kebersihan, kondisi kamar mandi, dan tanya tetangga kost tentang pengalaman mereka.</p>

<h2>5. Gunakan Platform Terpercaya</h2>
<p>Hindari calo kost di grup WhatsApp atau Facebook yang tidak jelas. Gunakan platform seperti <strong>mawkost</strong> yang sudah memverifikasi setiap listing dan menampilkan foto asli dari pemilik kost.</p>',
            ],
            [
                'title' => 'Checklist Sebelum Sewa Kost: Jangan Sampai Tertipu!',
                'slug' => 'checklist-sebelum-sewa-kost',
                'excerpt' => 'Daftar lengkap yang harus kamu periksa sebelum memutuskan sewa kost. Dari kontrak, fasilitas, hingga aturan kost.',
                'author' => 'Tim Mawkost',
                'meta_description' => 'Checklist lengkap sebelum sewa kost agar tidak tertipu. Periksa kontrak, fasilitas, aturan, dan kondisi lingkungan.',
                'content' => '<h2>Jangan Buru-buru Bayar DP!</h2>
<p>Banyak mahasiswa yang terburu-buru membayar DP kost karena takut kehabisan. Padahal, ada banyak hal yang perlu dicek terlebih dahulu. Berikut checklist lengkapnya:</p>

<h2>Checklist Kondisi Fisik</h2>
<ul>
<li>✅ Cek kondisi dinding — ada rembes atau lembab?</li>
<li>✅ Cek ventilasi dan jendela — bisa dibuka? Ada nyamuk?</li>
<li>✅ Cek kamar mandi — air lancar? Bersih? Ada water heater?</li>
<li>✅ Cek instalasi listrik — stop kontak cukup? Aman?</li>
<li>✅ Cek pintu dan kunci — aman? Ada kunci ganda?</li>
<li>✅ Cek sinyal HP dan WiFi — test langsung di kamar</li>
</ul>

<h2>Checklist Kontrak & Aturan</h2>
<ul>
<li>✅ Baca kontrak sewa dengan teliti</li>
<li>✅ Tanya aturan jam malam (jika ada)</li>
<li>✅ Tanya aturan tamu — boleh bawa teman?</li>
<li>✅ Tanya biaya tambahan — listrik, air, sampah</li>
<li>✅ Tanya kebijakan refund DP jika batal</li>
<li>✅ Minta kwitansi/bukti pembayaran resmi</li>
</ul>

<h2>Checklist Lingkungan</h2>
<ul>
<li>✅ Cek keamanan — ada CCTV? Satpam?</li>
<li>✅ Cek parkir — aman? Tertutup?</li>
<li>✅ Tanya tetangga kost — pengalaman mereka?</li>
<li>✅ Cek akses jalan — banjir saat hujan?</li>
</ul>

<blockquote>Pro tip: Datangi kost di malam hari untuk merasakan suasana sebenarnya. Kost yang siang hari terlihat tenang bisa jadi sangat berisik di malam hari.</blockquote>',
            ],
            [
                'title' => 'Area Kost Terbaik di Malang untuk Mahasiswa',
                'slug' => 'area-kost-terbaik-di-malang',
                'excerpt' => 'Rekomendasi area kost strategis di Malang dekat kampus UB, UM, Polinema, dan UIN. Lengkap dengan kisaran harga.',
                'author' => 'Tim Mawkost',
                'meta_description' => 'Daftar area kost terbaik di Malang untuk mahasiswa. Dekat UB, UM, Polinema dengan harga mulai 500rb/bulan.',
                'content' => '<h2>Malang: Surga Kost Mahasiswa</h2>
<p>Malang dikenal sebagai kota pelajar dengan puluhan kampus dan ribuan pilihan kost. Tapi tidak semua area sama strategisnya. Berikut rekomendasi area terbaik berdasarkan kampus:</p>

<h2>1. Area Soekarno-Hatta (Suhat)</h2>
<p>Area paling populer untuk mahasiswa <strong>Universitas Brawijaya (UB)</strong>. Keunggulan:</p>
<ul>
<li>Jarak 500m - 1km ke gerbang UB</li>
<li>Banyak warung makan murah</li>
<li>Dekat Malang Town Square (Matos)</li>
<li>Harga kost: <strong>Rp 600.000 - Rp 1.500.000/bulan</strong></li>
</ul>

<h2>2. Area Lowokwaru</h2>
<p>Cocok untuk mahasiswa <strong>UB dan UM</strong>. Lebih tenang dari Suhat:</p>
<ul>
<li>Lingkungan lebih tenang dan asri</li>
<li>Harga lebih terjangkau</li>
<li>Akses mudah ke dua kampus</li>
<li>Harga kost: <strong>Rp 500.000 - Rp 1.200.000/bulan</strong></li>
</ul>

<h2>3. Area Dinoyo</h2>
<p>Strategis untuk mahasiswa <strong>UM (Universitas Negeri Malang)</strong>:</p>
<ul>
<li>Sangat dekat dengan kampus UM</li>
<li>Banyak tempat makan dan fotokopi</li>
<li>Akses angkot mudah</li>
<li>Harga kost: <strong>Rp 500.000 - Rp 1.000.000/bulan</strong></li>
</ul>

<h2>4. Area Jalan Veteran</h2>
<p>Pilihan untuk mahasiswa <strong>Polinema</strong>:</p>
<ul>
<li>Dekat Politeknik Negeri Malang</li>
<li>Area ramai dan aman</li>
<li>Banyak minimarket</li>
<li>Harga kost: <strong>Rp 450.000 - Rp 900.000/bulan</strong></li>
</ul>

<blockquote>Cari kost di area-area ini? Langsung cek di mawkost! Semua listing sudah terverifikasi dan harga transparan langsung dari pemilik.</blockquote>',
            ],
            [
                'title' => 'Cara Menghemat Biaya Hidup di Kost',
                'slug' => 'cara-menghemat-biaya-hidup-di-kost',
                'excerpt' => 'Tips praktis menghemat pengeluaran bulanan saat tinggal di kost. Dari listrik, makan, hingga laundry.',
                'author' => 'Tim Mawkost',
                'meta_description' => 'Tips hemat biaya hidup di kost untuk mahasiswa. Hemat listrik, makan, laundry, dan pengeluaran bulanan lainnya.',
                'content' => '<h2>Hidup Hemat Bukan Berarti Hidup Susah</h2>
<p>Tinggal di kost dengan budget terbatas bukan berarti kamu harus menderita. Dengan strategi yang tepat, kamu bisa hidup nyaman tanpa menguras dompet.</p>

<h2>1. Hemat Listrik</h2>
<ul>
<li>Matikan AC saat keluar kamar — gunakan timer</li>
<li>Cabut charger yang tidak dipakai</li>
<li>Gunakan lampu LED hemat energi</li>
<li>Manfaatkan cahaya alami di siang hari</li>
</ul>

<h2>2. Hemat Makan</h2>
<ul>
<li>Masak sendiri — investasi rice cooker mini</li>
<li>Beli lauk di warung, masak nasi sendiri</li>
<li>Manfaatkan promo GoFood/GrabFood</li>
<li>Beli kebutuhan pokok di pasar tradisional</li>
</ul>

<h2>3. Hemat Laundry</h2>
<ul>
<li>Cuci pakaian sendiri untuk baju sehari-hari</li>
<li>Laundry kiloan hanya untuk sprei dan selimut</li>
<li>Cari laundry yang bisa langganan bulanan</li>
</ul>

<h2>4. Hemat Transportasi</h2>
<ul>
<li>Pilih kost dekat kampus — bisa jalan kaki</li>
<li>Gunakan sepeda</li>
<li>Nebeng teman yang searah</li>
</ul>

<blockquote>Budget kost juga bisa dihemat! Di mawkost, harga kost langsung dari pemilik tanpa markup agen. Bandingkan harga sebelum memutuskan.</blockquote>',
            ],
            [
                'title' => 'Perbedaan Kost Putra, Putri, dan Campur: Mana yang Cocok?',
                'slug' => 'perbedaan-kost-putra-putri-campur',
                'excerpt' => 'Memahami perbedaan tipe kost putra, putri, dan campur. Kelebihan, kekurangan, dan tips memilih yang tepat.',
                'author' => 'Tim Mawkost',
                'meta_description' => 'Perbedaan kost putra, putri, dan campur. Kelebihan dan kekurangan masing-masing tipe kost untuk mahasiswa.',
                'content' => '<h2>Tipe Kost: Bukan Sekadar Label</h2>
<p>Saat mencari kost, kamu pasti menemukan tiga tipe utama: <strong>Kost Putra</strong>, <strong>Kost Putri</strong>, dan <strong>Kost Campur</strong>. Masing-masing punya karakteristik berbeda.</p>

<h2>Kost Putri</h2>
<p><strong>Kelebihan:</strong></p>
<ul>
<li>Lingkungan lebih aman dan terjaga</li>
<li>Biasanya lebih bersih dan terawat</li>
<li>Aturan jam malam ketat — orang tua lebih tenang</li>
<li>Fasilitas cenderung lebih lengkap</li>
</ul>
<p><strong>Kekurangan:</strong></p>
<ul>
<li>Harga biasanya lebih mahal</li>
<li>Aturan lebih ketat (jam malam, tamu)</li>
</ul>

<h2>Kost Putra</h2>
<p><strong>Kelebihan:</strong></p>
<ul>
<li>Harga cenderung lebih murah</li>
<li>Aturan lebih fleksibel</li>
<li>Bebas jam malam</li>
</ul>
<p><strong>Kekurangan:</strong></p>
<ul>
<li>Kebersihan tergantung penghuni</li>
<li>Bisa lebih berisik</li>
</ul>

<h2>Kost Campur</h2>
<p><strong>Kelebihan:</strong></p>
<ul>
<li>Pilihan lebih banyak</li>
<li>Harga bervariasi</li>
<li>Cocok untuk pasangan yang sudah menikah</li>
</ul>
<p><strong>Kekurangan:</strong></p>
<ul>
<li>Privasi kurang terjaga</li>
<li>Orang tua mungkin kurang setuju</li>
</ul>

<blockquote>Di mawkost, kamu bisa filter pencarian berdasarkan tipe kost. Cari yang sesuai preferensimu dengan mudah!</blockquote>',
            ],
            [
                'title' => 'Kost vs Apartemen: Mana yang Lebih Worth It untuk Mahasiswa?',
                'slug' => 'kost-vs-apartemen-mana-lebih-worth-it',
                'excerpt' => 'Perbandingan lengkap antara tinggal di kost dan apartemen untuk mahasiswa. Dari segi harga, fasilitas, dan kenyamanan.',
                'author' => 'Tim Mawkost',
                'meta_description' => 'Perbandingan kost vs apartemen untuk mahasiswa. Analisis harga, fasilitas, kenyamanan, dan mana yang lebih hemat.',
                'content' => '<h2>Dilema Klasik Anak Rantau</h2>
<p>Saat mencari tempat tinggal, mahasiswa sering bingung antara kost dan apartemen. Keduanya punya kelebihan masing-masing. Mari kita bandingkan secara objektif.</p>

<h2>Perbandingan Harga</h2>
<p><strong>Kost:</strong> Rp 500.000 - Rp 2.000.000/bulan (sudah termasuk listrik, air, WiFi di banyak tempat)</p>
<p><strong>Apartemen:</strong> Rp 2.000.000 - Rp 5.000.000/bulan (belum termasuk maintenance fee, listrik, air)</p>

<h2>Perbandingan Fasilitas</h2>
<ul>
<li><strong>Kost:</strong> Kamar tidur, kamar mandi (dalam/luar), WiFi, parkir. Beberapa ada dapur bersama.</li>
<li><strong>Apartemen:</strong> Kamar tidur, kamar mandi, dapur, ruang tamu, balkon. Fasilitas gedung: gym, kolam renang, minimarket.</li>
</ul>

<h2>Kesimpulan</h2>
<p>Untuk mahasiswa dengan budget terbatas, <strong>kost tetap menjadi pilihan terbaik</strong>. Hemat biaya, lokasi strategis dekat kampus, dan tidak perlu repot urusan maintenance.</p>

<blockquote>Cari kost terbaik dengan harga transparan di mawkost. Tanpa markup, langsung dari pemilik!</blockquote>',
            ],
            [
                'title' => 'Panduan Lengkap Pindah Kost: Dari Packing Sampai Adaptasi',
                'slug' => 'panduan-lengkap-pindah-kost',
                'excerpt' => 'Panduan step-by-step pindah kost untuk mahasiswa. Tips packing efisien, adaptasi lingkungan baru, dan hal yang sering dilupakan.',
                'author' => 'Tim Mawkost',
                'meta_description' => 'Panduan lengkap pindah kost untuk mahasiswa. Tips packing, checklist barang, dan cara adaptasi di lingkungan baru.',
                'content' => '<h2>Pindah Kost Tidak Harus Ribet</h2>
<p>Pindah kost bisa jadi pengalaman yang menegangkan, terutama jika ini pertama kalinya. Tapi dengan persiapan yang tepat, prosesnya bisa lancar dan menyenangkan.</p>

<h2>Checklist Barang Wajib Bawa</h2>
<ul>
<li>Dokumen penting (KTP, KTM, surat keterangan)</li>
<li>Perlengkapan tidur (bantal, selimut, sprei)</li>
<li>Perlengkapan mandi</li>
<li>Peralatan masak sederhana (jika ada dapur)</li>
<li>Obat-obatan pribadi dan P3K</li>
<li>Charger dan kabel data</li>
<li>Gembok cadangan</li>
</ul>

<h2>Tips Packing Efisien</h2>
<ul>
<li>Gunakan kardus bekas — minta di minimarket</li>
<li>Label setiap kardus dengan isinya</li>
<li>Bawa barang berharga di tas pribadi, bukan di kardus</li>
<li>Foto kondisi kamar lama sebelum pindah (untuk klaim deposit)</li>
</ul>

<h2>Adaptasi di Kost Baru</h2>
<p>Minggu pertama adalah masa kritis. Kenalan dengan tetangga kost, hafal rute ke kampus, dan cari warung makan terdekat. Jangan sungkan bertanya ke pemilik kost tentang aturan dan fasilitas.</p>',
            ],
            [
                'title' => 'Hak dan Kewajiban Penghuni Kost yang Wajib Kamu Tahu',
                'slug' => 'hak-dan-kewajiban-penghuni-kost',
                'excerpt' => 'Ketahui hak dan kewajibanmu sebagai penghuni kost. Dari privasi, keamanan, hingga aturan yang sering dilanggar.',
                'author' => 'Tim Mawkost',
                'meta_description' => 'Hak dan kewajiban penghuni kost yang wajib diketahui. Privasi, keamanan, pembayaran, dan aturan tinggal di kost.',
                'content' => '<h2>Tahu Hakmu, Patuhi Kewajibanmu</h2>
<p>Banyak penghuni kost yang tidak tahu hak-haknya, dan banyak juga yang melanggar kewajibannya. Memahami keduanya akan membuat pengalaman ngekost lebih nyaman.</p>

<h2>Hak Penghuni Kost</h2>
<ul>
<li><strong>Privasi</strong> — Pemilik kost tidak boleh masuk kamar tanpa izin</li>
<li><strong>Keamanan</strong> — Kost harus menyediakan kunci yang layak</li>
<li><strong>Fasilitas sesuai janji</strong> — WiFi, air, listrik harus sesuai yang dijanjikan</li>
<li><strong>Kwitansi pembayaran</strong> — Berhak mendapat bukti bayar</li>
<li><strong>Pemberitahuan kenaikan harga</strong> — Minimal 1 bulan sebelumnya</li>
</ul>

<h2>Kewajiban Penghuni Kost</h2>
<ul>
<li><strong>Bayar tepat waktu</strong> — Jangan nunggak!</li>
<li><strong>Jaga kebersihan</strong> — Kamar dan area bersama</li>
<li><strong>Patuhi aturan</strong> — Jam malam, tamu, kebisingan</li>
<li><strong>Lapor kerusakan</strong> — Jangan diamkan, lapor ke pemilik</li>
<li><strong>Jaga hubungan baik</strong> — Dengan sesama penghuni dan pemilik</li>
</ul>

<blockquote>Kost yang baik adalah kost yang saling menghormati antara penghuni dan pemilik. Cari kost dengan pemilik terpercaya di mawkost!</blockquote>',
            ],
            [
                'title' => 'Dekorasi Kamar Kost Aesthetic dengan Budget Minim',
                'slug' => 'dekorasi-kamar-kost-aesthetic-budget-minim',
                'excerpt' => 'Ide dekorasi kamar kost aesthetic tanpa harus mahal. DIY, thrifting, dan tips menata kamar kost kecil agar terlihat luas.',
                'author' => 'Tim Mawkost',
                'meta_description' => 'Ide dekorasi kamar kost aesthetic dengan budget minim. Tips DIY, thrifting, dan menata kamar kost kecil agar luas.',
                'content' => '<h2>Kamar Kost Aesthetic Tanpa Bikin Kantong Jebol</h2>
<p>Siapa bilang kamar kost harus membosankan? Dengan kreativitas dan budget minim, kamu bisa mengubah kamar kost jadi tempat yang nyaman dan Instagram-worthy.</p>

<h2>1. Pencahayaan adalah Kunci</h2>
<ul>
<li>Tambahkan lampu tumblr/fairy lights — Rp 15.000-30.000</li>
<li>Lampu meja LED warm white — Rp 50.000</li>
<li>Hindari lampu neon putih terang — bikin kamar terasa dingin</li>
</ul>

<h2>2. Dinding Tidak Harus Polos</h2>
<ul>
<li>Poster atau printout foto — cetak di percetakan digital murah</li>
<li>Washi tape untuk frame tanpa paku</li>
<li>Tanaman gantung artifisial — Rp 20.000-40.000</li>
</ul>

<h2>3. Organisasi = Aesthetic</h2>
<ul>
<li>Rak gantung dari tali dan kayu — DIY Rp 30.000</li>
<li>Kotak penyimpanan dari kardus dilapisi kain</li>
<li>Gantungan baju di balik pintu</li>
</ul>

<h2>4. Tekstil yang Mengubah Suasana</h2>
<ul>
<li>Sprei dan sarung bantal motif — Rp 50.000-100.000</li>
<li>Karpet kecil di samping kasur</li>
<li>Tirai tipis untuk jendela</li>
</ul>

<blockquote>Total budget dekorasi: Rp 100.000 - 300.000 sudah bisa mengubah kamar kost jadi cozy dan aesthetic!</blockquote>',
            ],
            [
                'title' => 'Keamanan di Kost: Tips Agar Barang Tidak Hilang',
                'slug' => 'keamanan-di-kost-tips-barang-tidak-hilang',
                'excerpt' => 'Tips menjaga keamanan barang di kost. Dari kunci ganda, CCTV, hingga kebiasaan sehari-hari yang sering diabaikan.',
                'author' => 'Tim Mawkost',
                'meta_description' => 'Tips keamanan di kost agar barang tidak hilang. Kunci ganda, CCTV, asuransi, dan kebiasaan aman sehari-hari.',
                'content' => '<h2>Pencurian di Kost: Lebih Sering dari yang Kamu Kira</h2>
<p>Kasus kehilangan barang di kost cukup sering terjadi, terutama di kost yang keamanannya kurang. Berikut tips agar barangmu tetap aman.</p>

<h2>Pilih Kost dengan Keamanan Baik</h2>
<ul>
<li>Ada CCTV di area parkir dan koridor</li>
<li>Pintu gerbang dengan kunci/akses card</li>
<li>Pemilik kost tinggal di lokasi</li>
<li>Ada satpam atau penjaga malam</li>
</ul>

<h2>Kebiasaan Aman Sehari-hari</h2>
<ul>
<li><strong>Selalu kunci pintu</strong> — bahkan saat ke kamar mandi</li>
<li><strong>Jangan tinggalkan laptop di meja</strong> — simpan di lemari terkunci</li>
<li><strong>Jangan pamer barang mahal</strong> — keep low profile</li>
<li><strong>Kenali tetangga kost</strong> — tahu siapa yang biasa keluar masuk</li>
<li><strong>Catat serial number</strong> — laptop, HP, untuk laporan jika hilang</li>
</ul>

<h2>Investasi Keamanan Murah</h2>
<ul>
<li>Gembok tambahan — Rp 30.000-50.000</li>
<li>Kunci lemari — Rp 20.000</li>
<li>Doorstop alarm — Rp 50.000 (bunyi jika pintu dibuka paksa)</li>
</ul>

<blockquote>Di mawkost, kamu bisa melihat fasilitas keamanan setiap kost sebelum memutuskan. Cek apakah ada CCTV, parkir tertutup, dan penjaga!</blockquote>',
            ],
            [
                'title' => 'Etika Tinggal di Kost: Jangan Jadi Penghuni yang Dibenci',
                'slug' => 'etika-tinggal-di-kost',
                'excerpt' => 'Panduan etika tinggal di kost agar hubungan dengan sesama penghuni dan pemilik kost tetap harmonis.',
                'author' => 'Tim Mawkost',
                'meta_description' => 'Etika tinggal di kost yang wajib diketahui. Jaga kebisingan, kebersihan, dan hubungan baik dengan penghuni lain.',
                'content' => '<h2>Kost Itu Rumah Bersama</h2>
<p>Tinggal di kost berarti berbagi ruang dengan orang lain. Etika yang baik akan membuat pengalaman ngekost lebih menyenangkan untuk semua pihak.</p>

<h2>Aturan Emas Tinggal di Kost</h2>

<h3>1. Jaga Kebisingan</h3>
<ul>
<li>Gunakan headphone saat mendengarkan musik/nonton</li>
<li>Jangan telepon keras-keras di malam hari</li>
<li>Tutup pintu dengan pelan</li>
</ul>

<h3>2. Jaga Kebersihan Area Bersama</h3>
<ul>
<li>Bersihkan dapur setelah masak</li>
<li>Jangan tinggalkan pakaian di jemuran terlalu lama</li>
<li>Buang sampah pada tempatnya</li>
</ul>

<h3>3. Hormati Privasi</h3>
<ul>
<li>Ketuk pintu sebelum masuk kamar orang lain</li>
<li>Jangan gosip tentang penghuni lain</li>
<li>Jangan pakai barang orang tanpa izin</li>
</ul>

<h3>4. Komunikasi yang Baik</h3>
<ul>
<li>Sampaikan keluhan dengan sopan ke pemilik kost</li>
<li>Jika ada masalah dengan tetangga, bicarakan baik-baik</li>
<li>Ikut grup WhatsApp kost jika ada</li>
</ul>

<blockquote>Penghuni kost yang baik akan mendapat perlakuan baik juga. Saling menghormati adalah kunci kenyamanan bersama!</blockquote>',
            ],
        ];

        foreach ($articles as $data) {
            if (Article::where('slug', $data['slug'])->exists()) {
                continue;
            }

            Article::create(array_merge($data, [
                'is_published' => true,
                'published_at' => now()->subDays(rand(1, 30)),
            ]));
        }
    }
}
