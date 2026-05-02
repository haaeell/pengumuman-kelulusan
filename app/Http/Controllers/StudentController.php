<?php

namespace App\Http\Controllers;

use App\Imports\StudentsImport;
use App\Models\Student;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
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
            'nis'            => 'required|unique:students',
            'nisn'           => 'required|unique:students',
            'nama'           => 'required',
            'kelas'          => 'required',
            'tempat_lahir'   => 'required',
            'tanggal_lahir'  => 'required|date',
            'nama_orang_tua' => 'required',
            'mapel'          => 'nullable|string',

            'total_score'    => 'required|numeric|min:0',
            'average_score'  => 'required|numeric|min:0|max:100',
            'ranking'        => 'required|integer|min:1',
        ], [
            'nis.unique' => 'NIS tidak boleh sama',
            'nisn.unique' => 'NISN tidak boleh sama',
            'ranking.min' => 'Ranking minimal 1',
            'average_score.max' => 'Nilai rata-rata tidak boleh lebih dari 100',
            'total_score.min' => 'Total nilai tidak boleh kurang dari 0',
            'average_score.min' => 'Nilai rata-rata tidak boleh kurang dari 0',
        ]);

        Student::create([
            'nis'            => $request->nis,
            'nisn'           => $request->nisn,
            'nama'           => $request->nama,
            'kelas'          => $request->kelas,
            'tempat_lahir'   => $request->tempat_lahir,
            'tanggal_lahir'  => $request->tanggal_lahir,
            'nama_orang_tua' => $request->nama_orang_tua,
            'mapel'          => $request->mapel,

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
            'nis'            => 'required|unique:students,nis,' . $student->id,
            'nisn'           => 'required|unique:students,nisn,' . $student->id,
            'nama'           => 'required',
            'kelas'          => 'required',
            'tempat_lahir'   => 'required',
            'tanggal_lahir'  => 'required|date',
            'nama_orang_tua' => 'required',
            'mapel'          => 'nullable|string',

            'total_score'    => 'required|numeric|min:0',
            'average_score'  => 'required|numeric|min:0|max:100',
            'ranking'        => 'required|integer|min:1',
        ], [
            'nis.unique' => 'NIS tidak boleh sama',
            'nisn.unique' => 'NISN tidak boleh sama',
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
            'nisn'           => $request->nisn,
            'nama'           => $request->nama,
            'kelas'          => $request->kelas,
            'tempat_lahir'   => $request->tempat_lahir,
            'tanggal_lahir'  => $request->tanggal_lahir,
            'nama_orang_tua' => $request->nama_orang_tua,
            'mapel'          => $request->mapel,

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

    public function generateAllSurat()
    {
        return response()->stream(function () {

            set_time_limit(0);
            ini_set('memory_limit', '512M');

            $sharedData = [
                'school_year'    => '2025/2026',
                'rapat_tanggal'  => '4 Mei 2026',
                'issued_at'      => '4 Mei 2026',
                'kepala_sekolah' => 'Yanto Susanto, S.Pd., M.IP.',
                'nip_kepsek'     => '...',
                'logo_url' => 'data:image/png;base64,'  . base64_encode(file_get_contents(public_path('images/logo.png'))),
                'cap_url'  => 'data:image/png;base64,'  . base64_encode(file_get_contents(public_path('images/cap.png'))),
                'ttd_url'  => 'data:image/png;base64,'  . base64_encode(file_get_contents(public_path('images/ttd.png'))),
                'kop'      => 'data:image/jpeg;base64,' . base64_encode(file_get_contents(public_path('images/kop.jpeg'))),
                'footer'   => 'data:image/jpeg;base64,' . base64_encode(file_get_contents(public_path('images/footer.jpeg'))),
            ];

            $options = [
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled'      => false,
                'defaultFont'          => 'DejaVu Sans',
                'dpi'                  => 96,
            ];

            $total     = Student::whereNull('file_surat')->count();
            $generated = 0;

            // Kirim sinyal start
            echo "data: " . json_encode(['status' => 'running', 'generated' => 0, 'total' => $total]) . "\n\n";
            ob_flush();
            flush();

            Student::whereNull('file_surat')->chunk(50, function ($students) use ($sharedData, $options, $total, &$generated) {
                foreach ($students as $student) {
                    $data = array_merge($sharedData, ['student' => $student]);

                    $pdf = Pdf::loadView('certificate', $data)
                        ->setPaper('a4', 'portrait')
                        ->setOptions($options);

                    $filename = 'Surat_Kelulusan_' . str_replace(' ', '_', $student->nama) . '_' . $student->nis . '.pdf';
                    $path     = 'surat/' . $filename;

                    Storage::disk('public')->put($path, $pdf->output());
                    $student->update(['file_surat' => $path]);
                    $generated++;

                    // Push progress ke browser setiap 1 siswa
                    echo "data: " . json_encode([
                        'status'    => 'running',
                        'generated' => $generated,
                        'total'     => $total,
                    ]) . "\n\n";
                    ob_flush();
                    flush();
                }
            });

            // Selesai
            echo "data: " . json_encode(['status' => 'done', 'total' => $generated]) . "\n\n";
            ob_flush();
            flush();
        }, 200, [
            'Content-Type'      => 'text/event-stream',
            'Cache-Control'     => 'no-cache',
            'X-Accel-Buffering' => 'no',
        ]);
    }

    public function generateSurat($id)
    {
        $student = Student::findOrFail($id);

        $data = [
            'student'        => $student,
            'school_year'    => '2025/2026',
            'rapat_tanggal'  => '4 Mei 2026',
            'issued_at'      => '4 Mei 2026',
            'kepala_sekolah' => 'Yanto Susanto, S.Pd., M.IP.',
            'nip_kepsek'     => '...',
            'logo_url' => 'data:image/png;base64,'  . base64_encode(file_get_contents(public_path('images/logo.png'))),
            'cap_url'  => 'data:image/png;base64,'  . base64_encode(file_get_contents(public_path('images/cap.png'))),
            'ttd_url'  => 'data:image/png;base64,'  . base64_encode(file_get_contents(public_path('images/ttd.png'))),
            'kop'      => 'data:image/jpeg;base64,' . base64_encode(file_get_contents(public_path('images/kop.jpeg'))),
            'footer'   => 'data:image/jpeg;base64,' . base64_encode(file_get_contents(public_path('images/footer.jpeg'))),
        ];

        $pdf = Pdf::loadView('certificate', $data)
            ->setPaper('a4', 'portrait')
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled'      => false,
                'defaultFont'          => 'DejaVu Sans',
                'dpi'                  => 96,
            ]);

        $filename = 'Surat_Kelulusan_' . str_replace(' ', '_', $student->nama) . '_' . $student->nis . '.pdf';
        $path     = 'surat/' . $filename;

        Storage::disk('public')->put($path, $pdf->output());
        $student->update(['file_surat' => $path]);

        return back()->with('success', "Surat kelulusan {$student->nama} berhasil digenerate.");
    }
}
