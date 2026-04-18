# Plan: Update Office Address on Contact Page

## Current Situation
The contact page (`resources/views/contact.blade.php`) displays the office address at lines 42-43:

**Current address:**
```
Malang Creative Center (MCC)
Jl. A. Yani No.53, Blimbing
Kota Malang, Jawa Timur
```

This address only appears in the contact page — it's not duplicated in the footer, about page, or anywhere else in the codebase.

## Required Change

Replace the current address with the new Bali office address:

**New address:**
```
JL. PULAU BATAM NO. 12
Desa/Kelurahan Dauh Puri Kelod
Kec. Denpasar Barat, Kota Denpasar
Provinsi Bali, Kode Pos: 80114
```

## Implementation

### File to modify: `resources/views/contact.blade.php`

**Line 43 — Replace:**
```html
<p>Malang Creative Center (MCC)<br>Jl. A. Yani No.53, Blimbing<br>Kota Malang, Jawa Timur</p>
```

**With:**
```html
<p>JL. PULAU BATAM NO. 12<br>Desa/Kelurahan Dauh Puri Kelod<br>Kec. Denpasar Barat, Kota Denpasar<br>Provinsi Bali, Kode Pos: 80114</p>
```

## Notes
- The address is only displayed in one location (contact page)
- No database changes needed
- No other files affected
- Simple text replacement in a single view file
