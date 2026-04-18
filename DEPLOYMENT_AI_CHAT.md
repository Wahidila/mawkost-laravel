# Panduan Deploy AI Chat ke Server Hostinger

## 1. Pull Kode Terbaru di Server

SSH ke server Hostinger, lalu:

```bash
cd /home/u123456789/domains/mawkost.id/public_html
git pull origin main
```

## 2. Install Dependencies (Jika Ada Package Baru)

```bash
composer install --no-dev --optimize-autoloader
```

## 3. Jalankan Migration

```bash
php artisan migrate --force
```

Ini akan membuat tabel `chat_messages` dengan struktur:
- `id` (bigint, primary key)
- `session_id` (string, indexed)
- `role` (enum: user/assistant)
- `content` (text)
- `created_at`, `updated_at`

## 4. Clear Cache

```bash
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear
```

## 5. Set Permissions (Jika Perlu)

```bash
chmod -R 755 storage bootstrap/cache
chown -R u123456789:u123456789 storage bootstrap/cache
```

## 6. Konfigurasi AI Provider di Admin Panel

1. Login ke admin panel: `https://mawkost.id/admin`
2. Buka menu **Pengaturan** → **Pengaturan AI Chat**
3. Isi form:
   - **Aktifkan AI Konsultasi**: Toggle ON
   - **API Key**: Masukkan API key dari provider AI (OpenAI, Groq, Together, dll)
   - **Base URL**: 
     - OpenAI: `https://api.openai.com/v1`
     - Groq: `https://api.groq.com/openai/v1`
     - Together: `https://api.together.xyz/v1`
     - DeepSeek: `https://api.deepseek.com/v1`
   - **Model**: Nama model, contoh:
     - OpenAI: `gpt-4o-mini` atau `gpt-4o`
     - Groq: `llama-3.3-70b-versatile` atau `mixtral-8x7b-32768`
     - Together: `meta-llama/Meta-Llama-3.1-70B-Instruct-Turbo`
     - DeepSeek: `deepseek-chat`
   - **Max Tokens**: `1024` (default, bisa dinaikkan jika perlu respons lebih panjang)
   - **Temperature**: `0.7` (default, 0 = deterministik, 1 = kreatif)
   - **System Prompt**: Kosongkan (sudah ada default yang optimal)

4. Klik **Test Koneksi** untuk memastikan API key dan base URL benar
5. Jika test berhasil, klik **Simpan Pengaturan**

## 7. Verifikasi Fitur Berjalan

1. Buka `https://mawkost.id/konsultasi`
2. Pastikan:
   - Welcome message muncul dengan suggestion chips
   - Decorative blobs terlihat di background
   - Input form centered di bawah
   - Tombol reset (rotate icon) ada di sebelah tombol send
3. Coba kirim pesan: "Rekomendasikan kost murah di Malang"
4. Pastikan:
   - Typing indicator (3 bouncing dots) muncul
   - Teks muncul secara live (plain text)
   - Setelah selesai, teks berubah jadi formatted markdown (bold, list, link)
   - Link kost bisa diklik dan mengarah ke halaman detail

## 8. Monitoring & Maintenance

### Clear AI Knowledge Cache (Jika Data Kost Diupdate)

Setiap kali ada perubahan data kost (tambah/edit/hapus), clear cache agar AI dapat data terbaru:

```bash
php artisan cache:forget ai_kost_knowledge_base
php artisan cache:forget ai_kost_summary
php artisan cache:forget ai_kost_listings
```

Atau via admin panel: **Pengaturan AI Chat** → **Clear Knowledge Cache**

### Cleanup Chat History Lama (Opsional)

Untuk menghemat storage, bisa hapus chat messages > 30 hari:

```bash
php artisan tinker
```

```php
ChatMessage::where('created_at', '<', now()->subDays(30))->delete();
exit
```

Atau buat cron job di Hostinger cPanel:
```bash
# Jalankan setiap hari jam 3 pagi
0 3 * * * cd /home/u123456789/domains/mawkost.id/public_html && php artisan tinker --execute="ChatMessage::where('created_at', '<', now()->subDays(30))->delete();"
```

