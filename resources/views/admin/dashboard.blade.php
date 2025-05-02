@extends('admin.layouts.app')

@section('title', 'Admin Dashboard')

@section('content')

    <div class="container-fluid">
        <h2 class="title mt-3"><i class="fas fa-user-shield"></i> Admin Dashboard</h2>

        <!-- Quick Stats -->
        <div class="row">

            <div class="col-md-3">
                <div class="card shadow-sm p-2 text-center bg-primary text-white">
                    <span><i class="fas fa-users fa-3x mt-3"></i></span>
                    <h5 class="text-white">Total Users</h5>
                    <h2 class="text-white">{{ $totalUsers }}</h2>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm p-2 text-center bg-primary text-white">
                    <span><i class="fas fa-book fa-3x mt-3"></i></span>
                    <h5 class="text-white">Total Research Papers</h5>
                    <h2 class="text-white">{{ $totalResearch }}</h2>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm p-2 text-center bg-primary text-white">
                    <span><i class="fas fa-comment fa-3x mt-3"></i></span>
                    <h5 class="text-white">Total Comments</h5>
                    <h2 class="text-white">{{ $totalComments }}</h2>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm p-2 text-center bg-primary text-white">
                    <span><i class="fas fa-comment fa-3x mt-3"></i></span>
                    <h5 class="text-white">Total Pending Research</h5>
                    <h2 class="text-white">{{ $totalPendingResearch }}</h2>
                </div>
            </div>
        </div>
    </div>

@endsection
