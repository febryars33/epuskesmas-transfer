<?php

namespace Common\Repository;

use Common\Contracts\Repository\BaseRepository as BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class BaseRepository implements BaseRepositoryInterface
{
    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Get a new query builder instance for the model.
     */
    public function query(): Builder
    {
        return $this->model->query();
    }

    /**
     * Get all of the models from the database.
     */
    public function all(): Collection
    {
        return $this->model->all();
    }

    /**
     * Execute the query as a "select" statement.
     *
     * @param  array|string  $columns
     * @return \Illuminate\Database\Eloquent\Collection<int, TModel>
     */
    public function get(array $columns = ['*'])
    {
        return $this->query()->get($columns);
    }

    /**
     * Find a model by its primary key.
     *
     * @return ($id is (\Illuminate\Contracts\Support\Arrayable<array-key, mixed>|array<mixed>) ? \Illuminate\Database\Eloquent\Collection<int, TModel> : TModel|null)
     */
    public function find(mixed $id, array|string $columns = ['*'])
    {
        return $this->query()->find($id, $columns);
    }
}
