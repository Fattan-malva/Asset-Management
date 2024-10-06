@extends('layouts.noheader')
@section('title', 'User Create')
@section('content')
<br>
<br>
<br>
<div class="container">
    <div class="card shadow">
        <h2 style="margin-top: 25px; margin-bottom: 20px; text-align: center; font-weight: 600;">Create User</h2>
        <hr style="width: 80%; margin: 0 auto;">
        <div class="card-body" style="padding: 30px;">
            <form action="{{ route('customer.store') }}" method="POST">
                @csrf
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="username" class="form-label">Username</label>
                        <input type="email" class="form-control @error('username') is-invalid @enderror" id="username" name="username"
                            value="{{ old('username') }}" placeholder="Username"  required>
                        @error('username')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="password" class="form-label">Password</label>
                        <div class="mb-1" style="position: relative;">
                            <span style="position: absolute; right: 10px; top: 35%; cursor: pointer;" onclick="togglePassword()">
                                <i id="password-icon" class="fas fa-eye" style="margin-top: 15px;"></i>
                            </span>
                        </div>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password"
                            value="{{ old('password') }}" placeholder="Password"  required>
                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="role" class="form-label">Role</label>
                        <input type="text" class="form-control @error('role') is-invalid @enderror" id="role" name="role"
                            value="{{ old('role') }}" placeholder="Role"  required>
                        @error('role')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="nrp" class="form-label">NRP</label>
                        <input type="text" class="form-control @error('nrp') is-invalid @enderror" id="nrp" name="nrp"
                            value="{{ old('nrp') }}" placeholder="NRP"  required>
                        @error('nrp')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                            value="{{ old('name') }}" placeholder="Name User" required>
                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="mapping" class="form-label">Position</label>
                        <input type="text" class="form-control @error('mapping') is-invalid @enderror" id="mapping"
                            name="mapping" value="{{ old('mapping') }}" placeholder="Position">
                        @error('mapping')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="mt-3 mb-2" style="text-align: right;">
                    <button type="submit" class="btn btn-save">Create</button>
                    <a href="{{ route('customer.index') }}" class="btn btn-cancel">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
<br>
<br>

<style>
    .form-label {
        font-weight: 550;
    }
    .form-control {
        border: 1px solid #000;
    }
    .btn-save {
        background-color: transparent;
        border: 1.3px solid #1bcfb4;
        color: #1bcfb4;
        transition: background-color 0.3s, color 0.3s;
        font-weight: 500;
        padding: 5px 25px;
    }
    .btn-save:hover {
        background-color: #1bcfb4;
        color: #fff;
        padding: 5px 25px;
    }
    .btn-cancel {
        background-color: #fe7c96;
        border: 1.3px solid #fe7c96;
        color: #fff;
        transition: background-color 0.3s, color 0.3s;
        font-weight: 500;
        margin-left: 5px;
        padding: 5px 15px;
    }
    .btn-cancel:hover {
        background-color: transparent; /* A slightly darker shade for hover */
        border: 1.3px solid #fe7c96;
        color: #fe7c96;
        padding: 5px 15px;
    }
</style>

<script>
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
@endsection