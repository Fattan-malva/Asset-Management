<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Login')</title>
    <link rel="icon" href="{{ asset('assets/img/velaris.png') }}" type="image/png">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f5f5f5;
        }

        .card {
            display: flex;
            flex-direction: row;
            width: 80%;
            height: 80%;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            background-color: white;
        }

        .left-section,
        .right-section {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            width: 50%;
            padding: 20px;
        }

        .left-section {
            background-color: #F2EDF3;
        }

        .right-section {
            background: linear-gradient(to top right, #E5D3F6, #B86DFF);
        }

        .btn-primary {
            background-color: #8d45d1;
            border: none;
            margin-top: 15px;
            border-radius: 10px;
        }

        .btn-primary:hover {
            background-color: #B86DFF;
        }

        .form-group label {
            font-weight: bold;
        }

        .register-link {
            text-align: center;
            margin-top: 15px;
        }

        .register-link a {
            color: #8d45d1;
            text-decoration: none;
        }

        .register-link a:hover {
            text-decoration: underline;
        }

        img {
            max-width: 80%;
            height: auto;
        }

        h1 {
            font-size: 2.5rem;
            text-align: center;
            font-weight: bold;
        }

        .form-container {
            width: 100%;
            max-width: 380px;
            text-align: center;
        }

        .welcome {
            margin-bottom: 30px;
        }

        .logo-text-wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .logo-text-wrapper img {
            height: 60px;
        }

        small.form-text {
            margin-top: 10px;
            display: block;
        }

        .form-group {
            position: relative;
        }

        .form-control {
            padding-left: 40px;
            border-radius: 10px;
        }

        .form-control::placeholder {
            color: #999;
            opacity: 1;
        }

        .icon {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #b66dff;
        }

        .text-center {
            margin-top: 60px;
        }

        /* Overlay and loading animation */
        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* Redupkan background */
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }

        .overlay.active {
            display: flex;
        }

        /* Mobile responsiveness */
        @media (max-width: 768px) {
            .card {
                flex-direction: column;
                width: 100%;
                height: auto;
            }

            .left-section,
            .right-section {
                width: 100%;
                padding: 15px;
            }

            .right-section {
                display: none;
            }

            .left-section {
                height: 100vh;
            }

            .form-container {
                width: 100%;
                max-width: 320px;
            }

            h1 {
                font-size: 1.8rem;
            }
        }

        /* Animasi untuk memudar masuk */
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        /* Animasi untuk menutup ke dalam */
        @keyframes collapseToRight {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(100%);
                opacity: 1;
            }
        }

        @keyframes collapseToLeft {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(-100%);
                opacity: 1;
            }
        }

        .left-section.animate-out {
            animation: collapseToRight 0.8s ease-in-out forwards;
        }

        .right-section.animate-out {
            animation: collapseToLeft 0.8s ease-in-out forwards;
        }
    </style>
</head>

<body>
    <div class="card">
        <div class="left-section">
            <div class="form-container">
                <div class="welcome">
                    <div class="logo-text-wrapper">
                        <img src="{{ asset('assets/img/velaris.png') }}" alt="Login Image">
                        <h1>eLaris</h1>
                    </div>
                    <small class="form-text text-muted">Visionary Asset Lifecycle and Resource Intelligent System</small>
                </div>

                <div class="text-center">
                    @if(session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif
                    <form method="POST" action="{{ route('login') }}" id="loginForm">
                        @csrf
                        <div class="form-group">
                            <i class="fas fa-user icon"></i>
                            <input type="email" class="form-control" id="username" name="username" placeholder="Your email..." required>
                        </div>
                        <div class="form-group">
                            <i class="fas fa-lock icon"></i>
                            <div class="mb-1" style="position: relative;">
                                <span style="position: absolute; right: 40px; top: 35%; margin-top: 7.5px; cursor: pointer;" onclick="togglePassword()">
                                    <i id="password-icon" class="fas fa-eye icon" style="margin-top: 11px;"></i>
                                </span>
                            </div>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Your password..." required>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block">Login</button>
                    </form>
                    <div class="register-link">
                        <p>Don't have an account? <a href="{{ route('auth.register') }}">Register here</a></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="right-section">
            <script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs" type="module"></script>
            <dotlottie-player src="https://lottie.host/f7367c7c-1cec-451a-8e45-77f553c80baf/ulfq6H1NiO.json"
                background="transparent" speed="1" style="width: 550px; height: 550px; margin-bottom : 70px;" loop autoplay></dotlottie-player>
        </div>
    </div>

    <!-- Overlay and loading animation -->
    <div class="overlay" id="loadingOverlay">
        <dotlottie-player src="https://lottie.host/19a1839c-74a1-49d3-ae7c-41b465f7f546/KLdGOA1RNO.json"
            background="transparent" speed="1" style="width: 300px; height: 300px;" loop autoplay></dotlottie-player>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const leftSection = document.querySelector('.left-section');
            const rightSection = document.querySelector('.right-section');
            const loginForm = document.getElementById('loginForm');
            const overlay = document.getElementById('loadingOverlay');

            // Saat pengguna meninggalkan halaman, animasi keluar (menutup ke dalam) ditambahkan
            window.addEventListener("beforeunload", function () {
                if (!loginForm.querySelector('.alert')) { // Cek jika tidak ada error
                    leftSection.classList.add('animate-out');
                    rightSection.classList.add('animate-out');
                }
            });

            // Saat form dikirim, tampilkan loading overlay
            loginForm.addEventListener('submit', function (event) {
                event.preventDefault();
                overlay.classList.add('active'); // Tampilkan overlay dan animasi
                loginForm.submit(); // Lanjutkan pengiriman form
            });
        });

        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const passwordIcon = document.getElementById('password-icon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                passwordIcon.classList.remove('fa-eye');
                passwordIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                passwordIcon.classList.remove('fa-eye-slash');
                passwordIcon.classList.add('fa-eye');
            }
        }
    </script>
</body>

</html>