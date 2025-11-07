<?php
namespace App\Http\Controllers; // <-- WAJIB: Namespace untuk Controller Anda
use App\Models\Course;

use App\Http\Controllers\Controller;
use App\Models\Question; // <-- Baris ini harus ada!
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuestionController extends Controller
{

    public function selectCourse()
{
    $courses = Course::all();
    return view('questions.select_course', compact('courses'));
}

      public function index()
    {
        // Mengambil semua Mata Kuliah, sekaligus memuat semua soal yang terkait
        $courses = Course::with('questions')->get(); 
        
        return view('questions.index', compact('courses'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
        'text' => 'required|string',
        'course_id' => 'required|exists:courses,id', // <-- Validasi Mata Kuliah
        'options.*.key' => 'required|string|max:1',
        'options.*.text' => 'required|string',
        'correct_answer_key' => 'required|string|max:1',
    ]);

    DB::transaction(function () use ($validatedData) {
        $question = Question::create([
            'text' => $validatedData['text'],
            'course_id' => $validatedData['course_id'], // <-- Simpan ID Mata Kuliah
            'correct_answer_key' => $validatedData['correct_answer_key'],
            'type' => 'multiple_choice',
        ]);

            // 2. Simpan Pilihan Jawaban
            $question->options()->createMany($validatedData['options']);
        });

        return redirect()->route('questions.index')->with('success', 'Soal berhasil ditambahkan.');
    }
    // app/Http/Controllers/QuestionController.php

public function create(Request $request) // Menerima request untuk mengambil course_id
{
    $courseId = $request->get('course_id');
    
    if (!$courseId) {
        // Jika course_id tidak ada, redirect kembali ke halaman select course
        return redirect()->route('questions.select')->with('error', 'Pilih Mata Kuliah terlebih dahulu.');
    }

    $course = Course::findOrFail($courseId); // Ambil data Mata Kuliah yang dipilih

    // Sekarang, hanya kirim satu data course ke view create
    return view('questions.create', compact('course')); 
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
    $courses = Course::all();
    return view('questions.edit', compact('question', 'courses'));
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

