@extends('layouts.app')

@section('title', 'Admin Log | Sijinak')
{{-- TODO: REFACTOR SOME COMPONENT INTO MODULAR PIECE TO AVOID THESE SPAGHETTI ULALA FIX THE reset button abuse hack --}}

@section('content')

    <x-error-modal />
    
    <x-search-card />

    <div id='card-container-filter' class="card my-20  d-flex flex-column ">
        <div class="card-header  ">

            <!-- Header -->
            <div class="col-12 col-md-4 m-3">
                <h5 class="card-text mb-1">Showing All Logs</h5>
                <p class="mb-2">Menampilkan hasil untuk semua log </p>
                {{-- TODO add interactive ui to show query for .... --}}
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

                            {{-- Taruh disini nanti buat component accordion --}}
                            {{-- taruh dua aja dengan prop yang beda --}}

                            {{-- <x-dropdown-check-box-item :title="'Jenis Admin'" :helper-message="'Filter berdasarkan jenis admin'" :type="'admin'">
                                <x-dropdown-check-box-children :label="'Guru Piket'" :badge="''" :type="'admin'" />
                                <x-dropdown-check-box-children :label="'Admin'" :badge="''" :type="'admin'" />
                                <x-dropdown-check-box-children :label="'Petugas'" :badge="''" :type="'admin'" />
                            </x-dropdown-check-box-item> --}}

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

                            {{-- <x-dropdown-check-box-item :title="'Jenis Aksi'" :helper-message="'Filter berdasarkan jenis aksi'" type="'aksi'">
                                <x-dropdown-check-box-children :label="'Log In'" :badge="'primary'" :type="'aksi'" />
                                <x-dropdown-check-box-children :label="'Create QR'" :badge="'info'" :type="'aksi'" />
                                <x-dropdown-check-box-children :label="'Reject Student Request'" :badge="warning" :type="'aksi'" />
                                <x-dropdown-check-box-children :label="'Accept Student Request'" :badge="success" :type="'aksi'" />
                            </x-dropdown-check-box-item>           --}}

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
                                <ul class="dropdown-menu p-3" style="min-width: 300px;"
                                    aria-labelledby="dropdownMenuButton">
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
                                        <div id="floatingInputHelp" class="form-text">Filter berdasarkan rentang waktu
                                        </div>
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

                    const modalElement = document.getElementById('ajaxErrorModal');
                    const modal = new bootstrap.Modal(modalElement)

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

                    function resetSearch() {
                        $('#search').val('');
                        query = '';
                        fetchData(1, '');
                        $('#search').focus();
                        disableButtonAtHome();
                    }

                    $('#search-reset').on('click', resetSearch);

                    // Call on page load
                    disableButtonAtHome();

                    function handleError(xhr, status, error) {
                        console.error('Ajax error:', error);
                        $('#ajax-error-message').text('Request failed. Please check your connection.');
                        $('#ajax-error-code').text('Error ' + xhr.status);
                        modal.show();
                    }

                    function retryRequest(page, query) {
                        // add state to the request to show this is request and will close the modal
                        setTimeout(() => {
                            fetchData(page, query);
                        }, 1000)
                    }

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
                            error: (xhr, status, error) => {
                                handleError(xhr, status, error)
                                // retryRequest(page,query);
                            }
                        });
                    }
                });
            </script>
        @endsection
