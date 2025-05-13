@extends('layouts.app') @section('title', 'Add a Class | Sijinak')
@section('content')
<div class="text-end mb-3">
    <a href="{{ route('classes.index') }}" class="btn btn-outline-primary"
        >Kembali</a
    >
</div>
<h3>Tambah Kelas</h3>
<form action="{{ route('classes.store') }}" method="POST">
    @csrf
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="className" class="form-label">Kelas</label>
                <input
                    type="text"
                    name="className"
                    id="className"
                    required
                    class="form-control"
                    placeholder="Kelas"
                    required
                />
                <div id="nameHelp" class="form-text">
                    Masukkan nama kelas.
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

