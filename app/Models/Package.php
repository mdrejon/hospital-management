<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Package extends Model
{
    use HasTranslations;

    public array $translatable = ['title', 'short_desc', 'description', 'badge_label', 'seo_title', 'seo_description'];

    protected $fillable = [
        'title', 'slug', 'image', 'short_desc', 'description',
        'features', 'secondary_image', 'badge_value', 'badge_label',
        'is_featured', 'sort_order', 'is_active',
        'seo_title', 'seo_description', 'seo_keywords', 'seo_og_image',
    ];

    protected $casts = [
        'features'    => 'array',
        'is_featured' => 'boolean',
        'is_active'   => 'boolean',
        'sort_order'  => 'integer',
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
}
