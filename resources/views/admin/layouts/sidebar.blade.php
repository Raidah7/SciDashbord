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
                       href="{{ route('admin.dashboard') }}" aria-expanded="false">
                        <span><i class="ti ti-layout-dashboard"></i></span>
                        <span class="hide-menu">Home</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link {{ request()->routeIs('researcher.profile') ? 'active' : '' }}"
                       href="{{ route('admin.profile') }}" aria-expanded="false">
                        <span><i class="ti ti-user"></i></span>
                        <span class="hide-menu">Profile</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link {{ request()->routeIs('admin.users.index') ? 'active' : '' }}"
                       href="{{ route('admin.users.index') }}" aria-expanded="false">
                        <span><i class="ti ti-users"></i></span>
                        <span class="hide-menu">Users</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link {{ request()->is('admin/research*') ? 'active' : '' }}"
                       href="{{ route('admin.research.index') }}" aria-expanded="false">
                        <span><i class="ti ti-book"></i></span>
                        <span class="hide-menu">Research</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link {{ request()->is('admin/comments*') ? 'active' : '' }}"
                       href="{{ route('admin.comments.index') }}" aria-expanded="false">
                        <span><i class="ti ti-message-circle"></i></span>
                        <span class="hide-menu">Comments</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link {{ request()->routeIs('admin/ratings*') ? 'active' : '' }}"
                       href="{{ route('admin.ratings.index') }}" aria-expanded="false">
                        <span><i class="ti ti-star"></i></span>
                        <span class="hide-menu">Ratings</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link {{ request()->is('admin/reports*') ? 'active' : '' }}"
                       href="{{ route('admin.reports.index') }}" aria-expanded="false">
                        <span><i class="ti ti-file"></i></span>
                        <span class="hide-menu">Reports</span>
                    </a>
                </li>


                <li class="sidebar-item">
                    <a class="sidebar-link {{ request()->is('admin/notifications') ? 'active' : '' }}"
                       href="{{ route('admin.notifications.index') }}" aria-expanded="false">
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
