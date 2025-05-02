@extends('researcher.layouts.app')

@section('title', 'Edit Research')

@section('content')
    <div class="container-fluid">
        <div class="card mt-4">
            <div class="card-header d-flex justify-content-between">
                <h2 class="title">Edit Research</h2>
                <a href="{{ route('researcher.research.index') }}" class="btn btn-danger mb-3">Back <i class="fa fa-arrow-left"></i></a>
            </div>
            <div class="card-body">
                <form action="{{ route('researcher.research.update', $research->research_id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    @include('researcher.research.form', ['research' => $research])
                    <button type="submit" class="btn btn-primary mt-3">Update Research</button>
                </form>
            </div>
        </div>
    </div>
@endsection
