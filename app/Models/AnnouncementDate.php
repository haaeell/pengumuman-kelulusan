<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AnnouncementDate extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'announcement_date',
        'description',
        'is_active'
    ];

    protected $casts = [
        'announcement_date' => 'datetime',
        'is_active' => 'boolean'
    ];
}
