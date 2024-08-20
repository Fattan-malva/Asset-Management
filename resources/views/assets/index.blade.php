@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <br>
    <br>
    <br>
    <h1 class="text-center mb-4">List Status Approval</h1>

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
                                            data-bs-target="#detailModal{{ $asset->id }}" title="View Details" style="margin-right:10px;">
                                            <i class="bi bi-file-earmark-text"></i>
                                        </button>
                                        <!-- Conditional Button: Cancel Process -->
                                        @if ($asset->approval_status === 'Rejected' && $asset->aksi === 'Handover')
                                            <form action="{{ route('assets.delete', ['id' => $asset->id]) }}" method="POST" style="display:inline;">
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
                            </tr>

                            <!-- Modal -->
                            <div class="modal fade" id="detailModal{{ $asset->id }}" tabindex="-1"
                                aria-labelledby="detailModalLabel{{ $asset->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="detailModalLabel{{ $asset->id }}">Asset Details</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <strong>Asset Tagging:</strong> {{ $asset->tagging }}<br>
                                                    <strong>Name Holder:</strong> {{ $asset->customer_name }}<br>
                                                    <strong>Position:</strong> {{ $asset->customer_mapping }}<br>
                                                    <strong>Location:</strong> {{ $asset->lokasi }}<br>
                                                    <strong>Asset Type:</strong> {{ $asset->jenis_aset }}<br>
                                                    <strong>Merk:</strong> {{ $asset->merk_name }}<br>
                                                </div>
                                                <div class="col-md-6">
                                                    <strong>Serial Number:</strong> {{ $asset->serial_number }}<br>
                                                    <strong>O365:</strong> {{ $asset->o365 }}<br>
                                                    <strong>Status:</strong> {{ $asset->status }}<br>
                                                    <strong>Condition:</strong> {{ $asset->kondisi }}<br>
                                                    <strong>Transfer Date:</strong>
                                                    {{ \Carbon\Carbon::parse($asset->created_at)->format('d-m-Y') }}<br>
                                                    <strong>Documentation:</strong>
                                                    @if($asset->documentation)
                                                        <a href="{{ asset('storage/' . $asset->documentation) }}"
                                                            target="_blank">View Document</a>
                                                    @else
                                                        No Document
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center"
                                    style="padding: 50px; font-size: 1.2em;">No assets found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
