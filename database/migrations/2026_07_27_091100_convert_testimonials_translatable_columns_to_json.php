<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    private array $scalarColumns = ['review', 'role'];

    public function up(): void
    {
        DB::table('testimonials')->orderBy('id')->get()->each(function ($row) {
            $update = [];
            foreach ($this->scalarColumns as $col) {
                $update[$col] = json_encode(['en' => $row->$col ?? '', 'bn' => ''], JSON_UNESCAPED_UNICODE);
            }
            DB::table('testimonials')->where('id', $row->id)->update($update);
        });

        DB::statement('ALTER TABLE testimonials MODIFY review JSON NOT NULL');
        DB::statement('ALTER TABLE testimonials MODIFY role JSON NULL');
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE testimonials MODIFY review TEXT NOT NULL');
        DB::statement('ALTER TABLE testimonials MODIFY role VARCHAR(255) NULL');

        DB::table('testimonials')->orderBy('id')->get()->each(function ($row) {
            $update = [];
            foreach ($this->scalarColumns as $col) {
                $decoded = json_decode($row->$col, true);
                $update[$col] = is_array($decoded) ? ($decoded['en'] ?? '') : $row->$col;
            }
            DB::table('testimonials')->where('id', $row->id)->update($update);
        });
    }
};
