# Plan: Fix Slider Thumb Alignment (v2)

## Root Cause Found

The `.filter-group input` CSS rule (line 1296) applies to ALL inputs inside `.filter-group`, including our `<input type="range">` elements:

```css
.filter-group input {
  padding: 10px 14px;      /* ← shifts thumb travel area inward by 14px each side */
  border: 1px solid var(--border);  /* ← adds visible border around range input */
  border-radius: var(--radius-sm);  /* ← rounds the range input container */
  background: var(--bg);   /* ← adds background color (should be transparent) */
}
```

This causes:
1. The thumb travels within a padded area (14px + 1px border = 15px offset each side)
2. But the custom `.range-track` and `.range-track-bg` are positioned relative to the `.multi-range` container (no padding)
3. Result: thumb is ~15px offset from the colored track on each side

## Fix — 2 changes in 2 files

### 1. CSS: Override range input styles inside `.multi-range`

**File:** `public/css/styles.css`

Add after the existing `.multi-range input[type=range]` rule (after line 2759):

```css
.multi-range input[type=range] {
  /* ... existing styles ... */
  padding: 0;           /* override .filter-group input padding */
  border: none;         /* override .filter-group input border */
  background: transparent; /* already set, but reinforce */
}
```

Actually, the cleanest approach is to just add `padding: 0` and `border: none` to the existing `.multi-range input[type=range]` block since it already has `background: transparent`.

### 2. JS: Simplify track calculation

**File:** `resources/views/kost/search.blade.php`

With padding removed from the range inputs, the thumb now travels from `thumbHalf` to `width - thumbHalf` within the input, and the input is the same width as the container. The current pixel-based calculation should work correctly.

However, to be extra robust and handle window resize, wrap the initial call in a small `requestAnimationFrame` to ensure `offsetWidth` is accurate after layout.

## Files changed: 2
1. `public/css/styles.css` — Add `padding: 0; border: none;` to `.multi-range input[type=range]`
2. `resources/views/kost/search.blade.php` — Wrap initial `updateSlider()` in `requestAnimationFrame` + add resize listener
