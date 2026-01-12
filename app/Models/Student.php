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
        'nama',
        'kelas',
        'final_score',
        'is_eligible',
    ];

    protected $casts = [
        'final_score' => 'float',
        'is_eligible' => 'boolean',
    ];

    protected $attributes = [
        'is_eligible' => false,
    ];

    public function scopeEligible($query)
    {
        return $query->where('is_eligible', true);
    }

    public function scopeKelas($query, $kelas)
    {
        return $query->where('kelas', $kelas);
    }

    protected static function booted()
    {
        static::saving(function ($student) {
            if (! is_null($student->final_score)) {
                $student->is_eligible = $student->final_score >= 75;
            }
        });
    }
}
