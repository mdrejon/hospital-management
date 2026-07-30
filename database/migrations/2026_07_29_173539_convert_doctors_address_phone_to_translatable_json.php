<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    private array $columns = ['address', 'phone'];

    public function up(): void
    {
        DB::table('doctors')->orderBy('id')->get()->each(function ($row) {
            $update = [];
            foreach ($this->columns as $col) {
                $update[$col] = json_encode(['en' => $row->$col ?? '', 'bn' => ''], JSON_UNESCAPED_UNICODE);
            }
            DB::table('doctors')->where('id', $row->id)->update($update);
        });

        DB::statement('ALTER TABLE doctors MODIFY address JSON NULL');
        DB::statement('ALTER TABLE doctors MODIFY phone JSON NULL');
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE doctors MODIFY address VARCHAR(255) NULL');
        DB::statement('ALTER TABLE doctors MODIFY phone VARCHAR(255) NULL');

        DB::table('doctors')->orderBy('id')->get()->each(function ($row) {
            $update = [];
            foreach ($this->columns as $col) {
                $decoded = json_decode($row->$col, true);
                $update[$col] = is_array($decoded) ? ($decoded['en'] ?? '') : $row->$col;
            }
            DB::table('doctors')->where('id', $row->id)->update($update);
        });
    }
};
