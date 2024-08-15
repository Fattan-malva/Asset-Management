@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1 class="mt-4 text-center">Create User</h1>
            <p class="animate__animated animate__fadeInUp text-center">In the fast-paced world of logistics,
                reliability and exceptional service are paramount. At Management Inventory, we pride ourselves
                on providing top-notch logistics solutions that cater to all your business needs. Our
                user are designed to ensure that your goods are transported efficiently, safely, and on
                time, every time.</p>
            <div class="card">
                <div class="card-header">Create User</div>
                <div class="card-body">
                    <form action="{{ route('user.store') }}" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="username">Username</label>
                            <input type="text" class="form-control @error('username') is-invalid @enderror"
                                id="username" name="username" value="{{ old('username') }}">
                            @error('username')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="password">Password</label>
                            <input type="text" class="form-control @error('password') is-invalid @enderror"
                                id="password" name="password" value="{{ old('password') }}">
                            @error('password')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="role">Role</label>
                            <select class="form-control @error('role') is-invalid @enderror" id="role" name="role">
                                <option value="">--SelectRole--</option>
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="leader" {{ old('role') == 'leader' ? 'selected' : '' }}>Leader</option>
                                <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
                            </select>
                            @error('role')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Create User</button>
                        <a href="{{ route('user.index') }}" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection