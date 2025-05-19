@extends('layouts.app')

@section('title', 'Status Izin Siswa')

@section('content')
<div class="container mt-4">
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
                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#qrModal{{ $izin->id }}">
                  Lihat QR
                </button>

                <!-- Modal -->
                <div class="modal fade" id="qrModal{{ $izin->id }}" tabindex="-1" aria-labelledby="qrModalLabel{{ $izin->id }}" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="qrModalLabel{{ $izin->id }}">QR Code Izin</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                      </div>
                      <div class="modal-body text-center">
                        <img src="{{ asset('storage/' . $izin->qr_code) }}" alt="QR Code" class="img-fluid" style="max-width: 300px;">
                      </div>
                    </div>
                  </div>
                </div>
              @else
                -
              @endif
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  @endif
</div>
@endsection
