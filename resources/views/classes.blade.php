@extends('layouts.app') @section('title', 'Class Page | Sijinak')
@section('content')
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
                            <a class="dropdown-item" href="javascript:void(0);"
                                ><i class="bx bx-trash me-1"></i>Delete</a
                            >
                        </div>
                    </div>
                </td>
            </tr>
            @empty @endforelse
        </tbody>
    </table>
</div>
@endsection
