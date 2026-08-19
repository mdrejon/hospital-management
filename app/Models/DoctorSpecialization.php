<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class DoctorSpecialization extends Model
{
    use HasTranslations;

    public array $translatable = ['name', 'description', 'heading', 'content', 'seo_title', 'seo_description'];

    protected $fillable = ['name', 'slug', 'description', 'is_active', 'sort_order', 'image', 'heading', 'content', 'seo_title', 'seo_description'];

    protected $casts = [
        'is_active'  => 'boolean',
        'sort_order' => 'integer',
    ];

    public function doctors(): HasMany
    {
        return $this->hasMany(Doctor::class, 'doctor_specialization_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order')->orderBy('id');
    }
}
