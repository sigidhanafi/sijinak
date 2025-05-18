@extends('layouts.app')

@section('title', 'Status Izin Siswa')

@section('content')
<h2>Status Izin Siswa</h2>

@if($izinList->isEmpty())
  <p>Belum ada pengajuan izin.</p>
@else
<p class="text-muted">Berikut adalah daftar permohonan izin yang telah kamu ajukan beserta statusnya.</p>
  <table class="table">
    <thead>
      <tr>
        <th>Tanggal</th>
        <th>Alasan</th>
        <th>Status</th>
        <th>QR Code</th>
      </tr>
    </thead>
    <tbody>
      @foreach($izinList as $izin)
        <tr>
          <td>{{ $izin->created_at->format('d-m-Y') }}</td>
          <td>{{ $izin->alasan }}</td>
          <td>
            @if($izin->status == 'pending')
              <span class="badge bg-warning">Pending</span>
            @elseif($izin->status == 'approved')
              <span class="badge bg-success">Disetujui</span>
            @else
              <span class="badge bg-danger">Ditolak</span>
            @endif
          </td>
          <td>
            @if($izin->status == 'approved')
              {{-- Misal QR code disimpan di field qr_code sebagai image path --}}
              <img src="{{ asset('storage/' . $izin->qr_code) }}" alt="QR Code" width="100">
            @else
              -
            @endif
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
@endif

@endsection
