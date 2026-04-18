# Plan: Hapus Status Tersedia/Penuh dan Jumlah Kamar Tersedia dari Modul Kost

## Overview
Menghapus field `status` (tersedia/penuh) dan `available_rooms` dari seluruh modul kost. Ini termasuk menghapus dari form admin, tampilan card, detail page, model scopes, dan controller logic.

**PENTING:** Field `status` pada Order model (pending/paid/expired/refunded) TIDAK terpengaruh — ini field yang berbeda.

---

## Perubahan yang Diperlukan (13 file)

### 1. Migration — Buat migration baru untuk drop kolom
**File:** Buat `database/migrations/xxxx_remove_status_and_available_rooms_from_kosts_table.php`
- Drop kolom `status` dan `available_rooms` dari tabel `kosts`

### 2. Kost Model — Hapus dari fillable, hapus scope & accessor
**File:** `app/Models/Kost.php`
- Hapus `'available_rooms'` dan `'status'` dari `$fillable`
- Hapus method `scopeAvailable()`
- Hapus method `getStatusBadgeAttribute()`

### 3. Admin KostController — Hapus dari validasi
**File:** `app/Http/Controllers/Admin/KostController.php`
- Hapus `'available_rooms' => 'required|integer'` dari `store()` validation
- Hapus `'status' => 'required|in:tersedia,penuh'` dari `store()` validation
- Hapus `'available_rooms' => 'required|integer'` dari `update()` validation
- Hapus `'status' => 'required|in:tersedia,penuh'` dari `update()` validation

### 4. Admin Create Form — Hapus field status & available_rooms
**File:** `resources/views/admin/kosts/create.blade.php`
- Hapus select `status` (lines 48-53)
- Hapus input `available_rooms` (lines 69-71)

### 5. Admin Edit Form — Hapus field status & available_rooms
**File:** `resources/views/admin/kosts/edit.blade.php`
- Hapus select `status` (lines 82-87)
- Hapus input `available_rooms` (lines 162-165)

### 6. Admin Kost Index — Hapus kolom Status dari tabel
**File:** `resources/views/admin/kosts/index.blade.php`
- Hapus `<th>Status</th>` header
- Hapus `<td>` status badge display
- Update `colspan` di empty state

### 7. Kost Card Component — Hapus status badge
**File:** `resources/views/components/kost-card.blade.php`
- Hapus blok `@if($kost->status === 'tersedia')` ... `@endif` (lines 21-27)

### 8. Kost Detail Page — Hapus statusBadge
**File:** `resources/views/kost/show.blade.php`
- Hapus `<span class="badge {{ $kost->statusBadge['class'] }}">` (line 115)

### 9. KostController — Hapus `->available()` scope calls
**File:** `app/Http/Controllers/KostController.php`
- Line 14: Hapus `->available()` dari search query
- Line 56: Hapus `->available()` dari byCity query
- Line 75: Hapus `->available()` dari show page "other kosts" query

### 10. HomeController — Hapus `->available()` scope calls
**File:** `app/Http/Controllers/HomeController.php`
- Line 17: Hapus `->available()` dari featuredKosts query
- Line 23: Hapus `->available()` dari recommendedKosts query
- Line 28: Hapus `->available()` dari recentKosts query

### 11. DatabaseSeeder — Hapus `available_rooms` dan `status` dari seed data
**File:** `database/seeders/DatabaseSeeder.php`
- Hapus `'available_rooms' => X` dan `'status' => 'tersedia'/'penuh'` dari semua 7 kost entries

### 12. XSenderService — Hapus `{available_rooms}` placeholder
**File:** `app/Services/XSenderService.php`
- Line 124: Hapus `'{available_rooms}' => $kost->available_rooms ?? '-'`
- Line 162: Hapus `Kamar Tersedia: {available_rooms}` dari default template

### 13. WhatsApp Settings View — Hapus placeholder label
**File:** `resources/views/admin/settings/whatsapp.blade.php`
- Line 98: Hapus `'{available_rooms}' => 'Kamar Tersedia'`

---

## Urutan Implementasi
1. Migration baru (drop columns)
2. Model (hapus fillable, scope, accessor)
3. Controllers (hapus validation, hapus ->available() calls)
4. Views (admin forms, admin index, kost card, detail page)
5. Seeder
6. Services (XSender, WA settings)
7. Run migration
8. Clear caches

## Catatan
- Semua kost akan ditampilkan tanpa filter status — tidak ada lagi konsep "tersedia" vs "penuh"
- Badge di kost card hanya akan menampilkan: Featured, Rekomendasi, dan Tipe Kost
- Badge di detail page hanya: Featured, Rekomendasi, Tipe Kost
