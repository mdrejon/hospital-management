<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    private array $scalarColumns = ['title', 'excerpt', 'content', 'meta_title', 'meta_description', 'meta_keywords'];

    public function up(): void
    {
        DB::table('blogs')->orderBy('id')->get()->each(function ($row) {
            $update = [];
            foreach ($this->scalarColumns as $col) {
                $update[$col] = json_encode(['en' => $row->$col ?? '', 'bn' => ''], JSON_UNESCAPED_UNICODE);
            }
            DB::table('blogs')->where('id', $row->id)->update($update);
        });

        DB::statement('ALTER TABLE blogs MODIFY title JSON NOT NULL');
        DB::statement('ALTER TABLE blogs MODIFY excerpt JSON NULL');
        DB::statement('ALTER TABLE blogs MODIFY content JSON NULL');
        DB::statement('ALTER TABLE blogs MODIFY meta_title JSON NULL');
        DB::statement('ALTER TABLE blogs MODIFY meta_description JSON NULL');
        DB::statement('ALTER TABLE blogs MODIFY meta_keywords JSON NULL');
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE blogs MODIFY title VARCHAR(255) NOT NULL');
        DB::statement('ALTER TABLE blogs MODIFY excerpt TEXT NULL');
        DB::statement('ALTER TABLE blogs MODIFY content LONGTEXT NULL');
        DB::statement('ALTER TABLE blogs MODIFY meta_title VARCHAR(255) NULL');
        DB::statement('ALTER TABLE blogs MODIFY meta_description TEXT NULL');
        DB::statement('ALTER TABLE blogs MODIFY meta_keywords VARCHAR(255) NULL');

        DB::table('blogs')->orderBy('id')->get()->each(function ($row) {
            $update = [];
            foreach ($this->scalarColumns as $col) {
                $decoded = json_decode($row->$col, true);
                $update[$col] = is_array($decoded) ? ($decoded['en'] ?? '') : $row->$col;
            }
            DB::table('blogs')->where('id', $row->id)->update($update);
        });
    }
};
