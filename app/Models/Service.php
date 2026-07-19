<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'title', 'slug', 'icon_svg', 'image', 'short_desc',
        'description',
        'features', 'faqs',
        'is_featured', 'sort_order', 'is_active',
        'seo_title', 'seo_description', 'seo_keywords', 'seo_og_image',
    ];

    protected $casts = [
        'features'    => 'array',
        'faqs'        => 'array',
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

    public function doctors()
    {
        return $this->belongsToMany(Doctor::class);
    }
}
