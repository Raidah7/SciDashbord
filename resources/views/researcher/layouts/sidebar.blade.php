<!-- Sidebar Start -->
<aside class="left-sidebar">
    <div>
        <div class="brand-logo mt-3 d-flex align-items-center justify-content-center">
            <a href="#" class="text-nowrap logo-img">
                    <img style="height: 70px;width: 99px;" src="{{ asset('logo1.png') }}" />
            </a>
            <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                <i class="ti ti-x fs-8"></i>
            </div>
        </div>

        <!-- عرض اسم المستخدم ودوره -->
        <div class="user-info text-center p-3  rounded">
            <h6 class="mb-0"> welcome : {{auth()->user()->name }}  </h6>
            <small class="text-muted">{{ auth()->user()->role }}</small>
        </div>

        <nav class="sidebar-nav scroll-sidebar mt-3" data-simplebar="">
            <ul id="sidebarnav">
                <li class="sidebar-item">
                    <a class="sidebar-link {{ request()->routeIs('researcher.dashboard') ? 'active' : '' }}"
                       href="{{ route('researcher.dashboard') }}" aria-expanded="false">
                        <span><i class="ti ti-layout-dashboard"></i></span>
                        <span class="hide-menu">Home</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link {{ request()->routeIs('researcher.profile') ? 'active' : '' }}"
                       href="{{ route('researcher.profile') }}" aria-expanded="false">
                        <span><i class="ti ti-user"></i></span>
                        <span class="hide-menu">Profile</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link {{ request()->routeIs('researcher.research.*') ? 'active' : '' }}"
                       href="{{ route('researcher.research.index') }}" aria-expanded="false">
                        <span><i class="ti ti-book"></i></span>
                        <span class="hide-menu">My Research</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link {{ request()->routeIs('researcher.comments') ? 'active' : '' }}"
                       href="{{ route('researcher.comments') }}" aria-expanded="false">
                        <span><i class="ti ti-message-circle"></i></span>
                        <span class="hide-menu">Comments</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link {{ request()->routeIs('researcher.ratings') ? 'active' : '' }}"
                       href="{{ route('researcher.ratings') }}" aria-expanded="false">
                        <span><i class="ti ti-star"></i></span>
                        <span class="hide-menu">Ratings</span>
                    </a>
                </li>


                <li class="sidebar-item">
                    <a class="sidebar-link {{ request()->routeIs('researcher.notifications') ? 'active' : '' }}"
                       href="{{ route('researcher.notifications') }}" aria-expanded="false">
                        <span><i class="ti ti-bell"></i></span>
                        <span class="hide-menu">Notifications</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a onclick="confirmLogout()" class="sidebar-link"
                       href="#" aria-expanded="false">
                        <span><i class="ti ti-logout"></i></span>
                        <span class="hide-menu">Logout</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
