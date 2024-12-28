<?php

namespace App\Contracts\Repositories;

use Common\Contracts\Repository\BaseRepository;
use Illuminate\Database\Eloquent\Builder;

interface MedicalEquipmentRepository extends BaseRepository
{
    public function getMinimumStock(int $stock): Builder;

    public function search(string $keyword, array $columns = []): Builder;
}
