<?php

namespace App\Models;

use App\Concerns\Database\Counter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Item extends Model
{
    use Counter;

    /**
     * The table associated with the model.
     *
     * @var string|null
     */
    protected $table = 'databarang';

    /**
     * Get the itemType that owns the Item
     *
     * @return BelongsTo<ItemType, $this>
     */
    public function itemType(): BelongsTo
    {
        return $this->belongsTo(ItemType::class, 'kdjns', 'kdjns');
    }

    /**
     * Get the itemCategory that owns the Item
     *
     * @return BelongsTo<ItemCategory, $this>
     */
    public function itemCategory(): BelongsTo
    {
        return $this->belongsTo(ItemCategory::class, 'kode_kategori', 'kode');
    }

    /**
     * Get the itemClass that owns the Item
     *
     * @return BelongsTo<ItemClass, $this>
     */
    public function itemClass(): BelongsTo
    {
        return $this->belongsTo(ItemClass::class, 'kode_golongan', 'kode');
    }
}
