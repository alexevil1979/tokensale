<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UsageEvent extends Model
{
    protected $fillable = [
        'user_id', 'api_key_id', 'model_id', 'request_id',
        'prompt_tokens', 'completion_tokens', 'total_tokens',
        'cost_cents', 'status', 'latency_ms',
    ];

    protected $casts = [
        'prompt_tokens' => 'integer',
        'completion_tokens' => 'integer',
        'total_tokens' => 'integer',
        'cost_cents' => 'integer',
        'latency_ms' => 'integer',
    ];

    public function model(): BelongsTo
    {
        return $this->belongsTo(AiModel::class, 'model_id');
    }
}
