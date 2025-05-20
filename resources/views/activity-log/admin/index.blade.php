@extends('layouts.app')

@section('title', 'Admin Activity Log | Sijinak')

@section('content')
<style>
    select,
    select:active,
    select:focus {
        border: 1px solid gray !important;
        margin-right: 8px !important;
    }

    input,
    input:active,
    input:focus {
        border: 1px solid gray !important;
        margin-left: 8px !important;
    }
</style>

<main class="card">
    <header class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Activity Log</h5>

        {{-- Offacnvas Button to Create Activity --}}
        <button class="btn btn-primary d-flex align-items-center" type="button" data-bs-toggle="offcanvas"
            data-bs-target="#offcanvasEnd" aria-controls="offcanvasEnd">
            <i class='bx bx-plus me-2'></i>
            Create Activity</button>
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasEnd" aria-labelledby="offcanvasEndLabel">
            {{-- Header --}}
            <div class="offcanvas-header">
                <h5 id="offcanvasEndLabel" class="offcanvas-title">Create Activity</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>

            {{-- Content --}}
            <div class="offcanvas-body mb-auto mx-0 flex-grow-0">
                <form action="{{ route('activities.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="mb-3">
                        <label for="studentId" class="form-label">Student ID</label>
                        <input type="number" class="form-control" id="studentId" name="studentId" required>
                    </div>
                    <div class="mb-3">
                        <label for="activityId" class="form-label">Activity ID</label>
                        <input type="number" class="form-control" id="activityId" name="activityId" required>
                    </div>
                    <button type="submit" class="btn btn-primary ms-2">Create Activity</button>
                </form>
            </div>
        </div>
    </header>

    <section class="card-datatable table-responsive p-4 pt-0">
        <table id="myTable" class="table table-bordered datatables-basic">
            <thead>
                <tr class="p-2">
                    <th>ID</th>
                    <th>NISN</th>
                    <th>Name</th>
                    <th>Activity</th>
                    <th>Timestamp</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody id="table-body">
                @foreach ($activities as $activity)
                <tr>
                    <td class="text-center-middle">{{ $activity->id }}</td>
                    <td class="text-center-middle">{{ $activity->student_id }}</td>
                    <td class="text-center-middle">{{ fake()->name() }}</td>
                    <td class="text-center-middle">{{ $activity->activity_id }}</td>
                    <td class="text-center-middle">{{ $activity->created_at }}</td>
                    <td class="text-center align-middle">
                        <div class="d-flex justify-content-center align-items-center gap-1">
                            {{-- DELETE --}}
                            <form action="{{ route('activities.destroy', $activity->id) }}" method="POST"
                                onsubmit="return confirm('Yakin ingin menghapus activity ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm btn-icon me-1" title="Hapus">
                                    <i class='bx bx-trash'></i>
                                </button>
                            </form>
                            {{-- VIEW USER DETAILS --}}
                            <button class="btn btn-info btn-sm btn-icon me-1" title="Lihat">
                                <i class="bx bx-show"></i>
                            </button>
                            {{-- EDIT --}}
                            <button class="btn btn-primary btn-sm btn-icon" type="button" data-bs-toggle="offcanvas"
                                data-bs-target="#offcanvasEndEdit" aria-controls="offcanvasEndEdit">
                                <i class='bx bx-pencil'></i>
                            </button>
                            <div class="offcanvas offcanvas-end text-start" tabindex="-1" id="offcanvasEndEdit"
                                aria-labelledby="offcanvasEndLabel">
                                <div class="offcanvas-header">
                                    <h5 id="offcanvasEndLabel" class="offcanvas-title">Edit Activity {{ $activity->id
                                        }}</h5>
                                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                        aria-label="Close"></button>
                                </div>
                                {{-- Content --}}
                                <div class="offcanvas-body mb-auto mx-0 flex-grow-0">
                                    <form action="{{ route('activities.update', $activity) }}" method="POST"
                                        enctype="multipart/form-data">

                                        @csrf
                                        @method('PUT')

                                        <div class="mb-3">
                                            <label for="studentId" class="form-label">Student ID</label>
                                            <input type="number" class="form-control" id="studentId" name="studentId"
                                                required value="{{ $activity->student_id }}"
                                                placeholder="{{ $activity->student_id }}"> 
                                        </div>
                                        <div class="mb-3">
                                            <label for="activityId" class="form-label">Activity ID</label>
                                            <input type="number" class="form-control" id="activityId" name="activityId"
                                                required value="{{ $activity->activity_id }}"
                                                placeholder="{{ $activity->activity_id }}">
                                        </div>
                                        <button type="submit" class="btn btn-primary ms-2">Update</button>
                                    </form>
                                </div>
                            </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </section>
</main>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // DataTable
    $(function() {
        $('#myTable').DataTable({
            responsive: true,
            // Default order
            order: [[0, 'desc']],
            columnDefs: [
                // Disable sorting on the first column
                { orderable: false, targets: [1, 2, 3, 5] },
                // Disable searching on specific columns
                { searchable: false, targets: [0, 3, 4, 5] }
            ]
        });
    });

    // Message with sweetalert 
    if (session('success'))
            Swal.fire({
                icon: "success",
                title: "BERHASIL",
                text: "{{ session('success') }}", 
                showConfirmButton: false,
                timer: 2000
            });
        else if (session('error'))
            Swal.fire({
                icon: "error",
                title: "GAGAL!",
                text: "{{ session('error') }}", 
                showConfirmButton: false,
                timer: 2000
            });
</script>

@endsection