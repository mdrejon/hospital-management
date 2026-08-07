<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class VideoGallery extends Model
{
    use HasTranslations;

    public array $translatable = ['title', 'subtitle'];

    protected $fillable = [
        'title',
        'subtitle',
        'video_type',
        'video_url',
        'video_id',
        'thumbnail_image',
        'duration',
        'is_featured',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_active'   => 'boolean',
        'sort_order'  => 'integer',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order')->orderBy('id');
    }

    public static function extractVideoDetails(string $url, string $type = 'youtube'): array
    {
        $videoId = null;
        $thumbnail = null;

        if ($type === 'youtube' || str_contains($url, 'youtube.com') || str_contains($url, 'youtu.be')) {
            if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/i', $url, $matches)) {
                $videoId = $matches[1];
                $thumbnail = "https://img.youtube.com/vi/{$videoId}/hqdefault.jpg";
            }
        } elseif ($type === 'vimeo' || str_contains($url, 'vimeo.com')) {
            if (preg_match('/vimeo\.com\/(?:channels\/(?:\w+\/)?|groups\/([^\/]*)\/videos\/|album\/(\d+)\/video\/|video\/|)(\d+)/', $url, $matches)) {
                $videoId = end($matches);
            }
        }

        return [
            'video_id'  => $videoId,
            'thumbnail' => $thumbnail,
        ];
    }

    public function getEmbedUrlAttribute(): string
    {
        if ($this->video_type === 'youtube') {
            $id = $this->video_id;
            if (!$id && $this->video_url) {
                $extracted = self::extractVideoDetails($this->video_url, 'youtube');
                $id = $extracted['video_id'];
            }
            if ($id) {
                return "https://www.youtube.com/embed/{$id}?autoplay=1&rel=0";
            }
        } elseif ($this->video_type === 'vimeo') {
            $id = $this->video_id;
            if (!$id && $this->video_url) {
                $extracted = self::extractVideoDetails($this->video_url, 'vimeo');
                $id = $extracted['video_id'];
            }
            if ($id) {
                return "https://player.vimeo.com/video/{$id}?autoplay=1";
            }
        }

        return $this->video_url ?? '';
    }
}
