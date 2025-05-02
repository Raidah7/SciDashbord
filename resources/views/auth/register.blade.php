@extends('front.layouts.app')

@section('content')
    <div class="registration-section py-5  mt-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="card shadow border-0 rounded-3 p-4">
                        <h3 class="text-center fw-bold text-primary mb-4"><i class="fas fa-user-plus"></i> Create an Account</h3>

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
                        </div>

                        <form action="{{ route('auth.register.submit') }}" method="POST">
                            @csrf

                            <!-- Hidden Role Input -->
                            <input type="hidden" name="role" id="selectedRole" value="{{ old('role', 'researcher') }}">

                            <!-- Full Name -->
                            <div class="mb-3">
                                <label class="form-label fw-bold"><i class="fas fa-user"></i> Full Name</label>
                                <input type="text" name="name" class="form-control" placeholder="Enter your full name" value="{{ old('name') }}" required>
                                @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <!-- Email -->
                            <div class="mb-3">
                                <label class="form-label fw-bold"><i class="fas fa-envelope"></i> Email Address</label>
                                <input type="email" name="email" class="form-control" placeholder="Enter your email" value="{{ old('email') }}" required>
                                @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <!-- Researcher Fields -->
                            <div id="researcherFields" class="d-none">
                                <div class="mb-3">
                                    <label class="form-label fw-bold"><i class="fas fa-university"></i> Institution</label>
                                    <input type="text" name="institution" class="form-control" placeholder="Enter your institution" value="{{ old('institution') }}">
                                    @error('institution') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold"><i class="fas fa-lightbulb"></i> Expertise</label>
                                    <input type="text" name="expertise" class="form-control" placeholder="Enter your expertise" value="{{ old('expertise') }}">
                                    @error('expertise') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <!-- Password -->
                            <div class="mb-3">
                                <label class="form-label fw-bold"><i class="fas fa-lock"></i> Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Create a password" required>
                                @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div class="mb-3">
                                <label class="form-label fw-bold"><i class="fas fa-lock"></i> Confirm Password</label>
                                <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm your password" required>
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
            document.getElementById('researcherFields').classList.toggle('d-none', role !== 'researcher');
        }
    </script>
@endpush
