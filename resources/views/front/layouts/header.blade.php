{{--<div class="top-header text-end py-2" id="topHeader">--}}
{{--    <div class="container">--}}
{{--        <div class="d-flex justify-content-between align-items-center">--}}
{{--            <div class="contact-info">--}}
{{--                <a href="tel:+966123456789" class="me-3 text-white"><i class="fas fa-phone-alt"></i> +966 123 456 789</a>--}}
{{--                <a href="mailto:info@scidashboard.com" class="text-white"><i class="fas fa-envelope"></i> info@scidashboard.com</a>--}}
{{--            </div>--}}
{{--            <div class="social-icons">--}}
{{--                <a class="text-white me-2" href="#"><i class="fab fa-facebook-f"></i></a>--}}
{{--                <a class="text-white me-2" href="#"><i class="fab fa-twitter"></i></a>--}}
{{--                <a class="text-white me-2" href="#"><i class="fab fa-linkedin-in"></i></a>--}}
{{--                <a class="text-white" href="#"><i class="fab fa-researchgate"></i></a>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}

<header class="main-header shadow-sm bg-white py-1" id="mainHeader">
    <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-between">
            <!-- Logo and Home Link -->
            <a href="{{ url('/') }}" class="d-flex align-items-center text-dark text-decoration-none">
                <img class="imgLogo me-2" src="{{ asset('logo1.png') }}" alt="SciDashboard Logo">
                <span class="fs-4 fw-bold"></span>
            </a>

            <!-- Navigation Menu -->
            <ul class="nav col-lg-auto ms-lg-auto justify-content-center mb-md-0 d-none d-lg-flex">
                <li><a href="{{ route('home') }}" class="nav-link px-3 link-secondary {{request()->routeIs('home') ? 'activeClass' : ''}}">Home</a></li>
                <li><a href="{{ route('dashboard') }}" class="nav-link px-3 link-dark {{request()->is('dashboard*') ? 'activeClass' : ''}}">Dashboard </a></li>
                <li><a href="{{ route('research.list') }}" class="nav-link px-3 link-dark {{request()->is('research*') ? 'activeClass' : ''}}">Research Papers</a></li>
                <li><a href="{{ route('contact') }}" class="nav-link px-3 link-dark {{request()->is('contact') ? 'activeClass' : ''}}">Contact Us</a></li>
                @guest
                    <li><a href="{{ route('auth.register') }}" class="nav-link px-3 link-dark {{request()->is('auth/register') ? 'activeClass' : ''}}">Register</a></li>
                    <li><a href="{{ route('auth.login') }}" class="nav-link px-3 link-dark {{request()->is('auth/login') ? 'activeClass' : ''}}">Log In</a></li>
                @endguest
            </ul>

            <!-- Search Box -->
            <div class="search-box position-relative me-3">
                <input type="search" class="form-control" placeholder="Search research, authors...">
                <i class="fas fa-search search-icon position-absolute end-0 pe-2"></i>
            </div>

            <!-- User Dropdown -->
            <div class="dropdown text-end">
                <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" id="dropdownUser1"
                   data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-user rounded-circle"></i>
                </a>
                <ul class="dropdown-menu text-small text-end" aria-labelledby="dropdownUser1">
                    @auth
                        @if(auth()->user()->role == 'admin')
                            <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">Admin Dashboard</a></li>
                        @elseif(auth()->user()->role == 'researcher')
                            <li><a class="dropdown-item" href="{{ route('researcher.dashboard') }}">Researcher Dashboard</a></li>
                            <li><a class="dropdown-item" href="{{ route('researcher.profile') }}">My Profile</a></li>
                            <li><a class="dropdown-item" href="{{ route('researcher.research.index') }}">My Research</a></li>
                        @elseif(auth()->user()->role == 'user')
                            <li><a class="dropdown-item" href="{{ route('user.dashboard') }}">User Dashboard</a></li>
                            <li><a class="dropdown-item" href="{{ route('user.profile') }}">Profile</a></li>
                            <li><a class="dropdown-item" href="{{ route('user.commentsRatings') }}">My Comments & Ratings</a></li>
                        @endif
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('auth.logout') }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger" style="border: none; background: none; cursor: pointer;">
                                    Logout
                                </button>
                            </form>
                        </li>
                    @else
                        <li><a class="dropdown-item" href="{{ route('auth.register') }}">Join SciDashboard</a></li>
                        <li><a class="dropdown-item" href="{{ route('auth.login') }}">Login</a></li>
                    @endauth
                </ul>

            </div>

            <!-- Mobile Menu Toggle -->
            <a href="#" class="burger site-menu-toggle js-menu-toggle d-inline-block d-lg-none light"><span></span></a>
        </div>
    </div>
</header>
