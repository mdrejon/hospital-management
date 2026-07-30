<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('doctors')->orderBy('id')->get(['id', 'name'])->each(function ($row) {
            DB::table('doctors')->where('id', $row->id)->update([
                'name' => json_encode(['en' => $row->name ?? '', 'bn' => ''], JSON_UNESCAPED_UNICODE),
            ]);
        });

        DB::statement('ALTER TABLE doctors MODIFY name JSON NOT NULL');
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE doctors MODIFY name VARCHAR(255) NOT NULL');

        DB::table('doctors')->orderBy('id')->get(['id', 'name'])->each(function ($row) {
            $decoded = json_decode($row->name, true);
            DB::table('doctors')->where('id', $row->id)->update([
                'name' => is_array($decoded) ? ($decoded['en'] ?? '') : $row->name,
            ]);
        });
    }
};
