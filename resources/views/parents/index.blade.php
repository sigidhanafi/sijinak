@extends('layouts.app') @section('title', 'Parent Page | Sijinak')
@section('content')
<h3>Daftar Wali Siswa</h3>
<div class="row mb-3">
    <div class="col-md-6">
        <form
            class="d-flex flex-column flex-sm-row gap-2"
            method="GET"
            action="{{ route('parents.index') }}"
        >
            <input
                class="form-control"
                type="text"
                name="search"
                placeholder="Cari Wali Siswa"
                value="{{ request('search') }}"
            />
            <button class="btn btn-outline-primary" type="submit">
                Search
            </button>
        </form>
    </div>
</div>
{{-- Tambah Wali --}}
<button
    class="btn btn-primary mb-3"
    type="button"
    data-bs-toggle="offcanvas"
    data-bs-target="#offcanvasTambahWali"
    aria-controls="offcanvasTambahWali"
>
    Tambah Wali Siswa
</button>
@php $showCreateOffcanvas = ($errors->any() && session('error_source') ===
'create'); @endphp
<div
    class="offcanvas offcanvas-end {{ $showCreateOffcanvas ? 'show' : '' }}"
    tabindex="-1"
    id="offcanvasTambahWali"
    aria-labelledby="offcanvasTambahWaliLabel"
    style="{{ $showCreateOffcanvas ? 'visibility: visible;' : '' }}"
>
    <div class="offcanvas-header">
        <h3 class="offcanvas-title" id="offcanvasTambahWaliLabel">
            Tambah Wali Siswa
        </h3>
        <button
            type="button"
            class="btn-close"
            data-bs-dismiss="offcanvas"
            aria-label="Close"
        ></button>
    </div>
    <div class="offcanvas-body">
        <form action="{{ route('parents.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="parent_name" class="form-label"
                    >Nama Wali Siswa</label
                >
                <input
                    type="text"
                    name="parent_name"
                    id="parent_name"
                    class="form-control"
                    placeholder="Nama Lengkap"
                    value="{{ $showCreateOffcanvas ? old('parent_name') : '' }}"
                    required
                />
                <div id="nameHelp" class="form-text">
                    Masukkan nama wali siswa.
                </div>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input
                    type="text"
                    name="email"
                    class="form-control"
                    placeholder="Email"
                    value="{{ $showCreateOffcanvas ? old('email') : '' }}"
                    required
                />
                <div id="nameHelp" class="form-text">
                    Masukkan email wali siswa.
                </div>
            </div>
            <div class="mb-3">
                <label for="student_name" class="form-label">Nama Siswa</label>
                <input
                    type="text"
                    name="student_name"
                    id="student_name"
                    class="form-control"
                    placeholder="Contoh: John Doe, John Doe, John Doe"
                    value="{{ $showCreateOffcanvas ? old('student_name') : '' }}"
                    required
                />
                <div id="nameHelp" class="form-text">
                    Masukkan nama siswa, pisahkan dengan koma jika lebih dari satu.
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
        @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error) {{ $error }} @endforeach
        </div>
        @endif
    </div>
</div>
{{-- Tabel Wali --}}
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

    @unless ($parents->onFirstPage())
    <a
        href="{{ $parents->previousPageUrl() }}&paginate={{ request('paginate', 10) }}"
        class="btn btn-primary"
    >
        Previous
    </a>
    @endunless @if ($parents->hasMorePages())
    <a
        href="{{ $parents->nextPageUrl() }}&paginate={{ request('paginate', 10) }}"
        class="btn btn-primary"
    >
        Next
    </a>
    @endif
</div>

