<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class StudentsTemplateExport implements FromArray, WithHeadings, WithStyles, ShouldAutoSize
{
    public function headings(): array
    {
        return [
            'username',
            'pasword',
            'nama',
            'kelas',
            'total',
            'rata_rata',
            'ranking',
            'ket',
        ];
    }

    public function array(): array
    {
        return [
            [
                '18232411472',
                'Asthahannas18',
                'Haris Bintang Lazuardi',
                'XII-2',
                6119,
                91.32,
                1,
                'ELIGIBLE',
            ],
            [
                '18232411473',
                'Asthahannas18',
                'Budi Santoso',
                'XII-3',
                5870,
                88.45,
                2,
                'CADANGAN PRIORITAS 1',
            ],
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $lastColumn = 'H';
        $lastRow    = $sheet->getHighestRow();

        // Header style
        $sheet->getStyle("A1:{$lastColumn}1")->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '2563EB'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical'   => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // Border all
        $sheet->getStyle("A1:{$lastColumn}{$lastRow}")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => 'E5E7EB'],
                ],
            ],
        ]);

        // Alignment
        $sheet->getStyle("A2:A{$lastRow}")
            ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->getStyle("D2:D{$lastRow}")
            ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->getStyle("E2:G{$lastRow}")
            ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Status coloring
        foreach (range(2, $lastRow) as $row) {
            $status = strtoupper($sheet->getCell("H{$row}")->getValue());

            if ($status === 'ELIGIBLE') {
                $sheet->getStyle("H{$row}")->applyFromArray([
                    'font' => ['bold' => true],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'DCFCE7'],
                    ],
                ]);
            }

            if (str_contains($status, 'CADANGAN')) {
                $sheet->getStyle("H{$row}")->applyFromArray([
                    'font' => ['bold' => true],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'FEF9C3'],
                    ],
                ]);
            }
        }

        $sheet->freezePane('A2');
    }
}
