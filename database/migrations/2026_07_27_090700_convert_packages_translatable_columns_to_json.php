<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    private array $scalarColumns = ['title', 'short_desc', 'description', 'badge_label', 'seo_title', 'seo_description'];

    public function up(): void
    {
        DB::table('packages')->orderBy('id')->get()->each(function ($row) {
            $update = [];
            foreach ($this->scalarColumns as $col) {
                $update[$col] = json_encode(['en' => $row->$col ?? '', 'bn' => ''], JSON_UNESCAPED_UNICODE);
            }
            DB::table('packages')->where('id', $row->id)->update($update);
        });

        DB::statement('ALTER TABLE packages MODIFY title JSON NOT NULL');
        DB::statement('ALTER TABLE packages MODIFY short_desc JSON NULL');
        DB::statement('ALTER TABLE packages MODIFY description JSON NULL');
        DB::statement('ALTER TABLE packages MODIFY badge_label JSON NULL');
        DB::statement('ALTER TABLE packages MODIFY seo_title JSON NULL');
        DB::statement('ALTER TABLE packages MODIFY seo_description JSON NULL');

        // `features` is already JSON but holds a flat array of plain-text strings — reshape each into {en, bn}.
        DB::table('packages')->orderBy('id')->get()->each(function ($row) {
            $features = collect(json_decode($row->features, true) ?? [])
                ->map(fn ($f) => is_array($f) ? $f : ['en' => $f, 'bn' => ''])
                ->values()->all();

            DB::table('packages')->where('id', $row->id)->update([
                'features' => json_encode($features, JSON_UNESCAPED_UNICODE),
            ]);
        });
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE packages MODIFY title VARCHAR(255) NOT NULL');
        DB::statement('ALTER TABLE packages MODIFY short_desc VARCHAR(255) NULL');
        DB::statement('ALTER TABLE packages MODIFY description LONGTEXT NULL');
        DB::statement('ALTER TABLE packages MODIFY badge_label VARCHAR(255) NULL');
        DB::statement('ALTER TABLE packages MODIFY seo_title VARCHAR(255) NULL');
        DB::statement('ALTER TABLE packages MODIFY seo_description TEXT NULL');

        DB::table('packages')->orderBy('id')->get()->each(function ($row) {
            $update = [];
            foreach ($this->scalarColumns as $col) {
                $decoded = json_decode($row->$col, true);
                $update[$col] = is_array($decoded) ? ($decoded['en'] ?? '') : $row->$col;
            }

            $features = collect(json_decode($row->features, true) ?? [])
                ->map(fn ($f) => is_array($f) ? ($f['en'] ?? '') : $f)->values()->all();

            $update['features'] = json_encode($features);

            DB::table('packages')->where('id', $row->id)->update($update);
        });
    }
};
