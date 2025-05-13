@extends('layouts.app') @section('title', 'Class Page | Sijinak')
@section('content')
<div class="row mb-3">
    <div class="col-md-6">
        <form
            class="d-flex my-2 my-lg-0"
            method="GET"
            action="{{ route('classes.index') }}"
        >
            <input
                class="form-control me-sm-2"
                type="text"
                name="search"
                placeholder="Cari Kelas"
                value="{{ request('search') }}"
            />
            <button class="btn btn-outline-primary my-2 my-sm-0" type="submit">
                Search
            </button>
        </form>
    </div>
</div>
<a href="{{ route('classes.create') }}" class="btn btn-primary me-2 mb-3"
    >Tambah Kelas</a
>
<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>Kelas</th>
                <th>Wali Kelas</th>
                <th>Jumlah Siswa</th>
                <th>Ubah Data</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($classes as $class)
            <tr>
                <td><span class="fw-medium">{{ $class->className }}</span></td>
                <td>-</td>
                <td>
                    <a href="/classes/{{ $class->id }}"
                        >{{ $class->totalStudents($class->id) }}</a
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
                            <a class="dropdown-item" href="javascript:void(0);"
                                ><i class="bx bx-edit-alt me-1"></i>Edit</a
                            >
                            <form
                                action="{{ route('classes.destroy', $class->id) }}"
                                method="POST"
                                onsubmit="return confirm('Yakin ingin menghapus kelas ini?');"
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
