@extends('front.layouts.app')
@push('css')
    <style>
        /* Researcher Profile Section */
        .researcher-profile-section {
            background: #f8f9fa;
        }

        .card {
            background: #fff;
            border-radius: 10px;
        }

        .btn-primary {
            font-weight: bold;
            padding: 10px;
            border-radius: 5px;
        }

        .form-label {
            font-weight: 600;
        }

    </style>
@endpush
@section('content')

    <!-- Researcher Profile Section -->
    <div class="researcher-profile-section py-5">
        <div class="container">
            <div class="row justify-content-center">
                <!-- Researcher Info -->
                <div class="col-lg-8">
                    <div class="card shadow border-0 rounded-3 p-4">
                        <div class="d-flex align-items-center">
                           <i class="fa fa-user fa-2x rounded border-dark"></i>
                            <div>
                                <h3 class="fw-bold text-primary mb-1">Dr. John Doe</h3>
                                <p class="text-muted">Professor of Artificial Intelligence & Machine Learning</p>
                                <p><i class="fas fa-envelope text-primary"></i> johndoe@example.com</p>
                            </div>
                        </div>
                        <p class="mt-3">Dr. John Doe is a leading researcher in AI and Data Science, with over 10 years of experience in academic research and industry applications.</p>
                    </div>
                </div>
            </div>

            <!-- Research Papers Section -->
            <div class="row justify-content-center mt-5">
                <div class="col-lg-8">
                    <h4 class="fw-bold text-primary"><i class="fas fa-book"></i> Published Research</h4>
                    <div class="list-group shadow-sm rounded">
                        @foreach(range(1, 5) as $index)
                            <div class="list-group-item p-3">
                                <h5 class="fw-bold text-dark"><i class="fas fa-file-alt"></i> Research Paper Title {{ $index }}</h5>
                                <p class="text-muted">This research explores advancements in {{ ['Artificial Intelligence', 'Machine Learning', 'Data Science', 'Neural Networks', 'Robotics'][$index % 5] }} and its applications in modern technology.</p>
                                <small><i class="fas fa-calendar text-warning"></i> Published: {{ now()->subMonths($index)->format('M Y') }}</small> |
                                <small><i class="fas fa-bookmark text-info"></i> {{ rand(50, 500) }} Citations</small>
                                <div class="mt-2">
                                    <a href="#" class="btn btn-outline-primary btn-sm"><i class="fas fa-eye"></i> View Paper</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Comments Section -->
            <div class="row justify-content-center mt-5">
                <div class="col-lg-8">
                    <h4 class="fw-bold text-primary"><i class="fas fa-comments"></i> Comments</h4>

                    <!-- Comment Form -->
                    <div class="card shadow-sm p-3 mb-3">
                        <h6 class="fw-bold">Leave a Comment</h6>
                        <form>
                            <div class="mb-3">
                                <input type="text" class="form-control" placeholder="Your Name" required>
                            </div>
                            <div class="mb-3">
                                <textarea class="form-control" rows="3" placeholder="Write your comment here..." required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-paper-plane"></i> Submit</button>
                        </form>
                    </div>

                    <!-- Fake Comments -->
                    <div class="list-group shadow-sm rounded">
                        @foreach(['Alice Johnson', 'Mark Smith', 'Sophia Lee', 'David Brown'] as $name)
                            <div class="list-group-item p-3">
                                <h6 class="fw-bold text-dark"><i class="fas fa-user-circle"></i> {{ $name }}</h6>
                                <p class="text-muted">This research is truly groundbreaking! I really appreciate the insights provided.</p>
                                <small><i class="fas fa-clock text-secondary"></i> {{ now()->subHours(rand(1, 48))->diffForHumans() }}</small>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
