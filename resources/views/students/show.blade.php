@extends('layouts.app') @section('title', $student->name . ' | Sijinak')
@section('content')
<div class="text-end mb-3">
    <a href="{{ url()->previous() }}" class="btn btn-outline-primary"
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
        <th>Email</th>
        <td><span class="fw-medium">{{ $student->user->email }}</span></td>
    </tr>
    <tr>
        <th>NISN</th>
        <td><span class="fw-medium">{{ $student->nisn }}</span></td>
    </tr>
    <tr>
        <th>Kelas</th>
        <td>
            <span class="fw-medium"
                >{{ $student->classes->className ?? '-' }}</span
            >
        </td>
    </tr>
    <tr>
        <th>Nama Orang Tua</th>
        <td>
            <span class="fw-medium">{{ $student->parent->name ?? '-' }}</span>
        </td>
    </tr>
</table>
@endsection
