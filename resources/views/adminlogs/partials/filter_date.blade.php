<table class='table table-hover'>
    <thead>
        <tr>
            <th>No.</th>
            <th>Admin</th>
            <th>Action</th>
            <th>Done at</th>
        </tr>
    </thead>
    <tbody>
        @foreach($logs as $log)
            <tr>
                <td>
                    <span class="fw-medium">{{ $log->id }}</span>
                </td>
                <td>{{ $log->user->name }}</td>
                <td><span class="badge bg-label-{{ $log->activity_type == 'Log In' ? 'primary' : ($log->activity_type == 'Create QR' ? 'info' : ($log->activity_type == 'Accept Student Request' ? 'success' : 'warning')) }} me-1">{{ $log->activity_type }}</span></td>
                <td>
                    {{ $log->created_at->format('Y-m-d H:i:s') }}
                </td>
            </tr>
        @endforeach
    </tbody>

{{-- a bit redundant might want to refactor this into a generic blade partials --}}
</table>