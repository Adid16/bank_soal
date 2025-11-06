<?php
namespace App\Http\Controllers; // <-- WAJIB: Namespace untuk Controller Anda


use App\Http\Controllers\Controller;
use App\Models\Question; // <-- Baris ini harus ada!
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuestionController extends Controller
{

      public function index()
    {
        // Ambil semua soal dari database
        $questions = Question::latest()->get(); 
        
        // Mengarahkan ke view questions.index dan mengirimkan data soal
        return view('questions.index', compact('questions')); 
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'text' => 'required|string',
            'options.*.key' => 'required|in:a,b,c,d',
            'options.*.text' => 'required|string',
            'correct_answer_key' => 'required|in:a,b,c,d',
        ]);

        DB::transaction(function () use ($validatedData) {
            // 1. Buat Soal
            $question = Question::create([
                'text' => $validatedData['text'],
                'correct_answer_key' => $validatedData['correct_answer_key'],
                // default type multiple_choice
            ]);

            // 2. Simpan Pilihan Jawaban
            $question->options()->createMany($validatedData['options']);
        });

        return redirect()->route('questions.index')->with('success', 'Soal berhasil ditambahkan.');
    }
    // app/Http/Controllers/QuestionController.php

public function create()
{
    // Mengarahkan ke form pembuatan soal
    return view('questions.create'); 
}

// app/Http/Controllers/QuestionController.php

public function update(Request $request, Question $question)
{
    $validatedData = $request->validate([
        'text' => 'required|string',
        'options.*.id' => 'nullable|integer', // Untuk opsi yang sudah ada
        'options.*.key' => 'required|string|max:1', 
        'options.*.text' => 'required|string',
        'correct_answer_key' => 'required|string|max:1',
    ]);

    DB::transaction(function () use ($validatedData, $question) {
        // 1. Update data Soal utama
        $question->update([
            'text' => $validatedData['text'],
            'correct_answer_key' => $validatedData['correct_answer_key'],
        ]);

        // 2. Hapus semua Opsi lama
        $question->options()->delete(); 
        
        // 3. Simpan semua Opsi baru/yang diperbarui
        $question->options()->createMany($validatedData['options']);
    });

    return redirect()->route('questions.index')->with('success', 'Soal berhasil diperbarui.');
}


// app/Http/Controllers/QuestionController.php

/**
 * Menampilkan form untuk mengedit soal.
 */
public function edit(Question $question)
{
    // Karena Route Model Binding, $question sudah berisi data soal dan relasi options-nya.
    return view('questions.edit', compact('question'));
}




// app/Http/Controllers/QuestionController.php

/**
 * Menghapus soal dari database.
 */
public function destroy(Question $question)
{
    // Saat question dihapus, semua options terkait akan otomatis terhapus (cascade).
    $question->delete();

    return redirect()->route('questions.index')->with('success', 'Soal berhasil dihapus.');
}

 public function show(Question $question)
    {
        // Route Model Binding memastikan $question sudah berisi data soal yang diminta.
        // Relasi options ($question->options) juga sudah siap digunakan di view.
        return view('questions.show', compact('question'));
    }



  
    // Terapkan logika untuk index, show, edit, update, dan destroy (beserta relasi options)
}

