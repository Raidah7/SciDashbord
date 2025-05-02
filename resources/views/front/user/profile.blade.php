@extends('front.layouts.app')

@section('title', 'Update Profile')

@section('content')

    <div class="container pt-4">
        <div class="card mt-4 w-50 m-auto ">
            <div class="card-header">
                <h2>Update Profile</h2>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form class="" action="{{ route('user.profile.update') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-12 mb-3">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', auth()->user()->name) }}" required>
                        </div>
                        <div class="form-group col-md-12 mb-3">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', auth()->user()->email) }}" required>
                        </div>
                        <div class="form-group col-md-12 mb-3">
                            <label>Password (Optional)</label>
                            <input type="password" name="password" class="form-control">
                        </div>
                        <div class="form-group col-md-12 mb-3">
                            <label>Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Save Changes</button>
                </form>
            </div>
        </div>
    </div>

@endsection
