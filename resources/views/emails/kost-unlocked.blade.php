<x-mail::message>
# Halo, {{ $user->name }} 👋

Terima kasih telah menggunakan **mawkost**. Pembayaran untuk kode tiket **{{ $kost->kode }}** telah berhasil (Invoice: {{ $order->invoice_no }}).

Berikut adalah detail informasi kontak untuk kost yang Anda unlock:

<x-mail::panel>
**{{ $kost->name }}**

<div style="font-size: 14px;">
**📱 Nama Pemilik:**<br>
{{ $kost->owner_name ?? 'Bapak/Ibu Kost' }}

**📞 WhatsApp Pemilik:**<br>
[{{ $kost->owner_contact ?? '-' }}](https://wa.me/{{ preg_replace('/[^0-9]/', '', str_replace('+62', '62', $kost->owner_contact)) }})

**📍 Alamat Lengkap:**<br>
{{ $kost->address ?? '-' }}

@if($kost->maps_link)
**🗺️ Google Maps:**<br>
[Buka Titik Lokasi di Maps]({{ $kost->maps_link }})
@endif
</div>
</x-mail::panel>

Anda kini bisa langsung menghubungi pemilik kost untuk bertanya lebih detail atau memesan kamar.

<x-mail::button :url="'https://wa.me/' . preg_replace('/[^0-9]/', '', str_replace('+62', '62', $kost->owner_contact)) . '?text=' . urlencode('Halo, saya ' . $user->name . '. Saya tertarik dengan ' . $kost->name . ' (Kode: ' . $kost->kode . '). Apakah masih tersedia?')" color="success">
Hubungi via WhatsApp Sekarang
</x-mail::button>

Anda juga dapat melihat kembali detail pembukaan info ini kapan saja melalui Dashboard Member Anda.

<x-mail::button :url="route('user.orders.show', $order->id)">
Lihat Detail Pesanan
</x-mail::button>

Terima kasih,<br>
Tim **{{ config('app.name') }}**
</x-mail::message>
