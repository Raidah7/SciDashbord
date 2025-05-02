@extends('admin.layouts.app')

@section('title', 'Ratings Management')

@section('content')

    <div class="container-fluid">
        <h2 class="title mt-3"><i class="fas fa-star"></i> Ratings Management</h2>

        <!-- Ratings Table -->
        <div class="table-responsive">
            <table id="datatable" class="table table-bordered text-center table-striped">
                <thead>
                <tr>
                    <th>#</th>
                    <th>User</th>
                    <th>Research Title</th>
                    <th>Rating</th>
                    <th>Rated On</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($ratings as $index => $rating)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $rating->user->name }}</td>
                        <td>{{ $rating->research->title }}</td>
                        <td>
                            @for ($i = 0; $i < 5; $i++)
                                @if ($i < $rating->rating_value)
                                    <i class="fas fa-star text-warning"></i>
                                @else
                                    <i class="far fa-star text-warning"></i>
                                @endif
                            @endfor
                            <span>({{ number_format($rating->rating_value, 1) }}/5)</span>
                        </td>
                        <td>{{ date('M d, Y h:i A', strtotime($rating->date)) }}</td>
                        <td>
                            <button class="btn btn-danger btn-sm delete-rating" data-id="{{ $rating->user_id }}" data-research="{{ $rating->research_id }}">
                                <i class="fas fa-trash-alt"></i> Delete
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
        document.querySelectorAll('.delete-rating').forEach(button => {
            button.addEventListener('click', function () {
                let userId = this.getAttribute('data-id');
                let researchId = this.getAttribute('data-research');
                if (confirm('Are you sure you want to delete this rating?')) {
                    fetch("{{ route('admin.ratings.delete') }}", {
                        method: "POST",
                        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': "{{ csrf_token() }}" },
                        body: JSON.stringify({ user_id: userId, research_id: researchId })
                    }).then(response => response.json()).then(data => {
                        if (data.success) location.reload();
                        else alert('Error deleting rating.');
                    });
                }
            });
        });
    </script>
@endpush
