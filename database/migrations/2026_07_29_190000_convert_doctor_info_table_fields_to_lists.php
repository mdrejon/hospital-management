<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * "Specialty", "Degrees", "Experience" and "Awards" each held a single
 * translatable value ({"en": "...", "bn": "..."}). Admins need to list several
 * entries per field, so they become lists of translatable values
 * ([{"en": "...", "bn": "..."}, …]) — the shape `skills` already uses.
 *
 * The columns are already JSON and stay JSON; only the value shape changes.
 */
return new class extends Migration
{
    /** The four info-table columns being reshaped. */
    private const FIELDS = ['specialty', 'degrees', 'experience', 'awards'];

    public function up(): void
    {
        $this->reshape(function ($value) {
            // Already a list (re-run, or seeded new) — leave it alone.
            if (array_is_list($value)) {
                return $value;
            }

            // A single {locale => text} map: wrap it, unless it is blank in every locale.
            return count(array_filter($value, fn ($v) => filled($v))) ? [$value] : [];
        });
    }

    public function down(): void
    {
        $this->reshape(function ($value) {
            if (!array_is_list($value)) {
                return $value;
            }

            // Collapse back to one map by joining each locale's entries with ", ".
            $merged = [];
            foreach ($value as $item) {
                foreach ((array) $item as $locale => $text) {
                    if (filled($text)) {
                        $merged[$locale] = isset($merged[$locale]) ? $merged[$locale] . ', ' . $text : $text;
                    }
                }
            }

            return $merged;
        });
    }

    /** Walks every doctor row and rewrites the four columns through $transform. */
    private function reshape(callable $transform): void
    {
        DB::table('doctors')->select(array_merge(['id'], self::FIELDS))->orderBy('id')
            ->chunk(100, function ($rows) use ($transform) {
                foreach ($rows as $row) {
                    $update = [];

                    foreach (self::FIELDS as $field) {
                        if (blank($row->$field)) {
                            continue;
                        }

                        $decoded = json_decode($row->$field, true);

                        // A bare string (pre-translatable leftover) always becomes one entry.
                        if (!is_array($decoded)) {
                            $update[$field] = json_encode([['en' => (string) $decoded]], JSON_UNESCAPED_UNICODE);
                            continue;
                        }

                        $update[$field] = json_encode($transform($decoded), JSON_UNESCAPED_UNICODE);
                    }

                    if ($update) {
                        DB::table('doctors')->where('id', $row->id)->update($update);
                    }
                }
            });
    }
};
