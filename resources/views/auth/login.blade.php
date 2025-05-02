@extends('front.layouts.app')

@section('content')
    <div class="registration-section py-5 mt-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="card shadow border-0 rounded-3 p-4">
                        <h3 class="text-center fw-bold text-primary mb-4"><i class="fas fa-sign-in-alt"></i> Welcome Back</h3>

                        <!-- Role Selection Boxes -->
                        <div class="role-selection d-flex justify-content-center gap-3 mb-4">
                            <div class="role-box text-center" onclick="selectRole('researcher')">
                                <i class="fas fa-flask text-primary"></i>
                                <h6 class="fw-bold mt-2">Researcher</h6>
                            </div>
                            <div class="role-box text-center" onclick="selectRole('user')">
                                <i class="fas fa-user-graduate text-success"></i>
                                <h6 class="fw-bold mt-2">User</h6>
                            </div>
                            <div class="role-box text-center" onclick="selectRole('admin')">
                                <i class="fas fa-user-cog text-warning"></i>
                                <h6 class="fw-bold mt-2">Admin</h6>
                            </div>
                        </div>

                        <form action="{{ route('auth.login.submit') }}" method="POST">
                            @csrf

                            <!-- Hidden Role Input -->
                            <input type="hidden" name="role" id="selectedRole" value="{{ old('role', 'researcher') }}">

                            <!-- Email -->
                            <div class="mb-3">
                                <label class="form-label fw-bold"><i class="fas fa-envelope"></i> Email Address</label>
                                <input type="email" name="email" class="form-control" placeholder="Enter your email" value="{{ old('email') }}" required>
                                @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <!-- Password -->
                            <div class="mb-3">
                                <label class="form-label fw-bold"><i class="fas fa-lock"></i> Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
                                @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <!-- Remember Me -->
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="remember" name="remember">
                                <label class="form-check-label" for="remember">Remember Me</label>
                            </div>

                            <!-- Login Button -->
                            <button type="submit" class="btn btn-primary w-100"><i class="fas fa-sign-in-alt"></i> Login</button>

                            <!-- Forgot Password & Register Links -->
                            <div class="d-flex justify-content-between mt-3">
                                <a href="{{ route('password.request') }}" class="text-primary">Forgot Password?</a>
                                <a href="{{ route('auth.register') }}" class="text-primary">Create an Account</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        function selectRole(role) {
            document.getElementById('selectedRole').value = role;
            document.querySelectorAll('.role-box').forEach(box => {
                box.classList.remove('active');
            });
            event.currentTarget.classList.add('active');
        }
    </script>
@endpush
