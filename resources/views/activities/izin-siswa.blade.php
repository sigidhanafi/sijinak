@extends('layouts.app')

@section('title', 'Form Izin Siswa')

@section('content')
{{-- SweetAlert2 CSS --}}
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />

<div class="container mt-4">
  <h2>Formulir Izin Siswa Keluar Sekolah</h2>

  <p class="text-muted">
    Silakan isi formulir berikut untuk mengajukan izin keluar. Permohonan akan diverifikasi oleh guru piket sebelum disetujui.
</p>

  {{-- Notifikasi berhasil (akan diganti SweetAlert) --}}

  {{-- Notifikasi gagal --}}
  @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      {{ session('error') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  {{-- Error validasi (1 baris saja) --}}
  @if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      {{ $errors->first() }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  <form action="{{ route('activities.izin-siswa.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="mb-3">
      <label for="alasan" class="form-label">Alasan Izin</label>
      <textarea name="alasan" class="form-control" id="alasan" required>{{ old('alasan') }}</textarea>
    </div>

    <div class="mb-3">
      <label for="waktu_keluar" class="form-label">Waktu Keluar</label>
      <input type="datetime-local" name="waktu_keluar" class="form-control" id="waktu_keluar" value="{{ old('waktu_keluar') }}" required>
    </div>

    <div class="mb-3">
      <label for="dokumen" class="form-label">Dokumen Pendukung (PDF, JPG, atau PNG) (Max file: 2MB)</label>
      <input type="file" name="dokumen" class="form-control" id="dokumen" required>
    </div>

    <button type="submit" class="btn btn-primary">Kirim</button>
    <button type="button" class="btn btn-secondary ms-2" onclick="window.history.back()">Batal</button>

  </form>
</div>

{{-- SweetAlert2 JS --}}
<script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        @if(session('success'))
            Swal.fire({
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                icon: 'success',
                customClass: {
                    confirmButton: 'btn btn-primary'
                },
                buttonsStyling: false
            });
        @endif
    });
</script>
@endsection
