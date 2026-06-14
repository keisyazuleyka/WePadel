<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[Fillable(['name', 'email', 'password', 'role_id', 'avatar'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function isSuperAdmin(): bool
    {
        return $this->role && $this->role->name === 'super_admin';
    }

    public function isAdmin(): bool
    {
        return $this->role && in_array($this->role->name, ['admin', 'super_admin']);
    }

    public function isUser(): bool
    {
        return $this->role && $this->role->name === 'user';
    }

    public function activeMembership()
    {
        return $this->memberships()
            ->wherePivot('status', 'active')
            ->wherePivot('end_date', '>=', now()->toDateString())
            ->latest()
            ->first();
    }

    public function memberships(): BelongsToMany
    {
        return $this->belongsToMany(Membership::class, 'membership_users')
            ->withPivot(['start_date', 'end_date', 'status'])
            ->withTimestamps();
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function tournamentRegistrations(): HasMany
    {
        return $this->hasMany(TournamentRegistration::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }
}
