@extends('layouts.app')

@section('title', 'Admin Log | Sijinak')
{{-- TODO: REFACTOR SOME COMPONENT INTO MODULAR PIECE TO AVOID THESE SPAGHETTI ULALA FIX THE reset button abuse hack --}}

@section('content')
    <h1 class="mb-8 mb-md-3 mx-3">Administrator Activity Log</h1>
    <x-error-modal />

    <div id='card-container-filter' class=" d-flex flex-column flex-md-row gap-1 ">

        <x-search-card />

        <div id='filter-container' class="d-flex flex-column flex-md-row ">
            <x-filter-card />
        </div>


    </div> <!-- #card-container-filter -->

    {{-- admin log table --}}
    <div class=" card table-responsive-sm mt-1">
        <!-- Header -->
        <div class="card-header ">
            <div class="col-12 col-md-4 m-2">
                <h5 class="card-title mb-1">Showing All Logs</h5>
                <p class=" card-text mb-2">Menampilkan hasil untuk semua log </p>
                {{-- TODO add interactive ui to show query for .... --}}
            </div>
        </div>
        <!-- .card-header -->
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

            $('#search-reset').on('click', resetSearch);

            const processChange = debounce((page, query) => fetchData(page, query));
            let query = '';

            const $searchInput = $('#search');


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

            function debounce(func, timeout = 250) {
                let timer;
                return (...args) => {
                    clearTimeout(timer);
                    timer = setTimeout(() => {
                        func.apply(this, args);
                    }, timeout)
                };
            }


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
                
                $searchInput.val('');
                query = '';
                fetchData(1, '');
                $searchInput.focus();
                disableButtonAtHome();
            }


            const cleanURL = () => {
                const url = new URL(window.location);
                if (url.searchParams.get('page') === '1') {
                    url.searchParams.delete('page');
                    window.history.replaceState({}, '', url);
                }
            };
            cleanURL();


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
            // Call on page load
            disableButtonAtHome();

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
