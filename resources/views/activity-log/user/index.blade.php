{{-- TO DO: Tegar + Salsa --}}

@extends('layouts.app')

@section('title', 'Home Page | Sijinak')

@section('content')
    <h1>Activity Log</h1>


<div class="table-responsive">
  <table class="table">
    <thead>
        <tr class="align-middle p-2">
            <th>ID</th>
            <th>NISN</th>
            <th>Name</th>
            <th>Activity ID</th>
            <th>Timestamp</th>
            <th class="text-center">Action</th>
        </tr>
    </thead>

    <tbody>
  @foreach ($activities as $activity)
    <tr>
      <td class="text-center-middle">{{ $activity->id }}</td>
      <td class="text-center-middle">{{ $activity->student_id }}</td>
      <td class="text-center-middle">
        <a href="{{ route('activities.show', $activity) }}" class="link-primary">
          {{ fake()->name() }}
        </a>
      </td>
      <td class="text-center-middle">{{ $activity->activity_id }}</td>
      <td class="text-center-middle">{{ $activity->created_at->format('D, d F y H:i:s') }}</td>
      <td class="text-center align-middle">
        {{-- VIEW USER DETAILS --}}
        <a href="{{ route('activities.show', $activity->id) }}"
          class="btn btn-info btn-sm btn-icon me-1" title="Lihat">
          <i class="bx bx-show"></i>
        </a>
      </td>
    </tr>
  @endforeach
</tbody>

  </table>
</div>

@endsection