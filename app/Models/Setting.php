<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = ['key', 'value'];

    /** Default values used when a setting has never been saved. */
    public const DEFAULTS = [
        'daycare_fee' => 350,
        'bath_lunch_fee' => 160,
    ];

    public static function get(string $key, $default = null)
    {
        $all = Cache::rememberForever('settings', fn () => static::pluck('value', 'key')->all());

        return $all[$key] ?? $default ?? (self::DEFAULTS[$key] ?? null);
    }

    public static function set(string $key, $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
        Cache::forget('settings');
    }

    public static function daycareFee(): float
    {
        return (float) static::get('daycare_fee');
    }

    public static function bathLunchFee(): float
    {
        return (float) static::get('bath_lunch_fee');
    }
}
