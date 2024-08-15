<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa; /* Light gray background */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .card {
            width: 100%;
            max-width: 400px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: #343a40;
            color: #ffffff;
            font-size: 1.25rem;
            text-align: center;
            padding: 1rem;
            border-bottom: 1px solid #495057;
        }

        .card-body {
            padding: 2rem;
        }

        .btn-primary {
            background-color: #343a40;
            border: none;
        }

        .btn-primary:hover {
            background-color: #495057;
        }

        .alert-danger {
            background-color: #f8d7da;
            border-color: #f5c6cb;
            color: #721c24;
        }

        .form-group label {
            font-weight: bold;
        }

        .register-link {
            text-align: center;
            margin-top: 1rem;
        }

        .register-link a {
            color: #007bff;
            text-decoration: none;
        }

        .register-link a:hover {
            text-decoration: underline;
        }

        .button-group {
            display: flex;
            justify-content: space-between;
        }

        .button-group .btn {
            flex: 1;
            margin: 0 0.5rem;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="card">
            <div class="card-header">Register</div>
            <div class="card-body">
                <form action="{{ route('user.storeregister') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="username">Email</label>
                        <input type="email" class="form-control @error('username') is-invalid @enderror" id="username" name="username"
                            value="{{ old('username') }}" required>
                        @error('username')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password"
                            value="{{ old('password') }}" required>
                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <input type="hidden" name="role" value="user">
                    <div class="form-group">
                        <label for="nrp">NRP</label>
                        <input type="text" class="form-control @error('nrp') is-invalid @enderror" id="nrp" name="nrp"
                            value="{{ old('nrp') }}" required>
                        @error('nrp')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                            value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="mapping">Position</label>
                        <input type="text" class="form-control @error('mapping') is-invalid @enderror" id="mapping" name="mapping"
                            value="{{ old('mapping') }}">
                        @error('mapping')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <br>
                    <div class="form-group button-group">
                        <button type="submit" class="btn btn-primary">Register</button>
                        <a href="{{ route('login') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
