@extends('front.layouts.app')

@section('content')

    <!-- Registration Section -->
    <div class="registration-section py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5">
                    <div class="card shadow-lg border-0 rounded-3 p-4">
                        <h3 class="text-center fw-bold text-primary mb-4"><i class="fas fa-user-plus"></i> Create an Account</h3>

                        <form action="{{ route('register') }}" method="POST">
                            @csrf

                            <!-- Full Name -->
                            <div class="mb-3">
                                <label for="name" class="form-label fw-bold"><i class="fas fa-user"></i> Full Name</label>
                                <input type="text" id="name" name="name" class="form-control" placeholder="Enter your full name" required>
                            </div>

                            <!-- Email -->
                            <div class="mb-3">
                                <label for="email" class="form-label fw-bold"><i class="fas fa-envelope"></i> Email Address</label>
                                <input type="email" id="email" name="email" class="form-control" placeholder="Enter your email" required>
                            </div>

                            <!-- Password -->
                            <div class="mb-3">
                                <label for="password" class="form-label fw-bold"><i class="fas fa-lock"></i> Password</label>
                                <input type="password" id="password" name="password" class="form-control" placeholder="Create a password" required>
                            </div>

                            <!-- Confirm Password -->
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label fw-bold"><i class="fas fa-lock"></i> Confirm Password</label>
                                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Confirm your password" required>
                            </div>

                            <!-- Role Selection -->
                            <div class="mb-3">
                                <label class="form-label fw-bold"><i class="fas fa-user-tag"></i> Register As</label>
                                <select class="form-select" name="role" required>
                                    <option value="researcher">Researcher</option>
                                    <option value="student">Student</option>
                                    <option value="admin">Admin</option>
                                </select>
                            </div>

                            <!-- Terms & Conditions -->
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="terms" required>
                                <label class="form-check-label" for="terms">
                                    I agree to the <a href="#" class="text-primary">Terms and Conditions</a>
                                </label>
                            </div>

                            <!-- Register Button -->
                            <button type="submit" class="btn btn-primary w-100"><i class="fas fa-user-plus"></i> Register</button>

                            <!-- Already Have an Account? -->
                            <p class="text-center mt-3">Already have an account? <a href="{{ route('login') }}" class="text-primary">Login here</a></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
