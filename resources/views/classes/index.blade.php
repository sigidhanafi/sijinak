@extends('layouts.app') @section('title', 'Classes Page | Sijinak')
@section('content')
<h3>Daftar Kelas</h3>
<div class="row mb-3">
    <div class="col-md-6">
        <form
            class="d-flex flex-column flex-sm-row gap-2"
            method="GET"
            action="{{ route('classes.index') }}"
        >
            <input
                id="search"
                class="form-control"
                type="text"
                name="search"
                placeholder="Cari Kelas"
                value="{{ request('search') }}"
            />
        </form>
    </div>
</div>
{{-- Tambah Kelas --}}
<button
    class="btn btn-primary mb-3"
    type="button"
    data-bs-toggle="offcanvas"
    data-bs-target="#offcanvasTambahKelas"
    aria-controls="offcanvasTambahKelas"
>
    Tambah Kelas
</button>
@php $showCreateOffcanvas = ($errors->any() && session('error_source') ===
'create'); @endphp
<div
    class="offcanvas offcanvas-end {{ $showCreateOffcanvas ? 'show' : '' }}"
    tabindex="-1"
    id="offcanvasTambahKelas"
    aria-labelledby="offcanvasTambahKelasLabel"
    style="{{ $showCreateOffcanvas ? 'visibility: visible;' : '' }}"
>
    <div class="offcanvas-header">
        <h3 class="offcanvas-title" id="offcanvasTambahKelasLabel">
            Tambah Kelas
        </h3>
        <button
            type="button"
            class="btn-close"
            data-bs-dismiss="offcanvas"
            aria-label="Close"
        ></button>
    </div>
    <div class="offcanvas-body">
        <form action="{{ route('classes.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="className" class="form-label">Kelas</label>
                <input
                    type="text"
                    name="className"
                    class="form-control"
                    placeholder="Nama Kelas"
                    value="{{ $showCreateOffcanvas ? old('className') : '' }}"
                    required
                />
                <div id="nameHelp" class="form-text">
                    Masukkan nama kelas.
                </div>
            </div>
            <div class="mb-3">
                <label for="teacherName" class="form-label">Nama Wali Kelas</label>
                <input
                    type="text"
                    name="teacherName"
                    class="form-control"
                    placeholder="Nama Lengkap"
                    value="{{ $showCreateOffcanvas ? old('teacherName') : '' }}"
                />
                <div id="nameHelp" class="form-text">
                    Masukkan nama wali kelas.
                </div>
            </div>
            <div class="d-flex gap-2 mt-2 mb-3">
                <button type="submit" class="btn btn-primary">Simpan</button>
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
{{-- Tabel Kelas --}}
<div id="class-table">
    @include('classes.partials.class-table', ['classes' => $classes])
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
                        Yakin ingin menghapus kelas
                        <strong id="modalClassName"></strong>?
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
        const classNameEl = document.getElementById("modalClassName");
        const deleteModalEl = document.getElementById("deleteConfirmModal");
        const deleteModal = new bootstrap.Modal(deleteModalEl);

        deleteButtons.forEach((button) => {
            button.addEventListener("click", function () {
                const classId = this.getAttribute("data-id");
                const className = this.getAttribute("data-name");

                classNameEl.textContent = className;
                deleteForm.action = `/classes/${classId}`;
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
        $('#search').on('keyup', function () {
            let query = $(this).val();

            $.ajax({
                url: "{{ route('classes.index') }}",
                type: "GET",
                data: {
                    search: query
                },
                success: function (data) {
                    $('#class-table').html($(data).find('#class-table').html());
                    bindDeleteButtons(); // Re-bind event listeners after replacing HTML
                },
                error: function () {
                    alert('Terjadi kesalahan saat mengambil data.');
                }
            });
        });
    });
</script>
@endsection

