<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
        body {
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.9)), url('assets/img/slide/slide1.jpg');
            background-size: cover;
            background-position: center;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .card {
            width: 100%;
            max-width: 380px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
            background-color: rgba(255, 255, 255, 0.9);
            padding: 20px;
        }

        .card-header {
            background-color: #343a40;
            color: #ffffff;
            font-size: 1.5rem;
            text-align: center;
            padding: 15px;
            border-radius: 10px 10px 0 0;
        }

        .btn-primary {
            background-color: #343a40;
            border: none;
            margin-top: 15px;
        }

        .btn-primary:hover {
            background-color: #495057;
        }

        .form-group label {
            font-weight: bold;
        }

        .register-link {
            text-align: center;
            margin-top: 15px;
        }

        .register-link a {
            color: #007bff;
            text-decoration: none;
        }

        .register-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="card">
        <div class="card-header">Login</div>
        <div class="card-body">
            @if(session('error'))
            <div class="alert alert-danger" role="alert">
                {{ session('error') }}
            </div>
            @endif
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <label for="username">Email</label>
                    <input type="email" class="form-control" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Login</button>
            </form>
            <div class="register-link">
                <p>Don't have an account? <a href="{{ route('auth.register') }}">Register here</a></p>
            </div>
        </div>
    </div>
</body>

</html>
