<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Meeting extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia;

    protected $fillable = [
        'title',
        'description',
        'datetime',
        'status',
        'location',
        'association_id',
        'organizer_id',
    ];

    protected $casts = [
        'datetime' => 'datetime',
    ];

    // Relationships
    public function association()
    {
        return $this->belongsTo(Association::class);
    }

    public function organizer()
    {
        return $this->belongsTo(User::class, 'organizer_id');
    }
}
