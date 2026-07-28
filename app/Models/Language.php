<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Language extends Model
{
    protected $fillable = [
        'code', 'name', 'native_name', 'direction', 'is_default', 'is_active', 'sort_order',
    ];

    protected $casts = [
        'is_default' => 'boolean',
        'is_active'  => 'boolean',
        'sort_order' => 'integer',
    ];

    protected static function booted(): void
    {
        static::saved(fn () => Cache::forget('languages.active'));
        static::deleted(fn () => Cache::forget('languages.active'));
    }

    /** All active languages, cached until the next create/update/delete. */
    public static function active()
    {
        $rows = Cache::rememberForever(
            'languages.active',
            fn () => static::where('is_active', true)->orderBy('sort_order')->get()->toArray()
        );

        return static::hydrate($rows);
    }

    public static function defaultLanguage(): ?self
    {
        return static::active()->firstWhere('is_default', true);
    }
}
