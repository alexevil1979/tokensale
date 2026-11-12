<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentGateway extends Model
{
    protected $fillable = [
        'code', 'name', 'group', 'enabled', 'test_mode',
        'min_amount_cents', 'sort', 'config',
    ];

    protected $casts = [
        'enabled' => 'boolean',
        'test_mode' => 'boolean',
        'min_amount_cents' => 'integer',
        'sort' => 'integer',
        'config' => 'array',
    ];

    public function configGet(string $key, $default = null)
    {
        return data_get($this->config ?? [], $key, $default);
    }
}
