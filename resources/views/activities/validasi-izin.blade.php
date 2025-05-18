@extends('layouts.app')

@section('title', 'Validasi Izin Siswa')

@section('content')
<div class="container mt-4">
    <h2>Daftar Izin Keluar Siswa</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($izinList->isEmpty())
        <p>Tidak ada izin siswa yang menunggu validasi.</p>
    @else
        <p class="text-muted">
            Berikut adalah daftar permohonan izin yang diajukan oleh siswa dan menunggu validasi oleh guru piket.
            Silakan tinjau dan validasi izin sesuai kebijakan sekolah.
        </p>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama Siswa</th>
                    <th>Alasan</th>
                    <th>Waktu Keluar</th>
                    <th>Dokumen</th>
                    <th>Status</th>
                    <th>QR Code</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($izinList as $izin)
                    <tr>
                        <td>{{ $izin->user->name ?? 'N/A' }}</td>
                        <td>{{ $izin->alasan }}</td>
                        <td>{{ \Carbon\Carbon::parse($izin->waktu_keluar)->format('d-m-Y H:i') }}</td>
                        <td>
                            @if($izin->dokumen)
                            <a href="{{ asset('storage/' . $izin->dokumen) }}" target="_blank">Lihat Dokumen</a>
                            @else
                                Tidak ada
                            @endif
                        </td>
                        <td>
                            @if($izin->status === 'pending')
                                <span class="badge bg-warning text-white">Pending</span>
                            @elseif($izin->status === 'approved')
                                <span class="badge bg-success">Disetujui</span>
                            @elseif($izin->status === 'rejected')
                                <span class="badge bg-danger">Ditolak</span>
                            @endif
                        </td>
                        <td>
                            @if($izin->status === 'approved' && $izin->qr_code)
                                <img src="data:image/png;base64, {!! $izin->qr_code !!}" alt="QR Code" width="100">
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            @if($izin->status === 'pending')
                                <form action="{{ route('permission.approve', $izin->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm">Setujui</button>
                                </form>

                                <form action="{{ route('permission.reject', $izin->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm">Tolak</button>
                                </form>
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
