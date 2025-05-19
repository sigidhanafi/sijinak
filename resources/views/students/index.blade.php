@extends('layouts.app') @section('title', 'Student Page | Sijinak')
@section('content')
<h3>Daftar Siswa</h3>
<div class="row mb-3">
    <div class="col-md-6">
        <form
            class="d-flex flex-column flex-sm-row gap-2"
            method="GET"
            action="{{ route('students.index') }}"
        >
            <input
                class="form-control"
                type="text"
                name="search"
                placeholder="Cari Siswa"
                value="{{ request('search') }}"
            />
            <button class="btn btn-outline-primary" type="submit">
                Search
            </button>
        </form>
    </div>
</div>
{{-- Tambah Siswa --}}
<button
    class="btn btn-primary mb-3"
    type="button"
    data-bs-toggle="offcanvas"
    data-bs-target="#offcanvasTambahSiswa"
    aria-controls="offcanvasTambahSiswa"
>
    Tambah Siswa
</button>
@php $showCreateOffcanvas = ($errors->any() && session('error_source') ===
'create'); @endphp
<div
    class="offcanvas offcanvas-end {{ $showCreateOffcanvas ? 'show' : '' }}"
    tabindex="-1"
    id="offcanvasTambahSiswa"
    aria-labelledby="offcanvasTambahSiswaLabel"
    style="{{ $showCreateOffcanvas ? 'visibility: visible;' : '' }}"
>
    <div class="offcanvas-header">
        <h3 class="offcanvas-title" id="offcanvasTambahSiswaLabel">
            Tambah Siswa
        </h3>
        <button
            type="button"
            class="btn-close"
            data-bs-dismiss="offcanvas"
            aria-label="Close"
        ></button>
    </div>
    <div class="offcanvas-body">
        <form action="{{ route('students.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Nama</label>
                <input
                    type="text"
                    name="name"
                    class="form-control"
                    placeholder="Nama Lengkap"
                    required
                />
                <div id="nameHelp" class="form-text">
                    Masukkan nama siswa.
                </div>
            </div>
            <div class="mb-3">
                <label for="nisn" class="form-label">NISN</label>
                <input
                    type="text"
                    name="nisn"
                    class="form-control"
                    placeholder="Nomor Induk Siswa Nasional"
                    required
                />
                <div id="nameHelp" class="form-text">
                    Masukkan NISN siswa.
                </div>
            </div>
            <div class="mb-3">
                <label for="classId" class="form-label">Kelas</label>
                <select name="classId" class="form-select" required>
                    <option value="" disabled selected>Kelas</option>
                    @foreach ($classes as $class)
                    <option value="{{ $class->id }}"
                        >{{ $class->className }}</option
                    >
                    @endforeach
                </select>
                <div id="nameHelp" class="form-text">
                    Pilih kelas siswa.
                </div>
            </div>
            <div class="d-flex gap-2 mt-2 mb-3">
                <button type="submit" class="btn btn-primary">
                    Simpan
                </button>
                <button
                    type="reset"
                    class="btn btn-label-primary"
                    data-bs-dismiss="offcanvas"
                >
                    Batal
                </button>
            </div>
        </form>
        @if (session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
        @endif @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error) {{ $error }} @endforeach
        </div>
        @endif
    </div>
</div>
{{-- Pagination --}}
<div class="mb-3 d-flex gap-2 align-items-center">
    <span>Show:</span>
    <form method="GET" action="{{ url()->current() }}">
        <select
            name="paginate"
            onchange="this.form.submit()"
            class="form-select"
        >
            @foreach ([10, 50, 100, 500] as $size) @php $selected =
            request('paginate', 10) == $size ? 'selected' : ''; @endphp
            <option value="{{ $size }}" {{ $selected }}>
                {{ $size }}
            </option>
            @endforeach
        </select>
    </form>

    @unless ($students->onFirstPage())
    <a
        href="{{ $students->previousPageUrl() }}&paginate={{ request('paginate', 10) }}"
        class="btn btn-primary"
    >
        Previous
    </a>
    @endunless @if ($students->hasMorePages())
    <a
        href="{{ $students->nextPageUrl() }}&paginate={{ request('paginate', 10) }}"
        class="btn btn-primary"
    >
        Next
    </a>
    @endif
