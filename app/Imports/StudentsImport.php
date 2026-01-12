<?php

namespace App\Imports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class StudentsImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        $status = strtolower(trim($row['status'] ?? ''));

        $isEligible = match ($status) {
            'eligible', 'lulus', 'ya', 'yes' => true,
            'tidak', 'tidak eligible', 'no', 'false' => false,
            default => ($row['nilai_akhir'] >= 75),
        };

        return Student::updateOrCreate(
            ['nis' => $row['nis']],
            [
                'nama'         => $row['nama'],
                'kelas'        => $row['kelas'],
                'final_score' => $row['nilai_akhir'],
                'is_eligible' => $isEligible,
            ]
        );
    }

    public function rules(): array
    {
        return [
            'nis'          => 'required',
            'nama'         => 'required',
            'kelas'        => 'required',
            'nilai_akhir'  => 'required|numeric|min:0|max:100',
        ];
    }
}
