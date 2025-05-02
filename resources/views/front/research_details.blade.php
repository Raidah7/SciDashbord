@extends('front.layouts.app')

@section('title', 'Research Details')

@push('css')
    <style>
        /* General Styling */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
        }

        .container {
            max-width: 1200px;
        }

        /* Research Details Card */
        .research-details-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            padding: 30px;
            background: #fff;
            transition: transform 0.3s ease;
        }

        .research-details-card:hover {
            transform: translateY(-5px);
        }

        .research-details-card h2 {
            font-size: 2rem;
            color: #0056b3;
            margin-bottom: 15px;
        }

        .research-details-card p {
            font-size: 1rem;
            color: #555;
        }

        .research-details-card .btn-primary {
            border-radius: 20px;
            padding: 10px 25px;
            background: #007bff;
            border: none;
            transition: background 0.3s ease;
        }

        .research-details-card .btn-primary:hover {
            background: #0056b3;
        }

        /* Rating Stars */
        .rating-stars i {
            font-size: 1.2rem;
            margin-right: 3px;
        }

        /* Feedback Form */
        .feedback-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            padding: 25px;
            background: #fff;
        }

        .feedback-card .form-select,
        .feedback-card .form-control {
            border-radius: 8px;
            border: 1px solid #ced4da;
            transition: border-color 0.3s ease;
        }

        .feedback-card .form-select:focus,
        .feedback-card .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 8px rgba(0, 123, 255, 0.2);
        }

        .feedback-card .btn-primary {
            border-radius: 20px;
            padding: 10px 20px;
        }

        /* Ratings and Comments Section */
        .ratings-comments-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            padding: 25px;
            background: #fff;
        }

        .ratings-comments-card h5 {
            font-size: 1.25rem;
            color: #333;
            margin-bottom: 20px;
        }

        .list-group-item {
            border: none;
            border-bottom: 1px solid #eee;
            padding: 15px 0;
            background: transparent;
        }

        .list-group-item:last-child {
            border-bottom: none;
        }

        .list-group-item strong {
            color: #333;
        }

        .list-group-item .text-muted {
            color: #777 !important;
            font-size: 0.9rem;
        }

        .badge.bg-warning {
            padding: 6px 12px;
            border-radius: 20px;
            color: #fff;
        }

        .user-icon {
            color: #007bff;
            font-size: 2rem;
        }
    </style>
@endpush

@section('content')
    <div class="container my-5">
        <!-- Research Details Card -->
        <div class="research-details-card mb-5">
            <h2 class="fw-bold">{{ $research->title }}</h2>
            <p class="mb-2">By: <span class="fw-semibold">{{ $research->authors }}</span></p>
            <p class="mb-3">
                <i class="fas fa-calendar-alt text-warning me-1"></i>
                Published on <span class="fw-semibold">{{ date('M d, Y', strtotime($research->date_submitted)) }}</span>
            </p>

            <!-- Average Rating Display -->
            @php
                $avgRating = $research->ratings->avg('rating_value') ?? 0;
                $roundedAvg = round($avgRating);
            @endphp
            <div class="d-flex align-items-center mb-4">
                <span class="me-3 fw-semibold">Average Rating:</span>
                <div class="rating-stars">
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= $roundedAvg)
                            <i class="fas fa-star text-warning"></i>
                        @else
                            <i class="far fa-star text-warning"></i>
                        @endif
                    @endfor
                    <span class="ms-2 text-muted">({{ number_format($avgRating, 1) }}/5)</span>
                </div>
            </div>

            <p class="mt-3">{{ $research->abstract }}</p>

            @if($research->document)
                <a href="{{ asset('storage/' . $research->document) }}" target="_blank" class="btn btn-primary mt-3">
                    <i class="fas fa-file-download me-2"></i> Download Research Paper
                </a>
            @endif
        </div>

        <!-- Combined Interaction Form: Rating & Comment -->
        @auth
            <div class="feedback-card mb-5">
                <h5 class="fw-bold"><i class="fas fa-comment-dots me-2"></i> Leave Your Feedback</h5>
                <form action="{{ route('research.feedback.store', $research->research_id) }}" method="POST">
                    @csrf
                    <div class="row">
                        <!-- Rating Selection -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Your Rating:</label>
                            <select name="rating_value" class="form-select" required>
                                <option value="" selected disabled>Select a rating</option>
                                <option value="5">⭐️⭐️⭐️⭐️⭐️ - Excellent</option>
                                <option value="4">⭐️⭐️⭐️⭐️ - Good</option>
                                <option value="3">⭐️⭐️⭐️ - Average</option>
                                <option value="2">⭐️⭐️ - Poor</option>
                                <option value="1">⭐️ - Bad</option>
                            </select>
                        </div>
                        <!-- Comment Input -->
                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-semibold">Your Comment:</label>
                            <textarea name="comment_content" class="form-control" rows="4" placeholder="Share your thoughts..." required></textarea>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane me-2"></i> Submit Feedback</button>
                </form>
            </div>
        @endauth

        <!-- Display Ratings and Comments -->
        <div class="row">
            <!-- Ratings List -->
            <div class="col-md-6 mb-4">
                <div class="ratings-comments-card">
                    <h5 class="fw-bold"><i class="fas fa-star me-2"></i> Ratings ({{ $research->ratings->count() }})</h5>
                    @if($research->ratings->isEmpty())
                        <p class="text-muted">No ratings yet.</p>
                    @else
                        <ul class="list-group">
                            @foreach($research->ratings as $rating)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div >
                                        <i class="fas fa-user-circle user-icon me-3"></i>
                                        <strong class="ml-2">{{ $rating->user->name }}</strong>
                                        <small class="d-block text-muted">{{ date('M d, Y h:i A', strtotime($rating->date)) }}</small>
                                    </div>
                                    <span class="badge bg-warning">
                                        <i class="fas fa-star me-1"></i> {{ number_format($rating->rating_value, 1) }} / 5
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
            <!-- Comments List -->
            <div class="col-md-6 mb-4">
                <div class="ratings-comments-card">
                    <h5 class="fw-bold"><i class="fas fa-comment-alt me-2"></i> Comments ({{ $research->comments->count() }})</h5>
                    @if($research->comments->isEmpty())
                        <p class="text-muted">No comments yet.</p>
                    @else
                        <ul class="list-group">
                            @foreach($research->comments as $comment)
                                <li class="list-group-item">
                                    <div class="d-flex align-items-start">
                                        <i class="fas fa-user-circle user-icon me-3"></i>
                                        <div class="ml-2">
                                            <strong>{{ $comment->user->name }}</strong>
                                            <p class="mb-1 text-muted">{{ $comment->content }}</p>
                                            <small class="text-muted">{{ date('M d, Y h:i A', strtotime($comment->date)) }}</small>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
