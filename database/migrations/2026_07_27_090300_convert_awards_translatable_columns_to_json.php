<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    private array $columns = ['title', 'subtitle', 'link_text'];

    public function up(): void
    {
        DB::table('awards')->orderBy('id')->get()->each(function ($row) {
            $update = [];
            foreach ($this->columns as $col) {
                $update[$col] = json_encode(['en' => $row->$col ?? '', 'bn' => ''], JSON_UNESCAPED_UNICODE);
            }
            DB::table('awards')->where('id', $row->id)->update($update);
        });

        DB::statement('ALTER TABLE awards MODIFY title JSON NOT NULL');
        DB::statement('ALTER TABLE awards MODIFY subtitle JSON NULL');
        DB::statement('ALTER TABLE awards MODIFY link_text JSON NULL');
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE awards MODIFY title VARCHAR(255) NOT NULL');
        DB::statement('ALTER TABLE awards MODIFY subtitle VARCHAR(255) NULL');
        DB::statement('ALTER TABLE awards MODIFY link_text VARCHAR(255) NULL');

        DB::table('awards')->orderBy('id')->get()->each(function ($row) {
            $update = [];
            foreach ($this->columns as $col) {
                $decoded = json_decode($row->$col, true);
                $update[$col] = is_array($decoded) ? ($decoded['en'] ?? '') : $row->$col;
            }
            DB::table('awards')->where('id', $row->id)->update($update);
        });
    }
};
