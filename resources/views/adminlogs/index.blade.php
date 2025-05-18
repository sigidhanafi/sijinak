@extends('layouts.app')

@section('title', 'Admin Log | Sijinak')

@section('content')
    <h1>Administrator Activity Log</h1>
    <div class="card">
        <div class="d-flex flex-row justify-content-between py-2">
          <h5 class="card-header">All Logs</h5>
          <input
              type="text"
              id="search"
              class="form-control search-input border-2 w-25 mx-4 my-2"
              placeholder="Search..."
              aria-label="Search..." 
          />
        </div>
        <div class="table-responsive text-nowrap">
        <div id="searchResults"> 
          @include('adminlogs.partials.searchres')
        </div>
      </div>
@endsection

@section('scripts')
      <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
      <script>
          $(document).ready(function () {
              $('#search').on('keyup', function () {
                  let query = $(this).val();

                  $.ajax({
                      url: "{{ route('adminlogs.search') }}",
                      method: 'GET',
                      data: { search: query },
                      success: function (data) {
                          $('#searchResults').html(data);
                      }
                  });
              });
          });
      </script>
@endsection