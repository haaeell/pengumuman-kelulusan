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
            'description' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        AnnouncementDate::create($request->all());

        return back()->with('success', 'Tanggal pengumuman berhasil ditambahkan');
    }

    public function update(Request $request, AnnouncementDate $announcement)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'announcement_date' => 'required|date',
            'description' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        $announcement->update($request->all());

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

        return back()->with('success', 'Status berhasil diubah');
    }
}
