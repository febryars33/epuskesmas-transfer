<?php

namespace App\Repositories;

use App\Contracts\Repositories\MedicalEquipmentRepository as MedicalEquipmentRepositoryInterface;
use App\Models\MedicalEquipment;
use Common\Repository\BaseRepository;
use Illuminate\Database\Eloquent\Builder;

class MedicalEquipmentRepository extends BaseRepository implements MedicalEquipmentRepositoryInterface
{
    public function __construct(MedicalEquipment $model)
    {
        parent::__construct($model);
    }

    public function search(string $keyword, array $columns = []): Builder
    {
        return $this->query()->where(function ($query) use ($keyword, $columns) {
            foreach ($columns as $column) {
                $query->orWhere($column, 'like', '%'.$keyword.'%');
            }
        });
    }

    public function getMinimumStock(int $stock): Builder
    {
        return $this->query()->where('stokminimal', '<=', $stock);
    }
}
