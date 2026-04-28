<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $fillable = [
        'code', 'discount_type', 'discount_value', 'min_amount',
        'max_uses', 'used_count', 'expires_at', 'is_active', 'description',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'expires_at' => 'datetime',
    ];

    public function usages()
    {
        return $this->hasMany(VoucherUsage::class);
    }

    public function isValid(int $amount = 0): array
    {
        if (!$this->is_active) {
            return ['valid' => false, 'message' => 'Voucher tidak aktif.'];
        }

        if ($this->expires_at && $this->expires_at->isPast()) {
            return ['valid' => false, 'message' => 'Voucher sudah expired.'];
        }

        if ($this->max_uses && $this->used_count >= $this->max_uses) {
            return ['valid' => false, 'message' => 'Voucher sudah habis digunakan.'];
        }

        if ($this->min_amount && $amount < $this->min_amount) {
            return ['valid' => false, 'message' => 'Minimum transaksi Rp ' . number_format($this->min_amount, 0, ',', '.') . '.'];
        }

        return ['valid' => true, 'message' => 'Voucher valid!'];
    }

    public function calculateDiscount(int $amount): int
    {
        if ($this->discount_type === 'fixed') {
            return min($this->discount_value, $amount);
        }

        return (int) floor($amount * $this->discount_value / 100);
    }

    public function getFormattedDiscountAttribute(): string
    {
        if ($this->discount_type === 'percentage') {
            return $this->discount_value . '%';
        }
        return 'Rp ' . number_format($this->discount_value, 0, ',', '.');
    }
}
