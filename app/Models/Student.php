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
        'total_score',
        'average_score',
        'ranking',
        'is_eligible',
        'information',
        'status',
        'password'
    ];


    protected $casts = [
        'total_score' => 'float',
        'is_eligible' => 'boolean',
    ];

    protected $attributes = [
        'is_eligible' => false,
    ];
}
