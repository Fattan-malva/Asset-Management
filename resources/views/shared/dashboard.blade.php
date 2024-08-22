@extends('layouts.app')

@section('content')
<br>
<br>
<br>
<div>
    <div class="container">
        <h1>Welcome back <b>Admin</b>, let's manage assets!</h1>
    </div>
</div>
<div class="container mt-5">
    <div class="row">
        <!-- Column for Pie Charts (Left Side) -->
        <div class="col-md-5">
            <div class="row">
                <!-- Pie Chart for Asset Types -->
                <div class="col-md-12 mb-4">
                    <div class="card border-1 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Asset Total</h5>
                            <div class="chart-container" style="position: relative; height: 300px; width: 100%;">
                                <canvas id="assetPieChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pie Chart for Locations -->
                <div class="col-md-12">
                    <div class="card border-1 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Asset Location</h5>
                            <div class="chart-container" style="position: relative; height: 300px; width: 100%;">
                                <canvas id="locationPieChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Column for Cards and Summary Report (Right Side) -->
        <div class="col-md-7">
            <div class="row">
                <!-- Card for Total Assets -->
                <div class="row">
                    <!-- Card for Asset Total -->
                    <div class="col-md-4 mb-4">
                        <a href="{{ route('inventorys.total') }}" class="text-decoration-none">
                            <div class="card bg-primary text-white shadow-sm border-0 text-center"
                                style="height: 100px; padding: 15px;">
                                <div class="card-body d-flex align-items-center">
                                    <div class="me-3">
                                        <i class="fas fa-boxes fa-3x"></i>
                                    </div>
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="card-title mb-1">Asset Total</h6>
                                        <p class="card-text h3 mb-0">{{ $totalAssets }}</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- Card for Asset Locations -->
                    <div class="col-md-4 mb-4">
                        <a href="{{ route('inventorys.mapping') }}" class="text-decoration-none">
                            <div class="card bg-success text-white shadow-sm border-0 text-center"
                                style="height: 100px; padding: 15px;">
                                <div class="card-body d-flex align-items-center">
                                    <div class="me-3">
                                        <i class="fa-solid fa-location-dot fa-3x"></i>
                                    </div>
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="card-title mb-1">Asset Location</h6>
                                        <p class="card-text h3 mb-0">{{ $distinctLocations }}</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- Card for Asset Types -->
                    <div class="col-md-4 mb-4">
                        <a href="{{ route('inventorys.index') }}" class="text-decoration-none">
                            <div class="card bg-info text-white shadow-sm border-0 text-center"
                                style="height: 100px; padding: 15px;">
                                <div class="card-body d-flex align-items-center">
                                    <div class="me-3">
                                        <i class="fas fa-cogs fa-3x"></i>
                                    </div>
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="card-title mb-1">Asset Type</h6>
                                        <p class="card-text h3 mb-0">{{ $distinctAssetTypes }}</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>


                <!-- Summary Report Section -->
                <div class="row mt-3">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="mb-0">Summary Report</h3>
                            </div>
                            <div class="container">
                                <br>
                                <!-- Inventory Summary Table -->
                                <h2>Inventory Summary</h2>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Asset Tagging</th>
                                            <th>Asset</th>
                                            <th>Merk Name</th>
                                            <th>Condition</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($inventoryData as $data)
                                            <tr>
                                                <td>{{ $data->asset_tagging }}</td>
                                                <td>{{ $data->asset }}</td>
                                                <td>{{ $data->merk_name }}</td>
                                                <td>{{ $data->kondisi }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <!-- Operation Summary Section -->
                                <h2>Operation Summary</h2>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Location</th>
                                            <th>Asset Type</th>
                                            <th>Merk Name</th>
                                            <th>Asset Tagging</th>
                                            <th>Total Assets</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($operationSummaryData as $data)
                                            <tr>
                                                <td>{{ $data->lokasi }}</td>
                                                <td>{{ $data->jenis_aset }}</td>
                                                <td>{{ $data->merk }}</td>
                                                <td>{!! $data->asset_tagging !!}</td>
                                                <td>{{ $data->total_assets }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <br>
    <br>
    @endsection

    @section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Asset Types Pie Chart
        const assetData = @json($assetData);
        const assetLabels = assetData.map(data => data.jenis_aset);
        const assetCounts = assetData.map(data => data.total);

        const assetCtx = document.getElementById('assetPieChart').getContext('2d');
        new Chart(assetCtx, {
            type: 'pie',
            data: {
                labels: assetLabels,
                datasets: [{
                    label: 'Asset Types',
                    data: assetCounts,
                    backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function (tooltipItem) {
                                return tooltipItem.label + ': ' + tooltipItem.raw;
                            }
                        }
                    }
                }
            }
        });

        // Location Pie Chart
        const locationData = @json($locationData);
        const locationLabels = locationData.map(data => data.lokasi);
        const locationCounts = locationData.map(data => data.total);

        const locationCtx = document.getElementById('locationPieChart').getContext('2d');
        new Chart(locationCtx, {
            type: 'pie',
            data: {
                labels: locationLabels,
                datasets: [{
                    label: 'Locations',
                    data: locationCounts,
                    backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function (tooltipItem) {
                                return tooltipItem.label + ': ' + tooltipItem.raw;
                            }
                        }
                    }
                }
            }
        });
    </script>
    @endsection

    <style>
        .condition-bad,
        .condition-exception,
        .condition-good {
            margin-bottom: 5px;
        }

        .condition-bad .badge {
            font-size: 0.9em;
            color: white;
        }

        .condition-exception .badge {
            font-size: 0.9em;
            color: white;
        }

        .condition-good .badge {
            font-size: 0.9em;
            color: white;
        }

        .table th,
        .table td {
            text-align: center;
            vertical-align: middle;
        }

        .table-responsive {
            margin-top: 20px;
        }
    </style>