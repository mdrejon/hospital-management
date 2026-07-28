<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Testimonial extends Model
{
    use HasTranslations;

    public array $translatable = ['review', 'role'];

    protected $fillable = [
        'review', 'name', 'role', 'avatar', 'rating', 'sort_order', 'is_active',
    ];

    protected $casts = [
        'rating'     => 'float',
        'is_active'  => 'boolean',
        'sort_order' => 'integer',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order')->orderBy('id');
    }
}
