@extends('layouts.app')
@section('title', $class->className . ' | Sijinak')

@section('content')
<div class="text-end mb-3">
    <a href="{{ route('classes.index') }}" class="btn btn-outline-primary">Kembali</a>
</div>

<div class="row mb-3">
    <div class="col-md-6">
        <form class="d-flex my-2 my-lg-0" method="GET" action="{{ route('classes.show', $class->id) }}">
            <input
                class="form-control me-sm-2"
                type="text"
                name="search"
                placeholder="Cari Siswa"
                value="{{ request('search') }}"
            />
            <button class="btn btn-outline-primary my-2 my-sm-0" type="submit">Search</button>
        </form>
    </div>
</div>

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
                <td><span class="fw-medium">{{ $student->classes->className ?? '-' }}</span></td>
                <td>
                    <div class="dropdown">
                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                            <i class="bx bx-dots-vertical-rounded"></i>
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="{{ route('students.edit', $student->id) }}">
                                <i class="bx bx-edit-alt me-1"></i>Edit
                            </a>
                            <form action="{{ route('students.destroy', $student->id) }}" method="POST"
                                onsubmit="return confirm('Yakin ingin menghapus siswa ini?');">
                                @csrf @method('DELETE')
                                <input type="hidden" name="redirect_to" value="{{ url()->current() }}" />
                                <button class="dropdown-item" type="submit">
                                    <i class="bx bx-trash me-1"></i>Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </td>
            </tr>
            @empty
            @endforelse
        </tbody>
    </table>
</div>
@endsection
