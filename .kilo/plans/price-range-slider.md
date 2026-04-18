# Plan: Replace Price Range Inputs with Dual-Range Slider

## Current Situation
The search page (`resources/views/kost/search.blade.php`) uses two plain `<input type="number">` fields for `min_harga` and `max_harga`. This is functional but not user-friendly — users have to type exact numbers.

**Key discovery:** The CSS file already has complete styling for a dual-range slider (`.multi-range`, `.range-tooltip`, `.price-range-wrapper`) at lines 2694-2774 — these were prepared but never connected to the HTML.

## Plan

### 1. Update HTML in `resources/views/kost/search.blade.php`

Replace the current price range inputs (lines 44-51) with a dual-range slider component:

**Current:**
```html
<div class="filter-group price-range-wrapper">
    <label class="range-label">Rentang Harga</label>
    <div style="display: flex; gap: 8px; align-items: center;">
        <input type="number" name="min_harga" ...>
        <span>-</span>
        <input type="number" name="max_harga" ...>
    </div>
</div>
```

**New structure:**
```html
<div class="filter-group price-range-wrapper">
    <label class="range-label">Rentang Harga</label>
    <!-- Display: formatted price labels -->
    <div class="range-values">
        <span id="minPriceLabel">Rp 500rb</span>
        <span id="maxPriceLabel">Rp 5jt</span>
    </div>
    <!-- Dual range slider -->
    <div class="multi-range">
        <div class="range-track" id="rangeTrack"></div>
        <input type="range" id="minRange" min="500000" max="5000000" step="100000" value="...">
        <input type="range" id="maxRange" min="500000" max="5000000" step="100000" value="...">
    </div>
    <!-- Hidden inputs for form submission -->
    <input type="hidden" name="min_harga" id="minHargaInput">
    <input type="hidden" name="max_harga" id="maxHargaInput">
</div>
```

**Slider config:**
- Min: Rp 500.000 (500rb)
- Max: Rp 5.000.000 (5jt)
- Step: Rp 100.000 (100rb)
- Default: full range (500rb - 5jt) unless query params exist
- Pre-populate from `request('min_harga')` and `request('max_harga')` if present

### 2. Add JavaScript in `@push('scripts')` block

JavaScript to:
- Sync range sliders with hidden inputs and labels
- Prevent min slider from crossing max slider (and vice versa)
- Format price labels (e.g., "Rp 1,2jt", "Rp 500rb")
- Update the colored track fill between the two thumbs
- Initialize from existing query params if present

### 3. Update CSS in `public/css/styles.css`

The existing `.multi-range` CSS (lines 2694-2774) is mostly ready. Need to add:
- `.range-track` — the colored fill between the two thumbs (using `--primary` color)
- `.range-values` — flex container for min/max price labels
- Firefox thumb styling (`::-moz-range-thumb`) for cross-browser support
- Minor adjustments to `.price-range-wrapper` for proper spacing

### 4. Backend — No changes needed

The `KostController@search` already handles `min_harga` and `max_harga` as query params. The hidden inputs will submit the same values. No backend changes required.

---

## Files to modify (2):

| # | File | Change |
|---|---|---|
| 1 | `resources/views/kost/search.blade.php` | Replace number inputs with dual-range slider HTML + add JS in `@push('scripts')` |
| 2 | `public/css/styles.css` | Add `.range-track`, `.range-values`, Firefox thumb styles, update `.price-range-wrapper` |

## Design System Compliance (per DESIGN.md):
- Thumb color: `--cta` (#E8734A) — already in existing CSS
- Track fill: `--primary` (#8B5E3C)
- Tooltip: `--primary-dark` background, white text — already in existing CSS
- Labels: Poppins font, `--text-muted` color
- Border radius: `--radius-sm` for track
- Transitions: `--dur` and `--ease` variables
