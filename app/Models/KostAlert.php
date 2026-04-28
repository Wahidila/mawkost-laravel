<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KostAlert extends Model
{
    protected $fillable = [
        'user_id', 'city_id', 'kost_type_id', 'max_price',
        'channel', 'is_active', 'last_notified_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'last_notified_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function kostType()
    {
        return $this->belongsTo(KostType::class);
    }

    public function matchesKost(Kost $kost): bool
    {
        if ($this->city_id && $this->city_id !== $kost->city_id) {
            return false;
        }

        if ($this->kost_type_id && $this->kost_type_id !== $kost->kost_type_id) {
            return false;
        }

        if ($this->max_price && $kost->price > $this->max_price) {
            return false;
        }

        return true;
    }
}
