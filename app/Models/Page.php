<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = [
        'parent_id', 'title', 'slug', 'breadcrumb_title', 'hero_image', 'content',
        'is_active', 'sort_order',
        'seo_title', 'seo_description', 'seo_keywords', 'seo_og_image',
    ];

    protected $casts = [
        'is_active'  => 'boolean',
        'sort_order' => 'integer',
    ];

    public function parent()
    {
        return $this->belongsTo(Page::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Page::class, 'parent_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /** Slash-joined slug path from the top-most ancestor down to this page, e.g. "parent-content/privacy-policy". */
    public function fullPath(): string
    {
        $segments = [$this->slug];
        $parent = $this->parent;

        while ($parent) {
            array_unshift($segments, $parent->slug);
            $parent = $parent->parent;
        }

        return implode('/', $segments);
    }

    /** Ancestor chain including this page itself, top-most first — used to render the breadcrumb. */
    public function breadcrumbTrail(): array
    {
        $trail = [$this];
        $parent = $this->parent;

        while ($parent) {
            array_unshift($trail, $parent);
            $parent = $parent->parent;
        }

        return $trail;
    }
}
