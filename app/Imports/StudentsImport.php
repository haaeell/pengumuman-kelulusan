<?php

namespace App\Imports;

use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;

class StudentsImport implements
    ToModel,
    WithHeadingRow,
    WithValidation,
    WithMapping,
    WithChunkReading
{
    public function chunkSize(): int
    {
        return 500;
    }

    public function map($row): array
    {
        $tanggal = $row['tanggal_lahir'] ?? null;

        if (is_numeric($tanggal)) {
            $tanggal = ExcelDate::excelToDateTimeObject($tanggal)->format('Y-m-d');
        } elseif (!empty($tanggal)) {
            try {
                $tanggal = Carbon::parse($tanggal)->format('Y-m-d');
            } catch (\Exception $e) {
                $tanggal = null;
            }
        }

        return [
            ...$row,
            'tanggal_lahir' => $tanggal,
        ];
    }

    public function model(array $row)
    {
        $ket = strtolower(trim($row['ket'] ?? ''));

        $status = match ($ket) {
            'lulus' => 'lulus',
            'tidak lulus', 'tidak_lulus' => 'tidak_lulus',
            default => 'lulus'
        };

        $existing = Student::where('nis', $row['nis'])->first();
        $rowPassword = trim($row['password'] ?? '');

        $data = [
            'nisn'           => $row['nisn'] ?? null,
            'nama'           => $row['nama'],
            'kelas'          => $row['kelas'],
            'tempat_lahir'   => $row['tempat_lahir'] ?? null,
            'tanggal_lahir'  => $row['tanggal_lahir'] ?? null,
            'nama_orang_tua' => $row['nama_orang_tua'] ?? null,
            'mapel'          => $row['mapel'] ?? null,
            'total_score'    => $row['total'],
            'average_score'  => $row['rata_rata'],
            'ranking'        => $row['ranking'],
            'status'         => $status,
        ];

        if ($existing) {
            if (!empty($rowPassword)) {
                $data['password'] = Hash::make($rowPassword);
            }
        } else {
            if (!empty($rowPassword)) {
                $data['password'] = Hash::make($rowPassword);
            }
        }

        Student::updateOrCreate(
            ['nis' => $row['nis']],
            $data
        );

        return null;
    }

    public function rules(): array
    {
        return [
            'nis'            => 'required',
            'nisn'           => 'required',
            'nama'           => 'required',
            'kelas'          => 'required',
            'tempat_lahir'   => 'required',
            'tanggal_lahir'  => 'required|date',
            'nama_orang_tua' => 'required',
            'mapel'          => 'nullable|string',
            'total'          => 'required|numeric',
            'rata_rata'      => 'required|numeric',
            'ranking'        => 'required|integer',
            'ket'            => 'required',
            'password'       => 'nullable|string',
        ];
    }
}
