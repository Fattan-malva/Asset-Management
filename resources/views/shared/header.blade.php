<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <title>GSI</title>
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
                    <li><a href="{{ route('inventorys.scrap') }}"
                            class="{{ request()->routeIs('inventorys.scrap') ? 'active' : '' }}">Scrap</a></li>
                    <li><a href="{{ route('inventorys.edit') }}"
                            class="{{ request()->routeIs('inventorys.edit') ? 'active' : '' }}">
                            Maintenance
                        </a>
                    </li>

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
            <div class="bottom-section">
                <li>
                    <a href="https://helpdesk.globalservice.co.id/" target="_blank"
                        class="{{ request()->routeIs('sales.index') ? 'active' : '' }}">
                        <i class="fa-solid fa-headset"></i>
                        <span class="link_name" style="font-size:19px; margin-left:-10px;">Help Center</span>
                    </a>
                    <a href="#" onclick="toggleNightMode()">
                        <i class="fa-solid fa-moon" style="margin-top:-20px"></i>
                        <span class="link_name"
                            style="font-size:19px; margin-top:-20px; margin-left:-10px; margin-right:10px;">Dark
                            Mode</span>
                        <button id="nightModeToggle" class="toggle-switch" style="margin-top:-20px">
                            <i id="modeIcon" class='bx bx-moon'></i>
                            <div class="slider"></div>
                        </button>
                    </a>
                </li>
            </div>

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
            <!-- Ganti icon logout menjadi lebih umum, misalnya, icon power-off -->
            <i class="fa-solid fa-right-from-bracket" id="logout-icon" style="cursor: pointer;"></i>

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


<script>
    // Function to toggle dark mode and handle switch movement
    function toggleNightMode() {
        const body = document.body;
        const icon = document.getElementById('modeIcon');
        const logoName = document.querySelector('.logo_name');
        const toggleSwitch = document.getElementById('nightModeToggle'); // Reference to the switch

        // Toggle dark mode class
        body.classList.toggle('dark-mode');
        toggleSwitch.classList.toggle('active'); // Add 'active' class to move the slider

        // Check if dark mode is now enabled or disabled
        if (body.classList.contains('dark-mode')) {
            icon.classList.remove('bx-moon');
            icon.classList.add('bx-sun');
            logoName.style.color = 'white'; // Change logo text color when dark mode is enabled
            localStorage.setItem('dark-mode', 'enabled'); // Save dark mode state
        } else {
            icon.classList.remove('bx-sun');
            icon.classList.add('bx-moon');
            logoName.style.color = ''; // Reset logo text color when dark mode is disabled
            localStorage.setItem('dark-mode', 'disabled'); // Save dark mode state
        }
    }

    // Check if dark mode is already enabled when the page loads
    document.addEventListener("DOMContentLoaded", function () {
        const body = document.body;
        const icon = document.getElementById('modeIcon');
        const logoName = document.querySelector('.logo_name');
        const toggleSwitch = document.getElementById('nightModeToggle'); // Reference to the switch

        // Check the saved dark mode preference from localStorage
        const darkModeState = localStorage.getItem('dark-mode');

        if (darkModeState === 'enabled') {
            body.classList.add('dark-mode');
            toggleSwitch.classList.add('active'); // Add 'active' class to move the slider
            icon.classList.remove('bx-moon');
            icon.classList.add('bx-sun');
            logoName.style.color = 'white'; // Set logo text color to white when dark mode is enabled
        } else {
            toggleSwitch.classList.remove('active'); // Remove 'active' class when dark mode is disabled
            icon.classList.remove('bx-sun');
            icon.classList.add('bx-moon');
            logoName.style.color = ''; // Reset logo text color when dark mode is disabled
        }
    });
</script>


