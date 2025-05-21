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
            class="d-flex flex-column flex-sm-row gap-2"
            method="GET"
            action="{{ route('classes.show', $class->id) }}"
        >
            <input
                id="search"
                class="form-control"
                type="text"
                name="search"
                placeholder="Cari Siswa"
                value="{{ request('search') }}"
            />
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
                    value="{{ $showCreateOffcanvas ? old('name') : '' }}"
                    required
                />
                <div id="nameHelp" class="form-text">
                    Masukkan nama siswa.
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
                    Masukkan email siswa.
                </div>
            </div>
            <div class="mb-3">
                <label for="nisn" class="form-label">NISN</label>
                <input
                    type="text"
                    name="nisn"
                    class="form-control"
                    placeholder="Nomor Induk Siswa Nasional"
                    value="{{ $showCreateOffcanvas ? old('nisn') : '' }}"
                    required
                />
                <div id="nameHelp" class="form-text">
                    Masukkan NISN siswa.
                </div>
            </div>
            <div class="mb-3">
                <label for="classId" class="form-label">Kelas</label>
                <select name="classId" class="form-select" required>
                    <option value="" disabled
                        {{ $showCreateOffcanvas && old('classId') ? '' : 'selected' }}>
                        Kelas
                    </option>
                    <option value="{{ $class->id }}"
                        {{ $showCreateOffcanvas && old('classId') == $class->id ? 'selected' : '' }}>
                        {{ $class->className }}
                    </option>
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
        @if($showCreateOffcanvas)
        <div id="alert-message" class="alert alert-danger">
            {{ $errors->first() }}
        </div>
        @endif
    </div>
</div>
{{-- Tabel Siswa --}}
<div id="student-table">
    @include('students.table', ['students' => $students])
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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

                // AJAX search
        $('#search').on('keyup', function () {
            let query = $(this).val();
            let paginate = $('#paginate').val() ?? 50;

            $.ajax({
                url: "{{ route('classes.show', $class->id) }}",
                type: "GET",
                data: {
                    search: query,
                    paginate: paginate
                },
                success: function (data) {
                    $('#student-table').html($(data).find('#student-table').html());
                }
            });
        });

        $('#paginate').on('change', function () {
            $('#search').trigger('keyup');
        });

        $(document).on('click', '.pagination a', function (e) {
            e.preventDefault();
            let url = $(this).attr('href');

            $.ajax({
                url: url,
                success: function (data) {
                    $('#student-table').html($(data).find('#student-table').html());
                }
            });
        });
    });
</script>
@endsection
