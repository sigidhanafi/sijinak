@extends('layouts.app') @section('title', 'Add a Student | Sijinak')
@section('content')
<div class="text-end mb-3">
    <a href="{{ route('students.index') }}" class="btn btn-outline-primary"
        >Kembali</a
    >
</div>
<h3>Tambah Siswa</h3>
<form action="{{ route('students.store') }}" method="POST">
    @csrf
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="name" class="form-label">Nama Siswa</label>
                <input
                    type="text"
                    name="name"
                    id="name"
                    required
                    class="form-control"
                    placeholder="Nama Lengkap"
                    required
                />
                <div id="nameHelp" class="form-text">
                    Masukkan nama siswa.
                </div>
            </div>
            <div class="mb-3">
                <label for="nisn" class="form-label"
                    >Nomor Induk Siswa Nasional</label
                >
                <input
                    type="text"
                    name="nisn"
                    id="nisn"
                    required
                    class="form-control"
                    placeholder="Nomor Induk Siswa Nasional"
                    required
                />
                <div id="nameHelp" class="form-text">
                    Masukkan Nomor Induk Siswa Nasional siswa.
                </div>
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
                    <option value="" disabled {{ old('classId', $student->classId ?? '') == '' ? 'selected' : '' }}>Kelas</option>
                    @foreach ($classes as $class)
                        <option value="{{ $class->id }}" {{ old('classId', $student->classId ?? '') == $class->id ? 'selected' : '' }}>
                            {{ $class->className }}
                        </option>
                    @endforeach
                </select>
                <div id="nameHelp" class="form-text">
                    Pilih kelas siswa.
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-12 mb-3">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
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
