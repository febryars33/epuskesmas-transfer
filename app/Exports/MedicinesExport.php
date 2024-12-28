<?php

namespace App\Exports;

use App\Models\Medicine;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Excel;

class MedicinesExport implements FromCollection, Responsable, WithCustomStartCell, WithEvents, WithMapping, WithTitle
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
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Medicine::all();
    }

    public function getModel(): Medicine
    {
        return new Medicine;
    }

    /**
     * @param  Medicine  $medicine
     */
    public function map($medicine): array
    {
        static $number = 1;

        return [
            $number++,
            $medicine->nama_brng,
            is_null($medicine->unit_code_long) ? null : $medicine->unit_code_long->satuan,
            is_null($medicine->unit_code_short) ? null : $medicine->unit_code_short->satuan,
            '-',
            '-',
            '-',
            '-',
            '-',
            '-',
            '-',
            $medicine->dasar,
            $medicine->h_beli,
            $medicine->ralan,
            $medicine->kelas1,
            $medicine->kelas2,
            $medicine->kelas3,
            $medicine->utama,
            $medicine->vip,
            $medicine->vvip,
            $medicine->beliluar,
            $medicine->jualbebas,
            $medicine->karyawan,
            $medicine->expire,
        ];
    }
}
