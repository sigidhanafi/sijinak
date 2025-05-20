{{-- Html that will be injected to the dom to display empty search result can also be used to show empty query with CTA button --}}

<div>
    <div class="card bg-primary d-flex flex-column gap-3" role="alert">
        @if (isset($search) && $search)
            <div class="card-body">
                <h4 class="card-title text-white">No results found for "<i>{{ $search }}</i>"</h4>
                <p class="card-text text-white" style="opacity: 0.7;"> Coba gunakan kata kunci yang berbeda atau periksa
                    ejaannya. </p>
                <button class='btn btn-dark ' id="home-button">
                    Kembali ke Halaman Admin Log
                </button>
            </div>
        @else
            <h4>No logs available</h4>
        @endif
    </div>
</div>


