<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lecturer extends Model
{
        use HasFactory;

    protected $fillable = [
        'name',
        'nidn',
        'position',
        'photo_url',
        'email',
    ];
}
