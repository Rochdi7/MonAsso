<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cotisation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'association_id',
        'approved_by',
        'year',
        'amount',
        'paid_at',
        'status',
        'paid_at',
        'receipt_number',
    ];

    public const STATUS_PENDING  = 0;
    public const STATUS_PAID     = 1;
    public const STATUS_OVERDUE  = 2;
    public const STATUS_REJECTED = 3;

    public static function getStatuses(): array
    {
        return [
            self::STATUS_PENDING  => 'pending',
            self::STATUS_PAID     => 'paid',
            self::STATUS_OVERDUE  => 'overdue',
            self::STATUS_REJECTED => 'rejected',
        ];
    }

    public function getStatusLabel(): string
    {
        return self::getStatuses()[$this->status] ?? 'unknown';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function association()
    {
        return $this->belongsTo(Association::class);
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
