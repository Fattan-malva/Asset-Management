@extends('layouts.app')

@section('content')
<br>
<br>
<br>
<br>
<h1 class="mt-4 text-center">Users</h1>
<br>
<br>
<br>
<div class="container">
    <div class="mb-3">
        <a href="{{ route('customer.create') }}" class="btn btn-lg btn-success">
            <i class="bi bi-cloud-plus-fill"></i> Create
        </a>
    </div>
    <div class="card">
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            <div class="table-responsive">
                <table id="customerTable" class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">No.</th>
                            <th scope="col">Email</th>
                            <th scope="col">NRP</th>
                            <th scope="col">Name</th>
                            <th scope="col">Position</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($customers as $index => $customer)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $customer->username }}</td>
                                <td>{{ $customer->nrp }}</td>
                                <td>{{ $customer->name }}</td>
                                <td>{{ $customer->mapping }}</td> 
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('customer.edit', ['id' => $customer->id]) }}"
                                            class="btn btn-sm btn-primary" title="Edit">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form action="{{ route('customer.delete', ['id' => $customer->id]) }}"
                                            method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Delete"
                                                onclick="return confirm('Are you sure you want to delete this customer?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center"style="padding: 50px; padding-bottom: 100px; padding-top: 100px; font-size: 1.2em;">No customer found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<br>
<br>
@endsection
