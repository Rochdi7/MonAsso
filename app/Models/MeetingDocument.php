<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MeetingDocument extends Model
{
    protected $fillable = ['meeting_id', 'name', 'path'];

    public function meeting()
    {
        return $this->belongsTo(Meeting::class);
    }
}
