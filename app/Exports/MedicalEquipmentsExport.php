<?php

namespace App\Exports;

use App\Models\MedicalEquipment;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Excel;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class MedicalEquipmentsExport implements FromCollection, Responsable, WithCustomStartCell, WithEvents, WithMapping, WithTitle
{
    use Exportable;

    private $writerType = Excel::XLSX;

    public function title(): string
    {
        return 'Sheet1';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $headers = [
                    'A' => 'NO',
                    'B' => 'NAMA OBAT',
                    'C' => 'Sedian Obat',
                    'D' => 'Satuan Jual Obat',
                    'E' => 'Kategori Pasaran Obat',
                    'F' => 'Gol Penanda Kemasan',
                    'G' => 'Kelas Terapi',
                    'H' => 'Komposisi',
                    'I' => 'Jumlah',
                    'J' => 'Satuan',
                ];

                $sheet = $event->sheet->getDelegate();

                $sheet->mergeCells('K1:X1');
                $sheet->setCellValue('K1', 'HARGA'); // Judul besar "HARGA"

                $column = 'K'; // Kolom awal
                foreach ([
                    'Dasar', 'H_Beli', 'Ralan', 'Kelas 1', 'Kelas 2', 'Kelas 3',
                    'Utama', 'VIP', 'VVIP', 'Beli Luar', 'Jual Bebas',
                    'Karyawan', 'Stok Minimal', 'Expire',
                ] as $header) {
                    $sheet->setCellValue($column.'2', $header); // Set nilai header di baris 2
                    $column++; // Pindah ke kolom berikutnya
                }

                foreach ($headers as $column => $header) {
                    $sheet->mergeCells("{$column}1:{$column}2"); // Merge cells A1:A2, B1:B2, dst.
                    $sheet->setCellValue("{$column}1", $header); // Set nilai header di baris pertama.
                }

                $sheet->getStyle('A1:X2')->applyFromArray([
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
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
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return MedicalEquipment::all();
    }

    public function getModel(): MedicalEquipment
    {
        return new MedicalEquipment;
    }

    /**
     * @param  MedicalEquipment  $medical_equipment
     */
    public function map($medical_equipment): array
    {
        static $number = 1;

        return [
            $number++,
            $medical_equipment->nama_brng,
            is_null($medical_equipment->unit_code_long) ? null : $medical_equipment->unit_code_long->satuan,
            is_null($medical_equipment->unit_code_short) ? null : $medical_equipment->unit_code_short->satuan,
            '-',
            '-',
            '-',
            '-',
            '-',
            '-',
            '-',
            // $medical_equipment->dasar,
            // $medical_equipment->h_beli,
            // $medical_equipment->ralan,
            // $medical_equipment->kelas1,
            // $medical_equipment->kelas2,
            // $medical_equipment->kelas3,
            // $medical_equipment->utama,
            // $medical_equipment->vip,
            // $medical_equipment->vvip,
            // $medical_equipment->beliluar,
            // $medical_equipment->jualbebas,
            // $medical_equipment->karyawan,
            // $medical_equipment->expire,
        ];
    }
}
