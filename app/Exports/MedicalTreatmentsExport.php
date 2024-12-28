<?php

namespace App\Exports;

use App\Models\MedicalTreatment;
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

class MedicalTreatmentsExport implements FromCollection, Responsable, WithColumnFormatting, WithCustomStartCell, WithEvents, WithMapping, WithTitle
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
            'A' => NumberFormat::FORMAT_NUMBER,
            'B' => NumberFormat::FORMAT_TEXT,
            'C' => NumberFormat::FORMAT_TEXT,
            'D' => NumberFormat::FORMAT_NUMBER,
            'E' => NumberFormat::FORMAT_NUMBER,
            'F' => NumberFormat::FORMAT_NUMBER,
            'G' => NumberFormat::FORMAT_NUMBER,
            'H' => NumberFormat::FORMAT_NUMBER,
            'I' => NumberFormat::FORMAT_NUMBER,
            'J' => NumberFormat::FORMAT_NUMBER,
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $headers = [
                    'A' => 'No',
                    'B' => 'Nama Tindakan Medis',
                    'C' => 'Poli',
                ];

                $sheet = $event->sheet->getDelegate();

                $sheet->mergeCells('D1:J1');
                $sheet->setCellValue('D1', 'Harga');
                $sheet->setCellValue('D2', 'Tindakan Medis');
                $sheet->setCellValue('E2', 'Jasa Sarana');
                $sheet->setCellValue('F2', 'Jasa Pelayanan');
                $sheet->setCellValue('G2', 'Material');
                $sheet->setCellValue('H2', 'Tarif Tindakan DR');
                $sheet->setCellValue('I2', 'Tarif Tindakan PR');
                $sheet->setCellValue('J2', 'Total Bayar');

                foreach ($headers as $column => $header) {
                    $sheet->mergeCells("{$column}1:{$column}2");
                    $sheet->setCellValue("{$column}1", $header);
                }

                $sheet->getStyle('A1:J2')->applyFromArray([
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

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return MedicalTreatment::all();
    }

    public function startCell(): string
    {
        return 'A3';
    }

    /**
     * @param  MedicalTreatment  $medical_treatment
     */
    public function map($medical_treatment): array
    {
        static $number = 1;

        return [
            $number++,
            ucwords(strtolower($medical_treatment->nm_perawatan)),
            ucwords(strtolower($medical_treatment->polyclinic->nm_poli)),
            '', // NOTE: Tindakan Medis
            '', // NOTE: Jasa Sarana
            '', // NOTE: Jasa Pelayanan
            (int) $medical_treatment->material == null ? 0 : $medical_treatment->material,
            (int) $medical_treatment->tarif_tindakandr == null ? 0 : $medical_treatment->material,
            (int) $medical_treatment->tarif_tindakanpr == null ? 0 : $medical_treatment->material,
            (int) $medical_treatment->total_byrdr == null ? 0 : $medical_treatment->material,
        ];
    }

    public function getModel(): MedicalTreatment
    {
        return new MedicalTreatment;
    }
}
