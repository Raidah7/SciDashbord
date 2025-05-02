@extends('admin.layouts.app')

@section('title', 'Comments & Reviews')

@section('content')

    <div class="container-fluid">
        <h2 class="title mt-3"><i class="fas fa-comments"></i> Comments & Reviews</h2>

        <!-- Comments Table -->
        <div class="table-responsive">
            <table id="datatable" class="table table-bordered text-center table-striped">
                <thead>
                <tr>
                    <th>#</th>
                    <th>User</th>
                    <th>Research Title</th>
                    <th>Comment</th>
                    <th>Commented On</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($comments as $index => $comment)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ optional($comment->user)->name }}</td>
                        <td>{{ optional($comment->research)->title }}</td>
                        <td>{{ Str::limit($comment->content, 100) }}</td>
                        <td>{{ date('M d, Y h:i A', strtotime($comment->date)) }}</td>
                        <td>
                            <button class="btn btn-danger btn-sm delete-comment" data-id="{{ $comment->comment_id }}">
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
        document.querySelectorAll('.delete-comment').forEach(button => {
            button.addEventListener('click', function () {
                let commentId = this.getAttribute('data-id');
                if (confirm('Are you sure you want to delete this comment?')) {
                    fetch("{{ route('admin.comments.delete') }}", {
                        method: "POST",
                        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': "{{ csrf_token() }}" },
                        body: JSON.stringify({ comment_id: commentId })
                    }).then(response => response.json()).then(data => {
                        if (data.success) location.reload();
                        else alert('Error deleting comment.');
                    });
                }
            });
        });
    </script>
@endpush
