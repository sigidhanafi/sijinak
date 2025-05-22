@extends('layouts.app') @section('title', 'Teachers Page | Sijinak')
@section('content')
<h3>Daftar Guru</h3>
<div class="row mb-3">
    <div class="col-md-6">
        <form
            class="d-flex flex-column flex-sm-row gap-2"
            method="GET"
            action="{{ route('teachers.index') }}"
        >
            <input
                id="search"
                class="form-control"
                type="text"
                name="search"
                placeholder="Cari Guru"
                value="{{ request('search') }}"
            />
        </form>
    </div>
</div>
{{-- Tambah Guru --}}
<button
    class="btn btn-primary mb-3"
    type="button"
    data-bs-toggle="offcanvas"
    data-bs-target="#offcanvasTambahGuru"
    aria-controls="offcanvasTambahGuru"
>
    Tambah Guru
</button>
@php $showCreateOffcanvas = ($errors->any() && session('error_source') ===
'create'); @endphp
<div
    class="offcanvas offcanvas-end {{ $showCreateOffcanvas ? 'show' : '' }}"
    tabindex="-1"
    id="offcanvasTambahGuru"
    aria-labelledby="offcanvasTambahGuruLabel"
    style="{{ $showCreateOffcanvas ? 'visibility: visible;' : '' }}"
>
    <div class="offcanvas-header">
        <h3 class="offcanvas-title" id="offcanvasTambahGuruLabel">
            Tambah Guru
        </h3>
        <button
            type="button"
            class="btn-close"
            data-bs-dismiss="offcanvas"
            aria-label="Close"
        ></button>
    </div>
    <div class="offcanvas-body">
        <form action="{{ route('teachers.store') }}" method="POST">
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
                    Masukkan nama guru.
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
                    Masukkan email guru.
                </div>
            </div>
            <div class="mb-3">
                <label for="nip" class="form-label">NIP</label>
                <input
                    type="text"
                    name="nip"
                    class="form-control"
                    placeholder="Nomor Induk Siswa Nasional"
                    value="{{ $showCreateOffcanvas ? old('nip') : '' }}"
                    required
                />
                <div id="nameHelp" class="form-text">
                    Masukkan NIP siswa.
                </div>
            </div>
            <div class="mb-3">
                <label for="defaultSelect" class="form-label">Status Guru</label>
                <select name="is_on_duty" class="form-select" required>
                    <option value="" disabled
                        {{ $showCreateOffcanvas && old('is_on_duty') !== null ? '' : 'selected' }}>
                        Status Guru
                    </option>
                    <option value="0" {{ $showCreateOffcanvas && old('is_on_duty') == '0' ? 'selected' : '' }}>
                        Guru
                    </option>
                    <option value="1" {{ $showCreateOffcanvas && old('is_on_duty') == '1' ? 'selected' : '' }}>
                        Guru Piket
                    </option>
                </select>
                <div id="statusHelp" class="form-text">
                    Pilih status guru.
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
{{-- Pagination --}}
@php
    $queryExceptPaginate = request()->except('paginate');
    $queryExceptFilter = request()->except('filter');
@endphp
<div class="mb-3 d-flex gap-2 align-items-center">
    <span>Show:</span>
    <form method="GET" action="{{ url()->current() }}">
        @foreach($queryExceptPaginate as $key => $value)
            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
        @endforeach
        <select name="paginate" onchange="this.form.submit()" class="form-select">
            @foreach ([10, 50, 100, 500] as $size)
                @php $selected = request('paginate', 10) == $size ? 'selected' : ''; @endphp
                <option value="{{ $size }}" {{ $selected }}>{{ $size }}</option>
            @endforeach
        </select>
    </form>
    @unless ($teachers->onFirstPage())
    <a
        href="{{ $teachers->previousPageUrl() }}&paginate={{ request('paginate', 10) }}"
        class="btn btn-primary"
    >
        Previous
    </a>
    @endunless @if ($teachers->hasMorePages())
    <a
        href="{{ $teachers->nextPageUrl() }}&paginate={{ request('paginate', 10) }}"
        class="btn btn-primary"
    >
        Next
    </a>
    @endif
</div>
{{-- Filter Guru --}}
<div class="mb-3">
    <form method="GET" action="{{ url()->current() }}">
        @foreach($queryExceptFilter as $key => $value)
            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
        @endforeach
        <select name="filter" onchange="this.form.submit()" class="form-select w-auto d-inline-block">
            <option value="" {{ request('filter') === null ? 'selected' : '' }}>Semua Guru</option>
            <option value="wali" {{ request('filter') === 'wali' ? 'selected' : '' }}>Wali Kelas</option>
            <option value="duty" {{ request('filter') === 'duty' ? 'selected' : '' }}>Guru Piket</option>
        </select>
    </form>
</div>
{{-- Tabel Guru --}}
<div id="teacher-table">
    @include('teachers.table', ['teachers' => $teachers])
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
                        <strong id="modalTeacherName"></strong>?
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
    function bindDeleteButtons() {
        const deleteButtons = document.querySelectorAll(".btn-delete");
        const deleteForm = document.getElementById("deleteForm");
        const teacherNameEl = document.getElementById("modalTeacherName");
        const deleteModalEl = document.getElementById("deleteConfirmModal");
        const deleteModal = new bootstrap.Modal(deleteModalEl);

        deleteButtons.forEach((button) => {
            button.addEventListener("click", function () {
                const teacherId = this.getAttribute("data-id");
                const teacherName = this.getAttribute("data-name");

                teacherNameEl.textContent = teacherName;
                deleteForm.action = `/teachers/${teacherId}`;
                deleteModal.show();
            });
        });
    }

    document.addEventListener("DOMContentLoaded", function () {
        bindDeleteButtons();

        document.querySelectorAll(".offcanvas").forEach((offcanvas) => {
            offcanvas.addEventListener("hidden.bs.offcanvas", () => {
                offcanvas.querySelectorAll(".alert").forEach((alert) => alert.remove());
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
        $("#search").on("keyup", function () {
            let query = $(this).val();
            let filter = $("select[name=filter]").val();

            $.ajax({
                url: "{{ route('teachers.index') }}",
                type: "GET",
                data: {
                    search: query,
                    filter: filter,
                },
                success: function (data) {
                    $("#teacher-table").html(
                        $(data).find("#teacher-table").html()
                    );
                    bindDeleteButtons();
                },
                error: function () {
                    alert("Terjadi kesalahan saat mengambil data.");
                },
            });
        });
    });
</script>
@endsection

