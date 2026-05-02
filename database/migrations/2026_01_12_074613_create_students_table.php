<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();

            $table->string('nis')->unique();
            $table->string('nisn')->unique();

            $table->string('password');
            $table->string('nama');
            $table->string('kelas');

            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');

            $table->string('nama_orang_tua');
            $table->string('mapel');

            $table->integer('total_score');
            $table->decimal('average_score', 6, 3);
            $table->integer('ranking');

            $table->string('file_surat')->nullable();

            $table->enum('status', [
                'lulus',
                'tidak_lulus',
            ])->default('lulus');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
