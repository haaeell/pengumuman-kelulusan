<?php

namespace App\Imports;

use App\Models\Student;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;

class StudentsImport implements
    ToModel,
    WithHeadingRow,
    WithValidation,
    WithChunkReading,
    WithBatchInserts
{
    protected string $defaultPassword;

    public function __construct()
    {
        $this->defaultPassword = Hash::make('Asthahannas18');
    }

    public function chunkSize(): int
    {
        return 500;
    }

    public function batchSize(): int
    {
        return 500;
    }

    public function model(array $row)
    {
        $ket = strtolower(trim($row['ket'] ?? ''));

        $status = match ($ket) {
            'lulus' => 'lulus',
            'tidak lulus', 'tidak_lulus' => 'tidak_lulus',
            default => 'lulus'
        };

        return new Student([
            'nis'           => $row['username'],
            'nama'          => $row['nama'],
            'kelas'         => $row['kelas'],
            'total_score'   => $row['total'],
            'average_score' => $row['rata_rata'],
            'ranking'       => $row['ranking'],
            'password'      => $this->defaultPassword,
            'status'        => $status,
        ]);
    }

    public function rules(): array
    {
        return [
            'username'  => 'required',
            'nama'      => 'required',
            'kelas'     => 'required',
            'total'     => 'required|numeric',
            'rata_rata' => 'required|numeric',
            'ranking'   => 'required|integer',
            'ket'       => 'required',
        ];
    }
}
