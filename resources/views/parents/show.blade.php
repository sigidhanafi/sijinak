@extends('layouts.app') @section('title', $parent->name . ' | Sijinak')
@section('content')
<div class="text-end mb-3">
    <a href="{{ url()->previous() }}" class="btn btn-outline-primary"
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
        <td><span class="fw-medium">{{ $parent->user->email }}</span></td>
    </tr>
    <tr>
        <th>Nama Siswa</th>
        <td>
            <span class="fw-medium"
                >@forelse ($parent->students as $student)
                <span class="fw-medium">{{ $student->name }}</span><br />
                @empty
                <span>-</span>
                @endforelse</span
            >
        </td>
    </tr>
    <tr>
        <th>NISN</th>
        <td>
            <span class="fw-medium"
                >@forelse ($parent->students as $student)
                <span class="fw-medium">{{ $student->nisn }}</span><br />
                @empty
                <span>-</span>
                @endforelse</span
            >
        </td>
    </tr>
    <tr>
        <th>Kelas</th>
        <td>
            <span class="fw-medium"
                >@forelse ($parent->students as $student)
                <span class="fw-medium">{{ $student->classes->className }}</span
                ><br />
                @empty
                <span>-</span>
                @endforelse</span
            >
        </td>
    </tr>
</table>
@endsection
