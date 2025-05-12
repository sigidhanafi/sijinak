@extends('layouts.app') @section('title', 'Student Page | Sijinak')
@section('content')
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
                        >{{ $student->classes->className }}</span
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
