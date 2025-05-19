@extends('layouts.app')

@section('title', 'Admin Log | Sijinak')

@section('content')
    <h1>Administrator Activity Log</h1>

    <div id='card-container' class="card my-20 sticky-top">
        <div class="card-header ">
            <div class="row g-3">
                <!-- Header -->
                <div class="col-12 col-md-4">
                    <h5 class="mb-0">All Logs</h5>
                </div>
            </div>


        </div>

        <div class="card-body d-flex flex-column flex-md-row justify-content-start align-items-center gap-3">

            <!-- Search -->
            <div class="col-12 col-md-4 mb-3 mb-md-0">
                <div class="col-12">
                    <label class="form-label">Search Log</label>
                </div>

                <div class="input-group">
                    <input type="text" id="search" class="form-control search-input" placeholder="Search..."
                        aria-label="Search..." />
                </div>
            </div>

            <!-- Filter Date -->
            <div class="row col-md-4 mb-3 mb-md-0">

                <div class="col-12">
                    <label class="form-label">Filter date</label>
                </div>

                <div class="col-6">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class='bx bx-calendar'></i>
                        </span>
                        <input class="form-control date-mask" type="text" id="start_date" placeholder="YYYY-MM-DD" />
                    </div>
                </div>

                <div class="col-6">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class='bx bx-calendar'></i>
                        </span>
                        <input class="form-control date-mask" type="text" id="end_date" placeholder="YYYY-MM-DD" />
                    </div>
                </div>

            </div>
        </div>


    </div>

    {{-- admin log table --}}
    <div class="table-responsive text-nowrap mt-3">
        <div id="searchResults">
            @include('adminlogs.partials.searchres')
        </div>
    </div>

@endsection

{{-- ADDED DEBOUNCE, AJAX scenario for pagination call --}}
@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            function debounce(func, timeout = 250) {
                let timer;
                return (...args) => {
                    clearTimeout(timer);
                    timer = setTimeout(() => {
                        func.apply(this, args);
                    }, timeout)
                };
            }
            const processChange = debounce((page, query) => fetchData(page, query));
            let query = '';

            $(document).on('click', '.pagination a', function(e) {
                e.preventDefault();
                let page = $(this).attr('href').split('page=')[1];
                fetchData(page, query);
            });

            $('#search').on('keyup', function() {
                query = $(this).val();
                let page = 1;
                processChange(page, query);
            });

            function fetchData(page, query) {
                $.ajax({
                    url: "{{ route('adminlogs.search') }}",
                    method: 'GET',
                    data: {
                        page: page,
                        search: query
                    },
                    success: function(data) {
                        $('#searchResults').html(data); //ganti isi saerchresult sama partial
                        const url = new URL(window.location);//ambil url yang ada di browser
                        url.searchParams.set('page', page);//auto search param
                        window.history.pushState({}, '', url);
                    },
                    error: function(xhr, status, error) {
                        console.error('Ajax error:', error);
                    }
                });
            }
        });
    </script>
@endsection
