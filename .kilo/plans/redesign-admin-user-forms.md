# Plan: Redesign Admin User Create & Edit Forms

## Problem
Both `create.blade.php` and `edit.blade.php` in `admin/users/` use old plain Tailwind styling that doesn't match the polished admin design system used in the kost edit form, order detail page, and user index page.

**Current issues (both files):**
- Outer container: `bg-white shadow rounded-lg p-6 max-w-2xl` — no glassmorphism, no warm shadow
- Header: `text-lg font-semibold text-gray-800` + plain `text-gray-500` back link — no icon, no subtitle
- Labels: `text-gray-700 text-sm font-bold mb-2` — should use `text-primary-dark font-semibold mb-1.5`
- Inputs: `shadow appearance-none border rounded py-2 px-3 text-gray-700 focus:outline-none focus:shadow-outline` — should use `border-primary-lighter rounded-xl px-4 py-2.5 focus:ring-primary/30`
- Select: Same old styling
- Submit button: `bg-blue-600 hover:bg-blue-800 rounded` — should use `bg-primary rounded-full` with hover shadow
- Error box: `bg-red-50 text-red-700 border-red-200 rounded` — should use `rounded-xl` with icon
- No section cards — form fields are flat inside the container
- Password section divider: `border-t pt-4` — should use section card pattern

## Files Changed: 2
1. `resources/views/admin/users/create.blade.php` — Full redesign
2. `resources/views/admin/users/edit.blade.php` — Full redesign

## Target Design (matching admin kost edit form pattern)

### Outer Container
```
bg-white/90 backdrop-blur-xl w-full shadow-[0_4px_12px_rgba(92,61,46,0.08)] rounded-2xl border border-primary-lighter/30 overflow-hidden max-w-2xl
```

### Top Header Bar
```html
<div class="p-6 border-b border-primary-lighter/40 bg-white/50 flex items-center justify-between">
    <div>
        <h3 class="text-lg font-bold font-display text-primary-dark tracking-tight flex items-center gap-2">
            <i class="fas fa-user-plus text-cta"></i> Tambah Pengguna Baru
        </h3>
        <p class="text-sm text-gray-500 mt-0.5">Subtitle</p>
    </div>
    <a href="..." class="text-sm font-semibold text-primary hover:text-cta ...">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>
```

### Section Cards
Two sections per form:
1. **Informasi Akun** (`fa-user text-primary`) — Name, Email, WhatsApp, Role
2. **Keamanan** (`fa-shield-alt text-primary`) — Password

Each section:
```
bg-primary-lighter/10 p-5 rounded-2xl border border-primary-lighter/50
```

### Form Elements
- **Labels:** `block text-sm font-semibold text-primary-dark mb-1.5`
- **Inputs:** `w-full border border-primary-lighter rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary bg-white transition-all`
- **Select:** Same as input + `text-gray-700`
- **WhatsApp input:** With green WA icon prefix (like user profile page)

### Error Box
```
bg-red-50 text-red-700 p-4 rounded-xl border border-red-200 text-sm
```
With `<i class="fas fa-exclamation-circle"></i>` icon

### Bottom Action Bar
```
p-6 bg-primary-lighter/10 border-t border-primary-lighter/30 flex justify-end gap-3 rounded-b-2xl
```
- Cancel: `px-6 py-2.5 rounded-full bg-white border border-primary-lighter text-primary-dark`
- Submit: `bg-primary text-white rounded-full` with hover shadow + translate

### Differences Between Create & Edit
- **Create:** Title "Tambah Pengguna Baru" with `fa-user-plus` icon, password required, submit "Simpan Pengguna"
- **Edit:** Title "Edit Pengguna" with `fa-user-edit` icon, password optional with helper text, submit "Simpan Perubahan"
