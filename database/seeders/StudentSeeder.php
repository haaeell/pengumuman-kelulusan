<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        $students = [
            [
                'nis' => '2024001',
                'nama' => 'Ahmad Fauzi',
                'kelas' => 'XII IPA 1',
                'final_score' => 88.50,
            ],
            [
                'nis' => '2024002',
                'nama' => 'Siti Aisyah',
                'kelas' => 'XII IPA 2',
                'final_score' => 72.00,
            ],
            [
                'nis' => '2024003',
                'nama' => 'Budi Santoso',
                'kelas' => 'XII IPS 1',
                'final_score' => 91.75,
            ],
            [
                'nis' => '2024004',
                'nama' => 'Dewi Lestari',
                'kelas' => 'XII IPS 2',
                'final_score' => 68.40,
            ],
            [
                'nis' => '2024005',
                'nama' => 'Rizky Pratama',
                'kelas' => 'XII IPA 3',
                'final_score' => 79.90,
            ],
        ];

        foreach ($students as $student) {
            Student::create([
                'nis' => $student['nis'],
                'nama' => $student['nama'],
                'kelas' => $student['kelas'],
                'final_score' => $student['final_score'],
                'is_eligible' => $student['final_score'] >= 75,
            ]);
        }
    }
}
