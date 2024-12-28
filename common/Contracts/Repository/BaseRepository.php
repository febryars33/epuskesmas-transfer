<?php

namespace Common\Contracts\Repository;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

interface BaseRepository
{
    /**
     * Get a new query builder instance for the model.
     */
    public function query(): Builder;

    /**
     * Get all of the models from the database.
     */
    public function all(): Collection;

    /**
     * Find a model by its primary key.
     *
     * @return ($id is (\Illuminate\Contracts\Support\Arrayable<array-key, mixed>|array<mixed>) ? \Illuminate\Database\Eloquent\Collection<int, TModel> : TModel|null)
     */
    public function find(mixed $id, array|string $columns = ['*']);

    /**
     * Execute the query as a "select" statement.
     *
     * @param  array|string  $columns
     * @return \Illuminate\Database\Eloquent\Collection<int, TModel>
     */
    public function get(array $columns = ['*']);
}
