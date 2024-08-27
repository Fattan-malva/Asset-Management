<header id="header" class="fixed-top d-flex align-items-center bg-light shadow-sm">
    <div class="container d-flex align-items-center justify-content-between">
        <!-- Logo Image -->
        <img src="{{ asset('assets/img/GSI.png') }}" alt="GSI Logo" class="logo-image me-3">

        <!-- Logo Text -->
        <h1 class="logo me-auto d-none d-md-block">
            <a href="{{ route('shared.homeUser') }}" class="text-decoration-none text-dark">
                Global Service Indonesia
            </a>
        </h1>

        <!-- Navbar Toggler for Mobile -->
        <button class="navbar-toggler d-md-none" type="button" data-bs-toggle="offcanvas"
            data-bs-target="#navbarOffcanvas" aria-controls="navbarOffcanvas" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navigation for Desktop -->
        <nav id="navbarMenu" class="navbar d-flex align-items-center d-none d-md-flex">
            <ul class="navbar-nav d-flex align-items-center">
                <!-- Add Desktop Nav Items Here -->
            </ul>
            <ul class="navbar-nav d-flex align-items-center">
                <li class="nav-item">
                    <!-- User Profile Icon -->
                    <a href="#" class="nav-link badge badge-custom" data-bs-toggle="modal"
                        data-bs-target="#uniqueProfileModal"
                        style="font-size: 0.8rem; padding: 0.5em 1em; color: white; border-radius: 1.5em; background-color: rgba(33, 37, 41, 0.5);">
                        <img src="{{ asset('assets/img/admin.png') }}" alt="Profile Icon" class="profile-icon">
                        <span class="d-none d-md-inline ms-2">{{ session('user_name') }}</span>
                    </a>

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
                <li class="nav-item"><a class="nav-link {{ Request::is('home') ? 'active' : '' }}"
                        href="{{ route('shared.homeUser') }}">Home</a></li>
                <li class="nav-item">
                    <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#uniqueProfileModal">Profile</a>
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


<!-- Modal Profile -->
<div class="modal fade" id="uniqueProfileModal" tabindex="-1" aria-labelledby="uniqueProfileModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-end modal-slide-right">
        <div class="modal-content unique-profile-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uniqueProfileModalLabel">Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Profile Content -->
                <div class="text-center mb-4">
                    <img src="{{ asset('assets/img/admin.png') }}" alt="Profile Picture"
                        class="img-fluid rounded-circle profile-picture">
                </div>
                <h5><span>Name : </span>{{ session('user_name') }}</h5>
                <h5><span>Position : </span>{{ session('user_mapping') }}</h5>
                <h5><span>NRP : </span>{{ session('user_nrp') }}</h5>
                <p><span>Email : </span>{{ session('user_username') }}</p>
                <!-- Add more profile information here -->
            </div>
            <div class="modal-footer">
                <a href="{{ route('logout') }}" class="btn btn-danger"
                    onclick="event.preventDefault(); document.getElementById('unique-logout-form').submit();">
                    <i class='bx bx-log-out' id="logout-icon" style="cursor:pointer;"></i> Logout
                </a>
                <!-- Logout Form -->
                <form id="unique-logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>
    </div>
</div>


<style>
    /* Header styles */
    #header {
        width: 100%;
        background-color: #f8f9fa;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        padding: 0.5rem 1rem;
        z-index: 1030;
    }

    /* Logo Image */
    .logo-image {
        max-height: 70px;
        width: auto;
        display: inline-block;
    }

    /* Logo Text */
    .logo {
        font-size: 0.2rem;
    }

    /* Navbar styles */
    .navbar {
        display: flex;
        align-items: center;
        width: 100%;
        justify-content: space-between;
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
        padding: 0.5rem 0;
    }

    /* Navbar link states */
    .navbar a:hover,
    .navbar a:focus,
    .navbar a:active {
        color: #515d6a;
        background-color: transparent;
        outline: none;
    }

    /* User Profile Icon */
    .profile-icon {
        max-height: 25px;
        width: auto;
        border-radius: 50%;
    }

    /* Hide text for small screens */
    .d-none.d-md-inline {
        display: inline;
    }

    /* Responsive Styles */
    @media (max-width: 767px) {
        .logo {
            display: none;
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
        }

        .offcanvas {
            background-color: #f8f9fa;
        }

        .offcanvas-header {
            border-bottom: 1px solid rgba(0, 0, 0, 0.125);
        }

        .offcanvas-body {
            padding: 1rem;
        }

        .offcanvas .navbar-nav {
            width: 100%;
        }

        .offcanvas .navbar-nav .nav-link {
            color: #343a40;
            padding: 0.5rem 1rem;
        }
    }

    /* Modal dialog that slides from the right */
    .modal-slide-right .modal-dialog {
        transform: translateX(100%);
        transition: transform 0.3s ease-in-out;
        margin: 0;
    }

    .modal.fade.show .modal-slide-right .modal-dialog {
        transform: translateX(0);
    }

    /* Full height modal and align to the right for desktop */
    .modal-dialog-end.modal-slide-right {
        height: 100%;
        margin: 0;
        width: 50%;
        /* Default width for desktop */
        margin-left: auto;
        /* Align to the right */
        margin-right: 0;
    }

    /* Modal dialog that slides from the right */
    .modal-slide-right .modal-dialog {
        transform: translateX(100%);
        transition: transform 0.3s ease-in-out;
        margin: 0;
    }

    .modal.fade.show .modal-slide-right .modal-dialog {
        transform: translateX(0);
    }

    /* Full height modal and align to the right */
    .modal-dialog-end.modal-slide-right {
        height: 100%;
        margin: 0;
        width: 50%;
        /* Adjust width as needed */
        margin-left: auto;
        /* Align to the right */
        margin-right: 0;
    }

    .unique-profile-content {
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .modal-body {
        flex: 1;
        /* Allows modal body to take up available space */
        overflow-y: auto;
        /* Allows scrolling if content is too long */
    }

    .profile-picture {
        width: 150px;
        height: 150px;
    }

    /* Responsive Styles for Modal */
    @media (max-width: 767px) {
        .modal-dialog-end.modal-slide-right {
            width: 100%;
            /* Full width for mobile */
            margin: 0;
            /* Remove margin on mobile */
        }

        .profile-picture {
            width: 120px;
            /* Smaller size for mobile */
            height: 120px;
        }

        .unique-profile-content {
            height: auto;
            /* Auto height for mobile */
            display: block;
        }

        .modal-body {
            padding: 1rem;
            /* Add padding for better spacing */
        }
    }
</style>