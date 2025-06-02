<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class Membre extends Authenticatable
{
    use HasFactory, HasUuids, Notifiable, HasRoles;
    protected $table = 'members';

    protected $fillable = [
        'id',
        'name',
        'password',
        'phone',
        'role',
        'availability',
        'skills',
        'is_active',
        'is_admin',
        'association_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];



    public function association()
    {
        return $this->belongsTo(Association::class);
    }

    
}
