<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ManagementMember extends Model
{
    protected $fillable = [
        'name', 'slug', 'role', 'photo',
        'facebook_url', 'twitter_url', 'instagram_url', 'linkedin_url', 'youtube_url',
        'sort_order', 'is_active',
    ];

    protected $casts = [
        'is_active'  => 'boolean',
        'sort_order' => 'integer',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order')->orderBy('id');
    }
}
