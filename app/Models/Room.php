<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'hotel_id',
        'name',
        'description',
        'type',
        'capacity',
        'price_per_night',
        'amenities',
        'images',
        'is_available',
        'room_number'
    ];

    protected $casts = [
        'amenities' => 'array',
        'images' => 'array',
        'is_available' => 'boolean',
        'price_per_night' => 'decimal:2',
        'capacity' => 'integer'
    ];

    public function hotel(): BelongsTo
    {
        return $this->belongsTo(Hotel::class);
    }

    public function scopeAvailable($query)
    {
        return $query->where('is_available', true);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeByCapacity($query, $capacity)
    {
        return $query->where('capacity', '>=', $capacity);
    }
}
