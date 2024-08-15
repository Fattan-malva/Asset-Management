<header id="header" class="fixed-top d-flex align-items-center bg-light shadow-sm">
    <div class="container d-flex align-items-center justify-content-between">
        <!-- Logo Image -->
        <img src="{{ asset('assets/img/GSI.png') }}" alt="GSI Logo" class="logo-image me-3">

        <!-- Logo Text -->
        <h1 class="logo me-auto d-none d-md-block">
            <a href="{{ route('shared.home') }}" class="text-dark text-decoration-none">Global Service Indonesia</a>
        </h1>

        <!-- Toggle Button for Mobile -->
        <button class="navbar-toggler d-md-none ms-auto" type="button" data-bs-toggle="offcanvas"
            data-bs-target="#navbarOffcanvas" aria-controls="navbarOffcanvas" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navigation for Desktop -->
        <nav id="navbarMenu" class="navbar collapse d-md-flex">
            <ul class="navbar-nav d-flex flex-row">
                <li class="nav-item"><a href="{{ route('dashboard') }}" class="nav-link">Dashboard</a></li>

                <!-- Inventory Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="inventoryDropdown" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">Asset</a>
                    <ul class="dropdown-menu" aria-labelledby="inventoryDropdown">
                        <li><a class="dropdown-item {{ Request::is('inventorys.total') ? 'active' : '' }}"
                                href="{{ route('inventorys.total') }}">Asset Total</a></li>
                        <li><a class="dropdown-item {{ Request::is('inventorys.index') ? 'active' : '' }}"
                                href="{{ route('inventorys.index') }}">Asset List</a></li>
                        <li><a class="dropdown-item {{ Request::is('inventorys.mapping') ? 'active' : '' }}"
                                href="{{ route('inventorys.mapping') }}">Asset Location</a></li>
                    </ul>
                </li>

                <!-- Activity Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="activityDropdown" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false" onclick="location.href='{{ route('assets.index') }}'">Activity</a>
                    <ul class="dropdown-menu" aria-labelledby="activityDropdown">
                        <li>
                            <a class="dropdown-item {{ Request::is('assets/create') ? 'active' : '' }}"
                                href="{{ route('assets.create') }}"
                                style="background-color: rgba(40, 167, 69, 0.2); color: black; border-radius: 2rem; margin-bottom: 0.2rem; margin-left: 0.4rem;">
                                Handover
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ Request::is('assets/index') ? 'active' : '' }}"
                                href="{{ route('assets.indexmutasi') }}"
                                style="background-color: rgba(255, 193, 7, 0.2); color: black; border-radius: 2rem; margin-bottom: 0.2rem; margin-left: 0.4rem;">
                                Mutasi
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ Request::is('assets/index') ? 'active' : '' }}"
                                href="{{ route('assets.index') }}"
                                style="background-color: rgba(220, 53, 69, 0.2); color: black; border-radius: 2rem; margin-bottom: 0.2rem; margin-left: 0.4rem;">
                                Return
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ Request::is('assets/history') ? 'active' : '' }}"
                                href="{{ route('assets.history') }}">
                                History
                            </a>
                        </li>
                    </ul>
                </li>




                <!-- Configuration Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="configDropdown" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">Setting</a>
                    <ul class="dropdown-menu" aria-labelledby="configDropdown">
                        <li><a class="dropdown-item {{ Request::is('customer.index') ? 'active' : '' }}"
                                href="{{ route('customer.index') }}">Users</a></li>
                        <li><a class="dropdown-item {{ Request::is('inventorys.create') ? 'active' : '' }}"
                                href="{{ route('inventorys.create') }}"> + Assets</a></li>
                        <li><a class="dropdown-item {{ Request::is('merk.create') ? 'active' : '' }}"
                                href="{{ route('merk.create') }}"> + Merk</a></li>
                    </ul>
                </li>

                <li class="nav-item"><a href="{{ route('logout') }}" class="nav-link"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                </li>
            </ul>
        </nav>
    </div>

    <!-- Offcanvas Navigation for Mobile -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="navbarOffcanvas" aria-labelledby="navbarOffcanvasLabel">
        <div class="offcanvas-header">
            <h5 id="navbarOffcanvasLabel">Navigation</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <ul class="navbar-nav">
                <!-- Inventory Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="collapse" href="#inventoryOffcanvas"
                        role="button" aria-expanded="false" aria-controls="inventoryOffcanvas">Inventory</a>
                    <ul class="collapse" id="inventoryOffcanvas">
                        <li><a class="dropdown-item {{ Request::is('inventorys.total') ? 'active' : '' }}"
                                href="{{ route('inventorys.total') }}">Assets Total</a></li>
                        <li><a class="dropdown-item {{ Request::is('inventorys.index') ? 'active' : '' }}"
                                href="{{ route('inventorys.index') }}">Assets List</a></li>
                        <li><a class="dropdown-item {{ Request::is('inventorys.mapping') ? 'active' : '' }}"
                                href="{{ route('inventorys.mapping') }}">Asset Location</a></li>
                    </ul>
                </li>

                <!-- Activity Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="collapse" href="#activityOffcanvas"
                        role="button" aria-expanded="false" aria-controls="activityOffcanvas">Activity</a>
                    <ul class="collapse" id="activityOffcanvas">
                        <li>
                            <a class="dropdown-item {{ Request::is('assets/create') ? 'active' : '' }}"
                                href="{{ route('assets.create') }}"
                                style="background-color: rgba(40, 167, 69, 0.2); color: black; border-radius: 2rem; margin-bottom: 0.2rem; margin-left: 0.4rem;">
                                Handover
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ Request::is('assets/index') ? 'active' : '' }}"
                                href="{{ route('assets.indexmutasi') }}"
                                style="background-color: rgba(255, 193, 7, 0.2); color: black; border-radius: 2rem; margin-bottom: 0.2rem; margin-left: 0.4rem;">
                                Mutasi
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ Request::is('assets/index') ? 'active' : '' }}"
                                href="{{ route('assets.index') }}"
                                style="background-color: rgba(220, 53, 69, 0.2); color: black; border-radius: 2rem; margin-bottom: 0.2rem; margin-left: 0.4rem;">
                                Return
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ Request::is('assets/history') ? 'active' : '' }}"
                                href="{{ route('assets.history') }}">
                                History
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Configuration Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="collapse" href="#configOffcanvas" role="button"
                        aria-expanded="false" aria-controls="configOffcanvas">Setting</a>
                    <ul class="collapse" id="configOffcanvas">
                        <li><a class="dropdown-item {{ Request::is('customer.index') ? 'active' : '' }}"
                                href="{{ route('customer.index') }}">Users</a></li>
                        <li><a class="dropdown-item {{ Request::is('inventorys.create') ? 'active' : '' }}"
                                href="{{ route('inventorys.create') }}"> + Assets</a></li>
                        <li><a class="dropdown-item {{ Request::is('merk.create') ? 'active' : '' }}"
                                href="{{ route('merk.create') }}"> + Merk</a></li>
                    </ul>
                </li>

                <li class="nav-item"><a class="nav-link" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                </li>

            </ul>
        </div>
    </div>

    <!-- Logout Form -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form>
