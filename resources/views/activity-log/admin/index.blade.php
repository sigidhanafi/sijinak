@extends('layouts.app')

@section('title', 'Admin Activity Log | Sijinak')

@section('content')
<main class="card">
    <header class="card-header">
        <h5 class="card-title mb-0">Activity Log</h5>
    </header>

    <section class="card-datatable table-responsive">
        <div class="mx-2 mb-4 row">
            <div class="col-md-2">
                <select onchange="getActivities(this.value)" name="activity_table_length" id="activity_table_length"
                    class="form-select">
                    <option value="10" selected>10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>
            <div class="col-md-10">

            </div>
        </div>
        <table id="myTable" class="table">
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
                {{-- @foreach ($activities as $activity)
                <tr>
                    <td>{{ $activity->id }}</td>
                    <td>{{ $activity->activityId }}</td>
                    <td>{{ $activity->studentId }}</td>
                    <td>{{ $activity->created_at }}</td>
                </tr>
                @endforeach --}}
            </tbody>
        </table>
        <div class="card-footer">
            <div class="row">
                <div id='activity_table_info' class="col-md-6">
                </div>
            </div>
        </div>
    </section>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        $('#myTable').DataTable();
    });

    // const getActivities = async (length) => {
    //     // get data from api endpoint
    //     const response = await fetch(`/api/activities?length=${length}`).then((result) => {
    //         if (!result.ok) {
    //             throw new Error('Failed to fetch data, a network error occurred');
    //         }
    //         return result.json();
    //     }).catch((err) => {
    //         console.error('There was a problem getting activity data:', err);
    //     });

    //     // populate table with data
    //     const tableBody = document.querySelector('#table-body');
    //     tableBody.innerHTML = ''; 
    //     Object.entries(response.data).forEach(([key, activity]) => {
    //         const row = document.createElement('tr');
    //         row.innerHTML = `
    //             <td>${activity.id}</td>
    //             <td>
    //                 <a href="users/${activity.studentId}" class="alert-link">
    //                     ${activity.studentId}
    //                 </a>
    //             </td>
    //             <td>${activity.activityId}</td>
    //             <td>${activity.createdAt}</td>
    //             <td>
    //                 <div class="d-inline-block text-nowrap">
    //                     <button tabIndex="-1" class="btn btn-sm btn-icon delete-record">
    //                         <i class="bx bx-trash"></i>
    //                     </button>
    //                     <button tabIndex="-1" class="btn btn-sm btn-icon view-record">
    //                         <a href="users/${activity.studentId}" class="alert-link">
    //                             <i class="bx bx-user"></i>
    //                         </a>
    //                     </button>
    //                 </div>
    //             </td>
    //         `;
    //         tableBody.appendChild(row);
    //     });

    //     // update table footer info
    //     const tableInfo = document.querySelector('#activity_table_info');
    //     tableInfo.innerHTML = `
    //         <span>Showing ${response.meta.to} of ${response.meta.total} entries</span>
    //     `;
    // }

    // // call function
    // getActivities(10);
</script>

@endsection