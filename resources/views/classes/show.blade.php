@extends('layouts.app') @section('title', $class->className . ' | Sijinak')
@section('content')
<div class="text-end mb-3">
    <a href="{{ route('classes.index') }}" class="btn btn-outline-primary"
        >Kembali</a
    >
</div>
<h3>Daftar Siswa Kelas {{ $class->className }}</h3>
<div class="row mb-3">
    <div class="col-md-6">
        <form
            class="d-flex my-2 my-lg-0"
            method="GET"
            action="{{ route('classes.show', $class->id) }}"
        >
            <input
                class="form-control me-sm-2"
                type="text"
                name="search"
                placeholder="Cari Siswa"
                value="{{ request('search') }}"
            />
            <button class="btn btn-outline-primary my-2 my-sm-0" type="submit">
                Search
            </button>
        </form>
    </div>
</div>
<a href="{{ route('students.create') }}" class="btn btn-primary me-2 mb-3"
    >Tambah Siswa</a
>
<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>Nama</th>
                <th>NISN</th>
                <th>Kelas</th>
                <th>Hapus</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($students as $student)
            <tr>
                <td><span class="fw-medium">{{ $student->name }}</span></td>
                <td><span class="fw-medium">{{ $student->nisn }}</span></td>
                <td>
                    <span class="fw-medium"
                        >{{ $student->classes->className ?? '-' }}</span
                    >
                </td>
                <td>
                    <form
                        action="{{ route('students.destroy', $student->id) }}"
                        method="POST"
                        onsubmit="return confirm('Yakin ingin menghapus siswa ini?');"
                    >
                        @csrf @method('DELETE')
                        <input
                            type="hidden"
                            name="redirect_to"
                            value="{{ url()->current() }}"
                        />
                        <button class="dropdown-item" type="submit">
                            <i class="bx bx-trash me-1"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @empty @endforelse
        </tbody>
    </table>
</div>
@endsection
