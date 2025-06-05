<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Association extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia; 

    protected $fillable = [
        'name',
        'address',
        'email',
        'announcement_status',
        'creation_date',
        'is_validated',
        'validation_date',
    ];

    public function membres()
    {
        return $this->hasMany(User::class); 
    }
}
