<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    private array $columns = ['alt', 'sub_title', 'caption'];

    public function up(): void
    {
        DB::table('gallery_images')->orderBy('id')->get()->each(function ($row) {
            $update = [];
            foreach ($this->columns as $col) {
                $update[$col] = json_encode(['en' => $row->$col ?? '', 'bn' => ''], JSON_UNESCAPED_UNICODE);
            }
            DB::table('gallery_images')->where('id', $row->id)->update($update);
        });

        DB::statement('ALTER TABLE gallery_images MODIFY alt JSON NULL');
        DB::statement('ALTER TABLE gallery_images MODIFY sub_title JSON NULL');
        DB::statement('ALTER TABLE gallery_images MODIFY caption JSON NULL');
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE gallery_images MODIFY alt VARCHAR(255) NULL');
        DB::statement('ALTER TABLE gallery_images MODIFY sub_title VARCHAR(255) NULL');
        DB::statement('ALTER TABLE gallery_images MODIFY caption VARCHAR(255) NULL');

        DB::table('gallery_images')->orderBy('id')->get()->each(function ($row) {
            $update = [];
            foreach ($this->columns as $col) {
                $decoded = json_decode($row->$col, true);
                $update[$col] = is_array($decoded) ? ($decoded['en'] ?? '') : $row->$col;
            }
            DB::table('gallery_images')->where('id', $row->id)->update($update);
        });
    }
};
