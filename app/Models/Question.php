<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Option; // <-- Baris ini yang hilang!

class Question extends Model
{
    use HasFactory;
    protected $fillable = ['text', 'type', 'correct_answer_key'];

    public function options()
    {
        // Pastikan Anda memanggil class Option yang sudah di-import
        return $this->hasMany(Option::class);
    }
}