## 9. Troubleshooting

### AI Tidak Merespons / Error 503

**Penyebab**: AI provider down atau API key salah

**Solusi**:
1. Cek admin panel → Test Koneksi
2. Pastikan API key masih valid (tidak expired/revoked)
3. Cek quota/billing di dashboard provider

### Respons AI Lambat

**Penyebab**: Model terlalu besar atau server provider lambat

**Solusi**:
1. Ganti ke model lebih kecil (misal: `gpt-4o-mini` atau `llama-3.1-8b`)
2. Kurangi `max_tokens` di settings (misal: 512)
3. Pertimbangkan ganti provider (Groq paling cepat untuk open-source models)

### Rate Limit Error (429)

**Penyebab**: User mengirim > 30 pesan dalam 1 jam

**Solusi**: Ini by design untuk mencegah abuse. User perlu tunggu atau clear browser localStorage:
```js
// Di browser console
localStorage.removeItem('mawkost_chat_session');
```

Atau admin bisa naikkan limit di `app/Http/Middleware/ChatRateLimit.php` (line 18):
```php
$maxAttempts = 30; // Ubah ke 50 atau 100
```

### Tabel Markdown Tidak Muncul

**Penyebab**: CSS tidak ter-load atau browser cache

**Solusi**:
1. Hard refresh browser (Ctrl+Shift+R)
2. Clear cache di server: `php artisan view:clear`
3. Cek file `public/css/styles.css` sudah terupdate (ada `.chat-table-wrap` styles)

## 10. Estimasi Biaya AI Provider

Dengan optimasi token yang sudah dilakukan (~5k token per request):

| Provider | Model | Input | Output | Per 1000 Chat |
|----------|-------|-------|--------|---------------|
| OpenAI | gpt-4o-mini | $0.15/1M | $0.60/1M | ~$1.50 |
| Groq | llama-3.3-70b | FREE | FREE | $0 |
| Together | llama-3.1-70b | $0.88/1M | $0.88/1M | ~$2.20 |
| DeepSeek | deepseek-chat | $0.14/1M | $0.28/1M | ~$0.70 |

**Rekomendasi**: Mulai dengan **Groq** (gratis, cepat) atau **DeepSeek** (paling murah).

## 11. Fitur Tambahan (Opsional)

### A. Tambah Cron untuk Auto-Clear Cache

Agar knowledge base selalu fresh tanpa manual clear:

```bash
# Jalankan setiap 5 menit
*/5 * * * * cd /home/u123456789/domains/mawkost.id/public_html && php artisan cache:forget ai_kost_knowledge_base
```

### B. Monitoring Chat Usage

Buat query untuk lihat statistik:

```sql
-- Total chat sessions hari ini
SELECT COUNT(DISTINCT session_id) FROM chat_messages WHERE DATE(created_at) = CURDATE();

-- Total messages hari ini
SELECT COUNT(*) FROM chat_messages WHERE DATE(created_at) = CURDATE();

-- Top 10 pertanyaan user
SELECT content, COUNT(*) as count FROM chat_messages WHERE role = 'user' GROUP BY content ORDER BY count DESC LIMIT 10;
```

---

## Checklist Deploy

- [ ] `git pull` di server
- [ ] `composer install --no-dev --optimize-autoloader`
- [ ] `php artisan migrate --force`
- [ ] `php artisan config:clear && php artisan route:clear && php artisan view:clear && php artisan cache:clear`
- [ ] Set permissions `chmod -R 755 storage bootstrap/cache`
- [ ] Login admin panel → Pengaturan AI Chat
- [ ] Isi API Key, Base URL, Model
- [ ] Test Koneksi → Simpan
- [ ] Buka `/konsultasi` → Test kirim pesan
- [ ] Verifikasi respons AI muncul dengan formatting benar

---

**Selesai!** Fitur AI Chat sudah live di `https://mawkost.id/konsultasi`
