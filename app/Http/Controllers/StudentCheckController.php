<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Student;
use App\Models\AnnouncementDate;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class StudentCheckController extends Controller
{
    public function check(Request $request)
    {
        $request->validate([
            'nis'      => 'required|string',
            'password' => 'required|string',
        ]);

        $announcement = AnnouncementDate::where('is_active', true)->first();

        if (!$announcement || now()->lt($announcement->announcement_date)) {
            return response()->json([
                'success' => false,
                'message' => 'Pengumuman belum dibuka. Silakan tunggu hingga tanggal yang telah ditentukan.',
            ], 403);
        }

        $student = Student::where('nis', $request->nis)->first();

        if (!$student) {
            return response()->json([
                'success' => false,
                'message' => 'NIS tidak ditemukan. Periksa kembali NIS kamu.',
            ], 404);
        }

        $passwordValid = false;

        if ($student->password) {
            if (Hash::check($request->password, $student->password)) {
                $passwordValid = true;
            } elseif ($request->password === $student->password) {
                $passwordValid = true;
            }
        } else {
            if ($request->password === $student->nis) {
                $passwordValid = true;
            }
        }

        if (!$passwordValid) {
            return response()->json([
                'success' => false,
                'message' => 'Password salah. Password default adalah NIS kamu.',
            ], 401);
        }

        $token = base64_encode($student->id . '|' . $student->nis . '|' . now()->timestamp);

        return response()->json([
            'success' => true,
            'student' => [
                'id'            => $student->id,
                'nis'           => $student->nis,
                'nama'          => $student->nama,
                'kelas'         => $student->kelas,
                'total_score'   => $student->total_score,
                'average_score' => $student->average_score,
                'ranking'       => $student->ranking,
                'status'        => $student->status,
            ],
            'token' => $token,
        ]);
    }

    public function certificate(Request $request, $id)
    {
        $student = Student::find($id);
        $announcement = AnnouncementDate::where('is_active', true)->first();

        if (!$announcement || now()->lt($announcement->announcement_date)) {
            abort(403, 'Pengumuman belum dibuka.');
        }

        if ($student->status !== 'lulus') {
            abort(403, 'Surat kelulusan hanya tersedia untuk siswa yang dinyatakan LULUS.');
        }

        $token = $request->query('token');

        if (!$token) {
            abort(403, 'Token tidak valid.');
        }

        $decoded = base64_decode($token);
        $parts   = explode('|', $decoded);

        if (
            count($parts) !== 3
            || (int) $parts[0] !== $student->id
            || $parts[1] !== $student->nis
            || (now()->timestamp - (int) $parts[2]) > 1800
        ) {
            abort(403, 'Token tidak valid atau sudah kadaluarsa. Silakan cek kelulusan ulang.');
        }

        $data = [
            'student'      => $student,
            'announcement' => $announcement,
            'issued_at'    => Carbon::now()->translatedFormat('d F Y'),
            'year'         => Carbon::now()->year,
            'school_year'  => (Carbon::now()->year - 1) . '/' . Carbon::now()->year,
        ];

        $pdf = Pdf::loadView('certificate', $data)
            ->setPaper('a4', 'portrait')
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled'      => true,
                'defaultFont'          => 'DejaVu Sans',
                'dpi'                  => 150,
            ]);

        $filename = 'Surat_Kelulusan_' . str_replace(' ', '_', $student->nama) . '_' . $student->nis . '.pdf';

        return $pdf->download($filename);
    }
}
