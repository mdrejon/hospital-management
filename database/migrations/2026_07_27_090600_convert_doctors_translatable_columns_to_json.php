<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    private array $scalarColumns = ['role', 'specialty', 'degrees', 'experience', 'awards', 'bio', 'seo_title', 'seo_description'];

    public function up(): void
    {
        DB::table('doctors')->orderBy('id')->get()->each(function ($row) {
            $update = [];
            foreach ($this->scalarColumns as $col) {
                $update[$col] = json_encode(['en' => $row->$col ?? '', 'bn' => ''], JSON_UNESCAPED_UNICODE);
            }
            DB::table('doctors')->where('id', $row->id)->update($update);
        });

        DB::statement('ALTER TABLE doctors MODIFY role JSON NULL');
        DB::statement('ALTER TABLE doctors MODIFY specialty JSON NULL');
        DB::statement('ALTER TABLE doctors MODIFY degrees JSON NULL');
        DB::statement('ALTER TABLE doctors MODIFY experience JSON NULL');
        DB::statement('ALTER TABLE doctors MODIFY awards JSON NULL');
        DB::statement('ALTER TABLE doctors MODIFY bio JSON NULL');
        DB::statement('ALTER TABLE doctors MODIFY seo_title JSON NULL');
        DB::statement('ALTER TABLE doctors MODIFY seo_description JSON NULL');

        // `skills` is already JSON but holds a flat array of plain-text strings — reshape each into {en, bn}.
        // `schedule` ([{day, time}]) is intentionally left untouched: day-of-week and time values are
        // structural/formatted data, not free human-readable copy, per the translation scope rules.
        DB::table('doctors')->orderBy('id')->get()->each(function ($row) {
            $skills = collect(json_decode($row->skills, true) ?? [])
                ->map(fn ($s) => is_array($s) ? $s : ['en' => $s, 'bn' => ''])
                ->values()->all();

            DB::table('doctors')->where('id', $row->id)->update([
                'skills' => json_encode($skills, JSON_UNESCAPED_UNICODE),
            ]);
        });
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE doctors MODIFY role VARCHAR(255) NULL');
        DB::statement('ALTER TABLE doctors MODIFY specialty VARCHAR(255) NULL');
        DB::statement('ALTER TABLE doctors MODIFY degrees VARCHAR(255) NULL');
        DB::statement('ALTER TABLE doctors MODIFY experience VARCHAR(255) NULL');
        DB::statement('ALTER TABLE doctors MODIFY awards VARCHAR(255) NULL');
        DB::statement('ALTER TABLE doctors MODIFY bio LONGTEXT NULL');
        DB::statement('ALTER TABLE doctors MODIFY seo_title VARCHAR(255) NULL');
        DB::statement('ALTER TABLE doctors MODIFY seo_description TEXT NULL');

        DB::table('doctors')->orderBy('id')->get()->each(function ($row) {
            $update = [];
            foreach ($this->scalarColumns as $col) {
                $decoded = json_decode($row->$col, true);
                $update[$col] = is_array($decoded) ? ($decoded['en'] ?? '') : $row->$col;
            }

            $skills = collect(json_decode($row->skills, true) ?? [])
                ->map(fn ($s) => is_array($s) ? ($s['en'] ?? '') : $s)->values()->all();

            $update['skills'] = json_encode($skills);

            DB::table('doctors')->where('id', $row->id)->update($update);
        });
    }
};
