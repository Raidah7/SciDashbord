@extends('front.layouts.app')

@section('content')
    <div class="container mt-5">
        <h2 class="mb-5 fw-bold text-center text-primary">📊 General Research Dashboard</h2>

        <!-- Stats Cards -->
        <div class="row text-white mb-4 g-3">
            @php
                $cards = [
                    ['title' => 'Total Research', 'value' => $totalResearch, 'color' => 'primary', 'icon' => 'book'],
                    ['title' => 'Researchers', 'value' => $totalResearchers, 'color' => 'success', 'icon' => 'users'],
                    ['title' => 'Comments', 'value' => $totalComments, 'color' => 'warning', 'icon' => 'comments'],
                    ['title' => 'Ratings', 'value' => $totalRatings, 'color' => 'danger', 'icon' => 'star']
                ];
            @endphp

            @foreach ($cards as $card)
                <div class="col-md-3">
                    <div style="    background: #5c95e1 !important;" class="card  shadow p-3 h-100">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-white-50">{{ $card['title'] }}</h6>
                                <h3>{{ $card['value'] }}</h3>
                            </div>
                            <i class="fa fa-{{ $card['icon'] }} fa-3x"></i>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Charts Grid -->
        <div class="row g-4 mt-2">

            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header fw-semibold"> Yearly Submissions </div>
                    <div class="card-body"><div id="lineChart"></div></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header fw-semibold"> Growth Over Time </div>
                    <div class="card-body"><div id="areaChart"></div></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card shadow my-5">
                    <div class="card-header fw-semibold"> Research Count by Field </div>
                    <div class="card-body"><div id="barChart"></div></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card shadow my-5">
                    <div class="card-header fw-bold"> Latest Activities</div>
                    <div class="card-body">
                        <ul class="list-group">
                            @foreach ($latest as $item)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>
                            📄 <strong>{{ $item->title }}</strong> — <small class="text-muted">{{ $item->fields }}</small>
                        </span>
                                    <span class="badge bg-light text-dark">{{ \Carbon\Carbon::parse($item->date_submitted)->format('Y-m-d') }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

        </div>

        <!-- Latest Activity -->

    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        // Bar Chart
        new ApexCharts(document.querySelector("#barChart"), {
            chart: { type: 'bar', height: 300 },
            series: [{ name: 'Count', data: @json($researchCounts->pluck('total')) }],
            xaxis: {
                categories: @json($researchCounts->pluck('fields')),
                title: { text: 'Fields' }
            }
        }).render();

        // Line Chart
        new ApexCharts(document.querySelector("#lineChart"), {
            chart: { type: 'line', height: 300 },
            series: [{ name: 'Publications', data: @json($yearlyPublications->pluck('total')) }],
            xaxis: {
                categories: @json($yearlyPublications->pluck('year')),
                title: { text: 'Year' }
            }
        }).render();

        // Pie Chart
        new ApexCharts(document.querySelector("#pieChart"), {
            chart: { type: 'pie', height: 300 },
            series: @json($researchCounts->pluck('total')),
            labels: @json($researchCounts->pluck('fields'))
        }).render();

        // Area Chart
        new ApexCharts(document.querySelector("#areaChart"), {
            chart: { type: 'area', height: 300 },
            series: [{
                name: 'Research Growth',
                data: @json($yearlyPublications->pluck('total'))
            }],
            xaxis: {
                categories: @json($yearlyPublications->pluck('year')),
                title: { text: 'Year' }
            }
        }).render();
    </script>
@endsection
