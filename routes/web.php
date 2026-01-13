<?php

use App\Http\Controllers\StudentCheckController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\WaLinkController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::post('/cek-nis', [StudentCheckController::class, 'check'])->name('student.check');
Route::post('/print', [StudentController::class, 'printPdf'])->name('student.print');
Route::post('/student/update-status', [StudentController::class, 'updateStatus'])->name('student.updateStatus');

Route::middleware('auth')->prefix('students')->group(function () {
    Route::delete('/reset', [StudentController::class, 'reset'])->name('students.reset');
    Route::get('/template', [StudentController::class, 'template'])->name('students.template');
    Route::post('/import', [StudentController::class, 'import'])->name('students.import');
    Route::get('/', [StudentController::class, 'index'])->name('students.index');
    Route::get('/{student}', [StudentController::class, 'show'])->name('students.show');
    Route::post('/', [StudentController::class, 'store'])->name('students.store');
    Route::put('/{student}', [StudentController::class, 'update'])->name('students.update');
    Route::delete('/{student}', [StudentController::class, 'destroy'])->name('students.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/wa-links', [WaLinkController::class, 'index']);
    Route::post('/wa-links', [WaLinkController::class, 'store'])->name('wa-links.store');
});


Route::get('/home', function () {
    return redirect()->route('students.index');
});

Route::get('/migrate-fresh-seed', function () {
    Artisan::call('migrate:fresh', [
        '--seed' => true,
    ]);

    $output = Artisan::output();

    return response()->json([
        'status' => 'success',
        'message' => 'Database berhasil di-reset dan di-seed!',
        'artisan_output' => $output
    ]);
});
