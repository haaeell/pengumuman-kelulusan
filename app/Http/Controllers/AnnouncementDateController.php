<?php

namespace App\Http\Controllers;

use App\Models\AnnouncementDate;
use Illuminate\Http\Request;

class AnnouncementDateController extends Controller
{
    public function index()
    {
        $announcements = AnnouncementDate::orderBy('announcement_date', 'desc')->get();
        return view('admin.announcements.index', compact('announcements'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'announcement_date' => 'required|date',
            'announcement_hour' => 'required|min:0|max:23',
            'announcement_minute' => 'required|min:0|max:59',
            'announcement_second' => 'required|min:0|max:59',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean'
        ]);

        // Gabungkan tanggal dan waktu
        $dateTime = $this->combineDateAndTime(
            $request->announcement_date,
            $request->announcement_hour,
            $request->announcement_minute,
            $request->announcement_second
        );

        AnnouncementDate::create([
            'title' => $request->title,
            'announcement_date' => $dateTime,
            'description' => $request->description,
            'is_active' => $request->has('is_active') ? true : false
        ]);

        return back()->with('success', 'Tanggal pengumuman berhasil ditambahkan');
    }

    public function update(Request $request, AnnouncementDate $announcement)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'announcement_date' => 'required|date',
            'announcement_hour' => 'required|min:0|max:23',
            'announcement_minute' => 'required|min:0|max:59',
            'announcement_second' => 'required|min:0|max:59',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean'
        ]);

        // Gabungkan tanggal dan waktu
        $dateTime = $this->combineDateAndTime(
            $request->announcement_date,
            $request->announcement_hour,
            $request->announcement_minute,
            $request->announcement_second
        );

        $announcement->update([
            'title' => $request->title,
            'announcement_date' => $dateTime,
            'description' => $request->description,
            'is_active' => $request->has('is_active') ? true : false
        ]);

        return back()->with('success', 'Tanggal pengumuman berhasil diperbarui');
    }

    public function destroy(AnnouncementDate $announcement)
    {
        $announcement->delete();
        return back()->with('success', 'Tanggal pengumuman berhasil dihapus');
    }

    public function toggleActive(AnnouncementDate $announcement)
    {
        $announcement->update([
            'is_active' => !$announcement->is_active
        ]);

        $status = $announcement->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return back()->with('success', "Pengumuman berhasil {$status}");
    }

    /**
     * Menggabungkan tanggal dan waktu menjadi format datetime
     */
    private function combineDateAndTime($date, $hour, $minute, $second)
    {
        $time = sprintf('%02d:%02d:%02d', $hour, $minute, $second);
        return $date . ' ' . $time;
    }
}
