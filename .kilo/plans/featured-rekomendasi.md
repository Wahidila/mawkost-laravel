# Plan: Fix Featured & Rekomendasi Kost Flow

## Overview
Memperbaiki dan mengaktifkan fitur "Featured" dan "Rekomendasi" yang saat ini tidak berfungsi penuh. `is_featured` sudah ada di database tapi tidak pernah digunakan di frontend. Badge visual tidak ditampilkan di kost card. Admin tidak bisa melihat status featured/rekomendasi dari tabel index.

---

## A. Frontend (User-facing) — 7 perubahan

### A1. Tambah badge Featured & Rekomendasi di kost-card component
**File:** `resources/views/components/kost-card.blade.php`
- Tambah badge "Featured" (gold/amber) di card-badges jika `$kost->is_featured`
- Tambah badge "Rekomendasi" (blue) jika `$kost->is_recommended`
- Badge ditampilkan di posisi kiri atas card (di atas type badge)

### A2. Tambah CSS classes untuk badge baru
**File:** `public/css/styles.css`
- Tambah `.badge-featured` — background gold (#F59E0B), text white, dengan icon star
- Tambah `.badge-recommended` — background blue (#3B82F6), text white
- Tambah `.badge-danger` — background red (untuk status "Penuh" yang saat ini missing)
- Tambah `.card-featured-glow` — subtle gold border/glow effect untuk featured kost card

### A3. Tambah section "Kost Pilihan" (Featured) di homepage
**File:** `resources/views/home.blade.php`
- Tambah section baru **sebelum** "Rekomendasi Kost" (antara section Kota dan Rekomendasi)
- Title: "Kost Pilihan" / subtitle: "Kost premium yang dipilih khusus oleh tim mawkost"
- Tampilkan max 4 featured kost
- Hanya tampil jika ada featured kost (conditional `@if`)

### A4. Update HomeController untuk query featured kosts
**File:** `app/Http/Controllers/HomeController.php`
- Tambah query `$featuredKosts` menggunakan `Kost::featured()->available()->take(4)->get()`
- Pass ke view via `compact()`
- Eager load `kostType` di semua query (fix N+1)

### A5. Featured kost muncul duluan di search & by-city listing
**File:** `app/Http/Controllers/KostController.php`
- Di method `search()`: tambah `->orderByDesc('is_featured')` sebelum paginate
- Di method `byCity()`: tambah `->orderByDesc('is_featured')` sebelum paginate
- Efek: kost featured selalu muncul di halaman pertama

### A6. Tampilkan badge featured/rekomendasi di halaman detail kost
**File:** `resources/views/kost/show.blade.php`
- Di area header info (setelah type badge, sebelum title), tambah badge featured dan/atau rekomendasi

### A7. Update KostController@show untuk prioritaskan recommended
**File:** `app/Http/Controllers/KostController.php`
- Di method `show()`: ubah query `$otherKosts` untuk `->orderByDesc('is_recommended')` agar kost yang recommended muncul duluan di "Rekomendasi Serupa"

---

## B. Admin Panel — 4 perubahan

### B1. Tambah kolom Featured & Rekomendasi di admin kost index table
**File:** `resources/views/admin/kosts/index.blade.php`
- Tambah kolom "Label" setelah kolom "Status"
- Tampilkan badge/icon: star icon (gold) untuk featured, thumbs-up icon (blue) untuk rekomendasi
- Jika keduanya kosong, tampilkan dash "-"

### B2. Tambah quick toggle untuk featured/rekomendasi
**Files:** `resources/views/admin/kosts/index.blade.php`, `routes/web.php`, `app/Http/Controllers/Admin/KostController.php`
- Tambah route `PATCH admin/kosts/{kost}/toggle-featured` dan `PATCH admin/kosts/{kost}/toggle-recommended`
- Tambah method `toggleFeatured()` dan `toggleRecommended()` di AdminKostController
- Di tabel admin, badge featured/rekomendasi bisa diklik untuk toggle on/off (form POST kecil)

### B3. Samakan styling checkbox create form dengan edit form
**File:** `resources/views/admin/kosts/create.blade.php`
- Update checkbox section (lines 165-174) agar menggunakan styling yang sama dengan edit form (rounded border, hover effect, proper spacing)

### B4. Tambah filter di admin kost index
**Files:** `resources/views/admin/kosts/index.blade.php`, `app/Http/Controllers/Admin/KostController.php`
- Tambah filter bar di atas tabel: "Semua" | "Featured" | "Rekomendasi"
- Update `index()` method untuk accept query parameter `?filter=featured` atau `?filter=recommended`

---

## C. Backend/Logic — 1 perubahan

### C1. Eager load kostType di HomeController
**File:** `app/Http/Controllers/HomeController.php`
- Tambah `kostType` ke eager load di query `recommendedKosts` dan `featuredKosts` untuk menghindari N+1 query (kost-card menggunakan `$kost->kostType`)

---

## File yang akan diubah (total 10 file):

| # | File | Perubahan |
|---|---|---|
| 1 | `public/css/styles.css` | Tambah badge-featured, badge-recommended, badge-danger, card-featured-glow |
| 2 | `resources/views/components/kost-card.blade.php` | Tambah badge featured & rekomendasi |
| 3 | `resources/views/home.blade.php` | Tambah section "Kost Pilihan" |
| 4 | `app/Http/Controllers/HomeController.php` | Query featured kosts, eager load kostType |
| 5 | `app/Http/Controllers/KostController.php` | Sort by featured di search/byCity, prioritas recommended di show |
| 6 | `resources/views/kost/show.blade.php` | Badge featured/rekomendasi di detail |
| 7 | `resources/views/admin/kosts/index.blade.php` | Kolom label, quick toggle, filter bar |
| 8 | `resources/views/admin/kosts/create.blade.php` | Samakan styling checkbox |
| 9 | `app/Http/Controllers/Admin/KostController.php` | Toggle methods, filter logic |
| 10 | `routes/web.php` | Toggle routes |

## Urutan Implementasi:
1. CSS (A2) — foundation dulu
2. Kost card component (A1) — reusable component
3. HomeController + homepage (A4, A3, C1)
4. KostController search/byCity/show (A5, A7)
5. Show page (A6)
6. Admin controller + routes (B2, B4 backend)
7. Admin index view (B1, B2, B4 frontend)
8. Admin create form styling (B3)
