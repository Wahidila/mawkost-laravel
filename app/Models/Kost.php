<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kost extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode', 'name', 'slug', 'city_id', 'type', 'price', 'description',
        'area_label', 'available_rooms', 'total_rooms', 'total_bathrooms', 'status', 'floor_count', 'parking_type',
        'is_featured', 'is_recommended', 'unlock_price', 'address',
        'owner_contact', 'owner_name', 'maps_link', 'purchase_count',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_recommended' => 'boolean',
    ];

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function images()
    {
        return $this->hasMany(KostImage::class)->orderBy('sort_order');
    }

    public function facilities()
    {
        return $this->belongsToMany(Facility::class , 'kost_facility')->withPivot('label');
    }

    public function roomFacilities()
    {
        return $this->facilities()->where('category', 'kamar');
    }

    public function sharedFacilities()
    {
        return $this->facilities()->where('category', 'bersama');
    }

    public function nearbyPlaces()
    {
        return $this->hasMany(NearbyPlace::class)->orderBy('sort_order');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    // Scopes
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeRecommended($query)
    {
        return $query->where('is_recommended', true);
    }

    public function scopeAvailable($query)
    {
        return $query->where('status', 'tersedia');
    }

    public function scopeByCity($query, $cityId)
    {
        return $query->where('city_id', $cityId);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeByPrice($query, $min, $max)
    {
        return $query->whereBetween('price', [$min, $max]);
    }

    public function getFormattedPriceAttribute()
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    public function getBadgeClassAttribute()
    {
        return match ($this->type) {
                'putri' => 'badge-putri',
                'putra' => 'badge-putra',
                'campur' => 'badge-campur',
                default => '',
            };
    }

    public function getStatusBadgeAttribute()
    {
        if ($this->status === 'tersedia' && $this->available_rooms > 0) {
            return ['class' => 'badge-success', 'text' => 'Tersedia ' . $this->available_rooms . ' Kamar'];
        }
        return ['class' => '', 'text' => 'Penuh', 'style' => 'background:#9ca3af;color:#fff;'];
    }
}
