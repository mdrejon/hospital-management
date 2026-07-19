<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $fillable = [
        'name', 'slug', 'role', 'photo',
        'specialty', 'degrees', 'experience', 'awards', 'bio',
        'skills', 'schedule',
        'address', 'phone', 'email',
        'facebook_url', 'twitter_url', 'instagram_url', 'linkedin_url', 'youtube_url',
        'is_featured', 'sort_order', 'is_active',
        'seo_title', 'seo_description', 'seo_keywords', 'seo_og_image',
    ];

    protected $casts = [
        'skills'      => 'array',
        'schedule'    => 'array',
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

    public function services()
    {
        return $this->belongsToMany(Service::class);
    }
}
