# Plan: Rewrite Range Slider — Tailwind-inspired Style

## Approach

Completely rewrite the dual-range slider with a simpler, more robust approach inspired by Tailwind's range slider styling. The key changes:

1. **Remove the separate track div** — Instead, use a CSS `linear-gradient` background on the `.multi-range` container itself to create the colored fill. The gradient is controlled by CSS custom properties (`--min-pct`, `--max-pct`) set by JS.

2. **Simpler CSS** — Tailwind-style: `rounded-full` track (pill shape), `h-2` (8px height), clean appearance-none reset. No separate `.range-track-bg` or `.range-track` divs needed.

3. **Percentage-based positioning** — JS sets `--min-pct` and `--max-pct` as percentages on the container. CSS uses these to create the gradient. Since the browser's thumb position follows the same percentage math, they always align perfectly.

## Changes

### File 1: `public/css/styles.css`

Replace the entire multi-range CSS block (lines 2694-2823) with:

```css
/* Price range wrapper */
.price-range-wrapper { flex: 1.5; min-width: 220px; }
.range-label { display: block; }

/* Price labels */
.range-values { display: flex; justify-content: space-between; margin-bottom: 4px; }
.range-values span { font-family: Poppins; font-size: .85rem; font-weight: 600; color: var(--primary-dark); }

/* Dual range — container IS the track */
.multi-range {
  --min-pct: 0%;
  --max-pct: 100%;
  position: relative;
  width: 100%;
  height: 8px;
  border-radius: 9999px;
  background: linear-gradient(to right,
    var(--border) 0%, var(--border) var(--min-pct),
    var(--cta) var(--min-pct), var(--cta) var(--max-pct),
    var(--border) var(--max-pct), var(--border) 100%);
  margin: 18px 0;
}

/* Range inputs — full width, stacked, transparent */
.multi-range input[type=range] {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  width: 100%;
  height: 8px;
  margin: 0; padding: 0; border: none;
  appearance: none; -webkit-appearance: none;
  background: transparent;
  outline: none;
  pointer-events: none;
  z-index: 2;
}

/* Webkit track — transparent */
.multi-range input[type=range]::-webkit-slider-runnable-track {
  height: 8px; background: transparent; border: none;
}

/* Webkit thumb */
.multi-range input[type=range]::-webkit-slider-thumb {
  -webkit-appearance: none;
  pointer-events: all;
  width: 20px; height: 20px;
  border-radius: 50%;
  background: var(--cta);
  border: 3px solid #fff;
  cursor: grab;
  box-shadow: 0 1px 4px rgba(0,0,0,.2);
  margin-top: -6px; /* center on 8px track */
  transition: transform .15s, box-shadow .15s;
}
.multi-range input[type=range]::-webkit-slider-thumb:active {
  cursor: grabbing; transform: scale(1.15);
  box-shadow: 0 2px 8px rgba(232,115,74,.5);
}

/* Firefox thumb */
.multi-range input[type=range]::-moz-range-thumb {
  pointer-events: all;
  width: 20px; height: 20px;
  border-radius: 50%;
  background: var(--cta);
  border: 3px solid #fff;
  cursor: grab;
  box-shadow: 0 1px 4px rgba(0,0,0,.2);
}
.multi-range input[type=range]::-moz-range-thumb:active {
  cursor: grabbing; transform: scale(1.15);
}
.multi-range input[type=range]::-moz-range-track {
  background: transparent; border: none; height: 8px;
}
```

### File 2: `resources/views/kost/search.blade.php`

**HTML changes:**
- Remove `<div class="range-track-bg">` and `<div class="range-track" id="rangeTrack">` — no longer needed
- Keep the 2 range inputs and hidden inputs

**JS changes:**
- Remove all pixel/track calculation code
- Instead, set CSS custom properties on `.multi-range`:
  ```js
  const pctMin = ((minVal - RANGE_MIN) / (RANGE_MAX - RANGE_MIN)) * 100;
  const pctMax = ((maxVal - RANGE_MIN) / (RANGE_MAX - RANGE_MIN)) * 100;
  multiRange.style.setProperty('--min-pct', pctMin + '%');
  multiRange.style.setProperty('--max-pct', pctMax + '%');
  ```
- Remove `requestAnimationFrame`, `resize` listener, `thumbHalf` calculation — none needed
- Get reference to `.multi-range` container instead of `#rangeTrack`

## Why This Fixes the Alignment

The browser positions the thumb at exactly `percentage * trackWidth` internally. Our gradient uses the same percentage values. Since both use the same math on the same element width, they're always perfectly aligned — no pixel offsets, no thumb-half calculations, no `offsetWidth` timing issues.

## Files changed: 2
1. `public/css/styles.css` — Rewrite multi-range CSS (simpler, gradient-based track)
2. `resources/views/kost/search.blade.php` — Simplify HTML (remove track divs) + simplify JS (CSS custom properties)
