<?php

use App\Http\Controllers\AnnouncementDateController;
use App\Http\Controllers\StudentCheckController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\WaLinkController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::post('/check', [StudentCheckController::class, 'check'])->name('check.result');
Route::get('/students/{student}/certificate', [StudentCheckController::class, 'certificate'])->name('check.certificate');

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
    Route::controller(AnnouncementDateController::class)->prefix('announcements')->name('announcements.')->group(function () {
        Route::get('/',           'index')->name('index');
        Route::post('/',          'store')->name('store');
        Route::put('/{announcement}',    'update')->name('update');
        Route::delete('/{announcement}', 'destroy')->name('destroy');
        Route::patch('/{announcement}/toggle', 'toggleActive')->name('toggle');
    });
});


Route::get('/home', function () {
    return redirect()->route('students.index');
});
