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
        <div class="logo-details" style="margin-top:20px;">
            <img src="{{ asset('assets/img/GSI.png') }}" alt="Global Service Indonesia Logo"
                style="height: 50px; margin-right: 10px; margin-left: 13px; background-color: white; border-radius:50px;">
            <span class="logo_name">Global Service Indonesia</span>
        </div>

        <ul class="nav-links">
            <li>
                <a href="{{ route('dashboard') }}">
                    <i class='bx bx-grid-alt'></i>
                    <span class="link_name">Dashboard</span>
                </a>
            </li>
            <li>
                <div class="iocn-link">
                    <a href="{{ route('inventorys.index') }}">
                        <i class='bx bx-collection'></i>
                        <span class="link_name">Asset</span>
                    </a>
                    <i class='bx bxs-chevron-down arrow'></i>
                </div>
                <ul class="sub-menu">
                    <li><a href="{{ route('inventorys.total') }}">Total</a></li>
                    <li><a href="{{ route('inventorys.index') }}">List</a></li>
                    <li><a href="{{ route('inventorys.mapping') }}">Location</a></li>
                </ul>
            </li>
            <li>
                <div class="iocn-link">
                    <a href="{{ route('assets.index') }}">
                        <i class='bx bx-line-chart'></i>
                        <span class="link_name">Activity</span>
                    </a>
                    <i class='bx bxs-chevron-down arrow'></i>
                </div>
                <ul class="sub-menu">
                    <li><a href="{{ route('assets.index') }}">Approval Status</a></li>
                    <li><a href="{{ route('assets.create') }}">Handover</a></li>
                    <li><a href="{{ route('assets.indexmutasi') }}">Mutasi</a></li>
                    <li><a href="{{ route('assets.indexreturn') }}">Return</a></li>
                </ul>
            </li>
            <li>
                <a href="{{ route('assets.history') }}">
                    <i class='bx bx-history'></i>
                    <span class="link_name">History</span>
                </a>
            </li>
            <li>
                <div class="iocn-link">
                    <a href="#">
                        <i class='bx bx-cog'></i>
                        <span class="link_name">Setting</span>
                    </a>
                    <i class='bx bxs-chevron-down arrow'></i>
                </div>
                <ul class="sub-menu">
                    <li><a href="{{ route('customer.index') }}">Users</a></li>
                    <li><a href="{{ route('inventorys.create') }}">Add Asset</a></li>
                    <li><a href="{{ route('merk.index') }}">Add Merk</a></li>
                </ul>
            </li>
            <li>
                <div class="profile-details">
                    <div class="profile-content">
                        <img src="{{ asset('assets/img/admin.png') }}" alt="profileImg">
                    </div>
                    <div class="name-job">
                        <div class="profile_name">Admin</div>
                        <div class="job">Infrastructure</div>
                    </div>
                    <i class='bx bx-log-out' id="logout-icon" style="cursor:pointer;"></i>
                </div>
            </li>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </ul>
    </div>
    <section class="home-section">
        <div class="home-content">
            <i class='bx bx-menu'></i>
            <span class="text gsi-button" style="font-size:30px; font-weight: bold;">Global Service Indonesia</span>
        </div>
        <div class="">
            <main class="py-4">
                @yield('content')
            </main>
        </div>
    </section>
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
        sidebarBtn.addEventListener("click", () => {
            sidebar.classList.toggle("close");
        });
        document.getElementById('logout-icon').addEventListener('click', function (event) {
            event.preventDefault();
            document.getElementById('logout-form').submit();
        });
    </script>
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

.sidebar {
    position: fixed;
    top: 0;
    left: 0;
    height: 100%;
    width: 260px;
    background: #11101d;
    z-index: 100;
    transition: all 0.5s ease;
}

.sidebar.close {
    width: 78px;
}

.sidebar .logo-details {
    height: 60px;
    width: 100%;
    display: flex;
    align-items: center;
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
    font-size: 22px;
    color: #fff;
    font-weight: 600;
    transition: opacity 0.3s ease;
}

.sidebar.close .logo-details .logo_name {
    opacity: 0;
    pointer-events: none;
}

.sidebar .nav-links {
    height: 100%;
    padding: 30px 0 60px 0;
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
    background: #1d1b31;
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
    color: #fff;
    font-size: 20px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.sidebar .nav-links li.showMenu i.arrow {
    transform: rotate(-180deg);
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
    font-weight: 400;
    color: #fff;
    transition: opacity 0.4s ease;
}

.sidebar.close .nav-links li a .link_name {
    opacity: 0;
    pointer-events: none;
}

.sidebar .nav-links li .sub-menu {
    padding: 6px 6px 14px 80px;
    margin-top: -10px;
    background: #1d1b31;
    display: none;
}

.sidebar .nav-links li.showMenu .sub-menu {
    display: block;
}

.sidebar .nav-links li .sub-menu a {
    color: #fff;
    font-size: 15px;
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
    left: 78px; /* Menyesuaikan posisi submenu saat sidebar ditutup */
    top: 0;
    margin-top: 0;
    padding: 10px 20px;
    background: #1d1b31;
    border-radius: 0 6px 6px 0;
    opacity: 1;
    display: block;
    pointer-events: auto;
    transition: all 0.4s ease;
}

.sidebar.close .nav-links li .sub-menu .link_name {
    display: none;
}

.sidebar.close .nav-links li .sub-menu .link_name {
    font-size: 18px;
    opacity: 1;
    display: block;
}

.sidebar .profile-details {
    display: flex;
    align-items: center;
    position: fixed;
    width: 260px;
    bottom: 0;
    left: 0;
    padding: 10px 14px;
    background: #1d1b31;
    color: white;
    transition: all 0.5s ease;
    border-top: 1px solid #1d1b31;
    white-space: nowrap;
    justify-content: space-between;
}

.sidebar.close .profile-details {
    flex-direction: column;
    width: 78px;
    padding: 10px 0;
    align-items: center;
}

.sidebar .profile-details .profile-content {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.sidebar.close .profile-details .profile-content {
    display: block;
}

.sidebar .profile-details img {
    height: 35px;
    width: 35px;
    object-fit: cover;
    border-radius: 6px;
    margin-right: 10px;
}

.sidebar.close .profile-details img {
    margin-right: 0;
    margin-bottom: 0px;
}

.sidebar .profile-details .name-job {
    display: flex;
    flex-direction: column;
    line-height: 1.2;
}

.sidebar.close .profile-details .name-job {
    display: none;
}

.sidebar .profile-details i#logout-icon {
    font-size: 20px;
    cursor: pointer;
}

/* Style untuk Home Section */
.home-section {
    position: relative;
    background: whitesmoke;
    min-height: 100vh;
    width: calc(100% - 260px);
    left: 260px;
    transition: all 0.5s ease;
}

.sidebar.close~.home-section {
    width: calc(100% - 78px);
    left: 78px;
}

.home-section .home-content {
    height: 0px;
    display: flex;
    align-items: center;
    background: #E4E9F7;
    padding: 0 20px;
    margin-top: -25px;
}

.home-section .home-content i {
    font-size: 30px;
    color: #11101d;
    margin-right: 10px;
    cursor: pointer;
}

.home-section .home-content .text {
    font-size: 26px;
    font-weight: 600;
    color: #11101d;
}
@media (max-width: 768px) {
        .gsi-button {
            display: none;
        }
    }
</style>