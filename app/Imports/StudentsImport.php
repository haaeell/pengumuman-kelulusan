<?php

namespace App\Imports;

use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Collection;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;

class StudentsImport implements
    ToCollection,
    WithHeadingRow,
    WithValidation,
    WithMapping,
    WithChunkReading
{
    private array $passwordCache = [];

    public function chunkSize(): int
    {
        return 100;
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
            'password'      => !empty($row['password']) ? (string) $row['password'] : null,
        ];
    }

    public function collection(Collection $rows)
    {
        $nisList     = $rows->pluck('nis')->filter()->unique()->values()->toArray();
        $existingNis = Student::whereIn('nis', $nisList)->pluck('password', 'nis')->toArray();

        $inserts = [];
        $updates = [];

        foreach ($rows as $row) {
            $ket    = strtolower(trim($row['ket'] ?? ''));
            $status = match ($ket) {
                'lulus'                      => 'lulus',
                'tidak lulus', 'tidak_lulus' => 'tidak_lulus',
                default                      => 'lulus'
            };

            $rowPassword = trim($row['password'] ?? '');
            $nis         = $row['nis'];

            $data = [
                'nis'            => $nis,
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
                'updated_at'     => now(),
            ];

            if (!empty($rowPassword)) {
                if (!isset($this->passwordCache[$rowPassword])) {
                    $this->passwordCache[$rowPassword] = Hash::make($rowPassword, ['rounds' => 4]);
                }
                $data['password'] = $this->passwordCache[$rowPassword];
            } elseif (!isset($existingNis[$nis])) {
                $data['password'] = null;
            }

            if (isset($existingNis[$nis])) {
                $updates[] = $data;
            } else {
                $data['created_at'] = now();
                $inserts[]          = $data;
            }
        }

        if (!empty($inserts)) {
            DB::table('students')->insert($inserts);
        }

        if (!empty($updates)) {
            $updateColumns = [
                'nisn',
                'nama',
                'kelas',
                'tempat_lahir',
                'tanggal_lahir',
                'nama_orang_tua',
                'mapel',
                'total_score',
                'average_score',
                'ranking',
                'status',
                'updated_at',
            ];

            if (collect($updates)->contains(fn($u) => isset($u['password']))) {
                $updateColumns[] = 'password';
            }

            DB::table('students')->upsert($updates, ['nis'], $updateColumns);
        }
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
            'password'       => 'nullable',
        ];
    }
}
