<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Membre extends Authenticatable
{
    use HasFactory, HasUuids, Notifiable;
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

    // Remove this if you now use the default password field
    // public function getAuthPassword()
    // {
    //     return $this->mot_de_passe;
    // }

    public function association()
    {
        return $this->belongsTo(Association::class);
    }

    
}
