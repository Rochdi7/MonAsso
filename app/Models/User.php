<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class User extends Authenticatable implements HasMedia
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'availability',
        'skills',
        'is_active',
        'association_id',
        'profile_photo',
    ];

    /**
     * The attributes that should be hidden for arrays and JSON.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active' => 'boolean',
        'password' => 'hashed',
    ];

    /**
     * Relationship: User belongs to an Association.
     */
    public function association()
    {
        return $this->belongsTo(Association::class);
    }

    /**
     * Relationship: User has many dues (if applicable).
     */
    public function dues()
    {
        return $this->hasMany(Due::class, 'member_id');
    }

    /**
     * Relationship: User has many event participations.
     */
    public function eventParticipations()
    {
        return $this->hasMany(EventParticipation::class, 'member_id');
    }

    /**
     * Relationship: User has many meeting attendances.
     */
    public function meetingAttendances()
    {
        return $this->hasMany(MeetingAttendance::class, 'member_id');
    }
}
