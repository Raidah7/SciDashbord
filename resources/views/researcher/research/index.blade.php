@extends('researcher.layouts.app')

@section('title', 'My Research')

@section('content')
    <div class="container-fluid">
        <div class="card mt-4">
            <div class="card-header d-flex justify-content-between">
                <h2 class="title">My Research</h2>
                <a href="{{ route('researcher.research.create') }}" class="btn btn-primary">Add New Research <i class="fa fa-plus"></i></a>
            </div>
            <div class="card-body">
                <table id="datatable" class="table table-bordered text-center table-striped">
                    <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th class="text-center">Title</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($researches as $index => $research)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                    {{ $research->title }}
                            </td>
                            <td>
                                @if($research->status == 'Submitted')
                                    <span class="badge bg-warning">Submitted</span>
                                @elseif($research->status == 'Under Review')
                                    <span class="badge bg-info">Under Review</span>
                                @elseif($research->status == 'Approved')
                                    <span class="badge bg-success">Approved</span>
                                @elseif($research->status == 'Rejected')
                                    <span class="badge bg-danger">Rejected</span>
                                @else
                                    <span class="badge bg-secondary">{{ $research->status }}</span>
                                @endif
                            </td>
                            <td>
                                <a class="btn btn-primary btn-sm" href="#" data-bs-toggle="modal" data-bs-target="#researchModal-{{ $research->research_id }}">
                                    <i class="fas fa-eye"></i> View
                                </a>
                                <a href="{{ route('researcher.research.edit', $research->research_id) }}" class="btn btn-secondary btn-sm">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form id="delete-form-{{ $research->research_id }}" action="{{ route('researcher.research.destroy', $research->research_id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete('delete-form-{{ $research->research_id }}')">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>

                        <!-- Research Details Modal -->
                        <div class="modal fade" id="researchModal-{{ $research->research_id }}" tabindex="-1" aria-labelledby="researchModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="researchModalLabel">{{ $research->title }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p><strong>Authors:</strong> {{ $research->authors }}</p>
                                        <p><strong>Fields:</strong> {{ $research->fields }}</p>
                                        <p><strong>Abstract:</strong></p>
                                        <p>{{ $research->abstract }}</p>
                                        <p><strong>Submission Date:</strong> {{ $research->date_submitted }}</p>
                                        <p><strong>Status:</strong>
                                            @if($research->status == 'Submitted')
                                                <span class="badge bg-warning">Submitted</span>
                                            @elseif($research->status == 'Under Review')
                                                <span class="badge bg-info">Under Review</span>
                                            @elseif($research->status == 'Approved')
                                                <span class="badge bg-success">Approved</span>
                                            @elseif($research->status == 'Rejected')
                                                <span class="badge bg-danger">Rejected</span>
                                            @else
                                                <span class="badge bg-secondary">{{ $research->status }}</span>
                                            @endif
                                        </p>
                                        @if($research->document)
                                            <p><strong>Research Document:</strong> <a href="{{ asset($research->document) }}" target="_blank">View Document</a></p>
                                        @endif
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Modal -->
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        function confirmDelete(formId) {
            if (confirm("Are you sure you want to delete this research?")) {
                document.getElementById(formId).submit();
            }
        }
    </script>
@endpush
