@extends('front.layouts.app')

@section('content')

    <!-- Forgot Password Section -->
    <div class="forgot-password-section py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5">
                    <div class="card shadow border-0 rounded-3 p-4">
                        <h3 class="text-center fw-bold text-primary mb-4"><i class="fas fa-key"></i> Forgot Your Password?</h3>
                        <p class="text-center text-muted">Enter your email address, and we'll send you a link to reset your password.</p>

                        <form action="#" method="POST">
                            @csrf

                            <!-- Email -->
                            <div class="mb-3">
                                <label class="form-label fw-bold"><i class="fas fa-envelope"></i> Email Address</label>
                                <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-primary w-100"><i class="fas fa-paper-plane"></i> Send Password Reset Link</button>

                            <!-- Back to Login -->
                            <p class="text-center mt-3">
                                <a href="#" class="text-primary"><i class="fas fa-arrow-left"></i> Back to Login</a>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
