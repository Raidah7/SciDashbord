@extends('researcher.layouts.app')

@section('title', 'Research Ratings')

@section('content')
    <div class="container-fluid">
        <div class="card mt-4">
            <div class="card-header d-flex justify-content-between">
                <h2 class="title"><i class="fas fa-star"></i> Research Ratings</h2>
            </div>
            <div class="card-body">
                @if($ratings->isEmpty())
                    <div class="alert alert-info text-center">
                        <i class="fas fa-info-circle"></i> No ratings available.
                    </div>
                @else
                    <table id="datatable" class="table table-bordered text-center table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Research Title</th>
                            <th>Rating</th>
                            <th>By</th>
                            <th>Date</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($ratings as $index => $rating)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $rating->research->title }}</td>
                                <td>
                                    <span class="badge bg-warning">
                                        <i class="fas fa-star"></i> {{ number_format($rating->rating_value, 1) }} / 5
                                    </span>
                                </td>
                                <td>{{ $rating->user->name }}</td>
                                <td>{{ date('Y-m-d h:i A', strtotime($rating->date)) }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
@endsection
