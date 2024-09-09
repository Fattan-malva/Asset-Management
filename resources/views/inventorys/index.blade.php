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
                                <td>
                                    <!-- Status Badge -->
                                    @if ($inventory->status === 'Inventory')
                                        <span class="badge bg-warning" style="padding: 5px;">Available</span>
                                    @elseif ($inventory->status === 'Operation')
                                        <span class="badge bg-success" style="padding: 5px;">In Use</span>
                                    @elseif ($inventory->status === 'Under Maintenance')
                                        <span class="badge bg-secondary" style="padding: 5px;">Under Maintenance</span>
                                    @else
                                        <span class="badge bg-danger" style="padding: 5px;">Unavailable</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal"
                                            data-bs-target="#detailsModal-{{ $inventory->id }}" title="Details">
                                            <i class="bi bi-file-earmark-text"></i> Detail
                                        </button>
                                        <form action="{{ route('inventorys.delete', ['id' => $inventory->id]) }}"
                                            method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Delete"
                                                onclick="return confirm('Are you sure you want to delete this inventory?')">
                                                <i class="bi bi-trash"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center"
                                    style="padding: 50px; padding-bottom: 100px; padding-top: 100px; font-size: 1.2em;">No
                                    Assets found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal HTML Structure -->
@foreach ($inventorys as $inventory)
    <div class="modal fade" id="detailsModal-{{ $inventory->id }}" tabindex="-1" aria-labelledby="detailsModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailsModalLabel">Asset Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Assets Tag:</strong> {{ $inventory->tagging }}</p>
                    <p><strong>Assets Name:</strong> {{ $inventory->asets }}</p>
                    <p><strong>Merk:</strong> {{ $inventory->merk_name }}</p>
                    <p><strong>Serial Number:</strong> {{ $inventory->seri }}</p>
                    <p><strong>Type:</strong> {{ $inventory->type }}</p>

                    <!-- QR Code Container -->
                    <div id="qrcode-{{ $inventory->id }}" class="text-center my-3"></div>

                    <!-- Print Label Button -->
                    <button type="button" class="btn btn-primary"
                        onclick="window.open('{{ route('prints.qr', ['id' => $inventory->id]) }}', '_blank')">
                        <i class="bi bi-printer"></i> Print QR Code
                    </button>
                </div>
                <div class="modal-footer">
                    <a href="{{ route('inventorys.edit', ['id' => $inventory->id]) }}" class="btn btn-primary">
                        <i class="bi bi-pencil-square"></i> Edit
                    </a>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endforeach

@endsection

@section('scripts')
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/qrcode/build/qrcode.min.js"></script>


@endsection