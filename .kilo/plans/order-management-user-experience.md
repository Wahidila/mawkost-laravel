# Plan: Admin Order Management + User Experience

## Overview
Memperbaiki manajemen pesanan di admin panel dan meningkatkan pengalaman user terkait order/pesanan.

---

## P1: ADMIN ORDER MANAGEMENT

### P1.1 — Filter & Search di halaman pesanan admin

**Files:**
- `app/Http/Controllers/Admin/OrderController.php` — update `index()` method
- `resources/views/admin/orders/index.blade.php` — tambah filter bar + search

**Detail:**
- Tambah filter bar di atas tabel:
  - **Search** — input text, cari by invoice_no, customer_name, customer_email
  - **Status filter** — pills/tabs: Semua | Pending | Paid | Expired | Refunded
  - **Tanggal** — date range picker (dari - sampai) menggunakan native `<input type="date">`
- Update `index()` controller:
  - Accept query params: `?search=`, `?status=`, `?from=`, `?to=`
  - Apply filters ke query
  - `withQueryString()` pada paginator

### P1.2 — Update status order (manual)

**Files:**
- `app/Http/Controllers/Admin/OrderController.php` — tambah `updateStatus()` method
- `routes/web.php` — tambah route `PATCH admin/orders/{order}/status`
- `resources/views/admin/orders/show.blade.php` — tambah form update status

**Detail:**
- Admin bisa update status order ke: `paid` (untuk transfer manual), `refunded`, `expired`
- Form dropdown di halaman detail order dengan tombol "Update Status"
- Jika status diubah ke `paid`:
  - Set `paid_at` ke `now()`
  - Kirim notifikasi ke customer (email + WA) — reuse logic dari CheckoutController
- Jika status diubah ke `refunded`:
  - Catat waktu refund
- Validasi: tidak bisa ubah status `paid` ke `pending` (hanya forward transitions)
- Flash message success/error

### P1.3 — Detail order yang lebih lengkap

**Files:**
- `resources/views/admin/orders/show.blade.php` — redesign

**Detail:**
- Layout 2 kolom:
  - **Kiri:** Info customer (nama, WA, email), info kost (nama, kota, harga unlock)
  - **Kanan:** Info transaksi (invoice, amount, payment method, status badge, tanggal order, tanggal bayar)
- **Status badge** yang lebih prominent di atas halaman
- **Xendit info section** (jika ada): invoice ID, payment URL, payment method/channel
- **Action buttons:** Update Status dropdown + button, link ke halaman kost publik
- **Quick actions:** Copy invoice number, open WhatsApp customer

### P1.4 — Export CSV

**Files:**
- `app/Http/Controllers/Admin/OrderController.php` — tambah `export()` method
- `routes/web.php` — tambah route `GET admin/orders/export`
- `resources/views/admin/orders/index.blade.php` — tambah tombol Export

**Detail:**
- Tombol "Export CSV" di samping filter bar
- Export semua order yang match filter saat ini (status, search, date range)
- Kolom CSV: Invoice, Customer Name, WhatsApp, Email, Kost Name, City, Amount, Status, Payment Method, Order Date, Paid Date
- Response sebagai download file CSV (StreamedResponse)
- Nama file: `pesanan-mawkost-{date}.csv`

---

## P3: USER EXPERIENCE

### P3.1 — Tampilkan semua order di user dashboard (termasuk pending & expired)

**Files:**
- `app/Http/Controllers/User/UserDashboardController.php` — update `index()` dan `orders()`
- `resources/views/user/dashboard.blade.php` — update recent orders section
- `resources/views/user/orders/index.blade.php` — update tabel + tambah status badge

