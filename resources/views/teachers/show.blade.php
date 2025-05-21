@extends('layouts.app') @section('title', $teacher->name . ' | Sijinak')
@section('content')
<div class="text-end mb-3">
    <a href="{{ route('teachers.index') }}" class="btn btn-outline-primary"
        >Kembali</a
    >
</div>
<h3>Detail Guru</h3>
<table class="table">
    <tr>
        <th>Nama</th>
        <td><span class="fw-medium">{{ $teacher->name }}</span></td>
    </tr>
    <tr>
        <th>Email</th>
        <td><span class="fw-medium">{{ $teacher->user->email }}</span></td>
    </tr>
    <tr>
        <th>NIP</th>
        <td><span class="fw-medium">{{ $teacher->nip }}</span></td>
    </tr>
    <tr>
        <th>Status Guru</th>
        <td>
            <span class="fw-medium">{{ $teacher->is_on_duty ? 'Guru Piket' : 'Guru' }}</span>
        </td>
    </tr>
    <tr>
        <th>Kelas</th>
        <td>
            <span class="fw-medium"
                >{{ $teacher->class->className ?? '-' }}</span
            >
        </td>
    </tr>
</table>
@endsection
