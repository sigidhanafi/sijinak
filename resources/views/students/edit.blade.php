@extends('layouts.app') @section('title', 'Edit Kelas') @section('content')
<div class="text-end mb-3">
    <a href="{{ route('students.index') }}" class="btn btn-outline-primary"
        >Kembali</a
    >
</div>
<h3>Ubah Siswa {{ $student->name }}</h3>
<form action="{{ route('students.update', $student->id) }}" method="POST">
    @csrf @method('PUT')
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="name" class="form-label">Nama</label>
                <input
                    type="text"
                    class="form-control"
                    name="name"
                    id="name"
                    value="{{ old('name', $student->name) }}"
                    required
                />
            </div>
            <div class="mb-3">
                <label for="nisn" class="form-label">NISN</label>
                <input
                    type="text"
                    class="form-control"
                    name="nisn"
                    id="nisn"
                    value="{{ old('nisn', $student->nisn) }}"
                    required
                />
            </div>
            <div class="mb-3">
                <label for="defaultSelect" class="form-label"
                    >Pilih Kelas</label
                >
                <select
                    name="classId"
                    id="defaultSelect"
                    class="form-select"
                    required
                >
                    <option value="" disabled selected>Kelas</option>
                    @foreach ($classes as $class)
                    <option value="{{ $class->id }}"
                        >{{ $class->className }}</option
                    >
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <button type="submit" class="btn btn-primary mt-3 mb-3">
        Simpan Perubahan
    </button>
    <a href="{{ route('students.index') }}" class="btn btn-secondary mt-3 mb-3"
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
