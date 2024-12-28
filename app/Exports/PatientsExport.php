<?php

namespace App\Exports;

use App\Models\Patient;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Excel;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class PatientsExport implements FromCollection, Responsable, WithColumnFormatting, WithCustomStartCell, WithEvents, WithMapping, WithTitle
{
    use Exportable;

    private $writerType = Excel::XLSX;

    public function title(): string
    {
        return 'Sheet1';
    }

    public function columnFormats(): array
    {
        return [
            'D' => NumberFormat::FORMAT_TEXT,
            'F' => NumberFormat::FORMAT_TEXT,
            'R' => NumberFormat::FORMAT_TEXT,
            'V' => NumberFormat::FORMAT_TEXT,
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $headers = [
                    'A' => 'NO',
                    'B' => 'TANGGAL',
                    'C' => 'JAM',
                    'D' => 'NO RM',
                    'E' => 'NAMA LENGKAP',
                    'F' => 'NIK/PASPORT/IDENTITAS RESMI',
                    'G' => 'TEMPAT LAHIR',
                    'H' => 'TANGGAL LAHIR',
                    'I' => 'JENIS KELAMIN',
                    'J' => 'WARGA NEGARA',
                    'K' => 'AGAMA',
                    'L' => 'PENDIDIKAN',
                    'M' => 'PEKERJAAN',
                    'N' => 'UNIT',
                    'O' => 'STATUS PERNIKAHAN',
                    'P' => 'ALAMAT KTP',
                    'Q' => 'ALAMAT DOMISILI',
                    'R' => 'NO HP',
                ];

                $sheet = $event->sheet->getDelegate();

                $sheet->mergeCells('S1:V1');
                $sheet->setCellValue('S1', 'PENANGGUNG JAWAB/KELUARGA TERDEKAT');
                $sheet->setCellValue('S2', 'NAMA');
                $sheet->setCellValue('T2', 'JENIS KELAMIN');
                $sheet->setCellValue('U2', 'HUBUNGAN DENGAN PASIEN');
                $sheet->setCellValue('V2', 'NO HP');

                foreach ($headers as $column => $header) {
                    $sheet->mergeCells("{$column}1:{$column}2"); // Merge cells A1:A2, B1:B2, dst.
                    $sheet->setCellValue("{$column}1", $header); // Set nilai header di baris pertama.
                }

                $sheet->getStyle('A1:V2')->applyFromArray([
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
        return 'A3';
    }

    /**
     * @param  Patient  $patient
     */
    public function map($patient): array
    {
        static $number = 1;

        return [
            $number++,
            '-',
            '-',
            $patient->no_rkm_medis,
            strtoupper($patient->nm_pasien),
            $patient->no_ktp,
            strtoupper($patient->tmp_lahir),
            $patient->tgl_lahir,
            $patient->jk,
            '-', // WARGA NEGARA
            strtoupper($patient->agama),
            strtoupper($patient->pnd),
            strtoupper($patient->pekerjaan),
            '-', // UNIT
            $patient->stts_nikah,
            strtoupper($patient->alamat),
            strtoupper($patient->alamat),
            $patient->no_ktp,
            // NOTE: penanggung jawab
            strtoupper($patient->namakeluarga),
            '-', // JENIS KELAMIN
            strtoupper($patient->keluarga),
            $patient->no_tlp,
        ];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Patient::all();
    }

    public function getModel(): Patient
    {
        return new Patient;
    }
}
