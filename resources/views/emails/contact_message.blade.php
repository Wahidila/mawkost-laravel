<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Pesan Kontak Baru: {{ $contact->subject }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #f9f9f9;
            color: #333;
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }
        .header {
            background-color: #8B5E3C; /* Mawkost Primary */
            color: #ffffff;
            padding: 20px;
            text-align: center;
        }
        .header h2 {
            margin: 0;
            font-size: 20px;
        }
        .content {
            padding: 30px;
        }
        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .details-table th, .details-table td {
            text-align: left;
            padding: 10px;
            border-bottom: 1px solid #eeeeee;
        }
        .details-table th {
            width: 30%;
            color: #666;
            font-weight: bold;
        }
        .message-box {
            background-color: #f7f3f0;
            padding: 15px;
            border-left: 4px solid #D68F59; /* Mawkost CTA */
            border-radius: 4px;
            margin-top: 10px;
            white-space: pre-wrap;
        }
        .footer {
            background-color: #f4f4f4;
            padding: 15px;
            text-align: center;
            font-size: 12px;
            color: #888;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Pesan Kontak Baru Mawkost</h2>
        </div>
        <div class="content">
            <p>Halo Admin,</p>
            <p>Anda menerima pesan kontak baru melalui website Mawkost. Berikut adalah rinciannya:</p>
            
            <table class="details-table">
                <tr>
                    <th>Nama Pengirim</th>
                    <td>{{ $contact->name }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td><a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a></td>
                </tr>
                <tr>
                    <th>WhatsApp</th>
                    <td>{{ $contact->whatsapp ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Subjek</th>
                    <td><strong>{{ $contact->subject }}</strong></td>
                </tr>
                <tr>
                    <th>Tanggal Waktu</th>
                    <td>{{ $contact->created_at->format('d M Y, H:i') }}</td>
                </tr>
            </table>

            <p style="margin-bottom: 5px; font-weight: bold; color: #666;">Isi Pesan:</p>
            <div class="message-box">
{{ $contact->message }}
            </div>

            <p style="margin-top: 30px;">
                <a href="{{ route('admin.contacts.show', $contact->id) }}" style="display: inline-block; background-color: #D68F59; color: #fff; padding: 10px 20px; text-decoration: none; border-radius: 20px; font-weight: bold; font-size: 14px;">
                    Lihat di Dashboard Admin
                </a>
            </p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Mawkost. Email ini dibuat otomatis oleh sistem Mawkost.
        </div>
    </div>
</body>
</html>
