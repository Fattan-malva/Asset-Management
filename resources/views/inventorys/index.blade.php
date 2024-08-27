@extends('layouts.app')

@section('content')
<h1 class="mt-4 text-center fw-bold display-5">Asset List</h1>
<br>
<br>
<br>
<div class="container">
    <div class="card">
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
                            <th scope="col">Assets Tag</th>
                            <th scope="col">Assets Name</th>
                            <th scope="col">Merk</th>
                            <th scope="col">Serial Number</th>
                            <th scope="col">Type</th>
                            <th scope="col">Condition</th>
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
                                <td>{{ $inventory->merk_name }}</td>
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
                                <td colspan="9" class="text-center" style="padding: 50px; padding-bottom: 100px; padding-top: 100px; font-size: 1.2em;">No Assets found.</td>
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

@section('scripts')
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#inventoryTable').DataTable({
                paging: false,          // Enable pagination
                searching: true,       // Enable search functionality
                info: false,            // Show information about table state
                lengthChange: false,   // Disable length change dropdown
                pageLength: 10         // Default number of rows per page
            });
        });
    </script>
@endsection
