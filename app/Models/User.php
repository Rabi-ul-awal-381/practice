<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'membership_type', // main column in database
        'membership_start',
        'membership_end'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Virtual attribute: membership
    | Makes "membership" behave exactly like "membership_type"
    |--------------------------------------------------------------------------
    */
    public function getMembershipAttribute()
    {
        return $this->attributes['membership_type'] ?? 'free';
    }

    public function setMembershipAttribute($value)
    {
        $this->attributes['membership_type'] = $value;
    }

    /*
    |--------------------------------------------------------------------------
    | Role & Membership Helpers
    |--------------------------------------------------------------------------
    */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isPaidMember(): bool
    {
        $type = $this->membership_type ?? $this->membership;
        return in_array($type, ['paid', 'premium']);
    }

    public function videoViews()
    {
        return $this->hasMany(VideoView::class);
    }
}
