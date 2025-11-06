@extends('layouts.app') 

@section('content')
<div class="container">
    <h1>Bank Soal</h1>
    <a href="{{ route('questions.create') }}" class="btn btn-primary mb-3">Tambah Soal Baru</a>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($questions->isEmpty())
        <div class="alert alert-info">Belum ada soal yang tersimpan.</div>
    @else
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Teks Soal</th>
                    <th>Tipe</th>
                    <th>Kunci Jawaban</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($questions as $question)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ Str::limit($question->text, 70) }}</td>
                    <td>{{ $question->type }}</td>
                    <td>{{ strtoupper($question->correct_answer_key) }}</td>
                    <td>
                        <a href="{{ route('questions.show', $question) }}" class="btn btn-info btn-sm">Lihat</a>
                        <a href="{{ route('questions.edit', $question) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('questions.destroy', $question) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus soal ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection