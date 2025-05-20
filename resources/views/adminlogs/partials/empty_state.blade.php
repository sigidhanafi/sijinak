{{-- Html that will be injected to the dom to display empty search result can also be used to show empty query with CTA button --}}

<div class="text-center py-4">
    <div class="alert alert-info" role="alert">
        @if (isset($search) && $search)
            <h4>No results found for "{{ $search }}"</h4>
        @else
            <h4>No logs available</h4>
        @endif
    </div>
</div>
