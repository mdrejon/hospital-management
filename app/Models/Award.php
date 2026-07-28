<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Award extends Model
{
    use HasTranslations;

    public array $translatable = ['title', 'subtitle', 'link_text'];

    protected $fillable = [
        'title', 'subtitle', 'link_text', 'link_url', 'seal_variant', 'sort_order', 'is_active',
    ];

    protected $casts = [
        'seal_variant' => 'integer',
        'sort_order'   => 'integer',
        'is_active'    => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order')->orderBy('id');
    }
}
