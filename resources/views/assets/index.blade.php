@extends('layouts.app')

@section('content')
<br>
<br>
<br>
<br>
<h1 class="mt-4 text-center">Activity</h1>
<br>
<br>
<br>
<div class="container">
    <div class="mb-3">
        <a href="{{ route('assets.create') }}" class="btn btn-lg btn-success">
            <i class="bi bi-cloud-plus-fill"></i> Serah Terima
        </a>
    </div>
    <div class="card">
        <div class="card-header">
            <h2>Asets Operation</h2>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif
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
                                <td>{{ $asset->approval_status }}</td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn btn-sm btn-info" data-bs-toggle="modal"
                                            data-bs-target="#detailModal{{ $asset->id }}" title="View Details">
                                            <i class="bi bi-file-earmark-text"></i>
                                        </button>
                                        <a href="{{ route('assets.edit', ['id' => $asset->id]) }}"
                                            class="btn btn-sm btn-primary" title="Edit">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <a href="{{ route('assets.pindahtangan', ['id' => $asset->id]) }}"
                                            class="btn btn-sm btn-warning" title="Edit">
                                            Mutasi
                                        </a>
                                        <form action="{{ route('assets.delete', ['id' => $asset->id]) }}" method="POST"
                                            style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Delete"
                                                onclick="return confirm('Are you sure you want to delete this asset?')">
                                                Return
                                            </button>
                                        </form>
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
                                                    <strong>Nama Customer:</strong> {{ $asset->customer_name }}<br>
                                                    <strong>Position:</strong> {{ $asset->customer_mapping }}<br>
                                                    <strong>Location:</strong> {{ $asset->lokasi }}<br>
                                                    <strong>Jenis Aset:</strong> {{ $asset->jenis_aset }}<br>
                                                    <strong>Merk:</strong> {{ $asset->merk_name }}<br>
                                                </div>
                                                <div class="col-md-6">
                                                    <strong>Serial Number:</strong> {{ $asset->serial_number }}<br>
                                                    <strong>O365:</strong> {{ $asset->o365 }}<br>
                                                    <strong>Status:</strong> {{ $asset->status }}<br>
                                                    <strong>Kondisi:</strong> {{ $asset->kondisi }}<br>
                                                    <strong>Serah Terima:</strong>
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
                                <td colspan="7" class="text-center"
                                    style="padding: 50px; padding-bottom: 100px; padding-top: 100px; font-size: 1.2em;">No
                                    assets found.</td>
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