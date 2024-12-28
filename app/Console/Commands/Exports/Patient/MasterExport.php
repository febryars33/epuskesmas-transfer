<?php

namespace App\Console\Commands\Exports\Patient;

use App\Exports\EmployeesExport;
use App\Exports\MedicalEquipmentsExport;
use App\Exports\MedicalTreatmentsExport;
use App\Exports\MedicinesExport;
use App\Exports\PatientsExport;
use Illuminate\Console\Command;
use InvalidArgumentException;

class MasterExport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'master:export';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    public function __construct(
        protected PatientsExport $patientsExport,
        protected MedicalTreatmentsExport $medicalTreatmentsExport,
        protected EmployeesExport $employeesExport,
        protected MedicinesExport $medicinesExport,
        protected MedicalEquipmentsExport $medicalEquipmentsExport
    ) {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $type = $this->choice('Silahkan pilih jenis export', ['Patient', 'MedicalTreatment', 'Employee', 'Medicine', 'MedicalEquipment']);

        $this->validation($type);
    }

    private function validation(string $type)
    {
        switch ($type) {
            case 'Patient':
                $this->patient();
                break;
            case 'MedicalTreatment':
                $this->medicalTreatment();
                break;
            case 'Employee':
                $this->employee();
                break;
            case 'Medicine':
                $this->medicine();
                break;
            case 'MedicalEquipment':
                $this->medicalEquipment();
                break;

            default:
                throw new InvalidArgumentException;
                break;
        }
    }

    protected function patient()
    {
        $this->alert('Exporting Data Pasien...');

        $this->warn('Total: '.$this->patientsExport->getModel()->getRowTotal());

        $this->patientsExport->store(static::getFolderPath().'/'.'Data Pasien.xlsx');

        $this->info('Exported!');
    }

    protected function medicalTreatment()
    {
        $this->alert('Exporting Data Tindakan Medis...');

        $this->warn('Total: '.$this->medicalTreatmentsExport->getModel()->getRowTotal());

        $this->medicalTreatmentsExport->store(static::getFolderPath().'/'.'Data Tindakan Medis.xlsx');

        $this->info('Exported!');
    }

    protected function employee()
    {
        $this->alert('Exporting Data Pegawai...');

        $this->warn('Total: '.$this->employeesExport->getModel()->getRowTotal());

        $this->employeesExport->store(static::getFolderPath().'/'.'Data Pegawai.xlsx');

        $this->info('Exported!');
    }

    protected function medicine()
    {
        $this->alert('Exporting Data Obat...');

        $this->warn('Total: '.$this->medicinesExport->getModel()->getRowTotal());

        $this->medicinesExport->store(static::getFolderPath().'/'.'Data Obat.xlsx');

        $this->info('Exported!');
    }

    protected function medicalEquipment()
    {
        $this->alert('Exporting Data Alkes...');

        $this->warn('Total: '.$this->medicalEquipmentsExport->getModel()->getRowTotal());

        $this->medicalEquipmentsExport->store(static::getFolderPath().'/'.'Data Alkes.xlsx');

        $this->info('Exported!');
    }

    protected static function getFolderPath()
    {
        return env('DB_DATABASE');
    }
}
