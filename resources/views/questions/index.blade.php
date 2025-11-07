@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Bank Soal</h1>

    {{-- Link Tambah Soal Baru diarahkan ke halaman seleksi Mata Kuliah --}}
    <a href="{{ route('questions.select') }}" class="btn btn-primary mb-4">Tambah Soal Baru</a>
    
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- ----------------------------------------------------- --}}
    {{-- LOOPING UNTUK MENAMPILKAN MATA KULIAH DAN SOALNYA --}}
    {{-- ----------------------------------------------------- --}}
    
    @forelse ($courses as $course)
        <div class="card mb-5 border-info">
            <div class="card-header bg-info text-white">
                <h3 class="mb-0">Mata Kuliah: {{ $course->name }} 
                    <span class="badge bg-light text-info float-end">{{ $course->questions->count() }} Soal</span>
                </h3>
            </div>
            <div class="card-body p-0">
                
                @if ($course->questions->isEmpty())
                    <div class="alert alert-warning m-3">Belum ada soal tersimpan untuk Mata Kuliah **{{ $course->name }}**.</div>
                @else
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th style="width: 5%">#</th>
                                <th style="width: 50%">Teks Soal</th>
                                <th style="width: 15%">Tipe</th>
                                <th style="width: 10%">Kunci Jawaban</th>
                                <th style="width: 20%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($course->questions as $question)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ Str::limit($question->text, 100) }}</td>
                                    <td>{{ $question->type }}</td>
                                    <td>{{ strtoupper($question->correct_answer_key) }}</td>
                                    <td>
                                        {{-- Link Lihat (show) --}}
                                        <a href="{{ route('questions.show', $question->id) }}" class="btn btn-sm btn-info text-white">Lihat</a>
                                        
                                        {{-- Link Edit (edit) --}}
                                        <a href="{{ route('questions.edit', $question->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                        
                                        {{-- Form Hapus (destroy) --}}
                                        <form action="{{ route('questions.destroy', $question->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus soal ini?')">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    @empty
        <div class="alert alert-primary">
            <h4 class="alert-heading">Database Mata Kuliah Kosong!</h4>
            <p>Anda belum memiliki Mata Kuliah. Silakan tambahkan Mata Kuliah terlebih dahulu.</p>
        </div>
    @endforelse
</div>
@endsection