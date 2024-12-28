<?php

namespace App\Concerns\Relationships;

use App\Models\ItemCategory;
use App\Models\ItemClass;
use App\Models\ItemType;
use App\Models\PharmaceuticalIndustry;
use App\Models\UnitCode;
use Illuminate\Database\Eloquent\Concerns\HasRelationships;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait ItemRelationships
{
    use HasRelationships;

    /**
     * Get the pharmaceutical_industry that owns the Medicine
     */
    public function pharmaceutical_industry(): BelongsTo
    {
        return $this->belongsTo(PharmaceuticalIndustry::class, 'kode_industri', 'kode_industri');
    }

    /**
     * Get the unit_code_long that owns the Medicine
     */
    public function unit_code_long(): BelongsTo
    {
        return $this->belongsTo(UnitCode::class, 'kode_satbesar', 'kode_sat');
    }

    /**
     * Get the unit_code_short that owns the Medicine
     */
    public function unit_code_short(): BelongsTo
    {
        return $this->belongsTo(UnitCode::class, 'kode_sat', 'kode_sat');
    }

    /**
     * Get the itemType that owns the Item
     */
    public function item_type(): BelongsTo
    {
        return $this->belongsTo(ItemType::class, 'kdjns', 'kdjns');
    }

    /**
     * Get the item_category that owns the Item
     */
    public function item_category(): BelongsTo
    {
        return $this->belongsTo(ItemCategory::class, 'kode_kategori', 'kode');
    }

    /**
     * Get the item_class that owns the Item
     */
    public function item_class(): BelongsTo
    {
        return $this->belongsTo(ItemClass::class, 'kode_golongan', 'kode');
    }
}
