<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_no', 'kost_id', 'user_id', 'customer_name', 'customer_whatsapp',
        'customer_email', 'amount', 'payment_method', 'status', 'paid_at',
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
}
