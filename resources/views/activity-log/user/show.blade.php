@extends('layouts.app')

@section('title', 'View Activity | Sijinak')

@section('content')
<main class="container-xxl">
    {{-- Row 1 --}}
    <section class="row mb-4">
        <a href="{{ route('activities.index') }}" class="btn btn-primary  col-6 col-sm-2">
            <i class="bx bx-arrow-back me-2"></i> Back
        </a>
    </section>
    {{-- / Row 1 --}}

    {{-- Row 2 --}}
    <section class="row gap-4">
        {{-- <div class="col-12 col-sm-3 card">
            <div class="card-body text-center">
                <div class="avatar mx-auto mb-4">
                    <span class="avatar-initial rounded-circle bg-label-success">
                        <i class="bx bx-user"></i>
                    </span>
                </div>
                <h5 class="">
                    <a href="#" class="link-primary">{{ $activity->student->name }}</a>
                </h5>
            </div>
        </div> --}}
        <div class="col card">
            {{-- Header --}}
            <header class="card-header">
                <h4 class="card-title mb-2">Activity Details</h4>
                <p class="card-text text-secondary">Detailed information about activity #{{ $activity->id }}</p>
            </header>
            {{-- / Header --}}

            {{-- Content --}}
            <section class="card-body">

                {{-- Row 1 --}}
                <div class="row row-cols-1 row-cols-sm-2 g-3 g-sm-4">

                    {{-- Activity --}}
                    <div class="col">
                        <p class="mb-1 text-secondary">Activity Type</p>
                        <div class="d-flex gap-2 align-items-center">
                            <i class="bx bx-file"></i>
                            <p class="mb-0">TO DO</p>
                        </div>
                    </div>
                    {{-- / Activity --}}

                    {{-- Timestamp --}}
                    <div class="col">
                        <p class="mb-1 text-secondary">Timestamp</p>
                        <div class="d-flex gap-2 align-items-center">
                            <i class="bx bx-time"></i>
                            <p class="mb-0">{{ $activity->created_at->format('d/m/Y') }} at {{
                                $activity->created_at->format('H:i:s') }}</p>
                        </div>
                    </div>
                    {{-- / Timestamp --}}

                    {{-- User --}}
                    <div class="col">
                        <p class="mb-1 text-secondary">Student</p>
                        <div class="d-flex gap-2 align-items-center">
                            <i class="bx bx-user"></i>
                            <p class="mb-0">
                                <a href="#" class="link-primary">{{ $activity->student->name }}</a>
                            </p>
                        </div>
                    </div>
                    {{-- / User --}}

                    {{-- Description --}}
                    <div class="col-12">
                        <p class="mb-1 text-secondary">Description</p>
                        <div class="d-flex gap-2 align-items-center">
                            <p class="mb-0">
                                {{ fake()->sentence(10) }}
                            </p>
                        </div>
                    </div>
                    {{-- / Description --}}

                </div>
                {{-- / Row 1 --}}

            </section>
            {{-- / Content --}}

        </div>
    </section>
    {{-- / Row 2 --}}
</main>
@endsection