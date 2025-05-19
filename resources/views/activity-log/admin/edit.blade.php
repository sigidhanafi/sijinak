@extends('layouts.app')

@section('title', 'Admin Activity Log | Sijinak - Edit Activity')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Aktivitas Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
     <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet"
  />
</head>
<body style="background: lightgray">

    <div class="container mt-5 mb-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm rounded">
                    <div class="card-body">
                        <a href="{{ route('activities.index') }}" class="btn btn-md btn-danger mb-3"><i class="bi bi-chevron-left"></i> BACK</a>
                        <form action="{{ route('activities.update', $activity->id) }}" method="POST" enctype="multipart/form-data">
                        
                            @csrf
                            @method('PUT')

                            <div class="form-group mb-3">
                                <label class="font-weight-bold">FILE (.jpg, .jpeg, .png, .pdf, .doc, .docx)</label>
                                <input type="file" class="form-control @error('file') is-invalid @enderror" name="file">
                            
                                @error('file')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="font-weight-bold">STUDENT ID</label>
                                <input type="number" class="form-control @error('student_id') is-invalid @enderror" name="student_id" value="{{ old('student_id', $activity->student_id) }}" placeholder="Masukkan Student ID">
                            
                                @error('student_id')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="font-weight-bold">ACTIVITY DETAILS / ID</label>
                                <textarea class="form-control @error('activity_id') is-invalid @enderror" name="activity_id" rows="5" placeholder="Masukkan Detail atau ID Aktivitas">{{ old('activity_id', $activity->activity_id) }}</textarea>
                            
                                @error('activity_id')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-md btn-primary me-3">UPDATE</button>
                            <button type="reset" class="btn btn-md btn-warning">RESET</button>

                        </form> 
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace( 'activityId' ); // Updated to target the 'activityId' textarea
    </script>
</body>
</html>
@endsection