<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('management_members')->orderBy('id')->get()->each(function ($row) {
            DB::table('management_members')->where('id', $row->id)->update([
                'role' => json_encode(['en' => $row->role ?? '', 'bn' => ''], JSON_UNESCAPED_UNICODE),
            ]);
        });

        DB::statement('ALTER TABLE management_members MODIFY role JSON NULL');
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE management_members MODIFY role VARCHAR(255) NULL');

        DB::table('management_members')->orderBy('id')->get()->each(function ($row) {
            $decoded = json_decode($row->role, true);
            DB::table('management_members')->where('id', $row->id)->update([
                'role' => is_array($decoded) ? ($decoded['en'] ?? '') : $row->role,
            ]);
        });
    }
};
