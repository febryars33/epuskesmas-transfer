<?php

namespace App\Models;

use App\Concerns\Database\Counter;
use App\Concerns\Database\HasCustomTable;
use App\Concerns\Relationships\ItemRelationships;
use App\Models\Scopes\ItemType\Medicine as ItemTypeMedicine;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Model;

#[ScopedBy([ItemTypeMedicine::class])]
class Medicine extends Model
{
    use Counter, HasCustomTable, ItemRelationships;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setupCustomTable();
    }

    /**
     * The table associated with the model.
     *
     * @var string|null
     */
    protected $table = 'databarang';

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['item_type', 'unit_code_long', 'unit_code_short', 'pharmaceutical_industry', 'item_category', 'item_class'];
}
