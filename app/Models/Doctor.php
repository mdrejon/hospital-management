<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class Doctor extends Model
{
    use HasTranslations;

    public array $translatable = ['name', 'role', 'bio', 'address', 'phone', 'seo_title', 'seo_description'];

    /**
     * Columns holding a *list* of translatable values ([{locale => text}, …]) rather
     * than a single one, so an admin can enter several entries per field. Read them
     * with listValues()/listText() — the plain attribute returns the raw array.
     */
    public const TRANSLATABLE_LISTS = ['specialty', 'degrees', 'experience', 'awards', 'skills'];

    protected $fillable = [
        'name', 'slug', 'role', 'photo',
        'specialty', 'doctor_specialization_id', 'degrees', 'experience', 'awards', 'bio',
        'skills', 'schedule', 'consultation_fee',
        'address', 'phone', 'email',
        'facebook_url', 'twitter_url', 'instagram_url', 'linkedin_url', 'youtube_url',
        'is_featured', 'sort_order', 'is_active',
        'seo_title', 'seo_description', 'seo_keywords', 'seo_og_image',
    ];

    protected $casts = [
        'specialty'         => 'array',
        'degrees'           => 'array',
        'experience'        => 'array',
        'awards'            => 'array',
        'skills'            => 'array',
        'schedule'          => 'array',
        'consultation_fee'  => 'decimal:2',
        'is_featured'       => 'boolean',
        'is_active'         => 'boolean',
        'sort_order'        => 'integer',
    ];

    /**
     * Resolves one of the TRANSLATABLE_LISTS columns to plain current-locale strings,
     * dropping entries that are blank in every locale. Tolerates the shapes older rows
     * may still carry — a bare string, or a single {locale => text} map from before
     * these fields accepted multiple entries.
     */
    public function listValues(string $field): array
    {
        $raw = $this->getAttribute($field);

        if (blank($raw)) {
            return [];
        }
        if (!is_array($raw)) {
            return [(string) $raw];
        }
        if (!array_is_list($raw)) {
            $raw = [$raw];
        }

        return array_values(array_filter(
            array_map(fn ($item) => $this->localeText($item), $raw),
            fn ($text) => $text !== ''
        ));
    }

    /** listValues() joined into one line — for search results, dropdown labels and other single-line spots. */
    public function listText(string $field, string $glue = ', '): string
    {
        return implode($glue, $this->listValues($field));
    }

    /** Current locale's text out of a {locale => text} map, falling back to the app fallback locale, then any filled locale. */
    private function localeText($item): string
    {
        if (!is_array($item)) {
            return trim((string) $item);
        }

        foreach ([app()->getLocale(), config('app.fallback_locale')] as $locale) {
            if (filled($item[$locale] ?? null)) {
                return trim($item[$locale]);
            }
        }

        return trim((string) (collect($item)->first(fn ($v) => filled($v)) ?? ''));
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order')->orderBy('id');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_active', true)->where('is_featured', true)
            ->orderBy('sort_order')->orderBy('id');
    }

    public function services()
    {
        return $this->belongsToMany(Service::class);
    }

    public function specialization(): BelongsTo
    {
        return $this->belongsTo(DoctorSpecialization::class, 'doctor_specialization_id');
    }

    public function chambers(): HasMany
    {
        return $this->hasMany(DoctorChamber::class)->orderBy('sort_order')->orderBy('id');
    }

    public function availabilities(): HasMany
    {
        return $this->hasMany(DoctorAvailability::class)->orderBy('weekday');
    }

    public function leaves(): HasMany
    {
        return $this->hasMany(DoctorLeave::class);
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    public function user(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
