<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <title>Global Service Indonesia isa</title>
    <link rel="stylesheet" href="style.css">
    <!-- Boxicons CDN Link -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <div class="sidebar close">
        <div class="logo-details">
            <img src="{{ asset('assets/img/velaris.png') }}" alt="Global Service Indonesia Logo" class="sidebar-logo">
            <span class="logo_name">eLaris</span>
        </div>

        <ul class="nav-links">
            <li>
                <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="fa-solid fa-house-chimney"></i>
                    <span class="link_name">Dashboard</span>
                </a>
            </li>
            <li>
                <div class="iocn-link">
                    <a
                        class="{{ request()->routeIs('inventorys.total') || request()->routeIs('inventorys.index') || request()->routeIs('inventorys.mapping') ? 'active' : '' }}">
                        <i
                            class="bx bx-collection {{ request()->routeIs('inventorys.total') || request()->routeIs('inventorys.index') || request()->routeIs('inventorys.mapping') ? 'active' : '' }}"></i>
                        <span class="link_name">Asset</span>
                    </a>
                    <i class='bx bxs-chevron-left arrow'></i>
                </div>
                <ul class="sub-menu">
                    <li><a href="{{ route('inventorys.total') }}"
                            class="{{ request()->routeIs('inventorys.total') ? 'active' : '' }}">Total</a></li>
                    <li><a href="{{ route('inventorys.index') }}"
                            class="{{ request()->routeIs('inventorys.index') ? 'active' : '' }}">List</a></li>
                    <li><a href="{{ route('inventorys.mapping') }}"
                            class="{{ request()->routeIs('inventorys.mapping') ? 'active' : '' }}">Location</a></li>
                </ul>
            </li>
            <li>
                <div class="iocn-link">
                    <a
                        class="{{ request()->routeIs('assets.index') || request()->routeIs('assets.create') || request()->routeIs('assets.indexreturn') ? 'active' : '' }}">
                        <i class='bx bx-line-chart'
                            class="{{ request()->routeIs('assets.index') || request()->routeIs('assets.create') || request()->routeIs('assets.indexreturn') ? 'active' : '' }}"></i>
                        <span class="link_name">Activity</span>
                    </a>
                    <i class='bx bxs-chevron-left arrow'></i>
                </div>
                <ul class="sub-menu">
                    <li><a href="{{ route('assets.index') }}"
                            class="{{ request()->routeIs('assets.index') ? 'active' : '' }}">Approval Status</a></li>
                    <li><a href="{{ route('assets.create') }}"
                            class="{{ request()->routeIs('assets.create') ? 'active' : '' }}">Handover</a></li>
                    <li><a href="{{ route('assets.indexreturn') }}"
                            class="{{ request()->routeIs('assets.indexreturn') ? 'active' : '' }}">Return</a></li>
                    <!-- <li><a href="{{ route('assets.indexmutasi') }}">Mutasi</a></li> -->
                </ul>
            </li>
            <!-- <li>
                    <a href="{{ route('sales.index') }}" class="{{ request()->routeIs('sales.index') ? 'active' : '' }}">
                        <i class='bx bx-message-alt-detail'></i>
                        <span class="link_name">Ticket</span>
                    </a>
                </li> -->
            <li>
                <a href="{{ route('inventory.history') }}"
                    class="{{ request()->routeIs('sales.index') ? 'active' : '' }}">
                    <i class='bx bx-history'></i>
                    <span class="link_name">History</span>
                </a>
            </li>
            <!-- <li>
                    <div class="iocn-link">
                        <a class="{{ request()->routeIs('assets.history') || request()->routeIs('inventory.history') ? 'active' : '' }}">
                            <i class='bx bx-history' class="{{ request()->routeIs('assets.history') || request()->routeIs('inventory.history') ? 'active' : '' }}"></i>
                            <span class="link_name">History</span>
                        </a>
                        <i class='bx bxs-chevron-left arrow'></i>
                    </div>
                    <ul class="sub-menu">
                        <li><a href="{{ route('assets.history') }}" class="{{ request()->routeIs('assets.history') ? 'active' : '' }}">Activity</a></li>
                        <li><a href="{{ route('inventory.history') }}" class="{{ request()->routeIs('inventory.history') ? 'active' : '' }}">Entry & Scrap</a></li>
                    </ul>
                </li> -->
            <li>
                <div class="iocn-link">
                    <a href="#"
                        class="{{ request()->routeIs('customer.index') || request()->routeIs('inventorys.create') || request()->routeIs('merk.index') ? 'active' : '' }}">
                        <i class='bx bx-cog'
                            class="{{ request()->routeIs('customer.index') || request()->routeIs('inventorys.create') || request()->routeIs('merk.index') ? 'active' : '' }}"></i>
                        <span class="link_name">Setting</span>
                    </a>
                    <i class='bx bxs-chevron-left arrow'></i>
                </div>
                <ul class="sub-menu">
                    <li><a href="{{ route('customer.index') }}"
                            class="{{ request()->routeIs('customer.index') ? 'active' : '' }}">Users</a></li>
                    <li><a href="{{ route('inventorys.create') }}"
                            class="{{ request()->routeIs('inventorys.create') ? 'active' : '' }}">Add Asset</a></li>
                    <li><a href="{{ route('merk.index') }}"
                            class="{{ request()->routeIs('merk.index') ? 'active' : '' }}">Add Merk</a></li>
                </ul>
            </li>
        </ul>
    </div>

    <div class="home-content">
        <i class='bx bx-menu'></i>
        <span class="text gsi-button">Admin Dashboard</span>
        <!-- Admin -->
        <div class="profile-details-top">
            <div class="profile-content">
                <img src="{{ asset('assets/img/admin.png') }}" alt="profileImg">
            </div>
            <div class="name-job">
                <div class="profile_name">Admin</div>
                <div class="job">Infrastructure</div>
            </div>
            <i class='bx bxs-chevron-down' id="logout-icon"></i>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    </div>
    <section class="home-section">
        <div>
            <main class="py-4">
            @yield('content')
            </main>
        </div>
    </section>
