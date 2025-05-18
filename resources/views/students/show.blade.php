@extends('layouts.app') @section('title', 'Detail Siswa') @section('content')
<div class="text-end mb-3">
    <a href="{{ route('students.index') }}" class="btn btn-outline-primary"
        >Kembali</a
    >
</div>
<h3>Detail Siswa</h3>
<table class="table">
    <tr>
        <th>Nama</th>
        <td><span class="fw-medium">{{ $student->name }}</span></td>
    </tr>
    <tr>
        <th>NISN</th>
        <td>{{ $student->nisn }}</td>
    </tr>
    <tr>
        <th>Kelas</th>
        <td>{{ $student->classes->className ?? '-' }}</td>
    </tr>
    <tr>
        <th>Nama Orang Tua</th>
        <td>{{ $student->parent->name ?? '-' }}</td>
    </tr>
</table>
@endsection
