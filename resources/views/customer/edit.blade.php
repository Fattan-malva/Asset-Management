@extends('layouts.noheader')
@section('title', 'User Update')

@section('content')
<div class="container">
    <br>
    <br>
    <br>
    <div class="card shadow">
        <h2 style="margin-top: 25px; margin-bottom: 20px; text-align: center; font-weight: 600;">Edit User</h2>
        <hr style="width: 80%; margin: 0 auto;">
        <div class="card-body" style="padding: 30px;">
            <form method="POST" action="{{ route('customer.update', $customer->id) }}">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username"
                            placeholder="Enter your username" value="{{ old('username', $customer->username) }}" required>
                        @error('username')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="password" class="form-label">Password</label>
                        <div class="mb-1" style="position: relative;">
                            <span style="position: absolute; right: 10px; top: 35%; cursor: pointer;" onclick="togglePassword()">
                                <i id="password-icon" class="fas fa-eye" style="margin-top: 15px;"></i>
                            </span>
                        </div>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password"
                            placeholder="Enter your password" value="{{ old('password', $customer->password) }}" required>
                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="role" class="form-label">Role</label>
                        <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" required>
                            <option value="" disabled selected>Select role</option>
                            <option value="admin" {{ (old('role', $customer->role) == 'admin') ? 'selected' : '' }}>Admin</option>
                            <option value="user" {{ (old('role', $customer->role) == 'user') ? 'selected' : '' }}>User</option>
                        </select>
                        @error('role')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="nrp" class="form-label">NRP</label>
                        <input type="text" class="form-control @error('nrp') is-invalid @enderror" id="nrp" name="nrp"
                            placeholder="Enter your NRP" value="{{ old('nrp', $customer->nrp) }}" required>
                        @error('nrp')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                            placeholder="Enter your name" value="{{ old('name', $customer->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="mapping" class="form-label">Position</label>
                        <input type="text" class="form-control @error('mapping') is-invalid @enderror" id="mapping"
                            name="mapping" placeholder="Enter your position" value="{{ old('mapping', $customer->mapping) }}">
                        @error('mapping')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="mb-2 mt-2" style="text-align: right;">
                    <button type="submit" class="btn btn-save">Save</button>
                    <a href="{{ route('customer.index') }}" class="btn btn-cancel">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

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
        background-color: transparent;
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