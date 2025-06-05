<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Meeting extends Model
{
    use SoftDeletes;

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
