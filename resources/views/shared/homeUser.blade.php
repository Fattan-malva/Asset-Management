@extends('layouts.app')

@section('content')


<main id="main">
    <!-- ======= User Assets Section ======= -->
    <section id="user-assets" class="user-assets">
        <br>
        <br>
        <h1 class="text-center animate__animated animate__fadeInDown display-4">
            Hello <b class="fw-bold">{{ ucfirst(strtolower(session('user_name'))) }}</b>,
            This is your asset
        </h1>

        <br>
        <br>
        <div class="container">
            <div class="row">
                <!-- User Profile Card -->
                <!-- Section for Pending Assets -->
                <div class="col-md-4 mb-4">
                    <div class="card border-secondary">
                        <div class="card-header bg-secondary text-white">
                            <h2>Waiting for Approval</h2>
                        </div>
                        <div class="card-body">
                            @if ($pendingAssets->isEmpty())
                                <p class="text-center">No assets waiting for approval.</p>
                            @else
                                <div class="row">
                                    @foreach ($pendingAssets as $asset)
                                        <div class="col-md-12 mb-3">
                                            <div class="card" style="background-color: rgba(
                                                                                    {{ $asset->aksi == 'Handover' ? '40, 167, 69, 0.2' : '' }}
                                                                                    {{ $asset->aksi == 'Mutasi' ? '255, 193, 7, 0.2' : '' }}
                                                                                    {{ $asset->aksi == 'Return' ? '220, 53, 69, 0.2' : '' }});
                                                                                    border: 3px solid black;">
                                                <div class="card-body">
                                                    <div class="d-flex align-items-center mb-4">
                                                        <img src="{{ asset('assets/img/pending.png') }}"
                                                            alt="Pending Asset Icon" class="me-3"
                                                            style="width: 80px; height: 80px;">
                                                        <p class="card-text">
                                                            <span
                                                                class="badge position-absolute top-0 end-0 m-2
                                                                                                        {{ $asset->aksi == 'Handover' ? 'bg-success text-dark' : '' }}
                                                                                                        {{ $asset->aksi == 'Mutasi' ? 'bg-warning text-dark' : '' }}
                                                                                                        {{ $asset->aksi == 'Return' ? 'bg-danger text-dark' : '' }}">
                                                                {{ $asset->aksi }}
                                                            </span>

                                                            <strong>Asset Tag:</strong> {{ $asset->tagging }}<br>
                                                            <strong>Jenis Aset:</strong> {{ $asset->jenis_aset }}<br>
                                                            <strong>Merk:</strong> {{ $asset->merk_name }}
                                                        </p>
                                                    </div>

                                                    <div class="d-flex justify-content-between mt-4"
                                                        style="margin-bottom:-15px;">
                                                        <a href="{{ route('assets.serahterima', ['id' => $asset->id]) }}"
                                                            class="btn btn-success" style="margin-bottom:15px;">Approve</a>
                                                        <form action="{{ route('assets.reject', ['id' => $asset->id]) }}"
                                                            method="POST">
                                                            @csrf
                                                            <button type="submit" class="btn btn-danger">Reject</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <!-- Assets Section -->
                <div class="col-md-8">
                    <!-- Section for Approved Assets -->
                    <div class="card border-success">
                        <div class="card-header bg-success text-white">
                            <h2>Approved Assets</h2>
                        </div>
                        <div class="card-body">
                            @if ($assets->isEmpty())
                                <p class="text-center">No approved assets found.</p>
                            @else
                                                    <div class="row">
                                                        @foreach ($assets as $index => $asset)
                                                                                    <div class="col-md-5 mb-3">
                                                                                        <div class="card"
                                                                                            style="background-color: rgba(130, 130, 130, 0.2); border: 3px solid black;">
                                                                                            <div class="card-body">
                                                                                                <div class="d-flex align-items-center mb-4">
                                                                                                    @php
                                                                                                        // Determine the image file based on the jenis_aset
                                                                                                        $iconMap = [
                                                                                                            'PC' => 'pc.png',
                                                                                                            'Tablet' => 'tablet.png',
                                                                                                            'Laptop' => 'laptop.png',
                                                                                                            // Add more mappings as needed
                                                                                                        ];
                                                                                                        $iconFile = isset($iconMap[$asset->jenis_aset]) ? $iconMap[$asset->jenis_aset] : 'default.png'; // Fallback to default icon
                                                                                                    @endphp
                                                                                                    <img src="{{ asset('assets/img/' . $iconFile) }}" alt="Asset Icon"
                                                                                                        class="me-3" style="width: 60px; height: 60px;">
                                                                                                    <p class="card-text">
                                                                                                        <strong>Asset Tag:</strong> {{ $asset->tagging }}<br>
                                                                                                        <strong>Jenis Aset:</strong> {{ $asset->jenis_aset }}<br>
                                                                                                        <strong>Merk:</strong> {{ $asset->merk_name }}<br>
                                                                                                    </p>
                                                                                                </div>

                                                                                                <div class="action-buttons">
                                                                                                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                                                                                        data-bs-target="#detailModal{{ $asset->id }}" title="View Details">
                                                                                                        <i class="bi bi-file-earmark-text"></i> Detail
                                                                                                    </button>
                                                                                                </div>
                                                                                            </div>


                                                                                            <!-- Modal -->
                                                                                            <div class="modal fade" id="detailModal{{ $asset->id }}" tabindex="-1"
                                                                                                aria-labelledby="detailModalLabel{{ $asset->id }}" aria-hidden="true">
                                                                                                <div class="modal-dialog modal-lg">
                                                                                                    <div class="modal-content">
                                                                                                        <div class="modal-header">
                                                                                                            <h5 class="modal-title" id="detailModalLabel{{ $asset->id }}">
                                                                                                                Asset Details</h5>
                                                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                                                                aria-label="Close"></button>
                                                                                                        </div>
                                                                                                        <div class="modal-body">
                                                                                                            <div class="row">
                                                                                                                <div class="col-md-6">
                                                                                                                    <strong>Asset Tagging:</strong>
                                                                                                                    {{ $asset->tagging }}<br>
                                                                                                                    <strong>Jenis Aset:</strong>
                                                                                                                    {{ $asset->jenis_aset }}<br>
                                                                                                                    <strong>Merk:</strong> {{ $asset->merk_name }}<br>
                                                                                                                    <strong>Location:</strong> {{ $asset->lokasi }}<br>
                                                                                                                    <strong>Approval Status:</strong>
                                                                                                                    {{ $asset->approval_status }}<br>
                                                                                                                </div>
                                                                                                                <div class="col-md-6">
                                                                                                                    <strong>Serial Number:</strong>
                                                                                                                    {{ $asset->serial_number }}<br>
                                                                                                                    <strong>O365:</strong> {{ $asset->o365 }}<br>
                                                                                                                    <strong>Status:</strong> {{ $asset->status }}<br>
                                                                                                                    <strong>Kondisi:</strong> {{ $asset->kondisi }}<br>
                                                                                                                    <strong>Documentation:</strong>
                                                                                                                    @if($asset->documentation)
                                                                                                                        <a href="{{ asset('storage/' . $asset->documentation) }}"
                                                                                                                            target="_blank">View Documentation</a>
                                                                                                                    @else
                                                                                                                        No documentation available.
                                                                                                                    @endif
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <div class="modal-footer">
                                                                                                            <a href="{{ route('assets.print', ['id' => $asset->id]) }}"
                                                                                                                class="btn btn-primary">Print</a>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                        @endforeach
                                                    </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

