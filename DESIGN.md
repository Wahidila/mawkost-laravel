# Mawkost Design System

This document outlines the core design components, design tokens, and UI patterns extracted from the current Mawkost frontend architecture. The design language emphasizes a warm, modern aesthetic with glassmorphism elements, inspired by the "paw" logo concept.

## 1. Design Tokens (CSS Variables)

Defined in `:root` inside `public/css/styles.css`.

### 1.1. Color Palette

**Brand Colors (Warm/Earthy)**
- `--primary`: `#8B5E3C` (Main brand color, used for primary buttons and text emphasis)
- `--primary-light`: `#DEB8A0` (Used for background blobs and hover states)
- `--primary-lighter`: `#F5E6DB` (Used for section backgrounds and soft badge backgrounds)
- `--primary-dark`: `#5C3D2E` (Used for deep text contrast, headings, and strong CTAs)

**Call to Action (Orange/Amber)**
- `--cta`: `#E8734A` (High-contrast action color)
- `--cta-hover`: `#D4622E` (Hover state for CTA)

**Neutrals & Backgrounds**
- `--bg`: `#FFF9F5` (Main page background, off-white with warm tint)
- `--surface`: `#FFFFFF` (Card and modal backgrounds)
- `--text`: `#3D2B1F` (Primary body text)
- `--text-muted`: `#8C7A6E` (Secondary/muted text)
- `--text-light`: `#B09A8D` (Disabled or light placeholder text)
- `--border`: `#E8DDD5` (Standard borders)
- `--border-light`: `#F0E8E1` (Soft dividers)

**Semantic Colors**
- `--danger`: `#DC3545` (Error states / 'Penuh' badge)
- `--success`: `#28A745` (Success states / 'Tersedia' badge)
- `--warning`: `#FFC107` (Warnings / Info alerts)
- `--info`: `#17A2B8` (Informational alerts)

### 1.2. Typography

- **Headings (h1-h6)**: `'Poppins', sans-serif` (Weights: 400, 500, 600, 700, 800)
- **Body / General Text**: `'Open Sans', sans-serif` (Weights: 400, 500, 600, 700)

**Typographic Scales (Clamp Functions):**
- `h1`: `clamp(1.75rem, 4vw, 2.75rem)`
- `h2`: `clamp(1.5rem, 3vw, 2.25rem)`
- `h3`: `clamp(1.125rem, 2.5vw, 1.5rem)`
- Line height: `1.6` for body, `1.25` for headings.

### 1.3. Effects & Layout Variables

**Shadows**
- `--shadow-sm`: `0 1px 3px rgba(92, 61, 46, .06)`
- `--shadow`: `0 4px 12px rgba(92, 61, 46, .08)`
- `--shadow-md`: `0 8px 24px rgba(92, 61, 46, .1)`
- `--shadow-lg`: `0 16px 48px rgba(92, 61, 46, .12)`

**Border Radii**
- `--radius-sm`: `8px`
- `--radius`: `12px`
- `--radius-lg`: `16px`
- `--radius-xl`: `24px`
- `--radius-full`: `9999px` (Pill shapes for buttons and badges)

**Glassmorphism (Frosted Glass)**
- `--glass-bg`: `rgba(255, 255, 255, 0.75)`
- `--glass-border`: `rgba(232, 221, 213, 0.5)`
- `--glass-blur`: `blur(16px)`

**Layout Constraints**
- `--max-w`: `1280px`
- `--nav-h`: `72px`

---

## 2. Core UI Components

### 2.1. Buttons
Base class: `.btn` (inline-flex, pill shape `--radius-full`, 200ms transition, bold `Poppins` font).

- `.btn-primary`: Solid primary color `#8B5E3C`, white text. Hovers to `.primary-dark` with `--shadow-md`.
- `.btn-cta`: Solid `#E8734A`, white text. High contrast calls to action.
- `.btn-outline`: Transparent background, primary border and text. Hovers to solid primary.
- `.btn-ghost`: Transparent, text-only button that gets a light primary background on hover.

### 2.2. Badges
Base class: `.badge`. Pill shaped (`--radius-full`), small bold `Poppins`.

- `.badge-primary`: Soft background (`--primary-lighter`), dark text (`--primary-dark`).
- `.badge-cta`: Amber tint background (`rgba(cta, 0.12)`), CTA color text.
- `.badge-success` / `.badge-danger`: Solid green / red with white text.
- `.badge-putra` / `.badge-putri` / `.badge-campur`: Solid CTA orange (`#e8734a`) used on kost listings.

### 2.3. Cards
Base class: `.card`. Surface background, rounded corners (`--radius-lg`), light border, soft shadow.

- **Interaction**: On hover, translates Y by `-4px` and elevates to `--shadow-lg`.
- `.card-glass`: Applies glassmorphism variables (blur and translucent backgrounds).
- **Kost Card (`<x-kost-card>`)**: Uses `.listing-card`, features an image with absolute-positioned `.card-badges`, and a `.card-body` containing price, name, area, and `.listing-facilities` row.
- **City Card**: Fixed height `260px`, image `object-fit: cover` with scale-on-hover effect (`1.08x`), covered by a dark bottom-to-top gradient `.city-card-overlay`.

### 2.4. Form Elements & Search

**Hero Search Bar (`.hero-search-container`)**
- Glassmorphism container sitting over hero blobs.
- **Tabs**: `Cari Umum` vs `Kode Properti`.
- **Inputs**: Transparent background, clean typography. Hover/focus states change text color from `--primary-dark` to `--primary`. 

### 2.5. Decorative Elements

**Blobs**
- Absolute positioned blurred ellipses `.blob` behind main content.
- `blob-1`: Primary-light color.
- `blob-2`: CTA color with low opacity.

**Floating Badges (`.hero-float-badge`)**
- Absolute positioned on the hero image.
- Uses Keyframe animations (`floatBadge1`, `floatBadge2`, `floatBadge3`) to simulate hovering vertically and rotating slightly on different delay timers.

**"Cara Kerja" (How It Works) Step Cards**
- Connected by SVG dashed lines (`.step-connector`).
- Uses thematic icon colors (Primary, Success, Accent) mapped to the 3 steps of the Mawkost funnel: *1. Pilih & Bandingkan -> 2. Buka Kontak -> 3. Booking Langsung*.

## 3. Structural Patterns

- **Sectioning**: Wrapped in `<section class="section">` (80px top/bottom padding).
- **Container**: `.container` limits width to `--max-w` (1280px) and applies standard `24px` horizontal padding.
- **Header**: `.section-header` aligns text center, sets h2 and a muted descriptive paragraph. 
- **Grids**: Built using CSS Grid. `listing-grid` is used for Kost cards, `city-grid` for cities, and `steps-grid` for the "How it Works" section. All designed to collapse gracefully on smaller breakpoints (handled via media queries in the CSS).
- **Navbar**: Fixed position, `72px` height, drops a soft shadow. Links feature under-line expanding animations on hover/active.

## 4. Animation Classes

- `.fade-in`: General entrance animation.
- `@keyframes floatBadge`: Hovering animations for hero widgets.
- `pulse`: Status dot animation (e.g. for "Menunggu Pembayaran").
