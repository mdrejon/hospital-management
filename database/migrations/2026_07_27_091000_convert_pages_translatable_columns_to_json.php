<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    private array $scalarColumns = ['title', 'breadcrumb_title', 'content', 'seo_title', 'seo_description'];

    public function up(): void
    {
        DB::table('pages')->orderBy('id')->get()->each(function ($row) {
            $update = [];
            foreach ($this->scalarColumns as $col) {
                $update[$col] = json_encode(['en' => $row->$col ?? '', 'bn' => ''], JSON_UNESCAPED_UNICODE);
            }
            DB::table('pages')->where('id', $row->id)->update($update);
        });

        DB::statement('ALTER TABLE pages MODIFY title JSON NOT NULL');
        DB::statement('ALTER TABLE pages MODIFY breadcrumb_title JSON NULL');
        DB::statement('ALTER TABLE pages MODIFY content JSON NULL');
        DB::statement('ALTER TABLE pages MODIFY seo_title JSON NULL');
        DB::statement('ALTER TABLE pages MODIFY seo_description JSON NULL');
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE pages MODIFY title VARCHAR(255) NOT NULL');
        DB::statement('ALTER TABLE pages MODIFY breadcrumb_title VARCHAR(255) NULL');
        DB::statement('ALTER TABLE pages MODIFY content LONGTEXT NULL');
        DB::statement('ALTER TABLE pages MODIFY seo_title VARCHAR(255) NULL');
        DB::statement('ALTER TABLE pages MODIFY seo_description VARCHAR(255) NULL');

        DB::table('pages')->orderBy('id')->get()->each(function ($row) {
            $update = [];
            foreach ($this->scalarColumns as $col) {
                $decoded = json_decode($row->$col, true);
                $update[$col] = is_array($decoded) ? ($decoded['en'] ?? '') : $row->$col;
            }
            DB::table('pages')->where('id', $row->id)->update($update);
        });
    }
};