</div>
{{-- Tabel Siswa --}}
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
                <td>
                    <a
                        href="{{ route('students.show', $student->id) }}"
                        class="fw-medium"
                        >{{ $student->name }}</a
                    >
                </td>
                <td>
                    <span class="fw-medium">{{ $student->nisn ?? '-'}}</span>
                </td>
                <td>
                    <span class="fw-medium"
                        >{{ $student->classes->className ?? '-' }}</span
                    >
                </td>
                <td class="" style="">
                    <div class="d-inline-block text-nowrap">
                        <button
                            class="btn btn-sm btn-icon btn-edit"
                            type="button"
                            data-bs-toggle="offcanvas"
                            data-bs-target="#offcanvasUbahSiswa-{{ $student->id }}"
                            aria-controls="offcanvasUbahSiswa-{{ $student->id }}"
                        >
                            <i class="bx bx-edit"></i>
                        </button>

                        @php $showEditOffcanvas = ($errors->any() &&
                        session('error_source') === 'update' &&
                        session('edited_id') == $student->id); @endphp

                        <div
                            class="offcanvas offcanvas-end {{ $showEditOffcanvas ? 'show' : '' }}"
                            id="offcanvasUbahSiswa-{{ $student->id }}"
                            tabindex="-1"
                            aria-labelledby="offcanvasUbahSiswaLabel-{{ $student->id }}"
                            style="{{ $showEditOffcanvas ? 'visibility: visible;' : '' }}"
                        >
                            <div class="offcanvas-header">
                                <h3
                                    class="offcanvas-title"
                                    id="offcanvasUbahLabel"
                                >
                                    Ubah Siswa
                                </h3>
                                <button
                                    type="button"
                                    class="btn-close"
                                    data-bs-dismiss="offcanvas"
                                    aria-label="Close"
                                ></button>
                            </div>
                            <div class="offcanvas-body">
                                <form
                                    action="{{ route('students.update', $student->id) }}"
                                    method="POST"
                                >
                                    @csrf @method('PUT')
                                    <div class="mb-3">
                                        <label for="name" class="form-label"
                                            >Nama</label
                                        >
                                        <input
                                            type="text"
                                            class="form-control"
                                            name="name"
                                            id="name"
                                            value="{{ $student->name }}"
                                            data-initial-value="{{ $student->name }}"
                                            required
                                        />
                                    </div>
                                    <div class="mb-3">
                                        <label for="nisn" class="form-label"
                                            >NISN</label
                                        >
                                        <input
                                            type="text"
                                            class="form-control"
                                            name="nisn"
                                            id="nisn"
                                            value="{{ $student->nisn }}"
                                            data-initial-value="{{ $student->nisn }}"
                                            required
                                        />
                                    </div>
                                    <div class="mb-3">
                                        <label
                                            for="defaultSelect"
                                            class="form-label"
                                            >Pilih Kelas</label
                                        >
                                        <select
                                            name="classId"
                                            class="form-select"
                                            data-initial-value="{{ $student->classId }}"
                                            required
                                        >
                                            @foreach ($classes as $class) @php
                                            $selected = $student->classId ==
                                            $class->id ? 'selected' : '';
                                            @endphp
                                            <option
                                                value="{{ $class->id }}"
                                                {{
                                                $selected
                                                }}
                                            >
                                                {{ $class->className }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="d-flex gap-2 mt-2 mb-3">
                                        <button
                                            type="submit"
                                            class="btn btn-primary mt-2"
                                        >
                                            Simpan
                                        </button>
                                        <button
                                            type="reset"
                                            class="btn btn-label-primary mt-2"
                                            data-bs-dismiss="offcanvas"
                                        >
                                            Batal
                                        </button>
                                    </div>
                                </form>
                                @if (session('message'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('message') }}
                                </div>
                                @endif @if($errors->any())
                                <div
                                    id="alert-message"
                                    class="alert alert-danger"
                                >
                                    {{ $errors->first() }}
                                </div>
                                @endif
                            </div>
                        </div>
                        <form
                            action="{{ route('students.destroy', $student->id) }}"
                            method="POST"
                            class="d-inline-block"
                        >
                            @csrf @method('DELETE')
                            <button
                                type="button"
                                class="btn btn-sm btn-icon btn-delete"
                                data-id="{{ $student->id }}"
                                data-name="{{ $student->name }}"
                            >
                                <i class="bx bx-trash me-1"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center">Tidak ada data siswa.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
{{-- Modal Konfirmasi Hapus --}}
<div
    class="modal fade"
    id="deleteConfirmModal"
    tabindex="-1"
    aria-hidden="true"
>
    <div class="modal-dialog">
        <form id="deleteForm" method="POST">
            @csrf @method('DELETE')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Hapus</h5>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                    ></button>
                </div>
                <div class="modal-body">
                    <p>
                        Yakin ingin menghapus siswa
                        <strong id="studentName"></strong>?
                    </p>
                </div>
                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal"
                    >
                        Batal
                    </button>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection @section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const deleteButtons = document.querySelectorAll(".btn-delete");
        const deleteForm = document.getElementById("deleteForm");
        const studentNameEl = document.getElementById("studentName");
        const deleteModalEl = document.getElementById("deleteConfirmModal");
        const deleteModal = new bootstrap.Modal(deleteModalEl);

        deleteButtons.forEach((button) => {
            button.addEventListener("click", function () {
                const studentId = this.getAttribute("data-id");
                const studentName = this.getAttribute("data-name");

                studentNameEl.textContent = studentName;
                deleteForm.action = `/students/${studentId}`;
                deleteModal.show();
            });
        });

        document.querySelectorAll(".offcanvas .alert").forEach((alert) => {
            setTimeout(() => {
                alert.remove();
            }, 2000);
        });

        document.querySelectorAll(".offcanvas").forEach((offcanvas) => {
            offcanvas.addEventListener("hidden.bs.offcanvas", () => {
                offcanvas
                    .querySelectorAll(".alert")
                    .forEach((alert) => alert.remove());
            });
        });

        @if (session()->has('success') || session()->has('message') || session()->has('delete'))
        Swal.fire({
            icon: 'success',
            title: `<span style="color:#A5DC86">Berhasil!</span>`,
            html: `<span style="color:#A5DC86">{{ session('success') ?? session('message') ?? session('delete') }}</span>`,
            timer: 2000,
            showConfirmButton: false,
            background: 'transparent'
        });
        @endif
    });
</script>
@endsection
