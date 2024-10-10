<header id="header" class="fixed-top d-flex align-items-center">
    <div class="container d-flex align-items-center justify-content-between" style="margin-left: -13px;">
        <!-- Logo Image -->
        <img src="{{ asset('assets/img/velaris.png') }}" alt="GSI Logo" class="logo-image">

        <h1 class="logo-deks me-auto d-none d-md-block">
            <a href="{{ route('shared.homeUser') }}" class="text-decoration-none text-dark title-logo">
                eLaris
            </a>
        </h1>
    

        <!-- Logo Text for Mobile -->
        <h1 class="logo-mobile me-auto d-block d-md-none">
            <a href="{{ route('shared.homeUser') }}" class="text-decoration-none text-dark title-logo">
                eLaris
            </a>
        </h1>

        <!-- User Profile Icon -->
        <li class="nav-item d-md-none">
            <a href="#" class="nav-link user-prof" data-bs-toggle="modal" data-bs-target="#uniqueProfileModal">
                <img src="{{ asset('assets/img/admin.png') }}" alt="Profile Icon" class="profile-icon">
                <span class="d-none d-md-inline ms-2">{{ session('user_name') }}</span>
            </a>
        </li>


        <!-- Navbar Toggler for Mobile (Remove or hide for mobile) -->
        <button class="navbar-toggler d-md-none" type="button" data-bs-toggle="offcanvas"
            data-bs-target="#navbarOffcanvas" aria-controls="navbarOffcanvas" aria-expanded="false"
            aria-label="Toggle navigation" style="display: none;">
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

    <!-- Bottom Navbar for Mobile -->
    <nav class="navbar d-md-none fixed-bottom bg-light justify-content-between">
        <ul class="navbar-nav w-100 d-flex justify-content-around">
            <li class="nav-item text-center">
                <a class="nav-link" href="{{ route('shared.homeUser') }}" data-page="home">
                    <i class="fa-solid fa-house" style="font-size: 25px;"></i>
                    <span class="title-nav-bottom">Home</span>
                </a>
            </li>
            <li class="nav-item text-center">
                <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#uniqueProfileModal" data-page="profile">
                    <i class="fa-solid fa-user" style="font-size: 25px;"></i>
                    <span class="title-nav-bottom">Profile</span>
                </a>
            </li>
            <li class="nav-item text-center">
                <a class="nav-link" href="{{ route('logout') }}" data-page="logout"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fa-solid fa-right-from-bracket" style="font-size: 25px;"></i>
                    <span class="title-nav-bottom">Logout</span>
                </a>
            </li>
        </ul>
    </nav>



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
            <!-- <div class="modal-header">
                <h5 class="modal-title" id="uniqueProfileModalLabel">Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div> -->
            <div class="modal-body">
                <!-- Profile Content -->
                <div class="text-center mt-2 mb-2">
                    <img src="{{ asset('assets/img/admin.png') }}" alt="Profile Picture" class="img-fluid rounded-circle profile-picture mb-3">
                    <h5 class="fw-bold">{{ session('user_name') }}</h5>
                    <p>{{ session('user_username') }}</p>
                </div>
                <hr />
                <div class="profile-info">
                    <div class="profile-row">
                        <span class="fw-bold">NRP</span>
                        <input type="text" value="{{ session('user_nrp') }}" class="form-control" readonly>
                    </div>
                    <hr />
                    <div class="profile-row">
                        <span class="fw-bold">Name</span>
                        <input type="text" value="{{ session('user_name') }}" class="form-control" readonly>
                    </div>
                    <hr />
                    <div class="profile-row">
                        <span class="fw-bold">Position</span>
                        <input type="text" value="{{ session('user_mapping') }}" class="form-control" readonly>
                    </div>
                    <hr />
                    <div class="profile-row">
                        <span class="fw-bold">Email</span>
                        <input type="text" value="{{ session('user_username') }}" class="form-control" readonly>
                    </div>
                    <hr />
                </div>
            </div>

            <div class="modal-footer">
                <a class="btn-cancel" data-bs-dismiss="modal">
                    Close
                </a>
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
    .profile-info {
        display: flex;
        flex-direction: column;
    }

    .profile-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        /* Aligns items on the ends */
    }

    .profile-row span {
        flex: 1;
        /* Allow the spans to take up space */
        text-align: left;
        /* Align text to the left */
        margin-right: 10px;
        /* Space between label and input */
    }

    .profile-row input {
        flex: 2;
        /* Allow input to take up more space */
        padding: 0.5rem;
        /* Padding for better touch targets */
        border: 1px solid #ced4da;
        /* Border styling */
        border-radius: 0.25rem;
        /* Rounded corners */
        color: #495057;
        /* Text color */
    }

    .profile-row input:readonly {
        background-color: #e9ecef;
        /* Change background for readonly state */
        cursor: not-allowed;
        /* Cursor style for readonly */
    }


    /* Header styles */
    #header {
        width: 100%;
        background-color: #ffffff;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        padding: 0.5rem 1rem;
        z-index: 1030;
    }

    body {
        background-color: #f2edf3;
    }

    /* Logo Image */
    .logo-image {
        max-height: 70px;
        width: auto;
        display: inline-block;
        margin-left: 40px;
    }

    /* Logo Text */
    .logo-deks {
        font-size: 35px;
        margin-top: 10px;
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

    /* .navbar a {
        text-decoration: none;
        color: #343a40;
        padding: 0.5rem 0;
     
    } */

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
            /* flex-direction: column; */
            padding: 0;
            width: 100%;
        }

        .navbar li {
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
            height: 630px;
            /* Auto height for mobile */
            display: block;
            margin-top: 6px;
            position: relative;
            display: flex;
        }

        .modal-body {
            padding: 1rem 1rem 0rem 1rem;
            /* Add padding for better spacing */
        }

        .logo {
            display: none;
        }

        .logo-mobile {
            display: block;
        }

        .navbar {
            display: block;
            width: 100%;
        }

        .navbar ul {
            padding: 0;
            width: 100%;
        }

        .navbar li {
            margin-bottom: 10px;
        }

        .navbar-nav {
            flex-direction: row;
            /* Keep items in a single row */
            justify-content: space-around;
            /* Space out the items evenly */
        }

        .navbar ul {
            list-style: none;
            padding: 13 10 10 20;
            margin: 0;
            display: flex;
            align-items: center;
        }

        .navbar.d-md-none.fixed-bottom {
            height: 80px;
            /* Sesuaikan dengan tinggi navbar */
            box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.1);
        }

        .navbar-nav {
            padding: 0;
            /* Pastikan tidak ada padding ekstra */
        }

        .nav-item {
            flex: 1;
            /* Flex untuk menjaga item seimbang */
            list-style: none;
            /* Remove any default list styling */

        }

        .nav-link {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            padding: 10px;
            /* Tingkatkan padding untuk link */
            height: 100%;
            /* Pastikan link memenuhi tinggi navbar */
            min-height: 70px;
            /* Tinggi minimum untuk menjaga stabilitas */
            transition: background-color 0.3s;
            /* Transisi halus untuk efek hover */
        }

        /* 
        .nav-link:hover {
            background-color: #dab5ff;
        } */

        .navbar a {
            text-decoration: none;
            color: #343a40;
        }

        .navbar a,
        .navbar a:focus {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 13px 0px 13px 5px;
            font-family: "Poppins", sans-serif;
            font-size: 15px;
            font-weight: 500;
            color: #556270;
            white-space: nowrap;
            transition: 0.3s;
        }

        .title-nav-bottom {
            font-size: 13px;
            margin-left: 5px;
        }

        .logo-image {
            /* margin-left: 65px; */
            max-height: 70px;
            width: auto;
            display: inline-block;
            margin-left: 0;
        }

        .logo-mobile {
            font-size: 2rem;
            /* Adjust size for mobile */
            margin-top: 15px;
            /* Add some space between logo and text */
        }

        .user-prof {
            display: flex;
            align-items: center;
            border-radius: 50%;
            /* Make it circular */
            /* background-color: rgba(33, 37, 41, 0.5);
            transition: background-color 0.3s;  */
            margin-left: 105px;
        }

        .profile-icon {
            max-height: 50px;
            /* Adjust size of icon for mobile */
            width: 50px;
            border-radius: 50%;
            margin-left: 25px;
            /* Ensure the image is circular */
        }


        /* Bottom Navbar */
        .navbar-nav .nav-link {
            transition: background-color 0.3s, color 0.3s;
            /* Smooth transition */
        }

        .navbar-nav .nav-link:hover {
            color: #B66DFF;
            /* Teks menjadi ungu saat hover */
        }

        .navbar-nav .nav-link:hover i {
            color: #B66DFF;
            /* Ikon menjadi putih saat hover */
        }

        /* Active state */
        .navbar-nav .nav-link.active span {
            color: #B66DFF;
        }

        .navbar-nav .nav-link.active i {
            color: #B66DFF;
        }


        .btn-cancel {
            padding: 7px 19px;
            border-radius: 5px;
            background-color: #1d1d1d;
            color: #fff;
        }

        .btn-cancel:hover {
            padding: 7px 19px;
            border-radius: 5px;
            background-color: #1d1d1d;
            color: #fff;
        }

        /* Logo Image */
        .logo-image {
            max-height: 70px;
            width: auto;
            display: inline-block;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const navLinks = document.querySelectorAll('.nav-link');

        navLinks.forEach(link => {
            link.addEventListener('click', function() {
                // Hapus kelas active dari semua link
                navLinks.forEach(nav => nav.classList.remove('active'));

                // Tambahkan kelas active ke link yang diklik
                this.classList.add('active');
            });
        });

        // Set active class based on the current page (optional)
        const currentPath = window.location.pathname;
        navLinks.forEach(link => {
            if (link.getAttribute('href') === currentPath) {
                link.classList.add('active');
            }
        });
    });
</script>