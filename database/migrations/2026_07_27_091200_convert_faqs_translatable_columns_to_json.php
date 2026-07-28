<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    private array $scalarColumns = ['badge', 'title', 'description', 'image_alt'];

    public function up(): void
    {
        DB::table('faqs')->orderBy('id')->get()->each(function ($row) {
            $update = [];
            foreach ($this->scalarColumns as $col) {
                $update[$col] = json_encode(['en' => $row->$col ?? '', 'bn' => ''], JSON_UNESCAPED_UNICODE);
            }
            DB::table('faqs')->where('id', $row->id)->update($update);
        });

        DB::statement('ALTER TABLE faqs MODIFY badge JSON NOT NULL');
        DB::statement('ALTER TABLE faqs MODIFY title JSON NULL');
        DB::statement('ALTER TABLE faqs MODIFY description JSON NULL');
        DB::statement('ALTER TABLE faqs MODIFY image_alt JSON NULL');

        DB::table('faqs')->orderBy('id')->get()->each(function ($row) {
            $items = collect(json_decode($row->items, true) ?? [])
                ->map(fn ($i) => [
                    'question' => is_array($i['question'] ?? null) ? $i['question'] : ['en' => $i['question'] ?? '', 'bn' => ''],
                    'answer'   => is_array($i['answer'] ?? null) ? $i['answer'] : ['en' => $i['answer'] ?? '', 'bn' => ''],
                ])->values()->all();

            DB::table('faqs')->where('id', $row->id)->update([
                'items' => json_encode($items, JSON_UNESCAPED_UNICODE),
            ]);
        });
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE faqs MODIFY badge VARCHAR(100) NOT NULL DEFAULT \'FAQS\'');
        DB::statement('ALTER TABLE faqs MODIFY title VARCHAR(255) NULL');
        DB::statement('ALTER TABLE faqs MODIFY description TEXT NULL');
        DB::statement('ALTER TABLE faqs MODIFY image_alt VARCHAR(150) NULL');

        DB::table('faqs')->orderBy('id')->get()->each(function ($row) {
            $update = [];
            foreach ($this->scalarColumns as $col) {
                $decoded = json_decode($row->$col, true);
                $update[$col] = is_array($decoded) ? ($decoded['en'] ?? '') : $row->$col;
            }

            $items = collect(json_decode($row->items, true) ?? [])
                ->map(fn ($i) => [
                    'question' => is_array($i['question'] ?? null) ? ($i['question']['en'] ?? '') : ($i['question'] ?? ''),
                    'answer'   => is_array($i['answer'] ?? null) ? ($i['answer']['en'] ?? '') : ($i['answer'] ?? ''),
                ])->values()->all();

            $update['items'] = json_encode($items);

            DB::table('faqs')->where('id', $row->id)->update($update);
        });
    }
};
