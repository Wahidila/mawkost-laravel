<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NearbyPlace extends Model
{
    public $timestamps = false;

    protected $fillable = ['kost_id', 'description', 'sort_order'];

    public function kost()
    {
        return $this->belongsTo(Kost::class);
    }
}
