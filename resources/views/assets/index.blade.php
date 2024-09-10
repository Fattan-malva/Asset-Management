@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="text-center mb-4 fw-bold display-5">List Status Approval</h1>
    <br>
    @if (session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="assetTable" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">No.</th>
                            <th scope="col">Asset Tagging</th>
                            <th scope="col">Name Holder</th>
                            <th scope="col">Asset Type</th>
                            <th scope="col">Merk</th>
                            <th scope="col">Location</th>
                            <th scope="col">Status</th>
                            <th scope="col">Process</th>
                            <th scope="col">Approval</th>
                            <th scope="col">Actions</th>
                            <th scope="col">Track</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($assets as $index => $asset)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $asset->tagging }}</td>
                                <td>{{ $asset->customer_name }}</td>
                                <td>{{ $asset->jenis_aset }}</td>
                                <td>{{ $asset->merk_name }}</td>
                                <td>{{ $asset->lokasi }}</td>
                                <td>{{ $asset->status }}</td>
                                <td>{{ $asset->aksi }}</td>

                                <td>
                                    <!-- Approval Status Badge -->
                                    @if ($asset->approval_status === 'Approved')
                                        <span class="badge bg-success" style="padding: 5px;">Approved</span>
                                    @elseif ($asset->approval_status === 'Pending')
                                        <span class="badge bg-primary" style="padding: 5px;">Waiting Approval</span>
                                    @elseif ($asset->approval_status === 'Rejected')
                                        <span class="badge bg-danger" style="padding: 5px;">Rejected</span>
                                    @else
                                        <span class="badge bg-secondary" style="padding: 5px;">Unknown</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <!-- Button to View Details -->
                                        <button class="btn btn-sm btn-info" data-bs-toggle="modal"
                                            data-bs-target="#detailModal{{ $asset->id }}" title="View Details"
                                            style="margin-right:10px;">
                                            <i class="bi bi-file-earmark-text"></i> Detail
                                        </button>
                                        <!-- Conditional Button: Cancel Process -->
                                        @if ($asset->approval_status === 'Rejected' && $asset->aksi === 'Handover')
                                            <form action="{{ route('assets.delete', ['id' => $asset->id]) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger" title="Cancel Process"
                                                    onclick="return confirm('Are you sure you want to return this asset to inventory?')">
                                                    Cancel Process
                                                </button>
                                            </form>
                                        @endif

                                        <!-- Conditional Button: Rollback Name -->
                                        @if ($asset->approval_status === 'Rejected' && ($asset->aksi === 'Mutasi' || $asset->aksi === 'Return'))
                                            <form action="{{ route('assets.rollbackMutasi', ['id' => $asset->id]) }}"
                                                method="POST" style="display:inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-warning" title="Rollback Name"
                                                    onclick="return confirm('Are you sure you want to rollback this asset to its previous name?')">
                                                    Rollback Name
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <a href="{{ route('assets.track', ['id' => $asset->id]) }}" class="btn btn-success"
                                        title="Track Asset">
                                        <i class="bi bi-geo-alt"></i> Track
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11" class="text-center" style="padding: 50px; font-size: 1.2em;">No assets
                                    found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modals -->
@foreach ($assets as $asset)
    <div class="modal fade" id="detailModal{{ $asset->id }}" tabindex="-1"
        aria-labelledby="detailModalLabel{{ $asset->id }}" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title text-center font-weight-bold" id="detailModalLabel{{ $asset->id }}">Asset Details
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-borderless no-border-table">
                        <tbody>
                            <tr>
                                <th scope="row">Asset Tagging</th>
                                <td>{{ $asset->tagging }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Name Holder</th>
                                <td>{{ $asset->customer_name }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Position</th>
                                <td>{{ $asset->customer_mapping }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Location</th>
                                <td>{{ $asset->lokasi }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Asset Type</th>
                                <td>{{ $asset->jenis_aset }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Merk</th>
                                <td>{{ $asset->merk_name }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Serial Number</th>
                                <td>{{ $asset->serial_number }}</td>
                            </tr>
                            <tr>
                                <th scope="row">O365</th>
                                <td>{{ $asset->o365 }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Status</th>
                                <td>{{ $asset->status }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Condition</th>
                                <td>{{ $asset->kondisi }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Transfer Date</th>
                                <td>{{ \Carbon\Carbon::parse($asset->created_at)->format('d-m-Y') }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Documentation</th>
                                <td>
                                    @if($asset->documentation)
                                        <a href="{{ asset('storage/' . $asset->documentation) }}" target="_blank">View
                                            Document</a>
                                    @else
                                        No Document
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="modal-footer">
                        <br>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach

@endsection


<style>
    /* CSS to remove table borders in modals */
    .no-border-table th,
    .no-border-table td {
        border: none !important;
    }
    .modal-title {
    font-weight: bold;
    text-align: center;
    width: 100%; /* Memastikan elemen judul memanfaatkan lebar penuh */
    margin: 0; /* Menghapus margin default */
    padding: 0; /* Menghapus padding default jika ada */
}

/* CSS tambahan untuk memastikan tidak ada margin atau padding yang mengganggu */
.modal-header {
    display: flex;
    justify-content: center; /* Menyelaraskan konten ke tengah secara horizontal */
}
</style>