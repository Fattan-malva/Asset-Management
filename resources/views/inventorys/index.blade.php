@extends('layouts.app')
@section('title', 'Assets List')

@section('content')
<h1 class="mt-4 text-center fw-bold display-5">Assets List</h1>
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
                            <th scope="col">Location</th>
                            <th scope="col">Status Maintenance</th>
                            <th scope="col">Status Usage</th>
                            <th scope="col">Action</th>
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
                                                            // Ambil nilai lokasi
                                                            $lokasi = $inventory->lokasi ?? 'In Inventory';

                                                            // Jika lokasi tidak kosong, ambil kata sebelum koma pertama
                                                            if ($lokasi !== 'In Inventory') {
                                                                $lokasi = strtok($lokasi, ',');
                                                            }
                                                        @endphp

                                                        {{ $lokasi }}
                                                    </td>
                                                    <td>
                                                        @php
                                                            $tanggalMasuk = $inventory->tanggalmasuk;
                                                            $tanggalMaintenance = $inventory->maintenance ?? null;

                                                            $tanggalAcuan = $tanggalMaintenance ?? $tanggalMasuk;


                                                            $bulanSejakAcuan = now()->diffInMonths($tanggalAcuan);


                                                            $tanggalMaintenanceFormatted = $tanggalMaintenance ? date('d-m-Y', strtotime($tanggalMaintenance)) : '-';
                                                        @endphp


                                                        @if ($bulanSejakAcuan >= 1)
                                                            <span class="badge bg-danger text-center align-middle"
                                                                style="padding: 5px; font-size: 0.9em; margin-top:10px; color:black;">
                                                                Need Maintenance
                                                            </span>
                                                        @else
                                                            <span class="badge bg-info text-center align-middle"
                                                                style="padding: 5px; font-size: 0.9em; margin-top:10px; color:black;">
                                                                Under Maintenance
                                                            </span>
                                                        @endif
                                                    </td>


                                                    <td class="text-center align-middle">
                                                        <!-- Status Badge -->
                                                        @if ($inventory->status === 'Inventory')
                                                            <span class="badge bg-warning"
                                                                style="padding: 5px; color: black; font-size: 0.9em;">Available</span>
                                                        @elseif ($inventory->status === 'Operation')
                                                            <span class="badge bg-success" style="padding: 5px; color: black; font-size: 0.9em;">In
                                                                Use</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="action-buttons">
                                                            <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal"
                                                                data-bs-target="#detailsModal-{{ $inventory->id }}" title="Details">
                                                                <i class="bi bi-file-earmark-text"></i> Detail
                                                            </button>
                                                            <!-- <form action="{{ route('inventorys.delete', ['id' => $inventory->id]) }}"
                                                                method="POST" style="display: inline;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-sm btn-danger" title="Delete"
                                                                    onclick="return confirm('Are you sure you want to delete this Asset?')">
                                                                    <i class="bi bi-trash"></i> Scrap Asset
                                                                </button>
                                                            </form> -->
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
                            <span class="badge bg-warning legend-badge"
                                style="color: black; margin-right: 55px;">Available</span> : <span
                                class="legend-description">Asset is available for use.</span>
                        </li>
                        <li>
                            <span class="badge bg-success legend-badge" style="color: black; margin-right: 55px;">In
                                Use</span> : <span class="legend-description">Asset is currently in operation.</span>
                        </li>
                        <li>
                            <span class="badge bg-danger legend-badge" style="color: black; margin-right: 20px;">Need
                                Maintenance</span> : <span class="legend-description">Assets need maintenance.</span>
                        </li>
                        <li>
                            <span class="badge bg-info legend-badge" style="color: black; margin-right: 15px;">Under
                                Maintenance</span> : <span class="legend-description">Assets have been
                                maintained.</span>
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
                    <div class="row">
                        <!-- Tabel Kiri -->
                        <div class="col-md-6">
                            <table class="table no-border-table">
                                <tbody>
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
                                </tbody>
                            </table>
                        </div>

                        <!-- Tabel Kanan -->
                        <div class="col-md-6">
                            <table class="table no-border-table">
                                <tbody>
                                    <tr>
                                        <th><strong>Type</strong></th>
                                        <td>{{ $inventory->type }}</td>
                                    </tr>
                                    <tr>
                                        <th><strong>Entry Date</strong></th>
                                        <td
                                            style="background-color: rgba(0, 0, 255, 0.2); border-radius: 20px; padding: 5px 10px; display: inline-block;">
                                            @php
                                                $tanggalMasuk = $inventory->tanggalmasuk;
                                                echo date('d-m-Y', strtotime($tanggalMasuk));
                                            @endphp
                                        </td>
                                    </tr>

                                    <tr>
                                        <th><strong>Handover Date</strong></th>
                                        <td
                                            style="background-color: rgba(0, 255, 0, 0.2); border-radius: 20px; padding: 5px 10px; display: inline-block;">
                                            @php
                                                $tanggalDiterima = $inventory->tanggal_diterima ?? '-';
                                                if ($tanggalDiterima === '0000-00-00 00:00:00' || $tanggalDiterima === '-') {
                                                    echo '-';
                                                } else {
                                                    echo date('d-m-Y', strtotime($tanggalDiterima));
                                                }
                                            @endphp
                                        </td>
                                    </tr>

                                    <tr>
                                        <th><strong>Last Maintenance</strong></th>
                                        <td
                                            style="background-color: rgba(255, 255, 0, 0.2); border-radius: 20px; padding: 5px 10px; display: inline-block;">
                                            @php
                                                $maintenanceDate = $inventory->maintenance ?? '-';
                                                if ($maintenanceDate === '0000-00-00 00:00:00' || $maintenanceDate === '-') {
                                                    echo '-';
                                                } else {
                                                    echo date('d-m-Y', strtotime($maintenanceDate));
                                                }
                                            @endphp
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-success"
                        onclick="window.open('{{ route('prints.qr', ['id' => $inventory->id]) }}', '_blank')">
                        <i class="bi bi-qr-code"></i> Print QR Code
                    </button>
                    <a href="{{ route('inventorys.edit', ['id' => $inventory->id]) }}" class="btn btn-warning">
                        <i class="bi bi-tools"></i> Maintenance
                    </a>
                    <button type="button" class="btn btn-secondary open-history-modal"
                        data-tagging="{{ $inventory->tagging }}" data-inventory-id="{{ $inventory->id }}"
                        data-bs-toggle="modal" data-bs-target="#historyModal-{{ $inventory->id }}">
                        <i class="bi bi-clock-history"></i>
                        View History
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal structure for each inventory -->
    <div class="modal fade" id="historyModal-{{ $inventory->id }}" tabindex="-1" aria-labelledby="historyModalLabel"
        aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="historyModalLabel">History for Asset: {{ $inventory->tagging }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Activity</th>
                                <th>Date</th>
                                <th>User</th>
                                <th>Reason</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="history-body-{{ $inventory->id }}">
                            <!-- Data history akan dimuat di sini -->
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Event listener for all modal open buttons
            const modalButtons = document.querySelectorAll('.open-history-modal'); // Ensure these buttons have this class

            modalButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const tagging = this.getAttribute('data-tagging'); // Get tagging from button attribute
                    const inventoryId = this.getAttribute('data-inventory-id'); // Get inventory ID

                    // Call loadHistory with the correct tagging and inventory ID
                    loadHistory(tagging, inventoryId);
                });
            });
        });

        function loadHistory(tagging, inventoryId) {
            fetch(`{{ route('inventory.historyModal') }}?tagging=${tagging}`)
                .then(response => response.json())
                .then(data => {
                    const historyBody = document.getElementById(`history-body-${inventoryId}`);
                    historyBody.innerHTML = ''; // Clear previous data
                    console.log(data); // Log the fetched data to check the structure

                    if (data.length > 0) {
                        let latestUpdateDocumentation = null;
                        let deleteDocumentation = null;

                        // First pass: Identify the relevant documentation
                        data.forEach(item => {
                            if (item.action === 'UPDATE' && item.documentation_new) {
                                latestUpdateDocumentation = item.documentation_new;
                            }
                            if (item.action === 'DELETE' && item.documentation_old) {
                                deleteDocumentation = item.documentation_old;
                            }
                        });

                        // Second pass: Display only the rows with badges (Handover or Return) and filter for 'Return' with a reason
                        data.forEach(item => {
                            let actionBadge = '';
                            let documentationLink = '';
                            let printButton = '';

                            if (item.action === 'CREATE') {
                                actionBadge = '<span class="badge bg-success">Handover</span>';
                                if (latestUpdateDocumentation) {
                                    documentationLink = `<a href="{{ asset('storage/${latestUpdateDocumentation}') }}" target="_blank" class="btn btn-primary btn-sm">View Document</a>`;
                                } else {
                                    documentationLink = `<button class="btn btn-secondary btn-sm" disabled>No Document</button>`;
                                }
                            } else if (item.action === 'DELETE' && item.keterangan) {
                                // Show only 'Return' (DELETE) actions where 'reason' (keterangan) is filled
                                actionBadge = '<span class="badge bg-danger">Return</span>';
                                if (deleteDocumentation) {
                                    documentationLink = `<a href="{{ asset('storage/${deleteDocumentation}') }}" target="_blank" class="btn btn-primary btn-sm">View Document</a>`;
                                } else {
                                    documentationLink = `<button class="btn btn-secondary btn-sm" disabled>No Document</button>`;
                                }
                            }

                            // Only generate rows for actions that have a badge (CREATE or DELETE with a reason)
                            if (actionBadge) {
                                // Print button
                                printButton = `<button type="button" class="btn btn-success btn-sm printButton" 
                            data-action="${item.action}" 
                            data-tagging="${item.asset_tagging}" 
                            data-changed-at="${item.changed_at}">
                            <i class="bi bi-printer"></i> Print Proof
                        </button>`;

                                // Generate the row
                                const row = `<tr>
                                <td>${actionBadge}</td>
                                <td>${item.changed_at}</td>
                                <td>${item.nama_old || '-'}</td>
                                <td>${item.keterangan || '-'}</td>
                                <td>
                                    ${documentationLink}
                                    ${printButton}
                                </td>
                            </tr>`;

                                historyBody.innerHTML += row;
                            }
                        });

                        // Add event listeners for print buttons
                        document.querySelectorAll('.printButton').forEach(button => {
                            button.addEventListener('click', function () {
                                var action = this.getAttribute('data-action');
                                var assetTagging = this.getAttribute('data-tagging');
                                var changedAt = this.getAttribute('data-changed-at');

                                // Extract the date part (yyyy-mm-dd)
                                var changedAtDate = changedAt.split(' ')[0];

                                // Convert the date from 'yyyy-mm-dd' to 'd-m-Y'
                                var dateParts = changedAtDate.split('-');
                                var formattedDate = `${dateParts[2]}-${dateParts[1]}-${dateParts[0]}`;

                                var route = '';
                                if (action === 'CREATE') {
                                    route = '{{ route('prints.handover') }}';
                                } else if (action === 'UPDATE') {
                                    route = '{{ route('prints.mutation') }}';
                                } else if (action === 'DELETE') {
                                    route = '{{ route('prints.return') }}';
                                }

                                if (route) {
                                    var fullUrl = `${route}?asset_tagging=${encodeURIComponent(assetTagging)}&changed_at=${encodeURIComponent(formattedDate)}`;
                                    console.log('Opening URL: ' + fullUrl);
                                    window.open(fullUrl, '_blank');
                                }
                            });
                        });
                    } else {
                        historyBody.innerHTML = '<tr><td colspan="6" class="text-center">No history found</td></tr>';
                    }
                })
                .catch(error => {
                    console.error('Error fetching history:', error);
                });
        }


    </script>

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