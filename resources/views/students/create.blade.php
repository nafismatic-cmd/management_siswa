@extends('layouts.app')
@section('title', 'Tambah Siswa')

@section('content')
<div class="card shadow-sm">
    <div class="card-body">
        <h4 class="mb-3">Tambah Siswa</h4>
        <form action="{{ route('students.store') }}" method="POST">
            @include('students._form')
        </form>
    </div>
</div>
@endsection