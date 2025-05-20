<table class="table table-hover table-striped">
    <thead>
        <tr>
            <th>No.</th>
            <th>Admin</th>
            <th>Action</th>
            <th>Done at</th>
        </tr>
    </thead>
    <tbody class="table-border-bottom-0">
        @foreach ($logs as $log)
            <tr>
                <td>
                    <span class="fw-medium">{{ $log->id }}</span>
                </td>
                <td>{{ $log->user->name }}</td>
                <td><span
                        class="badge bg-label-{{ $log->activity_type == 'Log In' ? 'primary' : ($log->activity_type == 'Create QR' ? 'info' : ($log->activity_type == 'Accept Student Request' ? 'success' : 'warning')) }} me-1">{{ $log->activity_type }}</span>
                </td>
                <td>
                    {{ $log->created_at->format('Y-m-d H:i:s') }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

@php
    $currentPage = $logs->currentPage();
    $lastPage = $logs->LastPage();
    $previousPage = $currentPage - 1;
    $nextPage = $currentPage + 1;
@endphp


<nav aria-label="Page-navigation" class="mt-2 ">
    <ul class="pagination pagination-lg justify-content-center">

        {{-- First Page --}}
        <li class="page-item {{ $currentPage === 1 ? 'disabled' : '' }}">
            <a class="page-link" href="{{ $logs->url(1) }}">
                <i class="bx bx-chevrons-left"></i>
            </a>
        </li>

        {{-- Previous Page --}}
        <li class="page-item {{ $currentPage === 1 ? 'disabled' : '' }}">
            <a class="page-link" href="{{ $logs->previousPageUrl() }}">
                <i class="bx bx-chevron-left"></i>
            </a>
        </li>

        @php
            $start = max(1, $currentPage - 1);
            $end = min($lastPage, $currentPage + 1);
            if ($currentPage === 1) {
                $end = min($lastPage, $start + 2);
            }
            if ($currentPage === $lastPage) {
                $start = max(1, $lastPage - 2);
            }
        @endphp

        @for ($i = $start; $i <= $end; $i++)
            <li class="page-item {{ $i === $currentPage ? 'active' : '' }}">
                <a class="page-link" href="{{ $logs->url($i) }}">{{ $i }}</a>
            </li>
        @endfor

        {{-- Next Page --}}
        <li class="page-item {{ $currentPage === $lastPage ? 'disabled' : '' }}">
            <a class="page-link" href="{{ $logs->nextPageUrl() }}">
                <i class="bx bx-chevron-right"></i>
            </a>
        </li>

        {{-- Last Page --}}
        <li class="page-item {{ $currentPage === $lastPage ? 'disabled' : '' }}">
            <a class="page-link" href="{{ $logs->url($lastPage) }}">
                <i class="bx bx-chevrons-right"></i>
            </a>
        </li>

    </ul>
</nav>
