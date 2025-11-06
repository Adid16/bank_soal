

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            Detail Soal
        </div>
        <div class="card-body">
            <h5 class="card-title">Teks Soal:</h5>
            <p class="card-text">{{ $question->text }}</p>
            <hr>

            <h6>Pilihan Jawaban:</h6>
            <ul class="list-group mb-3">
                @foreach ($question->options as $option)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span class="badge bg-primary me-2">{{ strtoupper($option->key) }}</span>
                        {{ $option->text }}

                        @if ($question->correct_answer_key === $option->key)
                            <span class="badge bg-success">Kunci Jawaban</span>
                        @endif
                    </li>
                @endforeach
            </ul>
            
            <p><strong>Tipe Soal:</strong> {{ $question->type }}</p>
            <p><strong>Kunci Jawaban (Resmi):</strong> {{ strtoupper($question->correct_answer_key) }}</p>

            <a href="{{ route('questions.index') }}" class="btn btn-secondary mt-3">Kembali ke Daftar Soal</a>
        </div>
    </div>
</div>
@endsection