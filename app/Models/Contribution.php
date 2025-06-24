<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contribution extends Model
{
    protected $fillable = [
        'type',
        'amount',
        'description',
        'received_at',
        'association_id',
    ];

    public function association()
    {
        return $this->belongsTo(\App\Models\Association::class);
    }
}
