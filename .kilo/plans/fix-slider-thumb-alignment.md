# Plan: Fix Slider Thumb-to-Track Alignment

## Problem
The colored track (`.range-track`) doesn't align with the thumb positions. When the user drags a thumb, the colored fill segment is offset from where the thumb actually sits.

**Root cause:** Browser range inputs have built-in padding — the thumb center travels from `thumbWidth/2` to `containerWidth - thumbWidth/2`, not from `0` to `containerWidth`. The current JS uses a simple percentage calculation (`left: X%`, `width: Y%`) which maps to the full container width, causing a mismatch.

## Fix

### File: `resources/views/kost/search.blade.php` (JS only)

Replace the track position calculation in `updateSlider()` to use pixel-based positioning that accounts for the thumb's half-width (11px for a 22px thumb):

**Current (broken):**
```js
const pctMin = ((minVal - RANGE_MIN) / (RANGE_MAX - RANGE_MIN)) * 100;
const pctMax = ((maxVal - RANGE_MIN) / (RANGE_MAX - RANGE_MIN)) * 100;
track.style.left = pctMin + '%';
track.style.width = (pctMax - pctMin) + '%';
```

**Fixed:**
```js
const pctMin = (minVal - RANGE_MIN) / (RANGE_MAX - RANGE_MIN);
const pctMax = (maxVal - RANGE_MIN) / (RANGE_MAX - RANGE_MIN);

// Account for thumb radius — browser thumbs don't reach the edges
const thumbHalf = 11; // half of 22px thumb
const rangeWidth = minRange.offsetWidth;
const usableWidth = rangeWidth - thumbHalf * 2;
const leftPx = thumbHalf + pctMin * usableWidth;
const rightPx = thumbHalf + pctMax * usableWidth;
track.style.left = leftPx + 'px';
track.style.width = (rightPx - leftPx) + 'px';
```

This converts from percentage-based to pixel-based positioning, offsetting by the thumb's half-width on each side. The track endpoints will now perfectly align with the center of each thumb at all positions.

## Files changed: 1
- `resources/views/kost/search.blade.php` — Fix track position calculation in JS (6 lines changed)

## No CSS changes needed
The CSS is correct — `.range-track` already uses `position: absolute` with `left` and `width`, which works with both `%` and `px` values.
