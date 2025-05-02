@extends('front.layouts.app')

@section('title', 'User Dashboard')

@section('content')

    <div class="container mt-4">
        <h2 class="title mt-3 pt-2"><i class="fas fa-user"></i> User Dashboard</h2>

        <!-- Quick Stats -->
        <div class="row">
            <div class="col-md-3">
                <div class="card shadow-sm p-3 text-center bg-primary text-white">
                    <span class="icon-box"><i class="fas fa-comments fa-3x"></i></span>
                    <h5>Total Comments</h5>
                    <h2>{{ $totalComments }}</h2>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm p-3 text-center bg-primary text-white">
                    <span class="icon-box"><i class="fas fa-star fa-3x"></i></span>
                    <h5>Total Ratings</h5>
                    <h2>{{ $totalRatings }}</h2>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm p-3 text-center bg-primary text-white">
                    <span class="icon-box"><i class="fas fa-book-open fa-3x"></i></span>
                    <h5>Research Read</h5>
                    <h2>{{ $totalResearchRead }}</h2>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm p-3 text-center bg-primary text-white">
                    <span class="icon-box"><i class="fas fa-trophy fa-3x"></i></span>
                    <h5>Points Earned</h5>
                    <h2>{{ $totalPoints ?? 0 }}</h2>
                </div>
            </div>
        </div>
        <!-- Recent Activity Timeline -->
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card shadow-sm p-4">
                    <h5><i class="fas fa-chart-pie"></i> Research Categories You Interacted With</h5>
                    <div id="researchCategoryChart"></div>
                </div>
            </div>
            <div class="col-md-6">
                <div style="    overflow: hidden;" class="card shadow-sm p-4">
                    <h5><i class="fas fa-history"></i> Recent Activity</h5>
                    <ul style="    height: 238px;
    overflow-y: scroll;" class="timeline-widget mb-0 position-relative mb-n5">
                        @foreach($recentActivity as $activity)
                            <li class="timeline-item d-flex position-relative overflow-hidden">
                                <div class="timeline-time text-primary flex-shrink-0 text-end">
                                    {{ date('h:i A', strtotime($activity->date)) }}
                                </div>
                                <div class="timeline-badge-wrap d-flex flex-column align-items-center">
                                    <span class="timeline-badge border-2 border border-white flex-shrink-0 my-8"></span>
                                    <span class="timeline-badge-border d-block flex-shrink-0"></span>
                                </div>
                                <div class="timeline-desc fs-5 text-dark mt-n1">
                                    <strong>{{ $activity->type }}:</strong> {{ $activity->description }}
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card shadow-sm p-4">
                    <h5><i class="fas fa-chart-line"></i> Your Activity Over Time</h5>
                    <div id="userActivityChart"></div>
                </div>
            </div>


        </div>


    </div>

@endsection

@push('css')
    <style>
        .icon-box {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 10px;
        }

        .card h2 {
            font-size: 2rem;
            margin-top: 10px;
        }

        .timeline-widget {
            list-style: none;
            padding: 0;
        }

        .timeline-item {
            padding: 10px;
            border-left: 3px solid #007bff;
            position: relative;
        }

        .timeline-item:before {
            content: '';
            width: 12px;
            height: 12px;
            background-color: #007bff;
            position: absolute;
            left: -8px;
            top: 50%;
            transform: translateY(-50%);
            border-radius: 50%;
        }
    </style>
@endpush

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // User Activity Chart (Area Chart)
            let userActivityOptions = {
                series: [{
                    name: 'Activity Count',
                    data: @json($userActivityData)
                }],
                chart: {
                    type: 'area',
                    height: 350
                },
                xaxis: {
                    categories: @json($userActivityLabels),
                    labels: { rotate: -45 }
                },
                colors: ['#008FFB']
            };

            // Research Category Chart (Pie)
            let researchCategoryOptions = {
                series: Object.values(@json($researchCategoryCounts)),
                chart: {
                    type: 'pie',
                    height: 350
                },
                labels: Object.keys(@json($researchCategoryCounts)),
                colors: ['#00E396', '#1a2e8d', '#FF4560', '#a998e6', '#546E7A']
            };

            new ApexCharts(document.querySelector("#userActivityChart"), userActivityOptions).render();
            new ApexCharts(document.querySelector("#researchCategoryChart"), researchCategoryOptions).render();
        });
    </script>
@endpush
