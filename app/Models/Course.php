<?php
// app/Models/Course.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    // Relasi dari Mata Kuliah ke Soal
    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
