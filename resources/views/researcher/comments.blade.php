@extends('researcher.layouts.app')

@section('title', 'Research Comments')

@section('content')
    <div class="container-fluid">
        <div class="card mt-4">
            <div class="card-header d-flex justify-content-between">
                <h2 class="title"><i class="fas fa-comments"></i> Research Comments</h2>
            </div>
            <div class="card-body">
                @if($comments->isEmpty())
                    <div class="alert alert-info text-center">
                        <i class="fas fa-info-circle"></i> No comments available.
                    </div>
                @else
                    <table id="datatable" class="table table-bordered text-center table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Research Title</th>
                            <th>Comment</th>
                            <th>By</th>
                            <th>Date</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($comments as $index => $comment)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $comment->research->title }}</td>
                                <td>{{ $comment->content }}</td>
                                <td>{{ $comment->user->name }}</td>
                                <td>{{ date('Y-m-d h:i A', strtotime($comment->date)) }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
@endsection
