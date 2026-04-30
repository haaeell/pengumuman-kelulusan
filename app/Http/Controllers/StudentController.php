<?php

namespace App\Http\Controllers;

use App\Imports\StudentsImport;
use App\Models\Student;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::orderBy('ranking')->get() ?? [];
        return view('admin.students.index', compact('students'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nis'           => 'required|unique:students',
            'nama'          => 'required',
            'kelas'         => 'required',
            'total_score'   => 'required|numeric|min:0',
            'average_score' => 'required|numeric|min:0|max:100',
            'ranking'       => 'required|integer|min:1',
        ], [
            'nis.unique' => 'NIS tidak boleh sama',
            'ranking.min' => 'Ranking minimal 1',
            'average_score.max' => 'Nilai rata-rata tidak boleh lebih dari 100',
            'total_score.min' => 'Total nilai tidak boleh kurang dari 0',
            'average_score.min' => 'Nilai rata-rata tidak boleh kurang dari 0',
        ]);

        Student::create([
            'nis'            => $request->nis,
            'nama'           => $request->nama,
            'kelas'          => $request->kelas,

            'total_score'    => $request->total_score,
            'average_score'  => $request->average_score,
            'ranking'        => $request->ranking,
            'status'         => 'lulus',
            'password'       => Hash::make('Asthahannas18'),
        ]);

        return back()->with('success', 'Data siswa berhasil ditambahkan');
    }

    public function update(Request $request, Student $student)
    {
        $request->validate([
            'nis'           => 'required|unique:students,nis,' . $student->id,
            'nama'          => 'required',
            'kelas'         => 'required',
            'total_score'   => 'required|numeric|min:0',
            'average_score' => 'required|numeric|min:0|max:100',
            'ranking'       => 'required|integer|min:1',
        ], [
            'nis.unique' => 'NIS tidak boleh sama',
            'ranking.min' => 'Ranking minimal 1',
            'average_score.max' => 'Nilai rata-rata tidak boleh lebih dari 100',
            'total_score.min' => 'Total nilai tidak boleh kurang dari 0',
            'average_score.min' => 'Nilai rata-rata tidak boleh kurang dari 0',
        ]);

        $existingRanking = Student::where('ranking', $request->ranking)
            ->where('id', '<>', $student->id)
            ->first();

        if ($existingRanking) {
            return back()->withErrors(['ranking' => 'Ranking sudah digunakan oleh siswa lain'])->withInput();
        }

        $student->update([
            'nis'            => $request->nis,
            'nama'           => $request->nama,
            'kelas'          => $request->kelas,

            'total_score'    => $request->total_score,
            'average_score'  => $request->average_score,
            'ranking'        => $request->ranking,
            'status'         => 'lulus',
        ]);

        return back()->with('success', 'Data siswa berhasil diperbarui');
    }

    public function destroy(Student $student)
    {
        $student->delete();
        return back()->with('success', 'Data siswa berhasil dihapus');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        Excel::import(new StudentsImport, $request->file('file'));

        return back()->with('success', 'Data siswa berhasil diimport');
    }

    public function template()
    {
        return Excel::download(
            new \App\Exports\StudentsTemplateExport,
            'template_import_siswa.xlsx'
        );
    }

    public function printPdf(Request $request)
    {
        $request->validate([
            'nis' => 'required'
        ]);

        $student = Student::where('nis', $request->nis)->firstOrFail();

        $pdf = Pdf::loadView('admin.students.pdf', compact('student'))
            ->setPaper('A4', 'portrait');

        return $pdf->download(
            'hasil_kelulusan_' . $student->nis . '.pdf'
        );
    }

    /**
     * Siswa menerima / menolak
     */
    public function updateStatus(Request $request)
    {
        $request->validate([
            'nis' => 'required',
            'status' => 'required|in:ditolak,diterima'
        ]);

        $student = Student::where('nis', $request->nis)->first();
        if (!$student) {
            return response()->json(['status' => 'error', 'message' => 'Data tidak ditemukan']);
        }

        $student->status = $request->status;
        $student->save();

        return response()->json(['status' => 'success']);
    }

    public function reset()
    {
        Student::truncate();

        return back()->with('success', 'Semua data siswa berhasil direset');
    }
}
