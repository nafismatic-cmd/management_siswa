@extends('layouts.app')
@section('title', 'Edit Siswa')

@section('content')
<div class="card shadow-sm">
    <div class="card-body">
        <h4 class="mb-3">Edit Siswa</h4>
        <form action="{{ route('students.update', $student) }}" method="POST">
            @method('PUT')
            @include('students._form')
        </form>
    </div>
</div>
@endsection