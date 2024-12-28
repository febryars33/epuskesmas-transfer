<?php

namespace App\Console\Commands;

use App\Contracts\Repositories\MedicalEquipmentRepository;
use App\Contracts\Repositories\MedicineRepository;
use App\Models\MedicalEquipment;
use Illuminate\Console\Command;

class TesterCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    public function __construct(
        protected MedicalEquipmentRepository $medicalEquipmentRepository,
        protected MedicineRepository $medicineRepository
    ) {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        dd($this->medicineRepository->get()->take(5)->toArray());
        // dd($this->medicalEquipmentRepository->search('Terumo', ['nama_brng'])->first()->toArray());

        // $medical_equipment = new MedicalEquipment;

        $medical_equipment = $this->medicalEquipmentRepository->get();

        $medical_equipment->transform(function (MedicalEquipment $value) {
            return [
                'name' => strtoupper($value->nama_brng),
                'type' => strtoupper($value->item_type->nama),
                'unit_long' => strtoupper($value->unit_code_long->satuan),
                'unit_short' => strtoupper($value->unit_code_short->satuan),
                'pharmaceutical_industry' => strtoupper($value->pharmaceutical_industry->nama_industri),
            ];
        });

        $this->table([
            'Nama',
            'Jenis',
            'Satuan Panjang',
            'Satuan Pendek',
            'Industri',
        ], $medical_equipment);

        $this->output->success('Total: '.$medical_equipment->count());
    }

    /**
     * Execute the console command.
     */
    // public function handle()
    // {
    //     $medicine = new Medicine;

    //     $medicine = $medicine->query()->get();

    //     $medicine->transform(function (Medicine $value) {
    //         return [
    //             'name'  =>  strtoupper($value->nama_brng),
    //             'type'  =>  strtoupper($value->item_type->nama),
    //             'unit_long' =>  strtoupper($value->unit_code_long->satuan),
    //             'unit_short' =>  strtoupper($value->unit_code_short->satuan),
    //             'pharmaceutical_industry' =>  strtoupper($value->pharmaceutical_industry->nama_industri),
    //             'item_category' =>  strtoupper($value->item_category->nama),
    //             'item_class' =>  strtoupper($value->item_class->nama),
    //         ];
    //     });

    //     $this->table([
    //         'Nama',
    //         'Jenis',
    //         'Satuan Panjang',
    //         'Satuan Pendek',
    //         'Industri',
    //         'Kategori',
    //         'Golongan',
    //     ], $medicine);

    //     $this->warn('Total: '.$medicine->count());
    // }
}
