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
                            <th scope="col">Asset Tag</th>
                            <th scope="col">Asset Name</th>
                            <th scope="col">Merk</th>
                            <th scope="col">Entry Date</th>
                            <th scope="col">Handover Date</th>
                            <th scope="col">Location</th>
                            <th scope="col">Status</th>
                            <th scope="col" style="width: 150px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($inventorys as $index => $inventory)
    <tr>
        <td>{{ $index + 1 }}</td>
        <td>{{ $inventory->tagging }}</td>
        <td>{{ $inventory->asets }}</td>
        <td>{{ $inventory->merk_name }}</td>
        <td>
            @php
                $tanggalMasuk = $inventory->tanggalmasuk;
                echo date('d-m-Y', strtotime($tanggalMasuk));
            @endphp
        </td>
        <td>
            @php
                // Ambil nilai tanggal_diterima
                $tanggalDiterima = $inventory->tanggal_diterima ?? '-';

                // Jika tanggal_diterima adalah '0000-00-00 00:00:00' atau '-' maka tampilkan '-'
                if ($tanggalDiterima === '0000-00-00 00:00:00' || $tanggalDiterima === '-') {
                    echo '-';
                } else {
                    // Format tanggal menjadi tanggal-bulan-tahun (contoh: 19-09-2024)
                    echo date('d-m-Y', strtotime($tanggalDiterima));
                }
            @endphp
        </td>
        <td>
            @php
                // Ambil nilai lokasi
                $lokasi = $inventory->lokasi ?? 'In Inventory';

                // Jika lokasi tidak kosong, ambil kata sebelum koma pertama
                if ($lokasi !== 'In Inventory') {
                    $lokasi = strtok($lokasi, ',');
                }
            @endphp

            {{ $lokasi }}
        </td>
        <td class="text-center align-middle">
            <!-- Status Badge -->
            @if ($inventory->status === 'Inventory')
                <span class="badge bg-warning" style="padding: 5px; color: black; font-size: 0.9em;">Available</span>
            @elseif ($inventory->status === 'Operation')
                <span class="badge bg-success" style="padding: 5px; color: black; font-size: 0.9em;">In Use</span>
            @elseif ($inventory->status === 'Under Maintenance')
                <span class="badge bg-secondary" style="padding: 5px;">Under Maintenance</span>
            @else
                <span class="badge bg-danger" style="padding: 5px;">Unavailable</span>
            @endif
            <!-- Notification for Maintenance -->
            @if (now()->diffInMonths($tanggalMasuk) >= 1)
                <span class="badge bg-danger" style="padding: 5px; font-size: 0.9em; margin-top:10px; color:black;">Need Maintenance</span>
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
                            onclick="return confirm('Are you sure you want to delete this Asset?')">
                        <i class="bi bi-trash"></i> Scrap Asset
                    </button>
                </form>
            </div>
        </td>
    </tr>
@endforeach

                    </tbody>
                </table>
                <!-- Legend for Status Badges -->
                <div class="mt-4">
                    <ul class="list-unstyled legend-list">
                        <li>
                            <span class="badge bg-warning legend-badge" style="color: black;">Available</span> : <span
                                class="legend-description">Asset is available for use.</span>
                        </li>
                        <li>
                            <span class="badge bg-success legend-badge" style="color: black;">In Use</span> : <span
                                class="legend-description">Asset is currently in operation.</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@foreach ($inventorys as $inventory)
    <div class="modal fade" id="detailsModal-{{ $inventory->id }}" tabindex="-1" aria-labelledby="detailsModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title text-center fw-bold w-100" id="detailsModalLabel">Asset Details</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table no-border-table">
                        <tr>
                            <th style="width: 30%"><strong>Assets Tag</strong></th>
                            <td>{{ $inventory->tagging }}</td>
                        </tr>
                        <tr>
                            <th><strong>Assets Name</strong></th>
                            <td>{{ $inventory->asets }}</td>
                        </tr>
                        <tr>
                            <th><strong>Merk</strong></th>
                            <td>{{ $inventory->merk_name }}</td>
                        </tr>
                        <tr>
                            <th><strong>Serial Number</strong></th>
                            <td>{{ $inventory->seri }}</td>
                        </tr>
                        <tr>
                            <th><strong>Type</strong></th>
                            <td>{{ $inventory->type }}</td>
                        </tr>
                        <tr>
                            <th><strong>Condition</strong></th>
                            <td>{{ $inventory->kondisi }}</td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <!-- Print Label Button -->
                    <button type="button" class="btn btn-success"
                        onclick="window.open('{{ route('prints.qr', ['id' => $inventory->id]) }}', '_blank')">
                        <i class="bi bi-printer"></i> Print QR Code
                    </button>
                    <a href="{{ route('inventorys.edit', ['id' => $inventory->id]) }}" class="btn btn-primary">
                        <i class="bi bi-pencil-square"></i> Edit
                    </a>
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

<style>
    .no-border-table th,
    .no-border-table td {
        border: none !important;
        padding: 5px 12px;
    }

    .legend-list {
        font-size: 0.875em;
        line-height: 1.5;
    }

    .legend-list li {
        display: flex;
        align-items: center;
        margin-bottom: 5px;
    }

    .legend-list li .badge {
        min-width: 80px;
        margin-right: 10px;
    }

    .legend-list li .legend-description {
        margin-left: 10px;
        text-align: left;
    }
</style>