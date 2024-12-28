<?php

namespace App\Models;

use App\Concerns\Database\Counter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MedicalTreatment extends Model
{
    use Counter;

    /**
     * The table associated with the model.
     *
     * @var string|null
     */
    protected $table = 'jns_perawatan';

    /**
     * Get the polyclinic that owns the MedicalTreatment
     */
    public function polyclinic(): BelongsTo
    {
        return $this->belongsTo(Polyclinic::class, 'kd_poli', 'kd_poli');
    }
}
