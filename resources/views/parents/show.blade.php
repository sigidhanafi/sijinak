@extends('layouts.app') @section('title', 'Detail Siswa') @section('content')
<div class="text-end mb-3">
    <a href="{{ route('parents.index') }}" class="btn btn-outline-primary"
        >Kembali</a
    >
</div>
<h3>Detail Wali Siswa</h3>
<table class="table">
    <tr>
        <th>Nama</th>
        <td><span class="fw-medium">{{ $parent->name }}</span></td>
    </tr>
    <tr>
        <th>Email</th>
        <td>{{ $parent->user->email }}</td>
    </tr>
    <tr>
        <th>Nama Siswa</th>
        <td>
            @if($parent->students->isNotEmpty()) {{
            $parent->students->first()->name }} @else - @endif
        </td>
    </tr>
    <tr>
        <th>NISN</th>
        <td>
            @if($parent->students->isNotEmpty()) {{
            $parent->students->first()->nisn ?? '-' }} @else - @endif
        </td>
    </tr>
    <tr>
        <th>Kelas</th>
        <td>
            @if($parent->students->isNotEmpty()) {{
            $parent->students->first()->classes->className ?? '-' }} @else -
            @endif
        </td>
    </tr>
</table>
@endsection
