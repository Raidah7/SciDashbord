@extends('family.layouts.app')

@section('title', 'التقارير الواردة من المعلمين')

@section('content')

    <div class="container-fluid">
        <div class="card mt-4">
            <div class="card-header">
                <h2 class="title text-primary"><i class="ti ti-file-text"></i> التقارير الواردة من المعلمين</h2>
            </div>

            <div class="card-body">
                @if($reports->isEmpty())
                    <div class="alert alert-info text-center">
                        <i class="fas fa-info-circle"></i> لا يوجد تقارير متاحة في الوقت الحالي.
                    </div>
                @else
                    <table id="datatable" class="table table-bordered text-center table-striped">
                        <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">المعلم</th>
                            <th class="text-center">نوع التقرير</th>
                            <th class="text-center">المحتوى</th>
                            <th class="text-center">التاريخ</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($reports as $index => $report)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ optional($report->teacher)->name }}</td>
                                <td>{{ $report->report_type }}</td>
                                <td>{{ $report->content }}</td>
                                <td>{{ $report->created_at }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>

@endsection
