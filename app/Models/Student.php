<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;

    protected $table = 'students';
    protected $fillable = [
        'nis',
        'nisn',
        'password',
        'nama',
        'kelas',
        'tempat_lahir',
        'tanggal_lahir',
        'nama_orang_tua',
        'mapel',
        'total_score',
        'average_score',
        'ranking',
        'status',
    ];


    const STATUS_LULUS      = 'lulus';
    const STATUS_TIDAK_LULUS = 'tidak_lulus';

    public function isLulus(): bool
    {
        return $this->status === self::STATUS_LULUS;
    }

    public function getStatusLabelAttribute(): string
    {
        return $this->status === self::STATUS_LULUS ? 'Lulus' : 'Tidak Lulus';
    }
}