<style>
    .toggle-switch {
        background-color: transparent;
        /* Keeps it transparent */
        border: none;
        /* No border */
        cursor: pointer;
        /* Changes cursor to pointer on hover */
    }

    /* Dark Mode Styles */
    body.dark-mode {
        background-color: #1d1b31;
        color: #fff;
    }

    /* Sidebar Styles */
    .sidebar {
        background: #fff;
        /* Default background for light mode */
        transition: background-color 0.3s ease;
    }

    body.dark-mode .sidebar {
        background: #2c2b47;
        /* Dark background for dark mode */
    }

    .sidebar .nav-links li:hover {
        background: #f8f9fa;
        /* Hover color for light mode */
    }

    body.dark-mode .sidebar .nav-links li:hover {
        background: #59586b;
        /* Hover color for dark mode */
    }

    /* Sidebar Links */
    .sidebar .nav-links li a {
        color: #000;
        /* Default link color for light mode */
        transition: color 0.3s ease;
    }

    body.dark-mode .sidebar .nav-links li a {
        color: #fff;
        /* Link color for dark mode */
    }

    .sidebar .nav-links li a .link_name {
        color: #000;
        /* Default link text color */
    }

    body.dark-mode .sidebar .nav-links li a .link_name {
        color: #fff;
        /* Link text color for dark mode */
    }

    /* Active State Links in Sidebar */
    .sidebar .nav-links li a.active .link_name,
    .sidebar .nav-links li a.active i {
        color: #B66DFF;
        /* Purple color for active state */
    }

    /* Sub-menu Links */
    .sub-menu a {
        color: #000;
        /* Default sub-menu link color for light mode */
    }

    body.dark-mode .sub-menu a {
        color: #fff;
        /* Sub-menu link color for dark mode */
    }

    /* Hover State for Sub-menu Links */
    .sub-menu a:hover {
        color: #B66DFF;
        /* Purple color for hover state */
        background-color: rgba(182, 109, 255, 0.1);
        /* Slight background for hover */
        border-radius: 20px;
        margin-right: 35px;
    }

    /* Active State for Sub-menu Links */
    .sub-menu a.active {
        color: #B66DFF;
        /* Purple color for active sub-menu link */
        font-weight: bold;
        /* Bold active sub-menu link */
    }

    /* Home Section */
    .home-section {
        background: #f2edf3;
        /* Light background for home section in light mode */
        transition: background-color 0.3s ease;
    }

    body.dark-mode .home-section {
        background: #1d1b31;
        /* Dark background for home section in dark mode */
    }

    .home-content {
        background: #fff;
        /* Default background for home content in light mode */
    }

    body.dark-mode .home-content {
        background: #2c2b47;
        /* Dark background for home content in dark mode */
    }

    .home-content i {
        color: #a3a6ab;
        /* Icon color in light mode */
    }

    body.dark-mode .home-content i {
        color: #fff;
        /* Icon color in dark mode */
    }

    /* Profile Section */
    .profile-details-top .job {
        color: #888;
        /* Job text color in light mode */
    }

    body.dark-mode .profile-details-top .job {
        color: #ccc;
        /* Job text color in dark mode */
    }

    /* Toggle switch button container */
    .toggle-switch {
        position: relative;
        display: inline-block;
        width: 50px;
        height: 20px;
        background-color: #ccc;
        border-radius: 30px;
        border: none;
        cursor: pointer;
        transition: background-color 0.3s ease;
        margin-left: 5px;
    }

    .sidebar.close .toggle-switch {
        display: none;
    }

    /* Slider (the circle that moves) */
    .toggle-switch .slider {
        position: absolute;
        top: 3px;
        left: 3px;
        width: 14px;
        height: 14px;
        background-color: white;
        border-radius: 50%;
        transition: transform 0.3s ease;
    }

    /* When active (night mode on) */
    .toggle-switch.active {
        background-color: #BB73F9;
    }

    .toggle-switch.active {
        background-color: #BB73F9;

    }

    .sidebar.close .toggle-switch.active {
        display: none;
    }

    /* Moves the slider to the right when active */
    .toggle-switch.active .slider {
        transform: translateX(30px);
    }

    /* Moon and sun icon positioning */
    #modeIcon {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 18px;
        pointer-events: none;
    }

    /* Change icon to sun when active */
    #nightModeToggle.active #modeIcon {
        color: #fff;
    }

    /* Dark Mode Styles */
    body.dark-mode {
        background-color: #1d1b31;
        /* Warna latar belakang untuk mode gelap */
        color: #eaeaea;
        /* Warna teks untuk mode gelap */
    }

    /* Menyesuaikan elemen di sidebar untuk mode gelap */
    .sidebar.dark-mode {
        background-color: #2a2a2a;
        /* Warna sidebar di mode gelap */
    }

    /* Menyesuaikan warna link di sidebar */
    .sidebar.dark-mode .nav-links li a {
        color: #eaeaea;
        /* Warna link di mode gelap */
    }

    .sidebar.dark-mode .nav-links li a:hover {
        background-color: #3e3e3e;
        /* Warna hover di mode gelap */
    }

    /* Mengatur warna ikon di sidebar */
    .sidebar.dark-mode .nav-links li i {
        color: #eaeaea;
        /* Warna ikon di mode gelap */
    }

    /* Menyesuaikan posisi Help Center */
    .help-center {
        position: fixed;
        /* Memastikan pusat bantuan tetap di posisi tetap */
        right: 20px;
        /* Mengatur jarak dari kanan */
        bottom: 20px;
        /* Mengatur jarak dari bawah */
        background: #f8f9fa;
        /* Latar belakang pusat bantuan */
        border-radius: 8px;
        /* Sudut melengkung untuk pusat bantuan */
        padding: 10px;
        /* Memberikan ruang di dalam pusat bantuan */
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        /* Bayangan untuk efek kedalaman */
    }

    /* Menyesuaikan teks di pusat bantuan */
    .help-center p {
        color: #333;
        /* Warna teks pusat bantuan */
    }

    /* Mengatur tampilan pusat bantuan di mode gelap */
    body.dark-mode .help-center {
        background: #2a2a2a;
        /* Latar belakang pusat bantuan di mode gelap */
        color: #eaeaea;
        /* Warna teks pusat bantuan di mode gelap */
    }

    .bottom-section {
        margin-top: 125px;
    }

    .sidebar .bottom-section {
        display: flex;
        align-items: center;
        position: fixed;
        width: 260px;
        bottom: 0;
        left: 0;
        margin-bottom: -10px;
        padding: 10px 14px;
        color: white;
        transition: all 0.5s ease;
        white-space: nowrap;
        justify-content: space-between;
        background-color: #f8f9fa;
    }

    body.dark-mode .sidebar .bottom-section {
        background-color: #59586b;
    }


    .sidebar.close .bottom-section {
        flex-direction: column;
        width: 78px;
        /* Adjusted for closed state */
        padding: 10px 0;
        align-items: center;
    }

    /* Hide text labels when sidebar is closed */
    .sidebar.close .bottom-section .link_name {
        display: none;
        /* Hides the text when the sidebar is closed */
    }

    .sidebar .bottom-section .link_name {
        display: inline;
        /* Shows text when sidebar is open */
    }

    

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
        border-radius: 20px;
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
        font-size: 18px;
        font-weight: 600;
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

        display: none;
    }

    .sidebar .nav-links li.showMenu .sub-menu {
        display: block;
    }

    .sidebar .nav-links li .sub-menu a {
        color: #000;
        font-size: 14px;
        font-weight: 500;
        padding: 5px 20px;
        /* Adds left padding to indent the sub-menu */
        white-space: nowrap;
        opacity: 0.8;
        transition: opacity 0.3s ease;
        position: relative;
    }

    .sidebar .nav-links li .sub-menu a::before {

        font-size: 12px;
        opacity: 0.6;
        position: absolute;
        left: 0;
        /* Positions the bullet to the left of the sub-menu text */
        top: 50%;
        transform: translateY(-50%);
        /* Vertically centers the bullet */
    }

    .sidebar .nav-links li .sub-menu a:hover {
        opacity: 1;
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
        background: white;
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
        background: #fff;
        /* Non-transparent background */
        padding: 15px 20px;
        margin-top: 0;
        margin-left: 260px;
        /* Default margin untuk sidebar terbuka */
        transition: margin-left 0.5s ease, width 0.5s ease;
        /* Tambahkan transisi untuk margin dan width */
        position: fixed;
        /* Pastikan tetap di atas viewport */
        top: 0;
        /* Atur posisi di atas */
        width: calc(100% - 260px);
        /* Lebar saat sidebar terbuka */
        z-index: 10;
        /* Pastikan di atas sidebar */
    }

    .sidebar.close~.home-content {
        margin-left: 78px;
        /* Margin saat sidebar ditutup */
        width: calc(100% - 78px);
        /* Lebar saat sidebar ditutup */
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

    #logout-icon {
        font-size: 24px;
        margin-left: 10px;
        cursor: pointer;
        transition: color 0.3s ease;
    }

    #logout-icon:hover {
        color: red;
        /* Efek hover menjadi merah */
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

    // Logout functionality with SweetAlert confirmation
    document.getElementById('logout-icon').addEventListener('click', function (e) {
        e.preventDefault();  // Prevent form from submitting immediately

        // Show SweetAlert modal for logout confirmation with improved design
        Swal.fire({
            title: "Are you sure?",
            text: "You will be logged out of the system.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#6B07C2",
            cancelButtonColor: "#d33",
            confirmButtonText: "Log Out",
            cancelButtonText: "Cancel"
        }).then((result) => {
            if (result.isConfirmed) {
                // If the user confirms, submit the logout form
                document.getElementById('logout-form').submit();
            }
        });

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

</script>