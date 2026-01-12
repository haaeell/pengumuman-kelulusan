<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;

class StudentCheckController extends Controller
{
    public function check(Request $request)
    {
        $request->validate([
            'nis' => 'required'
        ]);

        $student = Student::where('nis', $request->nis)->first();

        if (!$student) {
            return response()->json([
                'status' => 'not_found'
            ]);
        }

        return response()->json([
            'status' => 'found',
            'data' => [
                'nama' => $student->nama,
                'kelas' => $student->kelas,
                'nis' => $student->nis,
                'final_score' => $student->final_score,
                'is_eligible' => $student->is_eligible,
            ]
        ]);
    }
}