**Detail:**
- `index()`: Tampilkan 5 recent orders **semua status** (bukan hanya `paid`)
- `orders()`: Tampilkan semua orders **semua status** dengan pagination
- Tambah **status badge** di setiap order row:
  - `paid` — badge hijau "Lunas"
  - `pending` — badge kuning "Menunggu Pembayaran" + link ke halaman pembayaran Xendit
  - `expired` — badge abu "Kedaluwarsa" + tombol "Bayar Ulang"
  - `refunded` — badge merah "Dikembalikan"
- Update stat card "Total Unlock" — tetap hitung hanya `paid`
- Tambah stat card baru atau ubah: "Pending" count jika ada

### P3.2 — Cegah duplikasi unlock kost yang sama

**Files:**
- `app/Http/Controllers/CheckoutController.php` — update `show()` method
- `app/Http/Controllers/KostController.php` — update `show()` method
- `resources/views/kost/show.blade.php` — update blur section

**Detail:**
- Di `CheckoutController@show()`:
  - Cek apakah user yang login sudah punya order `paid` untuk kost ini
  - Jika sudah, redirect ke halaman detail order user (bukan checkout)
  - Flash message: "Kamu sudah membuka info kontak kost ini sebelumnya"
- Di `KostController@show()`:
  - Cek apakah user sudah unlock kost ini (order `paid` exists)
  - Pass `$isUnlocked = true` ke view (sudah ada logic ini, perlu verifikasi)
- Di `show.blade.php`:
  - Jika sudah unlock, tampilkan info kontak langsung (sudah ada)
  - Jika belum, tampilkan blur section dengan tombol "Buka Info Sekarang"

**Verifikasi:** Perlu cek bagaimana `$isUnlocked` saat ini ditentukan di `KostController@show()`. Kemungkinan sudah ada tapi perlu dipastikan menggunakan `auth()->user()->orders()` check.

### P3.3 — Re-payment untuk order expired

**Files:**
- `app/Http/Controllers/User/UserDashboardController.php` — tambah `retryPayment()` method
- `routes/web.php` — tambah route `POST user/orders/{id}/retry`
- `resources/views/user/orders/index.blade.php` — tambah tombol "Bayar Ulang"

**Detail:**
- Tombol "Bayar Ulang" muncul di order dengan status `expired`
- `retryPayment()`:
  - Cek order milik user dan status `expired`
  - Buat order baru (copy data dari order lama: kost_id, customer info, amount)
  - Proses pembayaran seperti biasa (create Xendit invoice atau simulation)
  - Redirect ke halaman pembayaran
- Order lama tetap tersimpan dengan status `expired` (tidak dihapus)

---

## FILE CHANGES SUMMARY

| # | File | Perubahan |
|---|---|---|
| 1 | `app/Http/Controllers/Admin/OrderController.php` | Filter/search di index(), updateStatus(), export() |
| 2 | `resources/views/admin/orders/index.blade.php` | Filter bar, search, export button, status badges |
| 3 | `resources/views/admin/orders/show.blade.php` | Redesign 2 kolom, update status form, Xendit info |
| 4 | `routes/web.php` | Route: PATCH orders/{order}/status, GET orders/export, POST user/orders/{id}/retry |
| 5 | `app/Http/Controllers/User/UserDashboardController.php` | Show all statuses, retryPayment() |
| 6 | `resources/views/user/dashboard.blade.php` | Status badges, pending/expired orders |
| 7 | `resources/views/user/orders/index.blade.php` | Status badges, "Bayar Ulang" button, payment link |
| 8 | `app/Http/Controllers/CheckoutController.php` | Cek duplikasi di show() |
| 9 | `app/Http/Controllers/KostController.php` | Verifikasi $isUnlocked logic |

## URUTAN IMPLEMENTASI

1. **P1.1** — Admin filter & search (foundation)
2. **P1.2** — Admin update status
3. **P1.3** — Admin order detail redesign
4. **P1.4** — Export CSV
5. **P3.1** — User: tampilkan semua order status
6. **P3.2** — Cegah duplikasi unlock
7. **P3.3** — Re-payment expired orders