</header>




<style>
    /* Header styles */
    #header {
        width: 100%;
        background-color: #f8f9fa;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        padding: 0.5rem 1rem;
        z-index: 1030;
    }

    .logo-image {
        max-height: 50px;
        width: auto;
        display: inline-block;
    }

    .logo {
        font-size: 1.5rem;
    }

    .logo a {
        color: #343a40;
        text-decoration: none;
    }

    .navbar {
        display: flex;
        align-items: center;
    }

    .navbar ul {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        align-items: center;
    }

    .navbar li {
        position: relative;
        margin-right: 15px;
    }

    .navbar a {
        text-decoration: none;
        color: #343a40;
        padding: 0.5rem 1rem;
        /* Ensure consistent padding */
        display: inline-block;
        /* Ensures the link is block-level */
    }

    .navbar a.active,
    .navbar a:hover,
    .navbar a:focus,
    .navbar a:active {
        color: #515d6a;
        /* Change text color on hover and active */
        background-color: transparent;
        /* No background change */
        outline: none;
        /* Remove outline */
        text-decoration: none;
        /* No underline */
    }

    .navbar .dropdown {
        position: relative;
    }

    .navbar .dropdown-menu {
        background-color: #f8f9fa;
        border: 1px solid rgba(0, 0, 0, 0.125);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        display: none;
        /* Hide by default */
        position: absolute;
        top: 100%;
        left: 0;
        z-index: 1000;
        min-width: 160px;
        padding: 0;
        margin: 0;
        border-radius: 0.25rem;
    }

    .navbar .dropdown:hover .dropdown-menu {
        display: block;
        /* Show dropdown on hover */
    }

    .navbar .dropdown-menu .dropdown-item {
        color: #343a40;
        padding: 0.5rem 1rem;
        display: block;
        border-bottom: 1px solid rgba(0, 0, 0, 0.125);
        text-decoration: none;
    }

    .navbar .dropdown-menu .dropdown-item:last-child {
        border-bottom: none;
    }

    .navbar .dropdown-menu .dropdown-item:hover {
        background-color: #e9ecef;
    }

    .navbar .dropdown-toggle::after {
        display: none;
    }

    /* Responsive Styles */
    @media (max-width: 767px) {
        .logo {
            display: none;
            /* Hide the logo text on mobile */
        }

        .navbar {
            display: block;
            width: 100%;
        }

        .navbar ul {
            flex-direction: column;
            padding: 0;
            width: 100%;
        }

        .navbar li {
            margin-right: 0;
            margin-bottom: 10px;
        }

        .navbar .dropdown-menu {
            position: static;
            display: block;
            width: 100%;
            box-shadow: none;
        }

        .navbar-toggler {
            border: none;
            background: transparent;
            font-size: 1.5rem;
            color: #343a40;
        }

        .navbar-toggler-icon {
            background-image: url('data:image/svg+xml;charset=utf8,%3Csvg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30"%3E%3Cpath stroke="%23000" stroke-width="2" d="M5 7h20M5 15h20M5 23h20" /%3E%3C/svg%3E');
            margin-left: 230px;
        }

        .offcanvas {
            background-color: #f8f9fa;
        }

        .offcanvas-header {
            border-bottom: 1px solid rgba(0, 0, 0, 0.125);
        }
    }
</style>