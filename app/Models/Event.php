<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'location',
        'start_datetime',
        'end_datetime',
        'status',
        'association_id',
    ];

    public function association()
    {
        return $this->belongsTo(Association::class);
    }
}
