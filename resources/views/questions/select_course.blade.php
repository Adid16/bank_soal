@extends('layouts.app') 

@section('content')
<div class="container">
    <h1>Pilih Mata Kuliah</h1>
    <p class="lead">Pilih Mata Kuliah yang ingin Anda tambahkan soalnya.</p>
    
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="list-group">
        @foreach ($courses as $course)
            <a href="{{ route('questions.create', ['course_id' => $course->id]) }}" 
               class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                {{ $course->name }}
                <span class="badge bg-primary rounded-pill">Pilih</span>
            </a>
        @endforeach
    </div>

    @if ($courses->isEmpty())
        <div class="alert alert-warning mt-3">Belum ada Mata Kuliah yang ditambahkan.</div>
    @endif
    
</div>
@endsection