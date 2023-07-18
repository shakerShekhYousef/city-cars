<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    {{-- <a href="index3.html" class="brand-link">
        <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a> --}}

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class=" mt-3 pb-3 mb-3">
            @auth
                <div class="user-panel mt-3 pb-1 mb-1 d-flex">
                    <div class="image">
                        @if (Auth::user()->image)
                            <img src="{{ Auth::user()->image }}" class="img-circle elevation-2" alt="">
                        @endif
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">Admin</a>
                    </div>
                </div>
            @endauth
        </div>

        <!-- SidebarSearch Form -->
        {{-- <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div> --}}

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                    with font-awesome or any other icon font library -->
                <li
                    class="nav-item {{ Route::currentRouteName() == 'userslist' || Route::currentRouteName() == 'userscreate' ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-user"></i>
                        <p>
                            Users Managements
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('userslist') }}"
                                class="nav-link {{ Route::currentRouteName() == 'userslist' ? 'active' : '' }}">
                                <i class="nav-icon fas fa-duotone fa-bars"></i>
                                <p>List Users</p>
                            </a>
                        </li>
                        @if (Auth::user()->role == 'Admin')
                            <li class="nav-item">
                                <a href="{{ route('userscreate') }}"
                                    class="nav-link {{ Route::currentRouteName() == 'userscreate' ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Create Admin</p>
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
                <li
                    class="nav-item {{ Route::currentRouteName() == 'emailus' || Route::currentRouteName() == 'contactus' || Route::currentRouteName() == 'about' || Route::currentRouteName() == 'terms' || Route::currentRouteName() == 'privacypolicy' ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-solid fa-home"></i>
                        <p>
                            Home Content
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('about') }}"
                                class="nav-link {{ Route::currentRouteName() == 'about' ? 'active' : '' }}">
                                <i class="nav-icon far fa-duotone fa-circle"></i>
                                <p>About</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('terms') }}"
                                class="nav-link {{ Route::currentRouteName() == 'terms' ? 'active' : '' }}">
                                <i class="nav-icon far  fa-circle"></i>
                                <p>Terms</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('privacypolicy') }}"
                                class="nav-link {{ Route::currentRouteName() == 'privacypolicy' ? 'active' : '' }}">
                                <i class="nav-icon far fa-circle "></i>
                                <p>Privacy Policy</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('contactus') }}"
                                class="nav-link {{ Route::currentRouteName() == 'contactus' ? 'active' : '' }}">
                                <i class="nav-icon far  fa-circle"></i>
                                <p>Contact Us</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('emailus') }}"
                                class="nav-link {{ Route::currentRouteName() == 'emailus' ? 'active' : '' }}">
                                <i class="nav-icon far fa-circle"></i>
                                <p>Email Us</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li
                    class="nav-item {{ Route::currentRouteName() == 'cartypeslist' || Route::currentRouteName() == 'cartypescreate' ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-solid fa-car"></i>
                        <p>
                            Car Types Managements
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('cartypeslist') }}"
                                class="nav-link {{ Route::currentRouteName() == 'cartypeslist' ? 'active' : '' }}">
                                <i class="nav-icon fas fa-duotone fa-bars"></i>
                                <p>List Car Types</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('cartypescreate') }}"
                                class="nav-link {{ Route::currentRouteName() == 'cartypescreate' ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Create Car Type</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li
                    class="nav-item {{ Route::currentRouteName() == 'carmodelslist' || Route::currentRouteName() == 'carmodelscreate' ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link ">
                        <i class="nav-icon fas fa-solid fa-car"></i>
                        <p>
                            Car Models Managements
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview ">
                        <li class="nav-item ">
                            <a href="{{ route('carmodelslist') }}"
                                class="nav-link {{ Route::currentRouteName() == 'carmodelslist' ? 'active' : '' }}">
                                <i class="nav-icon fas fa-duotone fa-bars"></i>
                                <p>List Car Models</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('carmodelscreate') }}"
                                class="nav-link {{ Route::currentRouteName() == 'carmodelscreate' ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Create Car Model</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li
                    class="nav-item {{ Route::currentRouteName() == 'cardslist' || Route::currentRouteName() == 'cardscreate' ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-credit-card"></i>
                        <p>
                            Cards Managements
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('cardslist') }}"
                                class="nav-link {{ Route::currentRouteName() == 'cardslist' ? 'active' : '' }}">
                                <i class="nav-icon fas fa-duotone fa-bars"></i>
                                <p>List Cards</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('cardscreate') }}"
                                class="nav-link {{ Route::currentRouteName() == 'cardscreate' ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Create Card</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item {{ Route::currentRouteName() == 'lists' ? 'menu-open' : '' }}">
                    <a href="{{ route('lists') }}" class="nav-link">
                        <i class="nav-icon fas fa fa-bell"></i>
                        <p>
                            Notifications
                        </p>
                    </a>
                </li>
                <li class="nav-item {{ Route::currentRouteName() == 'driverprcentage' ? 'menu-open' : '' }}">
                    <a href="{{ route('driverprcentage') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>
                            Driver Percentage
                        </p>
                    </a>
                </li>
                <li class="nav-item {{ Route::currentRouteName() == 'tripreports' ? 'menu-open' : '' }}">
                    <a href="{{ route('tripreports') }}" class="nav-link">
                        {{-- <i class="far fa-circle nav-icon"></i> --}}
                        <i class="far fa-file nav-icon"></i>
                        {{-- <i class="fa-solid fa-file-chart-column"></i> --}}
                        <p>
                            Trip Reports
                        </p>
                    </a>
                </li>
                <li class="nav-item {{ Route::currentRouteName() == 'review' ? 'menu-open' : '' }}">
                    <a href="{{ route('review') }}" class="nav-link">
                        {{-- <i class="far fa-circle nav-icon"></i> --}}
                        <i class="far fa-file nav-icon"></i>
                        {{-- <i class="fa-solid fa-file-chart-column"></i> --}}
                        <p>
                            Reviews
                        </p>
                    </a>
                </li>

                <li
                    class="nav-item {{ Route::currentRouteName() == 'promocodeslist' || Route::currentRouteName() == 'promocodescreate' ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-tags"></i>
                        <p>
                            Promos Managements
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('promocodeslist') }}"
                                class="nav-link {{ Route::currentRouteName() == 'promocodeslist' ? 'active' : '' }}">
                                <i class="nav-icon fas fa-duotone fa-bars"></i>
                                <p>List Promo Codes</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('promocodescreate') }}"
                                class="nav-link {{ Route::currentRouteName() == 'promocodescreate' ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Create Promo Code</p>
                            </a>
                        </li>
                    </ul>
                </li>

        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
