<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class MedicalTest extends Model
{
    use HasTranslations;

    public array $translatable = ['name', 'description', 'preparation_instructions'];

    protected $fillable = [
        'category_id',
        'code',
        'name',
        'description',
        'price',
        'discount_type',
        'discount_amount',
        'final_price',
        'commission_rate',
        'preparation_instructions',
        'estimated_delivery_time',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'price'           => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'final_price'     => 'decimal:2',
        'commission_rate' => 'decimal:2',
        'is_active'       => 'boolean',
        'sort_order'      => 'integer',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(MedicalTestCategory::class, 'category_id');
    }

    public function bookingItems(): HasMany
    {
        return $this->hasMany(MedicalTestBookingItem::class, 'medical_test_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order')->orderBy('id');
    }

    public static function calculateFinalPrice(float $price, string $discountType, float $discountAmount): float
    {
        if ($discountType === 'percentage') {
            $discount = ($price * $discountAmount) / 100;
            return max(0, round($price - $discount, 2));
        }

        if ($discountType === 'fixed') {
            return max(0, round($price - $discountAmount, 2));
        }

        return round($price, 2);
    }
}
