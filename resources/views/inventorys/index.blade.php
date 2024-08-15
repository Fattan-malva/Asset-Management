@extends('layouts.app')

@section('content')
<br>
<br>
<h1 class="mt-4 text-center">Asset List</h1>
<br>
<br>
<br>
<div class="container">
    <div class="card">
        <div class="card-header">
            <h2>Asets List GSI</h2>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger" role="alert">
                    {{ session('error') }}
                </div>
            @endif
            <div class="table-responsive">
                <table id="inventoryTable" class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">No.</th>
                            <th scope="col">Asets Tag</th>
                            <th scope="col">Asets Name</th>
                            <th scope="col">Merk</th>
                            <th scope="col">Serial Number</th>
                            <th scope="col">Type</th>
                            <th scope="col">Kondisi</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($inventorys as $index => $inventory)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $inventory->tagging }}</td>
                                <td>{{ $inventory->asets }}</td>
                                <td>{{ $inventory->merk_name }}</td> <!-- Display merk name -->
                                <td>{{ $inventory->seri }}</td>
                                <td>{{ $inventory->type }}</td>
                                <td>{{ $inventory->kondisi }}</td>
                                <td>{{ $inventory->status }}</td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('inventorys.edit', ['id' => $inventory->id]) }}"
                                            class="btn btn-sm btn-primary" title="Edit">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form action="{{ route('inventorys.delete', ['id' => $inventory->id]) }}"
                                            method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Delete"
                                                onclick="return confirm('Are you sure you want to delete this inventory?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center" style="padding: 50px; padding-bottom: 100px; padding-top: 100px; font-size: 1.2em;">No Assets found.</td>
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