@section('scripts')
<script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<script>
    window.Echo.channel('data-channel')
        .listen('DataUpdated', (e) => {
            // Update the UI with the new data
            console.log('Data updated:', e.data); // Debugging output
            const dataContainer = document.getElementById('data-container');
            if (dataContainer) {
                dataContainer.innerHTML = JSON.stringify(e.data); // Update UI
            }
        });

    // Optional: Function to fetch data initially
    function fetchData() {
        fetch('{{ url('/fetch-data') }}')
            .then(response => response.json())
            .then(data => {
                document.getElementById('data-container').innerHTML = JSON.stringify(data);
            });
    }

    // Fetch initial data when page loads
    fetchData();
</script>
@endsection



@push('styles')
    <style>
        /* Header styles */
        .card-header.bg-success {
            background-color: #28a745 !important;
        }

        .card-header.bg-warning {
            background-color: #ffc107 !important;
        }

        .card-header.bg-danger {
            background-color: #dc3545 !important;
        }

        /* Badge styles */
        .badge.bg-success {
            background-color: #28a745 !important;
        }

        .badge.bg-warning {
            background-color: #ffc107 !important;
        }

        .badge.bg-danger {
            background-color: #dc3545 !important;
        }

        /* Card styles for Pending Assets */
        .card.border-warning {
            border-color: #ffc107 !important;
        }

        /* Background for Pending Assets card */
        .card-body {
            background-color: rgba(255, 193, 7, 0.5);
            /* Light yellow background with transparency */
        }
    </style>
@endpush