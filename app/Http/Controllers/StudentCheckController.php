<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\WaLink;
use Illuminate\Support\Facades\Hash;

class StudentCheckController extends Controller
{
    public function check(Request $request)
    {
        $request->validate([
            'nis' => 'required',
            'password' => 'required'
        ]);

        $student = Student::where('nis', $request->nis)->first();

        if (!$student) {
            return response()->json([
                'status' => 'not_found'
            ]);
        }

        if (!Hash::check($request->password, $student->password)) {
            return response()->json([
                'status' => 'wrong_password'
            ]);
        }

        $wa_links = WaLink::pluck('link', 'type');

        return response()->json([
            'status' => 'found',
            'data' => [
                'nama' => $student->nama,
                'kelas' => $student->kelas,
                'nis' => $student->nis,
                'total_score' => $student->total_score,
                'ranking' => $student->ranking,
                'average_score' => $student->average_score,
                'is_eligible' => $student->is_eligible,
                'information'  => $student->information,
                'status' => $student->status,
                'wa_link_eligible' => $wa_links['eligible'] ?? null,
                'wa_link_cadangan' => $wa_links['cadangan'] ?? null,
            ]
        ]);
    }
}
