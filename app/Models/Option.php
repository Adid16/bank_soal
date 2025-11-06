<?php
namespace App\Models; // <-- Ini harus App\Models

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    use HasFactory;
    protected $fillable = ['question_id', 'key', 'text'];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}