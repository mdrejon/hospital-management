<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Faq extends Model
{
    use HasTranslations;

    public array $translatable = ['badge', 'title', 'description', 'image_alt'];

    protected $fillable = [
        'page', 'badge', 'title', 'description', 'image', 'image_alt', 'items', 'sort_order', 'is_active',
    ];

    protected $casts = [
        'items'      => 'array',
        'is_active'  => 'boolean',
        'sort_order' => 'integer',
    ];

    public function scopeForPage($query, string $page)
    {
        return $query->where('page', $page)->where('is_active', true)
            ->orderBy('sort_order')->orderBy('id');
    }
}
