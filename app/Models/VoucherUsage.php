<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VoucherUsage extends Model
{
    public $timestamps = false;

    protected $fillable = ['voucher_id', 'order_id', 'user_id', 'discount_amount'];

    protected $casts = ['created_at' => 'datetime'];

    public function voucher()
    {
        return $this->belongsTo(Voucher::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
