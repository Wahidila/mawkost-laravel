# Plan: Fix Step Card Layout — Remove step-card wrapper

## Problem
The current "Cuma Butuh 3 Langkah" section uses a nested structure:
```
.steps-grid
  .step-card              <-- wrapper div (flex: inner + connector)
    .step-card-inner      <-- actual visual card
    .step-connector       <-- dashed line connector
```

The user wants to **remove the `.step-card` wrapper** and place the card content directly in the grid. The connectors between steps will be removed (they don't work well on mobile anyway and add unnecessary complexity).

Additionally, there are **duplicate conflicting CSS rules** at line ~2832 that redefine `.step-card` and `.step-icon` with different styles, causing potential rendering conflicts.

## Plan

### 1. Update HTML in `resources/views/home.blade.php` (lines 204-259)

**Before (each step):**
```html
<div class="step-card">
  <div class="step-card-inner">
    <div class="step-badge">...</div>
    <div class="step-icon-wrap">...</div>
    <h4>...</h4>
    <p>...</p>
  </div>
  <div class="step-connector">...</div>
</div>
```

**After (each step):**
```html
<div class="step-card-inner">
  <div class="step-badge">...</div>
  <div class="step-icon-wrap">...</div>
  <h4>...</h4>
  <p>...</p>
</div>
```

Changes:
- Remove all 3 `<div class="step-card">` wrappers
- Remove all 3 `<div class="step-connector">` elements
- Keep `step-card-inner` as direct children of `steps-grid`

### 2. Update CSS in `public/css/styles.css`

**a) Update `.steps-grid` (line 949):**
- Change `gap: 0` to `gap: 28px` (since connectors are gone, cards need spacing)

**b) Remove `.step-card` rules (lines 956-960):**
- Delete the `.step-card` block (no longer needed)

**c) Update `.step-card-inner` (line 962):**
- Remove `flex: 1` and `min-width: 0` (no longer inside a flex parent)
- Keep all visual styles (glass bg, padding, border, shadow, hover)

**d) Remove `.step-connector` rules (lines 1125-1152):**
- Delete `.step-connector`, `.step-connector svg`, `.connector-dash` animation, and `.step-card:last-child .step-connector`

**e) Remove duplicate `.step-card` rules at bottom (lines 2832-2865):**
- Delete the entire duplicate block that redefines `.step-card`, `.step-card:hover`, `.step-card h4`, `.step-card p`, and the duplicate `.step-icon`

**f) Update responsive rules:**
- Line 2258: `.steps-grid` — keep `grid-template-columns: 1fr` 
- Line 2634-2651: Remove `.step-card { flex-direction: column }` and `.step-connector { display: none }` (no longer relevant). Keep `.step-card-inner` padding override.
- Line 2919: Keep `.steps-grid { grid-template-columns: 1fr }` responsive rule

## Files Changed (2):
1. `resources/views/home.blade.php` — Remove step-card wrappers and connectors
2. `public/css/styles.css` — Clean up step-card CSS, remove connectors, remove duplicates
