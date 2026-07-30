<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    private array $columns = ['name', 'hospital_branch', 'floor', 'room_no', 'address', 'contact_number'];

    public function up(): void
    {
        DB::table('doctor_chambers')->orderBy('id')->get()->each(function ($row) {
            $update = [];
            foreach ($this->columns as $col) {
                $update[$col] = json_encode(['en' => $row->$col ?? '', 'bn' => ''], JSON_UNESCAPED_UNICODE);
            }
            DB::table('doctor_chambers')->where('id', $row->id)->update($update);
        });

        DB::statement('ALTER TABLE doctor_chambers MODIFY name JSON NOT NULL');
        DB::statement('ALTER TABLE doctor_chambers MODIFY hospital_branch JSON NULL');
        DB::statement('ALTER TABLE doctor_chambers MODIFY floor JSON NULL');
        DB::statement('ALTER TABLE doctor_chambers MODIFY room_no JSON NULL');
        DB::statement('ALTER TABLE doctor_chambers MODIFY address JSON NULL');
        DB::statement('ALTER TABLE doctor_chambers MODIFY contact_number JSON NULL');
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE doctor_chambers MODIFY name VARCHAR(255) NOT NULL');
        DB::statement('ALTER TABLE doctor_chambers MODIFY hospital_branch VARCHAR(255) NULL');
        DB::statement('ALTER TABLE doctor_chambers MODIFY floor VARCHAR(255) NULL');
        DB::statement('ALTER TABLE doctor_chambers MODIFY room_no VARCHAR(255) NULL');
        DB::statement('ALTER TABLE doctor_chambers MODIFY address TEXT NULL');
        DB::statement('ALTER TABLE doctor_chambers MODIFY contact_number VARCHAR(255) NULL');

        DB::table('doctor_chambers')->orderBy('id')->get()->each(function ($row) {
            $update = [];
            foreach ($this->columns as $col) {
                $decoded = json_decode($row->$col, true);
                $update[$col] = is_array($decoded) ? ($decoded['en'] ?? '') : $row->$col;
            }
            DB::table('doctor_chambers')->where('id', $row->id)->update($update);
        });
    }
};
