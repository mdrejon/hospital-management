<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    private array $columns = ['name', 'description'];

    public function up(): void
    {
        DB::table('blog_categories')->orderBy('id')->get()->each(function ($row) {
            $update = [];
            foreach ($this->columns as $col) {
                $update[$col] = json_encode(['en' => $row->$col ?? '', 'bn' => ''], JSON_UNESCAPED_UNICODE);
            }
            DB::table('blog_categories')->where('id', $row->id)->update($update);
        });

        DB::statement('ALTER TABLE blog_categories MODIFY name JSON NOT NULL');
        DB::statement('ALTER TABLE blog_categories MODIFY description JSON NULL');
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE blog_categories MODIFY name VARCHAR(255) NOT NULL');
        DB::statement('ALTER TABLE blog_categories MODIFY description TEXT NULL');

        DB::table('blog_categories')->orderBy('id')->get()->each(function ($row) {
            $update = [];
            foreach ($this->columns as $col) {
                $decoded = json_decode($row->$col, true);
                $update[$col] = is_array($decoded) ? ($decoded['en'] ?? '') : $row->$col;
            }
            DB::table('blog_categories')->where('id', $row->id)->update($update);
        });
    }
};
