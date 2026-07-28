<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Slider extends Model
{
    use HasTranslations;

    public array $translatable = ['label', 'title', 'subtitle', 'description', 'button_text', 'star_label'];

    protected $fillable = [
        'label',
        'title',
        'subtitle',
        'description',
        'button_text',
        'button_url',
        'background_image',
        'star_label',
        'star_rating',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active'   => 'boolean',
        'sort_order'  => 'integer',
        'star_rating' => 'integer',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }
}
