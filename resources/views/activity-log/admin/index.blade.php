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
    <header class="card-header">
        <h5 class="card-title mb-0">Activity Log</h5>
    </header>

    <section class="card-datatable table-responsive p-4 pt-0">
        <table id="myTable" class="table table-bordered datatables-basic">
            <thead>
                <tr class="p-2">
                    <th>ID</th>
                    <th>User</th>
                    <th>Activity</th>
                    <th>Timestamp</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="table-body">
                @foreach ($activities as $activity)
                <tr>
                    <td>{{ $activity->id }}</td>
                    <td>{{ $activity->activity_id }}</td>
                    <td>{{ $activity->student_id }}</td>
                    <td>{{ $activity->created_at }}</td>
                    <td>
                        <div class="d-inline-flex">
                            <form action="{{ route('activities.destroy', $activity->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus activity ini?');" class="me-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-icon">
                                    <i class="bx bx-trash text-danger"></i>
                                </button>
                            </form>
                            <button class="btn btn-sm btn-icon">
                                <i class="bx bx-show"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </section>
</main>

<script>
    $(function() {
        $('#myTable').DataTable({
            responsive: true,

            // Default order
            order: [[0, 'desc']]
        });
    });
</script>

@endsection