# Blueprint Integrasi XSender (Laravel)

Dokumen ini khusus untuk integrasi XSender di aplikasi Laravel. Tujuannya: pengguna cukup mengisi **API Key** dan **Nomor WhatsApp XSender**, lalu sistem dapat mengirim notifikasi WhatsApp.

---

## 1) Konsep Umum

**Input minimal:**
- `api_key` (API Key dari XSender)
- `sender` (Nomor WhatsApp XSender yang terhubung)
- `number` (Nomor tujuan)
- `message` (Isi pesan)

**Alur:**
```
App Laravel
    -> API XSender
        -> Node Server
            -> WhatsApp Device
```

---dfdf




## 2) Endpoint Standar

`POST https://xsender.id/id/send-message`

**Payload minimal:**
```json
{
  "api_key": "YOUR_API_KEY",
  "sender": "6281234567890",
  "number": "6289876543210",
  "message": "Halo, ini pesan dari sistem."
}
```

---

## 3) Konfigurasi ENV

Tambahkan ke `.env`:
```
XSENDER_API_KEY=xxxx
XSENDER_SENDER=6281234567890
XSENDER_ENDPOINT=https://xsender.id/id/send-message
```

---

## 4) Service Sederhana (Laravel)

Buat service sederhana (contoh di `app/Services/XSenderService.php`):
```php
<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class XSenderService
{
    public function send(string $phone, string $message): array
    {
        $response = Http::asForm()->post(config('services.xsender.endpoint'), [
            'api_key' => config('services.xsender.api_key'),
            'sender'  => config('services.xsender.sender'),
            'number'  => $phone,
            'message' => $message,
        ]);

        return [
            'ok' => $response->successful(),
            'status' => $response->status(),
            'body' => $response->body(),
        ];
    }
}
```

Tambahkan config di `config/services.php`:
```php
<?php

return [
    // ...
    'xsender' => [
        'api_key' => env('XSENDER_API_KEY'),
        'sender' => env('XSENDER_SENDER'),
        'endpoint' => env('XSENDER_ENDPOINT', 'https://xsender.id/id/send-message'),
    ],
];
```

---

## 5) Contoh Pemakaian

```php
use App\Services\XSenderService;

$xsender = new XSenderService();
$result = $xsender->send('6289876543210', 'Halo, ini pesan dari sistem.');

if (!$result['ok']) {
    // Log atau handle error
}
```

---

## 6) Template Pesan (Placeholder)

Format umum:
```
Nama: {name}
Email: {email}
Nomor: {phone}
Order: {order_id}
Total: {amount}
```

**Aturan:**
- Placeholder di-replace sebelum kirim.
- Field bisa dikustom sesuai kebutuhan integrasi.

---

## 7) Format Nomor

Gunakan format internasional Indonesia:
```
628xxxxxxxxxx
```

---

## 8) Troubleshooting Ringkas

- **Tidak terkirim:** cek API Key & status device.
- **Server error:** cek node server status.
- **Nomor gagal:** pastikan format 62 dan bukan 0.

---

## 9) Catatan Keamanan

- Jangan tampilkan API Key di client-side.
- Simpan API Key di backend/env.
- Batasi akses endpoint internal.

