<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_no', 'kost_id', 'user_id', 'customer_name', 'customer_whatsapp',
        'customer_email', 'amount', 'original_amount', 'discount_amount', 'voucher_id',
        'payment_method', 'status', 'paid_at',
        'xendit_invoice_id', 'xendit_invoice_url', 'xendit_payment_method', 'xendit_payment_channel',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
    ];

    public function kost()
    {
        return $this->belongsTo(Kost::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function voucher()
    {
        return $this->belongsTo(Voucher::class);
    }

    public static function generateInvoiceNo(): string
    {
        $date = now()->format('ymd');
        $random = str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
        return "INV-{$date}-{$random}";
    }

    public function getFormattedAmountAttribute()
    {
        return 'Rp ' . number_format($this->amount, 0, ',', '.');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeExpired($query)
    {
        return $query->where('status', 'expired');
    }
}
