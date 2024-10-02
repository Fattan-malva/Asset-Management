@extends('layouts.app')
@section('title', 'Asset Return')
@section('content')
<br>
<div class="container">
    <div style="display: flex; align-items: center; justify-content: space-between; padding: 10px; margin-top: 30px;">
        <i class='bx bx-arrow-back' id="back-icon" style="cursor:pointer; background: linear-gradient(135deg, #FFFFFF, #B66DFF); height: 36px; width: 36px; border-radius: 4px; color: #fff; display: flex; align-items: center; justify-content: center; box-shadow: 0 3px 8.3px .7px rgba(163, 93, 255, .35); margin-right: auto;">
        </i>
        <h3 style="font-weight: bold; font-size: 1.125rem;">
            Asset Return&nbsp;&nbsp;
            <span style="background: linear-gradient(135deg, #FFFFFF, #B66DFF); height: 36px; width: 36px; border-radius: 4px; color: #fff; display: inline-flex; align-items: center; justify-content: center; box-shadow: 0 3px 8.3px .7px rgba(163, 93, 255, .35);">
                <i class="fas fa-2xs fa-list" style="font-size: 16px;"></i>
            </span>
        </h3>
    </div>
    <div class="card">
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">No.</th>
                            <th scope="col">Name Holder</th>
                            <th scope="col">Asset Tagging</th>
                            <th scope="col">Asset Type</th>
                            <th scope="col">Merk</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($assets as $index => $asset)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $asset->customer_name }}</td>
                                <td>{{ $asset->tagging }}</td>
                                <td>{{ $asset->jenis_aset }}</td>
                                <td>{{ $asset->merk_name }}</td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('assets.return', ['id' => $asset->id]) }}"
                                            class="btn btn-sm" style="background-color: #fe7c96; color: #fff; font-weight: 500;" title="Return">
                                            Return
                                        </a>
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
                                                    <strong>Name Customer:</strong> {{ $asset->customer_name }}<br>
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
                                <td colspan="9" class="text-center"
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

<style>
        /* CSS for table row borders */
        .table-hover tbody tr td,
    .table-hover thead tr th {
        border-bottom: 1px solid #ebedf2; /* Add a border to the bottom of each row */
        background-color: #fff;
    }

    .table-hover tbody tr td {
        font-weight: 300;
    }

    .table-hover thead tr th {
        font-weight: 600;
    }

    /* Remove any cell borders */
    .table-hover th,
    .table-hover td {
        border: none; /* Remove borders from cells */
        padding: 10px; /* Keep padding for cells */
    }
</style>
@endsection