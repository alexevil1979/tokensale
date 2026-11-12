<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaymentOrder extends Model
{
    protected $fillable = [
        'user_id', 'gateway_code', 'amount_cents', 'currency', 'status',
        'idempotency_key', 'external_id', 'pay_url', 'meta', 'paid_at',
    ];

    protected $casts = [
        'amount_cents' => 'integer',
        'meta' => 'array',
        'paid_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
