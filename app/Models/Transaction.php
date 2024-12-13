<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'paycom_transaction_id',
        'paycom_time',
        'paycom_time_datetime',
        'create_time',
        'perform_time',
        'cancel_time',
        'amount',
        'state',
        'reason',
        'receivers',
        'order_id',
        'owner_id',
        'perform_time_unix',
        'transaction',
        'code',
        'payme_time',
    ];

    public static function getTransactionsByTimeRange($from, $to)
    {
        return self::whereBetween('paycom_time', [$from, $to])
            ->get();
    }
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
}
