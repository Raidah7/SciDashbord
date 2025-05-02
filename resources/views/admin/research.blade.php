@extends('admin.layouts.app')

@section('title', 'Research Management')

@section('content')

    <div class="container-fluid">
        <h2 class="title mt-3"><i class="fas fa-book"></i> Research Management</h2>

        <!-- Research Table -->
        <div class="table-responsive">
            <table id="datatable" class="table table-bordered text-center table-striped">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Status</th>
                    <th>Submitted On</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($researches as $index => $research)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $research->title }}</td>
                        <td>{{ $research->researcher->user->name }}</td>
                        <td>
                            @php
                                $statusColor = match ($research->status) {
                                    'Submitted' => 'badge bg-secondary',
                                    'Under Review' => 'badge bg-warning',
                                    'Approved' => 'badge bg-success',
                                    'Rejected' => 'badge bg-danger',
                                    default => 'badge bg-secondary'
                                };
                            @endphp
                            <span class="{{ $statusColor }}">{{ $research->status }}</span>
                        </td>
                        <td>{{ date('M d, Y', strtotime($research->date_submitted)) }}</td>
                        <td>
                            <a href="{{ route('admin.research.details', $research->research_id) }}" class="btn btn-info btn-sm">
                                <i class="fas fa-eye"></i> View
                            </a>
                            <button class="btn btn-success btn-sm update-status" data-id="{{ $research->research_id }}" data-status="Approved">
                                <i class="fas fa-check"></i> Approve
                            </button>
                            <button class="btn btn-warning btn-sm update-status" data-id="{{ $research->research_id }}" data-status="Under Review">
                                <i class="fas fa-spinner"></i> Under Review
                            </button>
                            <button class="btn btn-danger btn-sm update-status" data-id="{{ $research->research_id }}" data-status="Rejected">
                                <i class="fas fa-times"></i> Reject
                            </button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection

@push('js')
    <script>
        document.querySelectorAll('.update-status').forEach(button => {
            button.addEventListener('click', function () {
                let researchId = this.getAttribute('data-id');
                let newStatus = this.getAttribute('data-status');

                if (confirm(`Are you sure you want to mark this research as "${newStatus}"?`)) {
                    fetch("{{ route('admin.research.updateStatus') }}", {
                        method: "POST",
                        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': "{{ csrf_token() }}" },
                        body: JSON.stringify({ research_id: researchId, status: newStatus })
                    }).then(response => response.json()).then(data => {
                        if (data.success) location.reload();
                        else alert('Error updating status.');
                    });
                }
            });
        });
    </script>
@endpush
