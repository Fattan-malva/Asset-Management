@extends('layouts.app')

@section('content')
<br>
<div>
    <div class="container">
        <h1 class="text-center animate__animated animate__fadeInDown display-4">Welcome back <b
                class="fw-bold">Admin</b>, let's manage assets!</h1>
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
                            <h5 class="card-title text-center fw-bold display-6">Asset Total</h5>
                            <div class="chart-container">
                                <canvas id="assetPieChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pie Chart for Locations -->
                <div class="col-md-12">
                    <div class="card border-1 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title text-center fw-bold display-6">Asset Location</h5>
                            <div class="chart-container">
                                <canvas id="locationPieChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Column for Summary Cards and Tables (Right Side) -->
        <div class="col-md-7">
            <div class="row">
                <!-- Summary Cards -->
                <div class="col-lg-4 col-md-6 mb-4 assettotal-padding">
                    <a href="{{ route('inventorys.total') }}" class="text-decoration-none">
                        <div class="card bg-primary text-white shadow-sm border-0 text-center d-flex flex-column justify-content-center align-items-center"
                            style="height: 120px; padding: 15px;">
                            <div class="card-body d-flex align-items-center justify-content-center">
                                <div class="me-3">
                                    <i class="fas fa-boxes fa-3x"></i>
                                </div>
                                <div class="d-flex flex-column justify-content-center">
                                    <h6 class="card-title mb-1">Asset Total</h6>
                                    <p class="card-text h3 mb-0" id="totalAssets">{{ $totalAssets }}</p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-lg-4 col-md-6 mb-4">
                    <a href="{{ route('inventorys.mapping') }}" class="text-decoration-none">
                        <div class="card bg-success text-white shadow-sm border-0 text-center d-flex flex-column justify-content-center align-items-center"
                            style="height: 120px; padding: 15px;">
                            <div class="card-body d-flex align-items-center justify-content-center">
                                <div class="me-3">
                                    <i class="fa-solid fa-location-dot fa-3x"></i>
                                </div>
                                <div class="d-flex flex-column justify-content-center">
                                    <h6 class="card-title mb-1">Asset Location</h6>
                                    <p class="card-text h3 mb-0" id="distinctLocations">{{ $distinctLocations }}</p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-lg-4 col-md-6 mb-4">
                    <a href="{{ route('inventorys.index') }}" class="text-decoration-none">
                        <div class="card bg-info text-white shadow-sm border-0 text-center d-flex flex-column justify-content-center align-items-center"
                            style="height: 120px; padding: 15px;">
                            <div class="card-body d-flex align-items-center justify-content-center">
                                <div class="me-3">
                                    <i class="fas fa-cogs fa-3x"></i>
                                </div>
                                <div class="d-flex flex-column justify-content-center">
                                    <h6 class="card-title mb-1">Asset Type</h6>
                                    <p class="card-text h3 mb-0" id="distinctAssetTypes">{{ $distinctAssetTypes }}</p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

            </div>

            <!-- Summary Tables -->
            <div class="row">
                <div class="col-md-12 mb-4">
                    <div class="card border-1 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Inventory Summary</h5>
                            <div class="table-responsive">
                                <table id="inventorySummaryTable" class="table table-bordered">
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
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 mb-4">
                    <div class="card border-1 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Operation Summary</h5>
                            <div class="table-responsive">
                                <table id="operationSummaryTable" class="table table-bordered">
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
                                                <td>{{ explode(',', $data->lokasi)[0] }}</td>
                                                <td>{{ $data->jenis_aset }}</td>
                                                <td>{{ $data->merk }}</td>
                                                <td>{!! nl2br(e(str_replace(', ', "\n", $data->asset_tagging))) !!}</td>
                                                <td>{{ $data->total_assets }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="card border-1 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Location Summary</h5>
                            <div class="table-responsive">
                                <table id="mappingTable" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Location</th>
                                            <th>Asset Type</th>
                                            <th>Asset Quantity</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($assetQuantitiesByLocation as $item)
                                            <tr>
                                                <td>{{ explode(',', $item->lokasi)[0] }}</td>
                                                <td>{{ $item->jenis_aset }}</td>
                                                <td>{{ $item->jumlah_aset }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="text-center"
                                                    style="padding: 50px; font-size: 1.2em;">
                                                    No Data found.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br><br>
</div>
@endsection
