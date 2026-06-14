<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'description', 'location', 'price_per_hour', 'is_available'])]
class Court extends Model
{
    use HasFactory;

    public function images(): HasMany
    {
        return $this->hasMany(CourtImage::class);
    }

    public function primaryImage()
    {
        return $this->images()->where('is_primary', true)->first() 
            ?? $this->images()->first();
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function averageRating(): float
    {
        return (float) ($this->reviews()->avg('rating') ?? 5.0);
    }
}
