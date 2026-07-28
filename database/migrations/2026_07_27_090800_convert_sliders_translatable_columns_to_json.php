<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    private array $scalarColumns = ['label', 'title', 'subtitle', 'description', 'button_text', 'star_label'];

    public function up(): void
    {
        DB::table('sliders')->orderBy('id')->get()->each(function ($row) {
            $update = [];
            foreach ($this->scalarColumns as $col) {
                $update[$col] = json_encode(['en' => $row->$col ?? '', 'bn' => ''], JSON_UNESCAPED_UNICODE);
            }
            DB::table('sliders')->where('id', $row->id)->update($update);
        });

        DB::statement('ALTER TABLE sliders MODIFY label JSON NULL');
        DB::statement('ALTER TABLE sliders MODIFY title JSON NOT NULL');
        DB::statement('ALTER TABLE sliders MODIFY subtitle JSON NULL');
        DB::statement('ALTER TABLE sliders MODIFY description JSON NULL');
        DB::statement('ALTER TABLE sliders MODIFY button_text JSON NOT NULL');
        DB::statement('ALTER TABLE sliders MODIFY star_label JSON NULL');
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE sliders MODIFY label VARCHAR(255) NULL');
        DB::statement('ALTER TABLE sliders MODIFY title VARCHAR(255) NOT NULL');
        DB::statement('ALTER TABLE sliders MODIFY subtitle VARCHAR(255) NULL');
        DB::statement('ALTER TABLE sliders MODIFY description TEXT NULL');
        DB::statement("ALTER TABLE sliders MODIFY button_text VARCHAR(255) NOT NULL DEFAULT 'Explore'");
        DB::statement('ALTER TABLE sliders MODIFY star_label VARCHAR(255) NULL');

        DB::table('sliders')->orderBy('id')->get()->each(function ($row) {
            $update = [];
            foreach ($this->scalarColumns as $col) {
                $decoded = json_decode($row->$col, true);
                $update[$col] = is_array($decoded) ? ($decoded['en'] ?? '') : $row->$col;
            }
            DB::table('sliders')->where('id', $row->id)->update($update);
        });
    }
};
