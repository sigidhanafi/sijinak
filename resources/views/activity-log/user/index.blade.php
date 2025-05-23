{{-- TO DO: Tegar + Salsa --}}

@extends('layouts.app')

@section('title', 'Activity Log | Sijinak')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h1>Activity Log</h1>
    <h6>{{ $studentName }}</h6>

    <div class="card">
        <div class="card-datatable table-responsive p-4">
            <table id="myTable" class="table table-bordered">
                <thead>
                    <tr class="align-middle">
                        <th>ID</th>
                        <th>Activity ID</th>
                        <th>Timestamp</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($activities as $activity)
                    <tr>
                        <td>{{ $activity->id }}</td>
                        <td>{{ $activity->activity_id }}</td>
                        <td>{{ $activity->created_at->format('D, d F y H:i:s') }}</td>
                        <td class="text-center align-middle">
                            <a href="{{ route('activities.show', $activity->id) }}"
                                class="btn btn-info btn-sm btn-icon" title="View Details">
                                <i class='bx bx-show'></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#myTable').DataTable({
            "searching": false,
            "info": false,
            "lengthChange": false,
            "pageLength": 10,
        });
    });
</script>
@endpush