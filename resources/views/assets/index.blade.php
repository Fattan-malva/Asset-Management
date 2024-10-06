@extends('layouts.app')
@section('title', 'Approval Status')
@section('content')
<div class="container">
    <div>
        <div class="container">
            <div class="header-container">
                <div class="back-wrapper">
                    <i class='bx bxs-chevron-left back-icon' id="back-icon"></i>
                    <div class="back-text">
                        <span class="title">Back</span>
                        <span class="small-text">to previous page</span>
                    </div>
                </div>
                <h3 class="dashboard-title">
                    Approval Status&nbsp;&nbsp;
                    <span class="icon-wrapper">
                        <i class="fa-solid fa-2xs fa-calendar-check previous-icon"></i>
                    </span>
                </h3>
            </div>
        </div>
    </div>

    <div class="card">
        <!-- Button Section -->
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            <div class="mb-3">
                <div class="d-flex justify-content-start">
                    <a href="{{ route('assets.create') }}" class="btn btn-sm me-2"
                        style="background-color: #1BCFB4; color: #fff; font-weight: bold">Handover Asset</a>
                    <a href="{{ route('assets.indexreturn') }}" class="btn btn-sm"
                        style="background-color: #FE7C96; color: #fff; font-weight: bold">Return Asset</a>
                </div>
            </div>
            <div class="table-responsive">
                <table id="assetTable" class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">No.</th>
                            <th scope="col">Asset Tagging</th>
                            <th scope="col">Name Holder</th>
                            <th scope="col">Asset Type</th>
                            <th scope="col">Merk</th>
                            <th scope="col">Process</th>
                            <th scope="col">Approval</th>
                            <th scope="col">Actions</th>
                            <!-- <th scope="col">Track</th> -->
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
                                <td>{{ $asset->aksi }}</td>
                                <td>
                                    <!-- Approval Status Badge -->
                                    @if ($asset->approval_status === 'Approved')
                                        <span class="badge"
                                            style="padding: 6px 10px; background-color: #1BCFB4;">Approved</span>
                                    @elseif ($asset->approval_status === 'Pending')
                                        <span class="badge" style="padding: 6px 10px; background-color: #FED713;">Waiting
                                            Approval</span>
                                    @elseif ($asset->approval_status === 'Rejected')
                                        <span class="badge"
                                            style="padding: 6px 10px; background-color: #FE7C96;">Rejected</span>
                                    @else
                                        <span class="badge bg-secondary" style="padding: 5px;">Unknown</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <!-- Button to View Details -->
                                        <button class="btn btn-sm"
                                            style="background-color: #4FB0F1; color: #fff; font-weight:500;"
                                            data-bs-toggle="modal" data-bs-target="#detailModal{{ $asset->id }}"
                                            title="View Details" style="margin-right:10px;">
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

                                    <a href="{{ route('assets.track', ['id' => $asset->id]) }}" class="btn"
                                        style="background-color: #CB95E1; color: #fff; font-weight:500;"
                                        title="Track Asset">
                                        <i class="bi bi-geo-alt"></i> Track
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center" style="padding: 50px; font-size: 1.2em;">No approval
                                    status found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-4">
                    <ul class="list-unstyled legend-list">
                        <li>
                            <span class="badge legend-badge"
                                style="padding: 5px 28px; background-color: #1BCFB4;">Approved</span>
                            <span class="legend-colon">:</span>
                            <span class="legend-description">The asset has been approved by the user.</span>
                        </li>
                        <li>
                            <span class="badge legend-badge" style="padding: 5px 7px; background-color: #FED713">Waiting
                                Approval</span>
                            <span class="legend-colon">:</span>
                            <span class="legend-description">Waiting for the asset to be approved by the user.</span>
                        </li>
                        <li>
                            <span class="badge legend-badge"
                                style="padding: 5px 31px; background-color: #FE7C96;">Rejected</span>
                            <span class="legend-colon">:</span>
                            <span class="legend-description">The asset is rejected by the user.</span>
                        </li>
                    </ul>
                </div>
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
                    <div class="row">
                        <!-- Tabel Kiri -->
                        <div class="col-md-6">
                            <table class="table table-borderless">
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
                                </tbody>
                            </table>
                        </div>

                        <!-- Tabel Kanan -->
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tbody>
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
                                                <a href="{{ asset('storage/' . $asset->documentation) }}" target="_blank"
                                                    class="text-decoration-underline">View
                                                    Document</a>
                                            @else
                                                No Document
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <br>
                </div>
            </div>
        </div>
    </div>
@endforeach

<style>
    .card {
        box-shadow: rgba(0, 0, 0, 0.15) 0px 3px 3px 0px;
    }

    .table-borderless th {
        width: 40%;
        /* Width for header cells */
        text-align: left;
        /* Align text to the left */
    }

    .table-borderless td {
        width: 60%;
        /* Width for data cells */
        text-align: left;
        /* Align text to the left */
    }

    .legend-list {
        font-size: 0.875em;
        line-height: 1.5;
        margin-top: 33px;
    }

    .legend-list li {
        display: flex;
        flex-direction: column;
        /* Stack items vertically on mobile */
        align-items: flex-start;
        /* Align items to the start */
        margin-bottom: 5px;
    }

    .legend-list li .badge {
        min-width: 80px;
        margin-right: 0px;
    }

    .legend-list li .legend-description {
        margin-left: 0px;
        text-align: left;
    }

    .legend-colon {
        margin: 0 5px;
        /* Space around the colon */
    }

    /* Hide colon on mobile devices */
    @media (max-width: 576px) {
        .legend-colon {
            display: none;
            /* Hide colon */
        }
    }


    @media (min-width: 576px) {
        .legend-list li {
            flex-direction: row;
            /* Align items horizontally on larger screens */
            align-items: center;
        }

        .legend-list li .legend-description {
            margin-left: 10px;
            /* Add margin for larger screens */
        }
    }

    /* Header Styles */
    .header-container {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px;
        margin-top: 54px;
    }

    .back-icon {
        cursor: pointer;
        background: linear-gradient(90deg, rgba(255, 255, 255, 0) -30%, #B66DFF);
        height: 36px;
        width: 36px;
        border-radius: 4px;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 2px 2px 6px rgba(0, 0, 0, 0.25);
        margin-right: auto;
        transition: background 0.3s ease;
        /* Transition untuk efek hover */
    }

    .back-icon:hover {
        background: linear-gradient(90deg, rgba(255, 255, 255, 0.1) -13%, #B100FF);
        /* Warna gradien saat hover dengan putih sedikit di kiri */
    }

    .back-wrapper {
        display: flex;
        align-items: center;
        /* Center vertically */
        margin-right: auto;
        /* Push the dashboard title to the right */
    }

    .back-text {
        display: flex;
        flex-direction: column;
        /* Stack text vertically */
        margin-left: 10px;
        /* Space between icon and text */
    }

    .back-text .title {
        font-weight: 600;
        font-size: 17px;
    }

    .back-text .small-text {
        font-size: 0.8rem;
        /* Smaller font size for the second line */
        color: #aaa;
        /* Optional: a lighter color for the smaller text */
        margin-top: -3px;
    }

    .dashboard-title {
        font-weight: bold;
        font-size: 1.125rem;
    }

    .icon-wrapper {
        background: linear-gradient(90deg, rgba(255, 255, 255, 0) -30%, #B66DFF);
        height: 36px;
        width: 36px;
        border-radius: 4px;
        color: #fff;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        box-shadow: 2px 2px 6px rgba(0, 0, 0, 0.25);
    }

    .previous-icon {
        font-size: 16px;
    }
</style>
@endsection