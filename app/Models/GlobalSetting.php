<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class GlobalSetting extends Model
{
    protected $fillable = ['key', 'value'];

    /** Get a setting value by key, with optional default. */
    public static function get(string $key, mixed $default = null): mixed
    {
        $setting = static::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    /** Set (upsert) a single setting. */
    public static function set(string $key, mixed $value): void
    {
        if (is_array($value)) {
            $value = json_encode($value, JSON_UNESCAPED_UNICODE);
        }
        static::updateOrCreate(['key' => $key], ['value' => $value]);
    }

    /** Bulk-upsert an associative array of key => value pairs. */
    public static function setMany(array $data): void
    {
        foreach ($data as $key => $value) {
            static::set($key, $value);
        }
    }

    /** Return all settings as a flat key=>value array. */
    public static function allAsArray(): array
    {
        return static::all()->pluck('value', 'key')->toArray();
    }

    /** Get a translatable key's value for a locale (default: current), falling back to the default locale, then a plain default. */
    public static function getTranslated(string $key, ?string $locale = null, mixed $default = null): mixed
    {
        $locale ??= app()->getLocale();
        $fallback = Language::defaultLanguage()?->code ?? config('app.fallback_locale');
        $decoded = json_decode((string) static::get($key), true);

        if (! is_array($decoded)) {
            return static::get($key, $default);
        }

        return $decoded[$locale] ?: ($decoded[$fallback] ?? $default);
    }

    /** Store a translatable key from an ['en' => ..., 'bn' => ...] array as JSON. */
    public static function setTranslated(string $key, array $localized): void
    {
        static::set($key, json_encode($localized, JSON_UNESCAPED_UNICODE));
    }

    /** Decode a translatable key's raw stored value into an {en,bn} array for admin edit forms (empty shape if unset/legacy plain string). */
    public static function getTranslatedArray(string $key): array
    {
        $raw = static::get($key);
        $decoded = $raw ? json_decode($raw, true) : null;

        if (is_array($decoded)) {
            return $decoded;
        }

        $default = Language::defaultLanguage()?->code ?? config('app.locale');

        return $raw !== null && $raw !== '' ? [$default => $raw] : [];
    }
}
