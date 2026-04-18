# Plan: Redesign User Profile Page

## Problem
The user profile page (`resources/views/user/profile.blade.php`) uses a generic blue/amber design that doesn't match the Mawkost design system used consistently across the user dashboard and admin panel.

**Current issues:**
- Section headers use `bg-gradient-to-r from-blue-600 to-blue-400` and `from-amber-500 to-orange-400` — doesn't match Mawkost brand colors
- Inputs use `border-gray-300 focus:ring-blue-500` — should use `border-primary-lighter focus:ring-primary/30`
- Buttons use `bg-blue-600` and `bg-amber-500` — should use `bg-primary`
- Cards use `bg-white rounded-xl shadow-sm border-gray-100` — should use glassmorphism pattern
- Avatar border uses `border-blue-100` — should use `border-primary-lighter`
- Labels use `text-gray-700` — should use `text-primary-dark`

## File Changed: 1
- `resources/views/user/profile.blade.php` — Full redesign of CSS classes

## Design Changes

### Card Containers
- **OLD:** `bg-white rounded-xl shadow-sm border border-gray-100`
- **NEW:** `bg-white/90 backdrop-blur-xl rounded-2xl shadow-[0_4px_12px_rgba(92,61,46,0.08)] border border-primary-lighter/30`

### Section Headers
- **OLD:** `bg-gradient-to-r from-blue-600 to-blue-400 px-6 py-4` with white text
- **NEW:** `p-5 sm:p-6 border-b border-primary-lighter/40 bg-white/50` with `text-primary-dark font-display` + icon

### Labels
- **OLD:** `text-sm font-medium text-gray-700 mb-1`
- **NEW:** `text-sm font-semibold text-primary-dark mb-1.5`

### Inputs
- **OLD:** `border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500`
- **NEW:** `border border-primary-lighter rounded-xl focus:ring-2 focus:ring-primary/30 focus:border-primary bg-white transition-all`

### Password Inputs
- **OLD:** `focus:ring-amber-500 focus:border-amber-500`
- **NEW:** Same as above (consistent with profile inputs)

### Avatar
- **OLD:** `border-4 border-blue-100`
- **NEW:** `border-4 border-primary-lighter`
- Avatar fallback: change `background=3B82F6` to `background=8B5E3C` (primary color)

### Buttons
- **Profile Save:** `bg-blue-600 hover:bg-blue-700 rounded-lg` → `bg-primary hover:bg-primary-dark rounded-full` with shadow + translate
- **Password Save:** `bg-amber-500 hover:bg-amber-600 rounded-lg` → `bg-primary hover:bg-primary-dark rounded-full` with shadow + translate
- **Delete Avatar:** Keep red color but use `text-red-500 hover:text-red-700` (already fine)

### WhatsApp Input Icon
- Keep the green WhatsApp icon — it's semantically correct

### Layout
- Keep `max-w-3xl mx-auto space-y-6` — appropriate for a profile page (single column)
- Keep the avatar upload interaction (hover overlay with camera icon)
