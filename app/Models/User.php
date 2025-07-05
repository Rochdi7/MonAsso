<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class User extends Authenticatable implements HasMedia, MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, InteractsWithMedia;

    /**
     * Explicitly set the guard name for Spatie Permissions.
     *
     * This ensures Spatie always looks for permissions
     * assigned under the "web" guard.
     */
    protected $guard_name = 'web';

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'bio',
        'availability',
        'skills',
        'is_active',
        'association_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active' => 'boolean',
        'password' => 'hashed',
    ];

    // Relations
    public function association()
    {
        return $this->belongsTo(Association::class);
    }

    public function cotisations()
    {
        return $this->hasMany(Cotisation::class);
    }

    // Register MediaLibrary collections
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('profile_photo')
            ->singleFile() // only one profile photo per user
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/gif']);
    }
}
