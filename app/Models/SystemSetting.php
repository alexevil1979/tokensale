<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SystemSetting extends Model
{
    protected $fillable = ['key', 'value'];

    protected $casts = ['value' => 'array'];

    public static function getValue(string $key, $default = null)
    {
        $row = Cache::remember("sysset:$key", 60, fn () => static::query()->where('key', $key)->first());
        return $row ? ($row->value['v'] ?? $row->value) : $default;
    }

    public static function putValue(string $key, $value): void
    {
        static::query()->updateOrCreate(['key' => $key], ['value' => ['v' => $value]]);
        Cache::forget("sysset:$key");
    }
}
