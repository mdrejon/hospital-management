<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /** `schedule` is already a JSON column ([{day, time}]) — this reshapes each
     *  item's day/time from a plain string into a translatable {en, bn} object,
     *  matching how `skills` items were reshaped earlier. */
    public function up(): void
    {
        DB::table('doctors')->orderBy('id')->get(['id', 'schedule'])->each(function ($row) {
            $schedule = collect(json_decode($row->schedule, true) ?? [])
                ->map(fn ($item) => [
                    'day'  => is_array($item['day'] ?? null) ? $item['day'] : ['en' => $item['day'] ?? '', 'bn' => ''],
                    'time' => is_array($item['time'] ?? null) ? $item['time'] : ['en' => $item['time'] ?? '', 'bn' => ''],
                ])
                ->values()->all();

            DB::table('doctors')->where('id', $row->id)->update([
                'schedule' => json_encode($schedule, JSON_UNESCAPED_UNICODE),
            ]);
        });
    }

    public function down(): void
    {
        DB::table('doctors')->orderBy('id')->get(['id', 'schedule'])->each(function ($row) {
            $schedule = collect(json_decode($row->schedule, true) ?? [])
                ->map(fn ($item) => [
                    'day'  => is_array($item['day'] ?? null) ? ($item['day']['en'] ?? '') : ($item['day'] ?? ''),
                    'time' => is_array($item['time'] ?? null) ? ($item['time']['en'] ?? '') : ($item['time'] ?? ''),
                ])
                ->values()->all();

            DB::table('doctors')->where('id', $row->id)->update([
                'schedule' => json_encode($schedule, JSON_UNESCAPED_UNICODE),
            ]);
        });
    }
};