<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Nama Siswa</th>
                <th>Ubah Data</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($parents as $parent)
            <tr>
                <td>
                    <a
                        href="{{ route('parents.show', $parent->id) }}"
                        class="fw-medium"
                        >{{ $parent->name }}</a
                    >
                </td>
                <td>
                    @forelse ($parent->students as $student)
                    <span class="fw-medium">{{ $student->name }}</span><br />
                    @empty
                    <span>-</span>
                    @endforelse
                </td>
                <td class="" style="">
                    <div class="d-inline-block text-nowrap">
                        <button
                            class="btn btn-sm btn-icon btn-edit"
                            type="button"
                            data-bs-toggle="offcanvas"
                            data-bs-target="#offcanvasUbahWali-{{ $parent->id }}"
                            aria-controls="offcanvasUbahWali-{{ $parent->id }}"
                        >
                            <i class="bx bx-edit"></i>
                        </button>

                        @php $showEditOffcanvas = ($errors->any() &&
                        session('error_source') === 'update' &&
                        session('edited_id') == $parent->id); @endphp

                        <div
                            class="offcanvas offcanvas-end {{ $showEditOffcanvas ? 'show' : '' }}"
                            id="offcanvasUbahWali-{{ $parent->id }}"
                            tabindex="-1"
                            aria-labelledby="offcanvasUbahWaliLabel-{{ $parent->id }}"
                            style="{{ $showEditOffcanvas ? 'visibility: visible;' : '' }}"
                        >
                            <div class="offcanvas-header">
                                <h3
                                    class="offcanvas-title"
                                    id="offcanvasUbahLabel"
                                >
                                    Ubah Wali Siswa
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
                                    action="{{ route('parents.update', $parent->id) }}"
                                    method="POST"
                                >
                                    @csrf @method('PUT')
                                    <div class="mb-3">
                                        <label for="name" class="form-label"
                                            >Nama Wali Siswa</label
                                        >
                                        <input
                                            type="text"
                                            class="form-control"
                                            name="parent_name"
                                            id="parent_name"
                                            value="{{ $showEditOffcanvas ? old('parent_name') : $parent->name }}"
                                            data-initial-value="{{ $parent->name }}"
                                            required
                                        />
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label"
                                            >Email</label
                                        >
                                        <input
                                            type="text"
                                            class="form-control"
                                            name="email"
                                            id="email"
                                            value="{{ $showEditOffcanvas ? old('email') : $parent->user->email }}"
                                            data-initial-value="{{ $parent->user->email }}"
                                            required
                                        />
                                    </div>
                                    <div class="mb-3">
                                        <label
                                            for="student_name"
                                            class="form-label"
                                            >Nama Siswa</label
                                        >
                                        <input
                                            type="text"
                                            class="form-control"
                                            name="student_name"
                                            id="student_name"
                                            value="{{ $showEditOffcanvas ? old('student_name') : $parent->students->pluck('name')->implode(', ') }}"
                                            data-initial-value="{{ $parent->students->first()->name ?? '' }}"
                                            required
                                        />
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
                                @if($errors->any())
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
                            action="{{ route('parents.destroy', $parent->id) }}"
                            method="POST"
                            class="d-inline-block"
                        >
                            @csrf @method('DELETE')
                            <button
                                type="button"
                                class="btn btn-sm btn-icon btn-delete"
                                data-id="{{ $parent->id }}"
                                data-name="{{ $parent->name }}"
                            >
                                <i class="bx bx-trash me-1"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center">
                    Tidak ada data wali siswa.
                </td>
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
            <input type="hidden" name="redirect_to" id="redirectInput" />
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
                        <strong id="parentName"></strong>?
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
        const parentNameEl = document.getElementById("parentName");
        const deleteModalEl = document.getElementById("deleteConfirmModal");
        const deleteModal = new bootstrap.Modal(deleteModalEl);

        deleteButtons.forEach((button) => {
            button.addEventListener("click", function () {
                const parentId = this.getAttribute("data-id");
                const parentName = this.getAttribute("data-name");

                parentNameEl.textContent = parentName;
                deleteForm.action = `/parents/${parentId}`;
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
