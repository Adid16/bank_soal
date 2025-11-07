@extends('layouts.app')

@section('content')
<div class="container">
    {{-- PASTIKAN JUDUL MENGAMBIL NAMA MATA KULIAH DARI CONTROLLER --}}
    <h1>Buat Soal Baru untuk Mata Kuliah: **{{ $course->name }}**</h1>
    
    <form action="{{ route('questions.store') }}" method="POST">
        @csrf
        
        {{-- FIELD TERSEMBUNYI UNTUK MENYIMPAN ID MATA KULIAH (dari URL) --}}
        <input type="hidden" name="course_id" value="{{ $course->id }}"> 
        
        {{-- BLOK INPUT SOAL --}}
        <div class="mb-3">
            <label for="text" class="form-label">Teks Soal</label>
            <textarea name="text" id="text" class="form-control @error('text') is-invalid @enderror" rows="4" required>{{ old('text') }}</textarea>
            @error('text')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        
        {{-- BLOK PILIHAN JAWABAN (Container untuk JS) --}}
        <h3>Pilihan Jawaban</h3>
        <div id="options-container">
            {{-- Input Pilihan Jawaban akan ditambahkan di sini oleh JavaScript --}}
        </div>

        <button type="button" class="btn btn-secondary mb-3" id="add-option-btn">Tambah Pilihan</button>

        {{-- BLOK KUNCI JAWABAN --}}
        <div class="mb-3">
            <label for="correct_answer_key" class="form-label">Kunci Jawaban (Pilih salah satu huruf)</label>
            <select name="correct_answer_key" id="correct_answer_key" class="form-control @error('correct_answer_key') is-invalid @enderror" required>
                <option value="">-- Pilih Kunci --</option>
                {{-- Opsi akan di-update oleh JavaScript --}}
            </select>
             @error('correct_answer_key')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        
        <button type="submit" class="btn btn-success">Simpan Soal</button>
    </form>
</div>

{{-- SCRIPT JAVASCRIPT DISIMPAN DI LUAR FORM, TAPI MASIH DALAM SECTION CONTENT --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const optionsContainer = document.getElementById('options-container');
        const addOptionBtn = document.getElementById('add-option-btn');
        const correctAnswerSelect = document.getElementById('correct_answer_key');
        let optionCount = 0;
        const keys = ['A', 'B', 'C', 'D', 'E', 'F']; 

        function addOption() {
            if (optionCount >= keys.length) {
                alert('Maksimum pilihan jawaban tercapai.');
                return;
            }

            const key = keys[optionCount];
            const lowerKey = key.toLowerCase();

            // 1. Tambah Input Pilihan
            const optionDiv = document.createElement('div');
            optionDiv.className = 'input-group mb-2 option-group';
            optionDiv.setAttribute('data-key', lowerKey);
            
            optionDiv.innerHTML = `
                <span class="input-group-text">${key}</span>
                <input type="text" name="options[${optionCount}][text]" class="form-control" placeholder="Teks Pilihan Jawaban ${key}" required>
                <input type="hidden" name="options[${optionCount}][key]" value="${lowerKey}">
                <button type="button" class="btn btn-outline-danger remove-option-btn" data-key="${lowerKey}">Hapus</button>
            `;
            optionsContainer.appendChild(optionDiv);

            // 2. Tambah Opsi ke Kunci Jawaban
            const correctOption = document.createElement('option');
            correctOption.value = lowerKey;
            correctOption.textContent = `Pilihan ${key}`;
            correctAnswerSelect.appendChild(correctOption);

            optionCount++;
        }

        // Hapus Pilihan
        optionsContainer.addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-option-btn')) {
                const keyToRemove = e.target.getAttribute('data-key');
                
                // Hapus input pilihan
                const optionGroup = e.target.closest('.option-group');
                optionGroup.remove();

                // Hapus opsi dari select kunci jawaban
                const optionElement = correctAnswerSelect.querySelector(`option[value="${keyToRemove}"]`);
                if (optionElement) {
                    optionElement.remove();
                }

                optionCount--;
                // Note: Agar array index tetap urut (options[0], options[1]), diperlukan logika JS yang lebih kompleks (merapikan indeks setelah penghapusan).
            }
        });

        addOptionBtn.addEventListener('click', addOption);
        
        // Tambahkan minimal 4 pilihan saat load
        for(let i = 0; i < 4; i++) {
            addOption();
        }
    });
</script>
@endsection