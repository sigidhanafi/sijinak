@extends('layouts.app') {{-- Ganti sesuai layout utama kamu --}}

@section('title', 'Form Izin Siswa')

@section('content')
<div class="container mt-4">
  <h4>Formulir Izin Siswa Keluar Sekolah</h4>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <form action="{{ route('activities.izin-siswa.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="mb-3">
      <label for="alasan" class="form-label">Alasan Izin</label>
      <textarea name="alasan" class="form-control" id="alasan" required></textarea>
    </div>

    <div class="mb-3">
      <label for="waktu_keluar" class="form-label">Waktu Keluar</label>
      <input type="datetime-local" name="waktu_keluar" class="form-control" id="waktu_keluar" required>
    </div>

    <div class="mb-3">
      <label for="dokumen" class="form-label">Dokumen Pendukung (PDF/JPG/PNG)</label>
      <input type="file" name="dokumen" class="form-control" id="dokumen" required>
    </div>

    <button type="submit" class="btn btn-primary">Kirim Permohonan</button>
  </form>
</div>
@endsection
