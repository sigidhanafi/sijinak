@extends('layouts.app')

@section('title', 'View Activity | Sijinak')

@section('content')
<main class="container-xxl">
    <section class="row mb-4">
        <a href="{{ route('activities.index') }}" class="btn btn-primary col-2 d-inline">
            <i class="bx bx-arrow-back me-2"></i> Back
        </a>
    </section>
    {{-- Row 1 --}}
    <section class="row gap-4">
        <div class="col-12 col-sm-3 card">
            <div class="card-body text-center">
                <div class="avatar mx-auto mb-4">
                    <span class="avatar-initial rounded-circle bg-label-success">
                        <i class="bx bx-user"></i>
                    </span>
                </div>
                <h5 class="">
                    <a href="#
                    " class="link-primary">
                        Nama User</a>
                </h5>
            </div>
        </div>
        <div class="col card">
            <header class="card-header d-flex justify-content-between">
                <h5 class="card-title">{{ $activity->activity_id }}</h5>
                <p>{{ $activity->created_at }}</p>
            </header>
        </div>
    </section>
    {{-- / Row 1 --}}
</main>
@endsection