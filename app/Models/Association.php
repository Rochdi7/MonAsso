<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Association extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'id',
        'name',
        'address',
        'email',
        'logo',
        'announcement_status',
        'creation_date',
        'is_validated',
        'validation_date',
    ];

    public function membres()
    {
        return $this->hasMany(Membre::class);
    }

    
}
