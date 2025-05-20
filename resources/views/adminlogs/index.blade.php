@extends('layouts.app')

@section('title', 'Admin Log | Sijinak')
{{-- TODO: REFACTOR SOME COMPONENT INTO MODULAR PIECE TO AVOID THESE SPAGHETTI ULALA --}}

@section('content')
    <div class="d-flex flex-row flex-md-row justify-content-between align-items-center mb-3 gap-3 mt-3">
        <h1 class=" mb-2 mb-md-0">Administrator Activity Log</h1>

        <!-- Search -->
        <div class="mt-3 d-flex flex-column mb-md-3 justify-content-end mx-3">
            <label for="search" class="form-label d-flex align-items-center">
                <i class="bx bx-search me-1"></i> <b>Search Log</b>
            </label>
            <div class="input-group ">
                <input type="text" id="search" class="form-control" placeholder="Search..." aria-label="Search..."
                    style="max-width: 700px;" />
            </div>
            <div id="floatingInputHelp" class="form-text">Cari Admin, tipe aksi, dan waktu</div>
        </div>
    </div>


    <div id='card-container' class="card my-20 sticky-top">
        <div class="card-header ">
            <div class="row g-3">
                <!-- Header -->
                <div class="col-12 col-md-4">
                    <h5 class="mb-0">Filter Logs</h5>
                </div>
            </div>
        </div>

        <div class="card-body d-flex flex-row  flex-sm-row justify-content-start align-items-center gap-3 w-50">

            <div class="btn-group me-3 flex-fill ">
                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Jenis Admin
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <div class="list-group m-2">
                        

                        <li>
                            <label class="list-group-item dropdown-item">
                                <input class="form-check-input me-1" type="checkbox" value="">
                                Guru Piket
                            </label>
                        </li>

                        
                        <li>
                            <label class="list-group-item dropdown-item">
                                <input class="form-check-input me-1" type="checkbox" value="">
                                Admin
                            </label>
                        </li>

                        
                        <li>
                            <label class="list-group-item dropdown-item">
                                <input class="form-check-input me-1" type="checkbox" value="">
                                Petugas
                            </label>
                        </li>
                        <div id="floatingInputHelp" class="form-text">Filter berdasarkan jenis admin</div>
                    </div>
                </ul>
            </div>

            <div class="btn-group me-3 flex-fill">
                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Jenis Aksi
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <div class="list-group m-2">

                        <li>
                            <label class="list-group-item dropdown-item">
                                <input class="form-check-input me-1" type="checkbox" value="">
                                <span class="badge bg-label-primary">Log In</span>   
                            </label>
                        </li>

                        
                        <li>
                            <label class="list-group-item dropdown-item">
                                <input class="form-check-input me-1" type="checkbox" value="">
                                <span class="badge bg-label-info">Create QR</span> 
                            </label>
                        </li>

                        
                        <li>
                            <label class="list-group-item dropdown-item">
                                <input class="form-check-input me-1" type="checkbox" value="">
                                
                                <span class="badge bg-label-warning">Reject Student Request</span>
                            </label>
                        </li>

                        <li>
                            <label class="list-group-item dropdown-item">
                                <input class="form-check-input me-1" type="checkbox" value="">
                                
                                <span class="badge bg-label-success">Accept Student Request</span>
                            </label>
                        </li>
                        <div id="floatingInputHelp" class="form-text">Filter berdasarkan jenis aksi</div>
                    </div>
                </ul>
            </div>


            <div class="btn-group me-3 flex-fill">
                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Waktu
                </button>
                <ul class="dropdown-menu p-3" style="min-width: 300px;" aria-labelledby="dropdownMenuButton">
                    <li>
                        <label class="form-label mb-2">Filter date</label>
                        <div class="mb-2">
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class='bx bx-calendar'></i>
                                </span>
                                <input class="form-control date-mask" type="text" id="start_date"
                                    placeholder="Start: YYYY-MM-DD" />
                            </div>
                        </div>
                        <div>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class='bx bx-calendar'></i>
                                </span>
                                <input class="form-control date-mask" type="text" id="end_date"
                                    placeholder="End: YYYY-MM-DD" />
                            </div>
                        </div>
                        <div id="floatingInputHelp" class="form-text">Filter berdasarkan rentang waktu</div>
                    </li>
                </ul>
            </div>


            <button type="button" class="btn btn-outline-primary">Apply</button>
        </div>
    </div>

    {{-- admin log table --}}
    <div class="table-responsive text-nowrap mt-3">
        <div id="searchResults">
            @if ($logs->isEmpty())
                @include('adminlogs.partials.empty_state')
            @else
                @include('adminlogs.partials.searchres')
            @endif
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

               $(document).on('click', '#home-button', function() {
                document.querySelector('#search').value = '';
                // Also reset the search query and reload results
                query = '';
                fetchData(1, '');
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
                        const url = new URL(window.location); //ambil url yang ada di browser
                        url.searchParams.set('page', page); //auto search param
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
