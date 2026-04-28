<?php

namespace App\Models;

use App\Services\WatermarkService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KostImage extends Model
{
    use HasFactory;

    protected $fillable = ['kost_id', 'image_path', 'alt_text', 'sort_order'];

    protected $appends = ['url'];

    public function kost()
    {
        return $this->belongsTo(Kost::class);
    }

    public function getUrlAttribute(): string
    {
        $base = asset($this->image_path);

        if (!str_starts_with($this->image_path, 'storage/kosts/')) {
            return $base;
        }

        $version = WatermarkService::getVersion();

        return $base . '?v=' . $version;
    }
}
