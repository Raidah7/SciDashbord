@extends('admin.layouts.app')

@section('title', 'Reports & Analytics')

@section('content')

    <div class="container-fluid">
        <h2 class="title mt-3"><i class="fas fa-chart-bar"></i> Reports & Analytics</h2>

        <!-- Quick Report Actions -->
        <div class="row mb-4">
            <div class="col-md-4">
                <a href="{{ route('admin.reports.export', 'users') }}" class="btn btn-primary w-100">
                    <i class="fas fa-users"></i> Export User Report
                </a>
            </div>
            <div class="col-md-4">
                <a href="{{ route('admin.reports.export', 'research') }}" class="btn btn-success w-100">
                    <i class="fas fa-book"></i> Export Research Report
                </a>
            </div>
            <div class="col-md-4">
                <a href="{{ route('admin.reports.export', 'comments') }}" class="btn btn-warning w-100">
                    <i class="fas fa-comments"></i> Export Comments Report
                </a>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card shadow-sm p-4">
                    <h5><i class="fas fa-chart-line"></i> User Growth Over Time</h5>
                    <div id="userGrowthChart"></div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow-sm p-4">
                    <h5><i class="fas fa-chart-pie"></i> Research Status Distribution</h5>
                    <div id="researchStatusChart"></div>
                </div>
            </div>
        </div>

    </div>

@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // User Growth Chart (Line)
            let userGrowthOptions = {
                series: [{
                    name: 'New Users',
                    data: @json($userGrowthData)
                }],
                chart: {
                    type: 'area',
                    height: 350
                },
                xaxis: {
                    categories: @json($userGrowthLabels),
                    labels: { rotate: -45 }
                },
                colors: ['#008FFB']
            };

            // Research Status Chart (Pie)
            let researchStatusOptions = {
                series: Object.values(@json($researchStatusCounts)),
                chart: {
                    type: 'pie',
                    height: 350
                },
                labels: Object.keys(@json($researchStatusCounts)),
                colors: ['#00E396', '#FEB019', '#FF4560', '#775DD0']
            };

            new ApexCharts(document.querySelector("#userGrowthChart"), userGrowthOptions).render();
            new ApexCharts(document.querySelector("#researchStatusChart"), researchStatusOptions).render();
        });
    </script>
@endpush
