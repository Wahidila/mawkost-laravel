<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Facility;
use App\Models\Kost;
use App\Models\KostImage;
use App\Models\NearbyPlace;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Disable FK checks, truncate all tables, re-enable FK checks
        Schema::disableForeignKeyConstraints();
        DB::table('kost_facility')->truncate();
        NearbyPlace::truncate();
        KostImage::truncate();
        Order::truncate();
        Kost::truncate();
        Facility::truncate();
        City::truncate();
        User::truncate();
        Schema::enableForeignKeyConstraints();
        // ── Admin User ──
        User::create([
            'name' => 'Admin Mawkost',
            'email' => 'admin@mawkost.com',
            'role' => 'admin',
            'password' => Hash::make('password'),
        ]);

        // ── Cities ──
        $malang = City::create(['name' => 'Malang', 'slug' => 'malang', 'image' => 'assets/img/city-malang.png', 'kost_count' => 156]);
        $surabaya = City::create(['name' => 'Surabaya', 'slug' => 'surabaya', 'image' => 'assets/img/city-surabaya.png', 'kost_count' => 98]);
        $jogja = City::create(['name' => 'Yogyakarta', 'slug' => 'yogyakarta', 'image' => 'assets/img/city-jogja.png', 'kost_count' => 112]);

        // ── Facilities ──
        $facilities = [];
        $facilityData = [
            ['name' => 'WiFi', 'icon' => 'fa-solid fa-wifi', 'category' => 'kamar'],
            ['name' => 'AC', 'icon' => 'fa-solid fa-snowflake', 'category' => 'kamar'],
            ['name' => 'Kamar Mandi Dalam', 'icon' => 'fa-solid fa-bath', 'category' => 'kamar'],
            ['name' => 'Meja Belajar', 'icon' => 'fa-solid fa-table', 'category' => 'kamar'],
            ['name' => 'Lemari Pakaian', 'icon' => 'fa-solid fa-door-closed', 'category' => 'kamar'],
            ['name' => 'Kasur Springbed', 'icon' => 'fa-solid fa-bed', 'category' => 'kamar'],
            ['name' => 'Air Panas', 'icon' => 'fa-solid fa-hot-tub-person', 'category' => 'kamar'],
            ['name' => 'TV', 'icon' => 'fa-solid fa-tv', 'category' => 'kamar'],
            ['name' => 'Dapur', 'icon' => 'fa-solid fa-kitchen-set', 'category' => 'bersama'],
            ['name' => 'Parkir Motor', 'icon' => 'fa-solid fa-square-parking', 'category' => 'bersama'],
            ['name' => 'CCTV 24 Jam', 'icon' => 'fa-solid fa-video', 'category' => 'bersama'],
            ['name' => 'Ruang Tamu', 'icon' => 'fa-solid fa-couch', 'category' => 'bersama'],
            ['name' => 'Balkon', 'icon' => 'fa-solid fa-umbrella', 'category' => 'bersama'],
        ];
        foreach ($facilityData as $f) {
            $facilities[$f['name']] = Facility::create($f);
        }

        // ══════════════════════════════════════
        // ── Kost 1: Griya Asri Residence ──
        // ══════════════════════════════════════
        $k1 = Kost::create([
            'kode' => 'MK-001', 'name' => 'Kost Griya Asri Residence', 'slug' => 'kost-griya-asri-residence',
            'city_id' => $malang->id, 'type' => 'putri', 'price' => 1200000,
            'description' => 'Kost eksklusif khusus putri dengan fasilitas lengkap dan bangunan baru. Berada di lingkungan yang aman, tenang, dan sangat strategis dekat dengan pintu gerbang utama Universitas Brawijaya.',
            'area_label' => 'Radius 500m dari UB, Malang', 'available_rooms' => 3, 'total_rooms' => 12, 'total_bathrooms' => 4, 'status' => 'tersedia',
            'floor_count' => '2', 'parking_type' => 'Motor', 'is_featured' => true, 'is_recommended' => true,
            'unlock_price' => 35000, 'address' => 'Jl. Soekarno Hatta Indah No. XX, Lowokwaru, Malang',
            'owner_contact' => '+62 812-XXXX-XXXX', 'owner_name' => 'Ibu Sari',
            'maps_link' => 'https://maps.app.goo.gl/xxxxxxxxxxxxx', 'purchase_count' => 24,
        ]);
        KostImage::insert([
            ['kost_id' => $k1->id, 'image_path' => 'assets/img/kost-1.png', 'alt_text' => 'Exterior', 'sort_order' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['kost_id' => $k1->id, 'image_path' => 'assets/img/kost-room.png', 'alt_text' => 'Kamar', 'sort_order' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['kost_id' => $k1->id, 'image_path' => 'assets/img/kost-bathroom.png', 'alt_text' => 'Kamar Mandi', 'sort_order' => 2, 'created_at' => now(), 'updated_at' => now()],
        ]);
        $k1->facilities()->attach([
            $facilities['WiFi']->id => ['label' => 'WiFi Cepat'],
            $facilities['AC']->id => ['label' => null],
            $facilities['Kamar Mandi Dalam']->id => ['label' => null],
            $facilities['Meja Belajar']->id => ['label' => 'Meja Belajar & Kursi'],
            $facilities['Lemari Pakaian']->id => ['label' => null],
            $facilities['Kasur Springbed']->id => ['label' => 'Kasur Springbed (120x200)'],
            $facilities['Air Panas']->id => ['label' => 'Air Panas (Water Heater)'],
            $facilities['Dapur']->id => ['label' => 'Dapur & Kulkas'],
            $facilities['Parkir Motor']->id => ['label' => 'Parkir Motor Tertutup'],
            $facilities['CCTV 24 Jam']->id => ['label' => null],
            $facilities['Ruang Tamu']->id => ['label' => null],
        ]);
        NearbyPlace::insert([
            ['kost_id' => $k1->id, 'description' => '5 menit jalan kaki ke UB (Gerbang Suhat)', 'sort_order' => 0],
            ['kost_id' => $k1->id, 'description' => '3 menit ke Indomaret & Alfamart', 'sort_order' => 1],
            ['kost_id' => $k1->id, 'description' => '10 menit ke Malang Town Square (Matos)', 'sort_order' => 2],
            ['kost_id' => $k1->id, 'description' => 'Dikelilingi banyak warung makan murah', 'sort_order' => 3],
        ]);

        // ══════════════════════════════════════
        // ── Kost 2: Harmoni 88 ──
        // ══════════════════════════════════════
        $k2 = Kost::create([
            'kode' => 'MK-002', 'name' => 'Kost Harmoni 88', 'slug' => 'kost-harmoni-88',
            'city_id' => $malang->id, 'type' => 'putra', 'price' => 950000,
            'description' => 'Kost putra bersih dengan fasilitas dasar lengkap. Lingkungan aman dan dekat kampus.',
            'area_label' => 'Radius 1km dari UB, Malang', 'available_rooms' => 5, 'total_rooms' => 8, 'total_bathrooms' => 3, 'status' => 'tersedia',
            'is_featured' => false, 'is_recommended' => true, 'unlock_price' => 15000, 'purchase_count' => 12,
            'address' => 'Jl. Veteran No. XX, Malang', 'owner_contact' => '+62 813-XXXX-XXXX',
        ]);
        KostImage::insert([
            ['kost_id' => $k2->id, 'image_path' => 'assets/img/kost-room.png', 'alt_text' => 'Kamar', 'sort_order' => 0, 'created_at' => now(), 'updated_at' => now()],
        ]);
        $k2->facilities()->attach([$facilities['WiFi']->id, $facilities['Dapur']->id, $facilities['Parkir Motor']->id]);

        // ══════════════════════════════════════
        // ── Kost 3: Sakura Living ──
        // ══════════════════════════════════════
        $k3 = Kost::create([
            'kode' => 'MK-003', 'name' => 'Kost Sakura Living', 'slug' => 'kost-sakura-living',
            'city_id' => $malang->id, 'type' => 'campur', 'price' => 800000,
            'description' => 'Kost campur bersih dan nyaman. Dekat Politeknik Negeri Malang.',
            'area_label' => 'Dekat Polinema, Malang', 'available_rooms' => 2, 'total_rooms' => 6, 'total_bathrooms' => 2, 'status' => 'tersedia',
            'is_recommended' => true, 'unlock_price' => 15000, 'purchase_count' => 8,
            'address' => 'Jl. Soekarno Hatta No. XX, Malang', 'owner_contact' => '+62 857-XXXX-XXXX',
        ]);
        KostImage::insert([
            ['kost_id' => $k3->id, 'image_path' => 'assets/img/kost-bathroom.png', 'alt_text' => 'Kamar Mandi', 'sort_order' => 0, 'created_at' => now(), 'updated_at' => now()],
        ]);
        $k3->facilities()->attach([$facilities['WiFi']->id, $facilities['Lemari Pakaian']->id, $facilities['Kasur Springbed']->id]);

        // ══════════════════════════════════════
        // ── Kost 4: Bunga Eksekutif ──
        // ══════════════════════════════════════
        $k4 = Kost::create([
            'kode' => 'MK-004', 'name' => 'Kost Bunga Eksekutif', 'slug' => 'kost-bunga-eksekutif',
            'city_id' => $malang->id, 'type' => 'putri', 'price' => 1500000,
            'description' => 'Kost eksekutif putri dengan fasilitas premium.',
            'area_label' => 'Suhat, Malang', 'available_rooms' => 1, 'total_rooms' => 5, 'total_bathrooms' => 5, 'status' => 'tersedia',
            'is_featured' => true, 'unlock_price' => 15000, 'purchase_count' => 18,
            'address' => 'Jl. Suhat No. XX, Malang', 'owner_contact' => '+62 811-XXXX-XXXX',
        ]);
        KostImage::insert([
            ['kost_id' => $k4->id, 'image_path' => 'assets/img/kost-room.png', 'alt_text' => 'Kamar', 'sort_order' => 0, 'created_at' => now(), 'updated_at' => now()],
        ]);
        $k4->facilities()->attach([$facilities['AC']->id, $facilities['Kamar Mandi Dalam']->id, $facilities['TV']->id]);

        // ══════════════════════════════════════
        // ── Kost 5: Merdeka ──
        // ══════════════════════════════════════
        $k5 = Kost::create([
            'kode' => 'JK-001', 'name' => 'Kost Merdeka', 'slug' => 'kost-merdeka',
            'city_id' => $jogja->id, 'type' => 'putra', 'price' => 750000,
            'description' => 'Kost putra sederhana di Yogyakarta. Lingkungan tenang dekat kampus.',
            'area_label' => 'Sleman, Yogyakarta', 'available_rooms' => 0, 'total_rooms' => 10, 'total_bathrooms' => 3, 'status' => 'penuh',
            'unlock_price' => 15000, 'purchase_count' => 6,
            'address' => 'Jl. Kaliurang Km 5, Sleman', 'owner_contact' => '+62 878-XXXX-XXXX',
        ]);
        KostImage::insert([
            ['kost_id' => $k5->id, 'image_path' => 'assets/img/kost-1.png', 'alt_text' => 'Exterior', 'sort_order' => 0, 'created_at' => now(), 'updated_at' => now()],
        ]);
        $k5->facilities()->attach([$facilities['WiFi']->id, $facilities['Kasur Springbed']->id]);

        // ══════════════════════════════════════
        // ── Kost 6: Mawar Sederhana ──
        // ══════════════════════════════════════
        $k6 = Kost::create([
            'kode' => 'SB-001', 'name' => 'Kost Mawar Sederhana', 'slug' => 'kost-mawar-sederhana',
            'city_id' => $surabaya->id, 'type' => 'putri', 'price' => 600000,
            'description' => 'Kost putri sederhana di Surabaya, cocok untuk pekerja.',
            'area_label' => 'Gubeng, Surabaya', 'available_rooms' => 4, 'total_rooms' => 6, 'total_bathrooms' => 2, 'status' => 'tersedia',
            'unlock_price' => 15000, 'purchase_count' => 3,
            'address' => 'Jl. Gubeng Kertajaya No. XX, Surabaya', 'owner_contact' => '+62 822-XXXX-XXXX',
        ]);
        KostImage::insert([
            ['kost_id' => $k6->id, 'image_path' => 'assets/img/kost-bathroom.png', 'alt_text' => 'Kamar Mandi', 'sort_order' => 0, 'created_at' => now(), 'updated_at' => now()],
        ]);
        $k6->facilities()->attach([$facilities['Meja Belajar']->id, $facilities['Lemari Pakaian']->id, $facilities['Kasur Springbed']->id]);

        // ══════════════════════════════════════
        // ── Kost 7: Griya Pelajar ──
        // ══════════════════════════════════════
        $k7 = Kost::create([
            'kode' => 'MK-007', 'name' => 'Kost Griya Pelajar', 'slug' => 'kost-griya-pelajar',
            'city_id' => $malang->id, 'type' => 'campur', 'price' => 850000,
            'description' => 'Kost Griya Pelajar adalah pilihan tepat untuk mahasiswa yang mencari hunian nyaman dan strategis di area Universitas Brawijaya. Dengan suasana tenang, akses mudah ke kampus, dan fasilitas lengkap, kost ini cocok untuk kamu yang ingin fokus kuliah tanpa repot urusan tempat tinggal. Lingkungan sekitar aman, dekat dengan warung makan, minimarket, dan jalur angkot.',
            'area_label' => 'Radius 500m dari Universitas Brawijaya, Malang', 'available_rooms' => 8, 'total_rooms' => 10, 'total_bathrooms' => 3, 'status' => 'tersedia',
            'floor_count' => '2', 'is_recommended' => true,
            'unlock_price' => 35000, 'address' => 'Jl Raung Barisan Kalipare cek aja cek aja',
            'owner_contact' => '082312312312312', 'owner_name' => 'ibu ayu',
            'maps_link' => 'https://maps.app.goo.gl/xxxxxxxxxxxxx', 'purchase_count' => 0,
        ]);
        KostImage::insert([
            ['kost_id' => $k7->id, 'image_path' => 'assets/img/kost-1.png', 'alt_text' => 'Exterior', 'sort_order' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['kost_id' => $k7->id, 'image_path' => 'assets/img/kost-room.png', 'alt_text' => 'Kamar', 'sort_order' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['kost_id' => $k7->id, 'image_path' => 'assets/img/kost-bathroom.png', 'alt_text' => 'Kamar Mandi', 'sort_order' => 2, 'created_at' => now(), 'updated_at' => now()],
        ]);
        $k7->facilities()->attach([
            $facilities['WiFi']->id,
            $facilities['AC']->id,
            $facilities['Lemari Pakaian']->id,
            $facilities['Kasur Springbed']->id,
            $facilities['Air Panas']->id,
            $facilities['Balkon']->id,
        ]);
        NearbyPlace::insert([
            ['kost_id' => $k7->id, 'description' => '5 menit jalan kaki ke UB (Gerbang Suhat)', 'sort_order' => 0],
            ['kost_id' => $k7->id, 'description' => '3 menit ke Indomaret & Alfamart', 'sort_order' => 1],
            ['kost_id' => $k7->id, 'description' => '10 menit ke Malang Town Square (Matos)', 'sort_order' => 2],
            ['kost_id' => $k7->id, 'description' => 'Dikelilingi banyak warung makan murah', 'sort_order' => 3],
        ]);

        // ══════════════════════════════════════
        // ── Orders (Sample Data) ──
        // ══════════════════════════════════════
        $orderData = [
            ['invoice_no' => 'INV-260325-9412', 'kost_id' => $k1->id, 'customer_name' => 'WAHIDILA Surya', 'customer_whatsapp' => '0822333861482', 'customer_email' => 'contentsaya1@gmail.com', 'amount' => 35000, 'payment_method' => 'qris', 'status' => 'paid', 'paid_at' => '2026-03-25 15:37:27'],
            ['invoice_no' => 'INV-260325-9059', 'kost_id' => $k7->id, 'customer_name' => 'budi santoso', 'customer_whatsapp' => '0822333861482', 'customer_email' => 'contentsaya1@gmail.com', 'amount' => 35000, 'payment_method' => 'gopay', 'status' => 'paid', 'paid_at' => '2026-03-25 15:59:42'],
            ['invoice_no' => 'INV-260325-6828', 'kost_id' => $k7->id, 'customer_name' => 'budi santoso', 'customer_whatsapp' => '0822333861482', 'customer_email' => 'contentsaya1@gmail.com', 'amount' => 35000, 'payment_method' => 'gopay', 'status' => 'paid', 'paid_at' => '2026-03-25 16:03:23'],
            ['invoice_no' => 'INV-260325-8813', 'kost_id' => $k7->id, 'customer_name' => 'Wahidila', 'customer_whatsapp' => '082233386148', 'customer_email' => 'wahidilasp@gmail.com', 'amount' => 35000, 'payment_method' => 'qris', 'status' => 'paid', 'paid_at' => '2026-03-25 16:14:05'],
            ['invoice_no' => 'INV-260325-4251', 'kost_id' => $k7->id, 'customer_name' => 'Wahidila', 'customer_whatsapp' => '082233386148', 'customer_email' => 'wahidilasp@gmail.com', 'amount' => 35000, 'payment_method' => 'qris', 'status' => 'paid', 'paid_at' => '2026-03-25 16:30:34'],
            ['invoice_no' => 'INV-260325-4987', 'kost_id' => $k1->id, 'customer_name' => 'WAHIDILA SP', 'customer_whatsapp' => '0822333861482', 'customer_email' => 'wahidilasp@gmail.com', 'amount' => 35000, 'payment_method' => 'gopay', 'status' => 'paid', 'paid_at' => '2026-03-25 16:31:11'],
            ['invoice_no' => 'INV-260325-3124', 'kost_id' => $k7->id, 'customer_name' => 'wahid', 'customer_whatsapp' => '082233386148', 'customer_email' => 'wahidilasp@gmail.com', 'amount' => 35000, 'payment_method' => 'gopay', 'status' => 'paid', 'paid_at' => '2026-03-25 16:37:29'],
            ['invoice_no' => 'INV-260325-3432', 'kost_id' => $k7->id, 'customer_name' => 'wahidilasp', 'customer_whatsapp' => '082233386148', 'customer_email' => 'wahidilasp@gmail.com', 'amount' => 35000, 'payment_method' => 'va', 'status' => 'paid', 'paid_at' => '2026-03-25 16:42:56'],
        ];
        foreach ($orderData as $order) {
            Order::create(array_merge($order, ['created_at' => $order['paid_at'], 'updated_at' => $order['paid_at']]));
        }

        // ── User biasa (wahidilasp) + order terakhir ──
        $user = User::create([
            'name' => 'wahidilasp',
            'email' => 'wahidilasp@gmail.com',
            'role' => 'user',
            'whatsapp' => '082233386148',
            'password' => Hash::make('password'),
        ]);
        Order::create([
            'user_id' => $user->id,
            'invoice_no' => 'INV-260325-9228', 'kost_id' => $k7->id,
            'customer_name' => 'wahidilasp', 'customer_whatsapp' => '082233386148', 'customer_email' => 'wahidilasp@gmail.com',
            'amount' => 35000, 'payment_method' => 'gopay', 'status' => 'paid', 'paid_at' => '2026-03-25 16:56:45',
            'created_at' => '2026-03-25 16:56:45', 'updated_at' => '2026-03-25 16:56:45',
        ]);
    }
}
