<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Register')</title>
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
            background: linear-gradient(to top right, #E5D3F6, #B86DFF);
        }

        .right-section {
            background-color: #F2EDF3;
        }

        .btn-primary {
            background-color: #8d45d1;
            border: none;
            border-radius: 10px;
        }

        .btn-primary:hover {
            background-color: #B86DFF;
        }

        .form-group label {
            font-weight: bold;
        }

        .login-link {
            text-align: center;
            margin-top: 15px;
        }

        .login-link a {
            color: #8d45d1;
            text-decoration: none;
        }

        .login-link a:hover {
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
            color: #888;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .form-row .col {
            display: flex;
            flex-direction: column;
        }

        .form-row .col .form-group {
            margin-bottom: 0px;
        }

        .form-row .col .form-group input {
            width: 100%;
        }

        .form-group-full {
            grid-column: 1 / -1;
        }

        .button-group {
            margin-top: 15px;
            text-align: center;
        }

        .button-group button {
            width: 100%;
            padding: 6px;
        }
        .text-center {
            margin-top: 60px;
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

            .left-section {
                display: none;
            }

            .right-section {
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
    </style>
</head>

<body>
    <div class="card">
        <div class="left-section">
            <div class="text-center">
                <script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs"
                    type="module"></script><dotlottie-player
                    src="https://lottie.host/1fe35e94-e1f9-43d4-b401-b23f59ac064b/BTLdiThtoe.json"
                    background="transparent" speed="1" style="width: 400px; height: 400px; margin-bottom:100px;" loop
                    autoplay></dotlottie-player>
            </div>
        </div>

        <div class="right-section">
            <div class="welcome">
                <div class="logo-text-wrapper">
                    <img src="{{ asset('assets/img/velaris.png') }}" alt="Register Image">
                    <h1>Register</h1>
                </div>
            </div>
            <form action="{{ route('user.storeregister') }}" method="POST">
                @csrf
                <div class="form-group form-group-full">
                    <i class="fas fa-id-card icon"></i>
                    <input type="text" class="form-control @error('nrp') is-invalid @enderror" id="nrp" name="nrp"
                        placeholder="Your NRP..." value="{{ old('nrp') }}" required>
                    @error('nrp')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-row">
                    <div class="col">
                        <div class="form-group">
                            <i class="fas fa-user icon"></i>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" placeholder="Your name..." value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <i class="fas fa-envelope icon"></i>
                            <input type="email" class="form-control @error('username') is-invalid @enderror" id="username"
                                name="username" placeholder="Your email..." value="{{ old('username') }}" required>
                            @error('username')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <i class="fas fa-briefcase icon"></i>
                            <input type="text" class="form-control @error('mapping') is-invalid @enderror" id="mapping"
                                name="mapping" placeholder="Your position..." value="{{ old('mapping') }}">
                            @error('mapping')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <i class="fas fa-lock icon"></i>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                id="password" name="password" placeholder="Your password..." value="{{ old('password') }}"
                                required>
                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <input type="hidden" name="role" value="user">
                <div class="form-group button-group">
                    <button type="submit" class="btn btn-primary btn-block">Register</button>
                    <div class="login-link">
                        <p>Already have an account? <a href="{{ route('login') }}">Login</a></p>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
<style>
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
<script>
    document.addEventListener("DOMContentLoaded", function () {
    const leftSection = document.querySelector('.left-section');
    const rightSection = document.querySelector('.right-section');



    // Saat pengguna meninggalkan halaman, animasi keluar (menutup ke dalam) ditambahkan
    window.addEventListener("beforeunload", function () {
        leftSection.classList.add('animate-out');
        rightSection.classList.add('animate-out');
    });
});

</script>