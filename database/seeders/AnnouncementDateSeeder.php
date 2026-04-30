<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AnnouncementDate;
use Carbon\Carbon;

class AnnouncementDateSeeder extends Seeder
{
    public function run(): void
    {
        AnnouncementDate::truncate();

        AnnouncementDate::insert([
            [
                'title' => 'Pengumuman Kelulusan 2026',
                'announcement_date' => Carbon::now()->addDays(7),
                'description' => 'Pengumuman kelulusan siswa tahun 2026',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
