<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DoctorChamber extends Model
{
    protected $fillable = [
        'doctor_id', 'name', 'hospital_branch', 'floor', 'room_no',
        'address', 'contact_number', 'google_map_url',
        'is_own_hospital', 'sort_order', 'is_active',
    ];

    protected $casts = [
        'is_own_hospital' => 'boolean',
        'is_active'       => 'boolean',
        'sort_order'      => 'integer',
    ];

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }
}
