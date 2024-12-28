<?php

namespace Tests\Feature\Debug;

use Tests\TestCase;
use Transmedic\EPuskesmas\Tools\MedicineImporter\Models\Composition;
use Transmedic\EPuskesmas\Tools\MedicineImporter\Models\Medicine;
use Transmedic\EPuskesmas\Tools\MedicineImporter\Models\Pivot\Composition as PivotComposition;

class MedicineTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    // public function test_debug_for_medicine_relationship(): void
    // {
    //     $medicine = Medicine::with(['compositions'])->first();

    //     dd($medicine);
    // }

    /**
     * A basic feature test example.
     */
    public function test_insert_for_medicine(): void
    {
        /** @var Medicine $medicine */
        $medicine = Medicine::create([
            'nk_medicineName' => fake()->company(),
            'nk_akronim' => 'DEBUG',
        ]);

        $resep = [
            [
                'nk_compName' => 'Composition Debug 1',
                'nk_dosis_comp' => 0,
                'nk_satuan_comp' => 'mg',
            ],
            [
                'nk_compName' => 'Composition Debug 2',
                'nk_dosis_comp' => 0,
                'nk_satuan_comp' => 'mg',
            ],
        ];

        foreach ($resep as $key => $value) {
            $composition = Composition::create($value);

            PivotComposition::create([
                'nk_medicineId_mc' => $medicine->nk_medicineId,
                'nk_compId_mc' => $composition->nk_compId,
            ]);
        }
    }
}
