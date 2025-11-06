<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->text('text'); // Isi teks soal
            $table->string('type')->default('multiple_choice'); // Tipe soal (pilihan ganda, esai, dll.)
            $table->string('correct_answer_key')->nullable(); // Menampung 'a', 'b', 'c', 'd' untuk kunci jawaban PG
            $table->timestamps();
        });
    }
    // ...
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
