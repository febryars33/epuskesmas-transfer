<?php

namespace App\Models\Scopes\ItemType;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class MedicalEquipment implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        $builder->whereRelation('item_type', 'kdjns', 'J011')
            ->orWhereRelation('item_type', 'kdjns', 'J012')
            ->orWhereRelation('item_type', 'kdjns', 'JB03')
            ->orWhereRelation('item_type', 'kdjns', 'JB04')
            ->orWhereRelation('item_type', 'kdjns', 'JB05')
            ->orWhereRelation('item_type', function ($query) {
                // dd($query);
            }, '-');
    }
}
