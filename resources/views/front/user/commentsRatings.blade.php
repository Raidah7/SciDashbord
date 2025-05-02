@extends('front.layouts.app')

@section('title', 'My Comments & Ratings')

@section('content')

    <div class="container">
        <h2 class="mt-4"><i class="fas fa-comments"></i> My Comments & Ratings</h2>

        <div class="row mt-4">
            <!-- Comments Section -->
            <div class="col-md-6">
                <div class="card shadow-sm p-4">
                    <h5 class="fw-bold"><i class="fas fa-comment-alt"></i> Comments</h5>
                    <ul class="list-group">
                        @foreach($comments as $comment)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>{{ $comment->research->title }}</strong>: {{ $comment->content }}
                                    <br>
                                    <small class="text-muted"><i class="fas fa-clock"></i> {{ date('Y-m-d h:i A', strtotime($comment->date)) }}</small>
                                </div>
                                <button class="btn btn-danger btn-sm btnDelete delete-comment" data-id="{{ $comment->comment_id }}">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <!-- Ratings Section -->
            <div class="col-md-6">
                <div class="card shadow-sm p-4">
                    <h5 class="fw-bold"><i class="fas fa-star"></i> Ratings</h5>
                    <ul class="list-group">
                        @foreach($ratings as $rating)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>{{ $rating->research->title }}</strong>
                                    <br>
                                    <span class="badge bg-warning text-dark">
                                        <i class="fas fa-star"></i> {{ number_format($rating->rating_value, 1) }} / 5
                                    </span>
                                    <br>
                                    <small class="text-muted"><i class="fas fa-clock"></i> {{ date('Y-m-d h:i A', strtotime($rating->date)) }}</small>
                                </div>
                                <button class="btn btn-danger btn-sm btnDelete delete-rating" data-id="{{ $rating->user_id }}" data-research="{{ $rating->research_id }}">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

    </div>

@endsection

@push('js')
    <script>
        $(document).ready(function () {
            // Delete Comment
            $('.delete-comment').click(function () {
                let commentId = $(this).data('id');
                if (confirm('Are you sure you want to delete this comment?')) {
                    $.ajax({
                        url: "{{ route('user.comment.delete') }}",
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            comment_id: commentId
                        },
                        success: function (response) {
                            location.reload();
                        },
                        error: function () {
                            alert('Error deleting comment.');
                        }
                    });
                }
            });

            // Delete Rating
            $('.delete-rating').click(function () {
                let userId = $(this).data('id');
                let researchId = $(this).data('research');
                if (confirm('Are you sure you want to delete this rating?')) {
                    $.ajax({
                        url: "{{ route('user.rating.delete') }}",
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            user_id: userId,
                            research_id: researchId
                        },
                        success: function (response) {
                            location.reload();
                        },
                        error: function () {
                            alert('Error deleting rating.');
                        }
                    });
                }
            });
        });
    </script>
@endpush
