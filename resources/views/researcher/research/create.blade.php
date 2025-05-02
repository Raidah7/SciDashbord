@extends('researcher.layouts.app')

@section('title', 'Add Research')

@section('content')
    <div class="container-fluid">
        <div class="card mt-4">
            <div class="card-header d-flex justify-content-between">
                <h2 class="title">Add New Research</h2>
                <a href="{{ route('researcher.research.index') }}" class="btn btn-danger mb-3">Back <i class="fa fa-arrow-left"></i></a>
            </div>
            <div class="card-body">
                <form action="{{ route('researcher.research.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @include('researcher.research.form')
                    <button type="submit" class="btn btn-primary mt-3">Add Research</button>
                </form>
            </div>
        </div>
    </div>
@endsection
