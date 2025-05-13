@extends('layouts.app') @section('title', 'Student Page | Sijinak')
@section('content')
<h3>Daftar Siswa</h3>
<div class="row mb-3">
    <div class="col-md-6">
        <form
            class="d-flex my-2 my-lg-0"
            method="GET"
            action="{{ route('students.index') }}"
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
                <th>Ubah Data</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($students as $student)
            <tr>
                <td><span class="fw-medium">{{ $student->name }}</span></td>
                <td><span class="fw-medium">{{ $student->nisn }}</span></td>
                <td>
                    <span class="fw-medium"
                        >{{ $student->classes->className ?? '-'}}</span
                    >
                </td>
                <td>
                    <div class="dropdown">
                        <button
                            type="button"
                            class="btn p-0 dropdown-toggle hide-arrow"
                            data-bs-toggle="dropdown"
                        >
                            <i class="bx bx-dots-vertical-rounded"></i>
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="{{ route('students.edit', $student->id) }}"
                                ><i class="bx bx-edit-alt me-1"></i>Edit</a
                            >
                            <form
                                action="{{ route('students.destroy', $student->id) }}"
                                method="POST"
                                onsubmit="return confirm('Yakin ingin menghapus siswa ini?');"
                            >
                                @csrf @method('DELETE')
                                <button class="dropdown-item" type="submit">
                                    <i class="bx bx-trash me-1"></i>Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </td>
            </tr>
            @empty @endforelse
        </tbody>
    </table>
</div>
@endsection