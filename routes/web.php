<?php

use App\Http\Controllers\StudentCheckController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::post('/cek-nis', [StudentCheckController::class, 'check'])->name('student.check');
Route::post('/print', [StudentController::class, 'printPdf'])->name('student.print');

Route::middleware('auth')->prefix('students')->group(function () {
    Route::get('/template', [StudentController::class, 'template'])->name('students.template');
    Route::post('/import', [StudentController::class, 'import'])->name('students.import');
    Route::get('/', [StudentController::class, 'index'])->name('students.index');
    Route::get('/{student}', [StudentController::class, 'show'])->name('students.show');
    Route::post('/', [StudentController::class, 'store'])->name('students.store');
    Route::put('/{student}', [StudentController::class, 'update'])->name('students.update');
    Route::delete('/{student}', [StudentController::class, 'destroy'])->name('students.destroy');
});
Route::get('/home', function () {
    return redirect()->route('students.index');
});
