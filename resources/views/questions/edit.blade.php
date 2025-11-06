
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Soal: {{ Str::limit($question->text, 50) }}</h1>
    <form action="{{ route('questions.update', $question) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="text" class="form-label">Teks Soal</label>
            <textarea name="text" id="text" class="form-control @error('text') is-invalid @enderror" rows="4" required>{{ old('text', $question->text) }}</textarea>
            @error('text')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <h3>Pilihan Jawaban</h3>
        <div id="options-container">
            @foreach ($question->options as $index => $option)
                <div class="input-group mb-2 option-group" data-key="{{ $option->key }}">
                    <span class="input-group-text">{{ strtoupper($option->key) }}</span>
                    {{-- ID disisipkan sebagai input tersembunyi agar bisa di-update --}}
                    <input type="hidden" name="options[{{ $index }}][id]" value="{{ $option->id }}">
                    <input type="text" name="options[{{ $index }}][text]" class="form-control" value="{{ old('options.'.$index.'.text', $option->text) }}" placeholder="Teks Pilihan Jawaban {{ strtoupper($option->key) }}" required>
                    <input type="hidden" name="options[{{ $index }}][key]" value="{{ $option->key }}">
                    
                    {{-- Hanya tampilkan tombol hapus jika ini bukan opsi bawaan yang sudah ada --}}
                    @if ($index >= 4) {{-- Asumsi hanya opsi tambahan yang bisa dihapus --}}
                        <button type="button" class="btn btn-outline-danger remove-option-btn" data-key="{{ $option->key }}">Hapus</button>
                    @endif
                </div>
            @endforeach
            {{-- Pilihan tambahan dari JS akan masuk di sini --}}
        </div>

        <button type="button" class="btn btn-secondary mb-3" id="add-option-btn">Tambah Pilihan</button>

        <div class="mb-3">
            <label for="correct_answer_key" class="form-label">Kunci Jawaban (Pilih salah satu huruf)</label>
            <select name="correct_answer_key" id="correct_answer_key" class="form-control @error('correct_answer_key') is-invalid @enderror" required>
                <option value="">-- Pilih Kunci --</option>
                @foreach ($question->options as $option)
                    <option value="{{ $option->key }}" 
                        {{ old('correct_answer_key', $question->correct_answer_key) == $option->key ? 'selected' : '' }}>
                        Pilihan {{ strtoupper($option->key) }}
                    </option>
                @endforeach
                {{-- Opsi baru akan ditambahkan oleh JS --}}
            </select>
             @error('correct_answer_key')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        
        <button type="submit" class="btn btn-success">Update Soal</button>
    </form>
</div>

{{-- Script JS yang sama dengan create.blade.php perlu disesuaikan di sini untuk menghandle data lama --}}
@endsection