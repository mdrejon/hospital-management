<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    private array $scalarColumns = ['title', 'short_desc', 'description', 'seo_title', 'seo_description'];

    public function up(): void
    {
        DB::table('services')->orderBy('id')->get()->each(function ($row) {
            $update = [];
            foreach ($this->scalarColumns as $col) {
                $update[$col] = json_encode(['en' => $row->$col ?? '', 'bn' => ''], JSON_UNESCAPED_UNICODE);
            }
            DB::table('services')->where('id', $row->id)->update($update);
        });

        DB::statement('ALTER TABLE services MODIFY title JSON NOT NULL');
        DB::statement('ALTER TABLE services MODIFY short_desc JSON NULL');
        DB::statement('ALTER TABLE services MODIFY description JSON NULL');
        DB::statement('ALTER TABLE services MODIFY seo_title JSON NULL');
        DB::statement('ALTER TABLE services MODIFY seo_description JSON NULL');

        DB::table('services')->orderBy('id')->get()->each(function ($row) {
            $features = collect(json_decode($row->features, true) ?? [])
                ->map(fn ($f) => is_array($f) ? $f : ['en' => $f, 'bn' => ''])
                ->values()->all();

            $faqs = collect(json_decode($row->faqs, true) ?? [])
                ->map(fn ($f) => [
                    'question' => is_array($f['question'] ?? null) ? $f['question'] : ['en' => $f['question'] ?? '', 'bn' => ''],
                    'answer'   => is_array($f['answer'] ?? null) ? $f['answer'] : ['en' => $f['answer'] ?? '', 'bn' => ''],
                ])->values()->all();

            DB::table('services')->where('id', $row->id)->update([
                'features' => json_encode($features, JSON_UNESCAPED_UNICODE),
                'faqs'     => json_encode($faqs, JSON_UNESCAPED_UNICODE),
            ]);
        });
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE services MODIFY title VARCHAR(255) NOT NULL');
        DB::statement('ALTER TABLE services MODIFY short_desc TEXT NULL');
        DB::statement('ALTER TABLE services MODIFY description LONGTEXT NULL');
        DB::statement('ALTER TABLE services MODIFY seo_title VARCHAR(255) NULL');
        DB::statement('ALTER TABLE services MODIFY seo_description TEXT NULL');

        DB::table('services')->orderBy('id')->get()->each(function ($row) {
            $update = [];
            foreach ($this->scalarColumns as $col) {
                $decoded = json_decode($row->$col, true);
                $update[$col] = is_array($decoded) ? ($decoded['en'] ?? '') : $row->$col;
            }

            $features = collect(json_decode($row->features, true) ?? [])
                ->map(fn ($f) => is_array($f) ? ($f['en'] ?? '') : $f)->values()->all();

            $faqs = collect(json_decode($row->faqs, true) ?? [])
                ->map(fn ($f) => [
                    'question' => is_array($f['question'] ?? null) ? ($f['question']['en'] ?? '') : ($f['question'] ?? ''),
                    'answer'   => is_array($f['answer'] ?? null) ? ($f['answer']['en'] ?? '') : ($f['answer'] ?? ''),
                ])->values()->all();

            $update['features'] = json_encode($features);
            $update['faqs'] = json_encode($faqs);

            DB::table('services')->where('id', $row->id)->update($update);
        });
    }
};
