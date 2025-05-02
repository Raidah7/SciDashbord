@extends('researcher.layouts.app')

@section('title', 'Update Profile')

@section('content')

    <div class="container">
        <div class="card mt-4">
            <div class="card-header d-flex justify-content-between">
                <h2 class="title">Update Profile</h2>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <form action="{{ route('researcher.profile.update') }}" method="POST">
                    @csrf

                    <div class="row">
                        <!-- Name -->
                        <div class="form-group col-md-6 mb-3">
                            <label for="name">Name</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', auth()->user()->name) }}" required>
                            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <!-- Email -->
                        <div class="form-group col-md-6 mb-3">
                            <label for="email">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', auth()->user()->email) }}" required>
                            @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <!-- Institution -->
                        <div class="form-group col-md-6 mb-3">
                            <label for="institution">Institution</label>
                            <input type="text" name="institution" class="form-control" value="{{ old('institution', $researcher->institution) }}">
                            @error('institution') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <!-- Expertise -->
                        <div class="form-group col-md-6 mb-3">
                            <label for="expertise">Expertise</label>
                            <input type="text" name="expertise" class="form-control" value="{{ old('expertise', $researcher->expertise) }}">
                            @error('expertise') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <!-- Password (Optional) -->
                        <div class="form-group col-md-6 mb-3">
                            <label for="password">Password (Optional)</label>
                            <input type="password" name="password" class="form-control">
                            <small class="text-muted">Leave blank if you do not want to change it.</small>
                            @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="form-group col-md-6 mb-3">
                            <label for="password_confirmation">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary mt-3">Save Changes</button>
                </form>
            </div>
        </div>
    </div>

@endsection
