<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'image', 'kost_count'];

    public function kosts()
    {
        return $this->hasMany(Kost::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
