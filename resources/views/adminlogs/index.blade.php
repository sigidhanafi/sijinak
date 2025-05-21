@extends('layouts.app')

@section('title', 'Admin Log | Sijinak')
{{-- TODO: REFACTOR SOME COMPONENT INTO MODULAR PIECE TO AVOID THESE SPAGHETTI ULALA FIX THE reset button abuse hack--}}

@section('content')
    <div id='ajax-error-container'
        class="alert alert-solid-primary d-flex align-items-center fade show d-none justify-content-between" role="alert">
        <span id='ajax-error-message'></span>
        <button type="button" class="btn-close" id="error-close" data-bs-dismiss='alert' aria-label='close'></button>
    </div>


    <div id='search-container'class="d-flex flex-column justify-content-between align-items-start mb-3 gap-3 mt-3">
        <h1 class=" mb-2 mb-md-0 mx-3">Administrator Activity Log</h1>

        <!-- Search -->
        <div class="mt-3 d-flex flex-column mb-md-1 justify-content-end mx-3  w-100">
            <label for="search" class="form-label d-flex align-items-center">
                <i class="bx bx-search me-1"></i> <b>Search Log</b>
            </label>
            <div class="input-group w-50 ">
                <input type="text" id="search" class="form-control" placeholder="Search..." aria-label="Search..." />
                <span id="search-reset" class="input-group-text cursor-pointer"><i class="bx bx-x-circle"></i></span>
            </div>
            <div id="floatingInputHelp" class="form-text">Cari Admin, tipe aksi, dan waktu</div>
        </div>
    </div>


    <div id='card-container-filter' class="card my-20  d-flex flex-column ">
        <div class="card-header  ">

            <!-- Header -->
            <div class="col-12 col-md-4">
                <h5 class="card-text">Showing All Logs</h5>
            </div>

        </div>

        <div class="accordion accordion-header-primary w-50 m-3 " id="accordionStyle1">
            <div class="accordion-item card d-flex flex-wrap ">
                <h2 class="accordion-header">
                    <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse"
                        data-bs-target="#accordionStyle1-1" aria-expanded="false">
                        Filter Log
                    </button>
                </h2>

                <div id="accordionStyle1-1" class="accordion-collapse collapse flex flex-wrap"
                    data-bs-parent="#accordionStyle1">
                    <div class="d-flex flex-column flex-md-row flex-wrap align-items-start gap-3 m-2 accordion-body">


                        <div class="btn-group flex-fill ">
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

                        <div class="btn-group  flex-fill">
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


                        <div class="btn-group flex-fill">
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

            </div>

        </div>

        {{-- admin log table --}}
        <div class="table-responsive-sm  mt-3">
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

                $('#error-close').on('click', function() {
                    $('#ajax-error-container').addClass('d-none');
                })

                const disableButtonAtHome = () => {
                    const urlParams = new URLSearchParams(window.location.search);
                    const isPageOne = urlParams.get('page') === '1' || !urlParams.get('page');
                    // You may want to check for the current route if needed
                    if (isPageOne) {
                        $('#search-reset').attr('disabled', true);
                    } else {
                        $('#search-reset').removeAttr('disabled');
                    }
                }

                $('#search-reset').on('click', function() {
                    $('#search').val('');
                    query = '';
                    fetchData(1, query);
                    $('#search').focus();
                });

                // Call on page load
                disableButtonAtHome();

                // Optionally, call after AJAX fetch if you want to update the button state after navigation
                // For example, inside fetchData's success:
                // success: function(data) {
                //     $('#searchResults').html(data);
                //     const url = new URL(window.location);
                //     url.searchParams.set('page', page);
                //     window.history.pushState({}, '', url);
                //     disableButtonAtHome();
                // },


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
                            $('#ajax-error-message').text('Request failed. Please check your connection.')
                            $('#ajax-error-container').removeClass('d-none');
                        }
                    });
                }
            });
        </script>
    @endsection
