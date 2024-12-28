<?php

namespace App\Exports;

use App\Concerns\String\Cleaner;
use App\Models\Employee;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;

class EmployeesExport implements FromCollection, WithCustomStartCell, WithEvents, WithMapping
{
    use Cleaner, Exportable;

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Employee::all();
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $headers = [
                    'A' => 'NIP',
                    'B' => 'NIK',
                    'C' => 'Nama Pegawai',
                    'D' => 'Jenis Kelamin',
                    'E' => 'Tempat Lahir',
                    'F' => 'Tanggal Lahir',
                    'G' => 'Golongan Darah',
                    'H' => 'Domisili (Prov,Kab,Kec,Kel)',
                    'I' => 'Agama',
                    'J' => 'Profesi',
                    'K' => 'Asal Negara',
                    'L' => 'Alamat(Prov,Kab,Kec,Kel)',
                    'M' => 'Tanngal Bekerja',
                    'N' => 'username',
                    'O' => 'email',
                ];

                $sheet = $event->sheet->getDelegate();

                foreach ($headers as $column => $header) {
                    $sheet->setCellValue("{$column}1", $header); // Set nilai header di baris pertama.
                }

                $sheet->getStyle('A1:O1')->applyFromArray([
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    ],
                    'font' => [
                        'bold' => true,
                    ],
                ]);
            },
        ];
    }

    public function startCell(): string
    {
        return 'A2';
    }

    /**
     * @param  Employee  $employee
     */
    public function map($employee): array
    {
        return [
            '-', // NIP
            $this->clean()->nik($employee->nik), // NIK
            strtoupper($employee->nama),
            $this->clean()->gender($employee->jk),
            strtoupper($employee->tmp_lahir),
            $employee->tgl_lahir,
            '-', // GOLONGAN DARAH
            $employee->alamat,
            'ISLAM', //AGAMA
            $this->clean()->ucwords($employee->bidang),
            'INDONESIA',
            $employee->alamat,
            $employee->mulai_kerja,
            '-',
            '-',
        ];
    }

    public function getModel(): Employee
    {
        return new Employee;
    }
}
