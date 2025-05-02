@extends('researcher.layouts.app')

@section('title', 'Researcher Dashboard')

@section('content')

    <div class="container-fluid">
        <h2 class="title mt-3"><i class="fas fa-user"></i> Researcher Dashboard</h2>

        <!-- Quick Stats -->
        <div class="row mt-4">
            <div class="col-md-3">
                <div class="card shadow-sm p-2 text-center bg-primary text-white">
                    <span><i class="ti ti-book fa-3x"></i></span>
                    <h5 class="text-white">Total Research</h5>
                    <h2 class="text-white">{{ $totalResearch }}</h2>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm p-2 text-center bg-primary text-white">
                    <span><i class="fa fa-comments fa-3x"></i></span>
                    <h5 class="text-white">Total Comments</h5>
                    <h2 class="text-white">{{ $totalComments }}</h2>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm p-2 text-center bg-primary text-white">
                    <span><i class="ti ti-star fa-3x"></i></span>
                    <h5 class="text-white">Total Ratings</h5>
                    <h2 class="text-white">{{ $totalRatings }}</h2>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm p-2 text-center bg-primary text-white">
                    <span><i class="ti ti-check fa-3x"></i></span>
                    <h5 class="text-white">Approved Research</h5>
                    <h2 class="text-white">{{ $totalApprovedResearch }}</h2>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="row mt-4">
            <div class="col-md-7">
                <div class="card shadow-sm p-4">
                    <h5><i class="fas fa-chart-area"></i> Research Ratings Over Time</h5>
                    <div id="averageRatingChart"></div>
                </div>
            </div>

            <div class="col-md-5">
                <div class="card shadow-sm p-4">
                    <h5><i class="fas fa-chart-pie"></i> Research Status Distribution</h5>
                    <div id="researchStatusChart"></div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card shadow-sm p-4">
                    <h5><i class="fas fa-history"></i> Recent  Activity Rating</h5>
                    <ul class="timeline-widget mb-0 position-relative mb-n5">
                        @foreach($recentRatings as $rating)
                            <li class="timeline-item d-flex position-relative overflow-hidden">
                                <div class="timeline-time text-dark flex-shrink-0 text-end">
                                    {{ date('h:i A', strtotime($rating->date)) }}
                                </div>
                                <div class="timeline-badge-wrap d-flex flex-column align-items-center">
                                    <span class="timeline-badge border-2 border border-warning flex-shrink-0 my-8"></span>
                                    <span class="timeline-badge-border d-block flex-shrink-0"></span>
                                </div>
                                <div class="timeline-desc fs-3 text-dark mt-n1 fw-semibold">
                                    <strong>{{ $rating->user->name }}</strong> rated
                                    <em>{{ $rating->research->title }}</em>
                                    <span class="badge bg-warning">
                                        <i class="fas fa-star"></i> {{ number_format($rating->rating_value, 1) }} / 5
                                    </span>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card shadow-sm p-4">
                    <h5><i class="fas fa-history"></i> Recent Comments</h5>
                    <ul class="timeline-widget mb-0 position-relative mb-n5">
                        @foreach($recentComments as $comment)
                            <li class="timeline-item d-flex position-relative overflow-hidden">
                                <div class="timeline-time text-dark flex-shrink-0 text-end">
                                    {{ date('h:i A', strtotime($comment->date)) }}
                                </div>
                                <div class="timeline-badge-wrap d-flex flex-column align-items-center">
                                    <span class="timeline-badge border-2 border border-primary flex-shrink-0 my-8"></span>
                                    <span class="timeline-badge-border d-block flex-shrink-0"></span>
                                </div>
                                <div class="timeline-desc fs-3 text-dark mt-n1">
                                    <strong>{{ $comment->user->name }}</strong> commented on
                                    <em>{{ $comment->research->title }}</em>:
                                    <span class="text-muted">{{ $comment->content }}</span>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let researchStatusOptions = {
                series: Object.values(@json($researchStatusCounts)),
                chart: {
                    type: 'pie',
                    height: 350
                },
                labels: Object.keys(@json($researchStatusCounts)),
                colors: ['#008FFB', '#00E396', '#FEB019', '#FF4560']
            };

            let averageRatingOptions = {
                series: [{
                    name: 'Rating',
                    data: @json($recentRatings->pluck('rating_value'))
                }],
                chart: {
                    type: 'area',
                    height: 350
                },
                dataLabels: { enabled: false },
                stroke: { curve: 'smooth' },
                xaxis: {
                    categories: @json($recentRatings->pluck('created_at')->map(fn($date) => date('Y-m-d', strtotime($date)))),
                    labels: { rotate: -45 }
                },
                colors: ['#4648be']
            };

            new ApexCharts(document.querySelector("#researchStatusChart"), researchStatusOptions).render();
            new ApexCharts(document.querySelector("#averageRatingChart"), averageRatingOptions).render();
        });
    </script>
@endpush
