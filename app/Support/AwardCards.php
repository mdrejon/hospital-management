<?php

namespace App\Support;

use Illuminate\Support\Collection;

/**
 * Normalises Award models into the plain array shape the
 * `<x-frontend.award-card>` component renders, so the Home slider and the
 * Achievements page always show the same data in the same design.
 */
class AwardCards
{
    /** @param Collection|null $awards Active awards; falls back to placeholder cards when empty. */
    public static function from(?Collection $awards): Collection
    {
        if ($awards && $awards->isNotEmpty()) {
            return $awards->map(fn ($a) => [
                'title'        => $a->title,
                'subtitle'     => $a->subtitle,
                'link_text'    => $a->link_text,
                'link_url'     => $a->link_url ?: '#',
                'seal_image'   => $a->seal_image_url,
                'seal_variant' => $a->seal_variant,
            ])->values();
        }

        return collect(self::defaults());
    }

    private static function defaults(): array
    {
        return collect(range(0, 5))->map(fn ($i) => [
            'title'        => 'ClinicMaster 2024',
            'subtitle'     => 'Quality and Accreditation Institute',
            'link_text'    => 'Save the Children',
            'link_url'     => '#',
            'seal_image'   => null,
            'seal_variant' => ($i % 3) + 1,
        ])->all();
    }
}
