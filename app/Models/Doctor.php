<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class Doctor extends Model
{
    use HasTranslations;

    public array $translatable = ['role', 'specialty', 'degrees', 'experience', 'awards', 'bio', 'seo_title', 'seo_description'];

    protected $fillable = [
        'name', 'slug', 'role', 'photo',
        'specialty', 'degrees', 'experience', 'awards', 'bio',
        'skills', 'schedule', 'consultation_fee',
        'address', 'phone', 'email',
        'facebook_url', 'twitter_url', 'instagram_url', 'linkedin_url', 'youtube_url',
        'is_featured', 'sort_order', 'is_active',
        'seo_title', 'seo_description', 'seo_keywords', 'seo_og_image',
    ];

    protected $casts = [
        'skills'            => 'array',
        'schedule'          => 'array',
        'consultation_fee'  => 'decimal:2',
        'is_featured'       => 'boolean',
        'is_active'         => 'boolean',
        'sort_order'        => 'integer',
    ];

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
