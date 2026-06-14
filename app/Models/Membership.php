<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[Fillable(['name', 'price', 'discount_percentage', 'benefits', 'duration_in_days'])]
class Membership extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'benefits' => 'array',
        ];
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'membership_users')
            ->withPivot(['start_date', 'end_date', 'status'])
            ->withTimestamps();
    }
}
