<?php

namespace App\Models;

use App\Concerns\Database\Counter;
use Illuminate\Database\Eloquent\Model;

class ItemType extends Model
{
    use Counter;

    /**
     * The table associated with the model.
     *
     * @var string|null
     */
    protected $table = 'jenis';
}
