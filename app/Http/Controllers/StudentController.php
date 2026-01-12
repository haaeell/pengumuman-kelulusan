<?php

namespace App\Http\Controllers;

use App\Imports\StudentsImport;
use App\Models\Student;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::orderBy('nama')->get();
        return view('admin.students.index', compact('students'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nis' => 'required|unique:students',
            'nama' => 'required',
            'kelas' => 'required',
            'final_score' => 'required|numeric|min:0|max:100',
        ], [
            'nis.required' => 'NIS harus diisi',
            'nis.unique' => 'NIS sudah ada',
            'nama.required' => 'Nama harus diisi',
            'kelas.required' => 'Kelas harus diisi',
            'final_score.required' => 'Nilai akhir harus diisi',
            'final_score.numeric' => 'Nilai akhir harus berupa angka',
            'final_score.min' => 'Nilai akhir minimal 0',
            'final_score.max' => 'Nilai akhir maksimal 100',
        ]);

        Student::create([
            'nis' => $request->nis,
            'nama' => $request->nama,
            'kelas' => $request->kelas,
            'final_score' => $request->final_score,
            'is_eligible' => $request->has('is_eligible'),
        ]);

        return back()->with('success', 'Data berhasil ditambahkan');
    }

    public function update(Request $request, Student $student)
    {
        $request->validate([
            'nis' => 'required|unique:students,nis,' . $student->id,
            'nama' => 'required',
            'kelas' => 'required',
            'final_score' => 'required|numeric|min:0|max:100',
        ], [
            'nis.required' => 'NIS harus diisi',
            'nis.unique' => 'NIS sudah ada',
            'nama.required' => 'Nama harus diisi',
            'kelas.required' => 'Kelas harus diisi',
            'final_score.required' => 'Nilai akhir harus diisi',
            'final_score.numeric' => 'Nilai akhir harus berupa angka',
            'final_score.min' => 'Nilai akhir minimal 0',
            'final_score.max' => 'Nilai akhir maksimal 100',
        ]);

        $student->update([
            'nis' => $request->nis,
            'nama' => $request->nama,
            'kelas' => $request->kelas,
            'final_score' => $request->final_score,
            'is_eligible' => $request->has('is_eligible'),
        ]);

        return back()->with('success', 'Data berhasil diperbarui');
    }

    public function destroy(Student $student)
    {
        $student->delete();
        return back()->with('success', 'Data berhasil dihapus');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        Excel::import(new StudentsImport, $request->file('file'));

        return redirect()
            ->back()
            ->with('success', 'Data siswa berhasil diimport');
    }

    public function template()
    {
        return Excel::download(new \App\Exports\StudentsTemplateExport, 'template_import_siswa.xlsx');
    }

    public function printPdf(Request $request)
    {
        $request->validate([
            'nis' => 'required'
        ]);

        $student = Student::where('nis', $request->nis)->first();

        if (!$student) {
            abort(404, 'Data siswa tidak ditemukan');
        }

        $pdf = Pdf::loadView('admin.students.pdf', [
            'student' => $student
        ])->setPaper('A4', 'portrait');

        return $pdf->download('hasil_kelulusan_' . $student->nis . '.pdf');
    }
}
