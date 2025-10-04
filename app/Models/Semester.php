<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// Import HasMany dari namespace yang benar
use Illuminate\Database\Eloquent\Relations\HasMany;

class Semester extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    // Gunakan HasMany yang sudah di-import
    public function courses(): HasMany
    {
        return $this->hasMany(Course::class);
    }
}
