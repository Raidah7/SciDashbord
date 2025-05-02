@extends('admin.layouts.app')

@section('title', 'Research Details')

@section('content')

    <div class="container">
        <div class="card mt-4">
            <div class="card-header">
                <h2><i class="fas fa-file-alt"></i> Research Details</h2>
            </div>
            <div class="card-body">
                <h4 class="fw-bold text-primary">{{ $research->title }}</h4>
                <p class="text-muted">By: {{ $research->researcher->user->name }}</p>
                <p><i class="fas fa-calendar text-warning"></i> Submitted on {{ date('M d, Y', strtotime($research->date_submitted)) }}</p>

                <h5 class="mt-4">Abstract</h5>
                <p>{{ $research->abstract }}</p>

                @if($research->document)
                    <a href="{{ asset($research->document) }}" target="_blank" class="btn btn-primary">
                        <i class="fas fa-file-download"></i> Download Research Paper
                    </a>
                @endif
            </div>
        </div>
    </div>

@endsection
