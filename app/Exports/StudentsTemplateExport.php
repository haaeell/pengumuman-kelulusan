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
            'nisn',
            'password',
            'nama',
            'kelas',
            'tempat_lahir',
            'tanggal_lahir',
            'nama_orang_tua',
            'mapel',
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
                '1234567890',
                'Asthahannas18',
                'Haris Bintang Lazuardi',
                'XII-2',
                'Magelang',
                '2005-01-15',
                'Bapak Haris',
                'Matematika',
                6119,
                91.32,
                1,
                'lulus',
            ],
            [
                '18232411473',
                '1234567891',
                'Asthahannas18',
                'Budi Santoso',
                'XII-3',
                'Semarang',
                '2005-02-20',
                'Bapak Budi',
                'Bahasa Indonesia',
                5870,
                88.45,
                2,
                'tidak_lulus',
            ],
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $lastColumn = 'M';
        $lastRow    = $sheet->getHighestRow();

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

        $sheet->getStyle("A1:{$lastColumn}{$lastRow}")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => 'E5E7EB'],
                ],
            ],
        ]);

        $sheet->getStyle("A2:A{$lastRow}")
            ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->getStyle("E2:E{$lastRow}")
            ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->getStyle("J2:L{$lastRow}")
            ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        foreach (range(2, $lastRow) as $row) {
            $status = strtolower(trim($sheet->getCell("M{$row}")->getValue()));

            if ($status === 'lulus') {
                $sheet->getStyle("M{$row}")->applyFromArray([
                    'font' => ['bold' => true],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'DCFCE7'],
                    ],
                ]);
            }

            if ($status === 'tidak_lulus') {
                $sheet->getStyle("M{$row}")->applyFromArray([
                    'font' => ['bold' => true],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'FEE2E2'],
                    ],
                ]);
            }
        }

        $sheet->freezePane('A2');
    }
}
