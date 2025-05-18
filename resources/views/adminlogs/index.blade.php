@extends('layouts.app')

@section('title', 'Admin Log | Sijinak')

@section('content')
    <h1>Administrator Activity Log</h1>
    <div class="card">
        <div class="d-flex flex-row justify-content-between py-2">
          <h5 class="card-header">All Logs</h5>
        <div class="d-flex flex-row justify-end py-2">
            <div class='flex flex-row justify-evenly p-2 mx-4 my-2'>
                <p class="mx-4 my-2">Search Log</p>
                <input
                    type="text"
                    id="search"
                    class="form-control search-input border-2 xl:w-70 mx-4 my-2"
                    placeholder="Search..."
                    aria-label="Search..." 
                />
            </div>
            
            {{-- Bagian filter tanggal IN PROGRESS~ erwin --}}
                <div class='flex flex-row justify-evenly p-2 mx-4 my-2 xl:w-20'>
                        <p class="mx-1 my-2">Filter date</p>

                        {{-- container input group --}}

                        <div class="flex flex-col justify-between p-2 my-2">

                            <div class="row">
                                <div class="col">
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class='bx bx-calendar'></i>
                                        </span>
                                        <input class="form-control" style="max-width: 100px;" id="start-date" type="text" placeholder="start date" readonly>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class='bx bx-calendar'></i>
                                        </span>
                                        <input class="form-control" style="max-width: 100px;" id="end-date" type="text" placeholder="end date" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex flex-row justify-between py-2">
    
                                <button type="button" 
                                        id="filter-btn" 
                                        class="btn btn-primary mt-1 mr-3">
                                    <i class='bx bx-search'></i> Filter
                                </button>
            
                                <button type="button" 
                                        id="reset-btn" 
                                        class="btn btn-secondary mt-1 mr-3">
                                    <i class='bx bx-refresh'></i> Reset
                                </button>
                            </div>
                        </div>

                    </div>

                </div>
            </div>

            {{-- Bagian filter tanggal IN PROGRESS~ erwin --}}

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