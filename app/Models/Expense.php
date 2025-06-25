<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = [
        'title',
        'description',
        'amount',
        'spent_at',
        'association_id',
    ];

    public function association()
    {
        return $this->belongsTo(\App\Models\Association::class);
    }
}
