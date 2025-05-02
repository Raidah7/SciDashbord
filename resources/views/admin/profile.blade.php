@extends('admin.layouts.app')

@section('title', 'Update Profile')

@section('content')

    <div class="container">
        <div class="card mt-4">
            <div class="card-header">
                <h2><i class="fas fa-user-edit"></i> Update Profile</h2>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form action="{{ route('admin.profile.update') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-6 mb-3">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $admin->name) }}" required>
                        </div>
                        <div class="form-group col-md-6 mb-3">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', $admin->email) }}" required>
                        </div>
                        <div class="form-group col-md-6 mb-3">
                            <label>Password (Optional)</label>
                            <input type="password" name="password" class="form-control">
                        </div>
                        <div class="form-group col-md-6 mb-3">
                            <label>Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3"><i class="fas fa-save"></i> Save Changes</button>
                </form>
            </div>
        </div>
    </div>

@endsection
