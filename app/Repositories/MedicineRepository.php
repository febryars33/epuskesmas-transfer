<?php

namespace App\Repositories;

use App\Contracts\Repositories\MedicineRepository as MedicineRepositoryInterface;
use App\Models\Medicine;
use Common\Repository\BaseRepository;

class MedicineRepository extends BaseRepository implements MedicineRepositoryInterface
{
    public function __construct(Medicine $model)
    {
        parent::__construct($model);
    }
}
