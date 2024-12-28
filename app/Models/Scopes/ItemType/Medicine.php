<?php

namespace App\Models\Scopes\ItemType;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class Medicine implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        $builder->whereRelation('item_type', 'kdjns', 'JB01')
            ->orWhereRelation('item_type', 'kdjns', 'J001')
            ->orWhereRelation('item_type', 'kdjns', 'J002')
            ->orWhereRelation('item_type', 'kdjns', 'J003')
            ->orWhereRelation('item_type', 'kdjns', 'J004')
            ->orWhereRelation('item_type', 'kdjns', 'J007')
            ->orWhereRelation('item_type', 'kdjns', 'J008')
            ->orWhereRelation('item_type', 'kdjns', 'J010')
            ->orWhereRelation('item_type', 'kdjns', 'J012')
            ->orWhereRelation('item_type', 'kdjns', 'J013')
            ->orWhereRelation('item_type', 'kdjns', 'J018')
            ->orWhereRelation('item_type', 'kdjns', 'J005')
            ->orWhereRelation('item_type', 'kdjns', 'JB02');
    }
}
