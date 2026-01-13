<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        $students = [
            [
                'nis' => '18232411472',
                'nama' => 'HARIS BINTANG LAZUARDI',
                'kelas' => 'XII-2',
                'total_score' => 6119,
                'average_score' => 91.32,
                'ranking' => 1,
            ],
            [
                'nis' => '18232411487',
                'nama' => 'AHMAD SAIFUL ANWAR',
                'kelas' => 'XII-1',
                'total_score' => 6067,
                'average_score' => 90.55,
                'ranking' => 2,
            ],
            [
                'nis' => '18232411523',
                'nama' => 'ELZIDNI ALFI ISHROQY',
                'kelas' => 'XII-3',
                'total_score' => 6062,
                'average_score' => 90.47,
                'ranking' => 3,
            ],
            [
                'nis' => '18232411560',
                'nama' => 'MUHAMMAD ADHITA MADYA PRAWIRA',
                'kelas' => 'XII-1',
                'total_score' => 6060,
                'average_score' => 90.44,
                'ranking' => 4,
            ],
            [
                'nis' => '18232411589',
                'nama' => 'M. PARIS DAFFA',
                'kelas' => 'XII-4',
                'total_score' => 6059,
                'average_score' => 90.43,
                'ranking' => 5,
            ],
        ];

        foreach ($students as $student) {
            Student::create([
                'nis'           => $student['nis'],
                'password'      => Hash::make('Asthahannas18'),

                'nama'          => $student['nama'],
                'kelas'         => $student['kelas'],

                'total_score'   => $student['total_score'],
                'average_score' => $student['average_score'],
                'ranking'       => $student['ranking'],

                // LOGIKA STATUS
                'status'        => 'eligible',
                'priority_level' => null,
                'is_eligible'   => true,
            ]);
        }
    }
}
