# Plan: Redesign "Tambah Kost Baru" Form

## Problem
The create kost form (`admin/kosts/create.blade.php`) uses a plain, outdated design that doesn't match the polished admin panel design system used in the edit form and other admin pages.

## Approach
Rewrite `create.blade.php` to match the exact design language of `edit.blade.php` — same outer card, section cards, headers with icons, input styling, button styling, and 2-column layout.

## File Changed: 1
- `resources/views/admin/kosts/create.blade.php` — Full rewrite of HTML/CSS classes

## Design Changes (OLD → NEW)

### Structure
- **Outer card:** `bg-white shadow rounded-lg p-6` → `bg-white/90 backdrop-blur-xl shadow-[...] rounded-2xl border border-primary-lighter/30 overflow-hidden`
- **Top header bar:** None → `p-6 border-b border-primary-lighter/40 bg-white/50` with icon title + subtitle + "Kembali" link
- **Grid:** `md:grid-cols-2 gap-6` → `lg:grid-cols-2 gap-8` inside `p-6`
- **Column wrappers:** bare `<div>` → `<div class="space-y-6">`

### Section Cards
- None → `bg-primary-lighter/10 p-5 rounded-2xl border border-primary-lighter/50`
- Section headers: plain text → `font-display text-primary-dark` with FontAwesome icon
  - Info Dasar: `fa-info-circle`
  - Kontak & Lokasi: `fa-map-marker-alt`
  - Detail & Fasilitas: `fa-list-ul`
  - Tempat Sekitar & Media: `fa-image`

### Form Elements
- **Labels:** `text-gray-700 font-bold mb-2` → `text-primary-dark font-semibold mb-1.5`
- **Inputs:** `shadow border rounded py-2 px-3` → `border border-primary-lighter rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/30 focus:border-primary bg-white transition-all`
- **Selects:** Same as inputs + `text-gray-700`
- **Textareas:** Same as inputs + `resize-none`
- **Price inputs:** Add `Rp` prefix with `relative` wrapper + `absolute left-3 top-2.5` span + `pl-9` on input
- **File input:** Add `file:` pseudo-element styling (rounded-full, primary-lighter bg)

### Facilities
- Container: `border rounded p-3 h-48` → `bg-white border border-primary-lighter rounded-xl p-4 max-h-[220px] overflow-y-auto custom-scrollbar`
- Category headers: `text-gray-500` → `text-primary` with icons (`fa-bed`, `fa-users`)
- Checkboxes: `form-checkbox text-blue-600` → `w-4 h-4 text-primary bg-gray-100 border-gray-300 rounded focus:ring-primary focus:ring-2`
- "Tambah Fasilitas Baru" button: `bg-blue-100 text-blue-700` → `bg-primary-lighter/30 text-primary hover:bg-primary hover:text-white rounded-full`

### Buttons
- Cancel: `bg-gray-500 rounded` → `bg-white border border-primary-lighter rounded-full text-primary-dark`
- Submit: `bg-blue-600 rounded` → `bg-primary rounded-full` with hover translate + shadow
- Button bar: `mt-6 border-t pt-4` → `p-6 bg-primary-lighter/10 border-t border-primary-lighter/30 rounded-b-2xl`

### Layout (matching edit form sections)

**Left Column:**
1. **Informasi Dasar** (`fa-info-circle`) — Nama Kost, Kota+Tipe (2-col), Harga+Harga Buka Kontak (2-col with Rp prefix), Featured/Recommended checkboxes
2. **Kontak & Lokasi** (`fa-map-marker-alt`) — Label Area, Alamat Lengkap, Nama Pemilik+Kontak WA (2-col), Link Google Maps

**Right Column:**
1. **Detail & Fasilitas** (`fa-list-ul`) — Deskripsi, Total Kamar+Total Kamar Mandi (2-col), Jml Lantai/Parkir, Fasilitas checklist (2-col: Kamar/Bersama)
2. **Tempat Sekitar & Media** (`fa-image`) — Tempat Terdekat textarea, Upload Foto

## Notes
- The `@include('admin.kosts._facility_modal')` and `@push('scripts')` blocks remain unchanged
- The form action, method, and all `name` attributes remain the same
- Only visual/CSS classes change — no functional changes
