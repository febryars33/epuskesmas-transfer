<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Transmedic\EPuskesmas\Tools\MedicineImporter\Facades\MedicineImporter;

class AkuCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:aku-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        dd(MedicineImporter::import('Data Obat.xlsx'));
    }
}
