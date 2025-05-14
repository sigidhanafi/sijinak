@extends('layouts.app') @section('title', 'Edit Kelas') @section('content')
<div class="text-end mb-3">
    <a href="{{ route('classes.index') }}" class="btn btn-outline-primary"
        >Kembali</a
    >
</div>
<h3>Ubah Kelas {{ $class->className }}</h3>
<form action="{{ route('classes.update', $class->id) }}" method="POST">
    @csrf @method('PUT')
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="className" class="form-label">Nama Kelas</label>
                <input
                    type="text"
                    class="form-control"
                    id="className"
                    name="className"
                    value="{{ old('className', $class->className) }}"
                    required
                />
            </div>

            <div class="mb-3">
                <label for="teacherId" class="form-label">NIP Wali Kelas</label>
                <input
                    type="text"
                    class="form-control"
                    id="teacherId"
                    name="teacherId"
                    value="{{ old('teacherId', $class->teacherId) }}"
                />
            </div>
        </div>
    </div>

    <button type="submit" class="btn btn-primary mt-3 mb-3">
        Simpan Perubahan
    </button>
    <a href="{{ route('classes.index') }}" class="btn btn-secondary mt-3 mb-3"
        >Batal</a
    >
</form>
@if (session('success'))
<div class="row">
    <div class="col-md-6">
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    </div>
</div>
@endif @if ($errors->any())
<div class="row">
    <div class="col-md-6">
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error) {{ $error }} @endforeach
        </div>
    </div>
</div>
@endif @endsection