</body>

</html>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Poppins', sans-serif;
    }

    section {
        padding: 0px 0;
        overflow: hidden;
    }


    /* SIDEBAR */

    /* sidebar logo */
    /* .sidebar-logo {
        height: 60px; background-color: white; margin-top: -10px;
    } */
    .sidebar .logo-details img.sidebar-logo {
        height: 60px;
        /* Membuat tinggi otomatis */
        max-height: 120px;
        /* Maksimum tinggi saat sidebar terbuka */
        width: auto;
        /* Memastikan lebar otomatis */
        max-width: 90%;
        /* Memastikan logo tidak lebih dari 90% lebar container */
        transition: max-height 0.5s ease;
        /* Transisi halus saat mengubah ukuran */
        margin-top: -10px;
    }

    .sidebar.close .logo-details img.sidebar-logo {
        max-height: 60px;
        /* Tinggi maksimum saat sidebar ditutup */
    }

    .sidebar .logo-details {
        width: auto;
        /* display: flex; */
        text-align: center;
        overflow-y: auto;
    }

    .sidebar .logo-details.close {
        overflow: visible;

    }

    .sidebar .logo-details::-webkit-scrollbar {
        display: none;
    }

    .sidebar .logo-details i {
        font-size: 30px;
        color: #fff;
        height: 50px;
        min-width: 78px;
        text-align: center;
        line-height: 50px;
    }

    .sidebar .logo-details .logo_name {
        font-size: 28px;
        color: #000;
        font-weight: 600;
        transition: opacity 0.3s ease;
    }

    .sidebar.close .logo-details .logo_name {
        opacity: 0;
        pointer-events: none;
        display: none;
        /* Hide when sidebar is closed */
    }

    .sidebar {
        position: fixed;
        top: 0;
        left: 0;
        height: 100%;
        width: 260px;
        background: #fff;
        z-index: 100;
        transition: all 0.5s ease;
    }

    .sidebar.close {
        width: 78px;
    }

    .sidebar .logo-details {
        width: 100%;
        /* Memastikan lebar 100% untuk responsivitas */
        text-align: center;
        padding: 10px 0;
        /* Menambahkan padding untuk ruang vertikal */
        margin-top: 15px;
    }

    .sidebar .nav-links {
        height: 100%;
        padding: 0px 0 0 0;
        overflow-y: auto;
    }

    .sidebar.close .nav-links {
        overflow: visible;
    }

    .sidebar .nav-links::-webkit-scrollbar {
        display: none;
    }

    .sidebar .nav-links li {
        position: relative;
        list-style: none;
        transition: all 0.4s ease;
    }

    .sidebar .nav-links li:hover {
        background: #f8f9fa;
    }

    .sidebar .nav-links li .iocn-link {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .sidebar.close .nav-links li .iocn-link {
        display: block;
    }

    .sidebar .nav-links li i {
        height: 50px;
        min-width: 78px;
        text-align: center;
        line-height: 50px;
        color: #beabc2;
        font-size: 18px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .sidebar .nav-links li i.active {
        height: 50px;
        min-width: 78px;
        text-align: center;
        line-height: 50px;
        font-size: 20px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .sidebar .nav-links li.showMenu i.arrow {
        transform: rotate(-90deg);
    }

    .sidebar.close .nav-links i.arrow {
        display: none;
    }

    .sidebar .nav-links li a {
        display: flex;
        align-items: center;
        text-decoration: none;
    }

    .sidebar .nav-links li a .link_name {
        font-size: 14px;
        font-weight: 400;
        color: #000;
        transition: opacity 0.4s ease;
    }

    /* Pewarnaan pada text menu apabila user berada di menu tsb */
    .sidebar .nav-links li a.active .link_name {
        color: #B66DFF;
        /* Active color */
    }

    .sidebar .nav-links li a.active i {
        color: #B66DFF;
        /* Active color for icon */
    }

    .sub-menu a.active {
        color: #B66DFF;
        /* Active color for submenu link text */
    }

    .sub-menu a.active i {
        color: #B66DFF;
        /* Active color for submenu icon, if any */
    }

    .sidebar.close .nav-links li a .link_name {
        opacity: 0;
        pointer-events: none;
    }

    .sidebar .nav-links li .sub-menu {
        padding: 6px 6px 14px 80px;
        margin-top: -10px;
        background: #f8f9fa;
        display: none;
    }

    .sidebar .nav-links li.showMenu .sub-menu {
        display: block;
    }

    .sidebar .nav-links li .sub-menu a {
        color: #000;
        font-size: 13px;
        padding: 5px 0;
        white-space: nowrap;
        opacity: 0.6;
        transition: opacity 0.3s ease;
    }

    .sidebar .nav-links li .sub-menu a:hover {
        opacity: 1;
    }

    .sidebar.close .nav-links li:hover .sub-menu,
    .sidebar.close .nav-links li.showMenu .sub-menu {
        position: absolute;
        left: 78px;
        /* Menyesuaikan posisi submenu saat sidebar ditutup */
        top: 0;
        margin-top: 0;
        padding: 0px;
        background: #1d1b31;
        border-radius: 0 6px 6px 0;
        opacity: 1;
        display: none;
        pointer-events: auto;
        transition: all 0.4s ease;
    }

    .sidebar.close .nav-links li:hover .sub-menu a {
        color: #000;
        /* Color for submenu links on hover */
        font-size: 13px;
        padding: 5px 5px;
        white-space: nowrap;
        opacity: 1;
        /* Make fully opaque on hover */
        transition: opacity 0.3s ease;
    }

    .sidebar.close .nav-links li .sub-menu {
        display: none;
        /* Keep submenu hidden by default */
    }

    .sidebar.close .nav-links li:hover .sub-menu {
        display: block;
        /* Show submenu when hovering over the parent item */
        position: absolute;
        /* Positioning for dropdown effect */
        left: 78px;
        /* Adjust position as necessary */
        top: 0;
        /* Align with the parent menu item */
        background: #f8f9fa;
        /* Background for the submenu */
        border-radius: 6px;
        /* Optional: rounded corners */
        z-index: 10;
        /* Ensure it appears above other content */
    }


    .sidebar.close .nav-links li .sub-menu .link_name {
        display: none;
    }

    .sidebar.close .nav-links li .sub-menu .link_name {
        font-size: 18px;
        opacity: 1;
        display: block;
    }

    /* icon logout */
    .profile-details-top .bxs-chevron-down {
        cursor: pointer;
        margin-left: 10px;
        color: #a3a6ab;
        font-size: 25px;
    }


    /* Style untuk Home Section */
    .home-section {
        position: relative;
        background: #f2edf3;
        min-height: 100vh;
        width: calc(100% - 260px);
        left: 260px;
        transition: all 0.5s ease;
        /* padding-left: 20px; Jarak ketika sidebar terbuka */
    }

    .sidebar.close~.home-section {
        width: calc(100% - 60px);
        left: 60px;
        /* padding-left: 10px; Jarak ketika sidebar tertutup */
    }

    /* Adjustments for padding when sidebar is open */
    .home-section {
        padding-left: 20px;
        /* Add padding when sidebar is open */
    }

    .home-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: #fff; /* Non-transparent background */
        padding: 15px 20px;
        margin-top: 0;
        margin-left: 260px; /* Default margin untuk sidebar terbuka */
        transition: margin-left 0.5s ease, width 0.5s ease; /* Tambahkan transisi untuk margin dan width */
        position: fixed; /* Pastikan tetap di atas viewport */
        top: 0; /* Atur posisi di atas */
        width: calc(100% - 260px); /* Lebar saat sidebar terbuka */
        z-index: 10; /* Pastikan di atas sidebar */
    }

    .sidebar.close ~ .home-content {
        margin-left: 78px; /* Margin saat sidebar ditutup */
        width: calc(100% - 78px); /* Lebar saat sidebar ditutup */
    }

    .gsi-button {
        font-size: 30px;
        /* Font size for the title */
        font-weight: bold;
        /* Bold text */
        margin-right: auto;
        /* Push the profile section to the right */
    }

    .profile-details-top {
        display: flex;
        align-items: center;
        /* Centers profile items vertically */
        margin-right: 30px;
    }

    .profile-details-top .profile-content {
        display: flex;
        align-items: center;
    }

    .profile-details-top img {
        height: 40px;
        width: 40px;
        object-fit: cover;
        border-radius: 50%;
        /* Circular image */
        margin-right: 10px;
        /* Space between image and text */
    }

    .profile-details-top .name-job {
        display: flex;
        flex-direction: column;
        line-height: 1.2;
    }

    .profile-details-top .profile_name {
        font-weight: bold;
        font-size: 15px;
    }

    .profile-details-top .job {
        font-size: 14px;
        color: #888;
        /* Lighter color for job title */
    }

    /* icon toogle untuk sidebar */
    .home-content i {
        font-size: 30px;
        color: #a3a6ab;
        margin-right: 10px;
        cursor: pointer;
    }

    .home-content span {
        font-size: 22.5px;
        font-weight: bold;
        margin-left: 0px;
    }

    @media (max-width: 768px) {
        .sidebar {
            width: 270px;
            /* Adjusted width for mobile sidebar */
        }

        .sidebar.close {
            width: 80px;
            /* Ensure the closed sidebar width matches */
        }

        .home-section {
            width: calc(100% - 60px);
            /* Adjust width for mobile */
            left: 60px;
            /* Adjust position for mobile */
        }

        .sidebar.close~.home-section {
            width: calc(100% - 60px);
            /* Maintain width consistency */
            left: 60px;
            /* Adjust for mobile */
        }

        .home-content {
            margin-left: 270px;
            /* Align content properly */
            padding: 15px;
            /* Add some padding for better spacing */
        }

        .gsi-button {
            display: none;
            /* Hide button text on smaller screens */
        }

        .sidebar .nav-links li .sub-menu {
            display: none;
            /* Hide submenus in mobile view */
        }

        .sidebar.close .nav-links li.showMenu .sub-menu {
            display: block;
            /* Show submenus when parent is expanded */
        }
    }
</style>

<script>
    let arrow = document.querySelectorAll(".arrow");
    for (var i = 0; i < arrow.length; i++) {
        arrow[i].addEventListener("click", (e) => {
            let arrowParent = e.target.parentElement.parentElement; //selecting main parent of arrow
            arrowParent.classList.toggle("showMenu");
        });
    }

    let sidebar = document.querySelector(".sidebar");
    let sidebarBtn = document.querySelector(".bx-menu");

    // Check localStorage for sidebar state and set it
    if (localStorage.getItem('sidebarState') === 'open') {
        sidebar.classList.remove("close");
    } else {
        sidebar.classList.add("close");
    }

    sidebarBtn.addEventListener("click", () => {
        sidebar.classList.toggle("close");
        // Update localStorage based on the sidebar state
        if (sidebar.classList.contains("close")) {
            localStorage.setItem('sidebarState', 'closed');
        } else {
            localStorage.setItem('sidebarState', 'open');
        }
    });

    document.getElementById('logout-icon').addEventListener('click', function (event) {
        event.preventDefault();
        document.getElementById('logout-form').submit();
    });

    // Untuk add color pada sidebar menu saat berada d page tersebut
    document.querySelectorAll('.nav-links li a').forEach(link => {
        link.addEventListener('click', function () {
            // Remove active class from all links and icons
            document.querySelectorAll('.nav-links li a').forEach(link => {
                link.classList.remove('active');
            });
            // Add active class to the clicked link and icon
            this.classList.add('active');
        });
    });

    // Add click event listeners to all menu links
    document.querySelectorAll('.nav-links li a').forEach(link => {
        link.addEventListener('click', () => {
            if (window.innerWidth <= 768) { // Check if it's mobile view
                sidebar.classList.add("close"); // Close the sidebar
                localStorage.setItem('sidebarState', 'closed'); // Update localStorage
            }
        });
    });
    document.getElementById('back-icon').addEventListener('click', function () {
        window.history.back();
    });


</script>