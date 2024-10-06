@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<br>
<div>
    <div class="container">
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
                    Dashboard&nbsp;&nbsp;
                    <span class="icon-wrapper">
                        <i class="fa-solid fa-2xs fa-house-chimney previous-icon"></i>
                    </span>
                </h3>
            </div>
        </div>
    </div>
</div>

<style>
    /* Header Styles */
    .header-container {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px;
        margin-top: 30px;
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


    /* CARD */
    .card {
        overflow: hidden;
        border-radius: 8px;
    }

    .card-total {
        box-shadow:
            rgb(182, 109, 255)-10px 0px,
            /* First shadow */
            rgba(0, 0, 0, 0.15) 1.95px 1.95px 2.6px;

        height: 160px;
        max-width: 380px;
        border-radius: 20px;
        position: relative;
    }

    .card-map {
        box-shadow:
            rgb(255, 220, 59) -10px 0px,
            /* First shadow */
            rgba(0, 0, 0, 0.15) 1.95px 1.95px 2.6px;

        height: 160px;
        max-width: 380px;
        border-radius: 20px;
        position: relative;
    }

    .card-type {
        box-shadow:
            rgb(27, 207, 180)-10px 0px,
            rgba(0, 0, 0, 0.15) 1.95px 1.95px 2.6px;

        height: 160px;
        max-width: 380px;
        border-radius: 20px;
        position: relative;
    }

    /* card-title dari card */
    h6 {
        font-weight: 400px;
        font-size: 22px;
    }

    .card-text {
        color: #878282;
    }

    /* G kepake sbnarnya */
    .img-card {
        height: 220px;
        /* Adjust this as needed */
        margin-right: -125px;
        /* This might need adjusting based on your layout */
        border-top-right-radius: 25px;
        border-bottom-right-radius: 25px;
        position: absolute;
        /* Make sure the image is positioned absolutely */
        bottom: 0;
        /* Position it at the bottom of the card */
        transform: translateX(-50%);
        /* Adjust position to center */
        z-index: 0;
        /* Ensure the image is behind the text */
        max-width: 100%;
        left: 80%;
    }

    .card-body {
        position: relative;
        /* This is to allow z-index to work correctly */
        z-index: 1;
        /* Keep the text above the image */
    }


    /* CHART */
    .card-chart {
        border-radius: 20px;
        height: 500px;
    }

    .card-title-chart {
        font-size: 1.825rem;
        text-transform: capitalize;
    }

    .chart-container {
        position: relative;
        height: 80%;
        width: 100%;
    }

    canvas {
        max-height: 90%;
        max-width: 100%;
        flex: 1;
    }


    /* TABLE */
    .table-responsivee {
        height: 300px;
        /* Atur tinggi maksimum tabel */
        overflow-y: auto;
        /* Tambahkan scrollbar vertikal */
    }

    .table th {
        height: 20px;
        /* Atur tinggi sel tabel */
        vertical-align: middle;
        /* Rata tengah secara vertikal */
    }

    .table td {
        height: 0px;
        vertical-align: middle;
    }

    /* CSS for table row borders */
    .table-hover tbody tr td,
    .table-hover thead tr th {
        border-bottom: 1px solid #ebedf2;
        /* Add a border to the bottom of each row */
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
        border: none;
        /* Remove borders from cells */
        padding: 10px;
        /* Keep padding for cells */
    }

    .wrapper-Inv_Loc {
        margin-top: -45px;

    }
</style>

<script>
    $(document).ready(function () {
        // Initialize DataTables
        $('.table-responsivee').each(function () {
            const tableId = $(this).find('table').attr('id'); // Mendapatkan ID tabel
            // Tentukan apakah pencarian harus dinonaktifkan untuk tabel tertentu
            const disableSearch = tableId === 'inventorySummaryTable' || tableId === 'mappingTable' || tableId === 'operationSummaryTable';
            const disableLength = tableId === 'inventorySummaryTable' || tableId === 'mappingTable' || tableId === 'operationSummaryTable';
            $(this).find('table').DataTable({
                paging: true,
                searching: false,
                ordering: false,
                info: true,
                lengthChange: false,
                language: {
                    search: "",
                    searchPlaceholder: "Search...", // Placeholder text
                    lengthMenu: "MENU ",
                    info: "Showing START to END of TOTAL entries",
                    infoEmpty: "No entries available",
                    infoFiltered: "(filtered from MAX total entries)",
                    paginate: {
                        previous: "Prev",  // Customize previous button text
                        next: "Next"       // Customize next button text
                    }
                },
                dom: '<"top"f>rt<"bottom"lp><"clear">', // Search on top, paginate on bottom
                createdRow: function (row, data, dataIndex) {
                    // Apply 'text-center' and 'align-middle' class to every cell in the row
                    $(row).find('td').addClass('text-center align-middle');
                },
                initComplete: function () {
                    // Apply 'text-center' and 'align-middle' class to the header columns
                    $(this).find('th').addClass('text-center align-middle');
                }
            });
        });

        // Initialize Select2
        $('#asset_tagging').select2({
            placeholder: "Select asset tagging",
            allowClear: true
        }).on('change', function () {
            updateSelectedAssets();
        });

        function updateSelectedAssets() {
            var selectedOptions = $('#asset_tagging').val();
            $('#selected-assets-list').empty();

            if (selectedOptions) {
                selectedOptions.forEach(function (option) {
                    var optionText = $('#asset_tagging option[value="' + option + '"]').text();
                    addAssetToList(option, optionText);
                });
            }
        }

        function addAssetToList(assetId, assetText) {
            if ($('#selected-assets-list').find(li[data - id= "${assetId}"]).length === 0) {
                $('#selected-assets-list').append(<li class="list-group-item" data-id="${assetId}">${assetText}</li>);
            }
        }

        // Double-click to remove item from list
        $('#selected-assets-list').on('dblclick', 'li', function () {
            var assetId = $(this).data('id');
            var selectElement = $('#asset_tagging');

            var currentValues = selectElement.val();
            currentValues = currentValues.filter(function (value) {
                return value !== assetId.toString();
            });
            selectElement.val(currentValues).trigger('change');
            $(this).remove();
        });
    });
</script>

<div class="container mt-1">
    <div class="row" style="margin-left: 0px;">
        <!-- Summary Cards -->
        <!-- Card Asset Total -->
        <div class="col-lg-4 col-md-6 mb-2 assettotal-padding">
            <a href="{{ route('inventorys.total') }}" class="text-decoration-none">
                <div
                    class="card text-white border-0 d-flex flex-column justify-content-center align-items-center card-total">
                    <img class="d-flex flex-column img-card" alt="circle">
                    <div class="card-body d-flex align-items-center justify-content-center"
                        style="position: relative; z-index: 1;">
                        <div class="d-flex flex-column align-items-start text-left">
                            <h6 class="card-title mb-3" style="color: #b66dff">Asset Total</h6>
                            <p class="card-text h4 mb-0" id="totalAssets">{{ $totalAssets }}</p>
                        </div>
                        <div class="me-3" style="margin-left: 50px;">
                            <i class="fas fa-light fa-cubes fa-4x" style="color: #b66dff"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Card Asset Location -->
        <div class="col-lg-4 col-md-6 mb-2 assettotal-padding">
            <a href="{{ route('inventorys.mapping') }}" class="text-decoration-none">
                <div
                    class="card text-white border-0 d-flex flex-column justify-content-center align-items-center card-map">
                    <img class="d-flex flex-column img-card" alt="circle">
                    <div class="card-body d-flex align-items-center justify-content-center"
                        style="position: relative; z-index: 1;">
                        <div class="d-flex flex-column align-items-start text-left">
                            <h6 class="card-title mb-3" style="color: #ffdc3b">Asset Location</h6>
                            <p class="card-text h4 mb-0" id="distinctLocations">{{ $distinctLocations }}</p>
                        </div>
                        <div class="me-3" style="margin-left: 50px;">
                            <i class="fa-solid fa-location-dot fa-4x" style="color: #ffdc3b"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Card Asset Type -->
        <div class="col-lg-4 col-md-6 mb-2 assettotal-padding">
            <a href="{{ route('inventorys.index') }}" class="text-decoration-none">
                <div
                    class="card text-white border-0 d-flex flex-column justify-content-center align-items-center card-type">
                    <img class=" img-card" alt="circle">
                    <div class="card-body d-flex align-items-center justify-content-center"
                        style="position: relative; z-index: 1;">
                        <div class="d-flex flex-column align-items-start text-left">
                            <h6 class="card-title mb-3" style="color: #1bcfb4;">Asset Type</h6>
                            <p class="card-text h4 mb-0" id="distinctAssetTypes">{{ $distinctAssetTypes }}</p>
                        </div>
                        <div class="me-3" style="margin-left: 50px;">
                            <i class="fas fa-cogs fa-4x" style="color: #1bcfb4;"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <br />
    <div class="row">
        <!-- Column for Pie Charts (Left Side) -->
        <div class="col-md-6">
            <div class="row">
                <!-- Pie Chart for Asset Types -->
                <div class="col-md-12 mb-4">
                    <div class="card border-1 shadow-sm card-chart">
                        <div class="card-body">
                            <h4 class="card-title text-center fw-bold display-6 mt-4 card-title-chart">Asset Total</h4>
                            <div class="chart-container">
                                <canvas id="assetPieChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Column for Summary Cards and Tables (Right Side) -->
        <div class="col-md-6">
            <!-- Summary Tables -->
            <div class="row">
                <!-- Pie Chart for Locations -->
                <div class="col-md-12 mb-4">
                    <div class="card border-1 shadow-sm card-chart">
                        <div class="card-body">
                            <h4 class="card-title text-center fw-bold display-6 mt-4 card-title-chart">Asset Location
                            </h4>
                            <div class="chart-container">
                                <canvas id="locationPieChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Table Operation Summary -->
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="card border-1 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Operation Summary</h5>
                    <div class="table-responsivee">
                        <table id="operationSummaryTable" class="table table-hover">
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
    </div>
    <br><br>

    <div class="row wrapper-Inv_Loc">
        <!-- Column for Pie Charts (Left Side) -->
        <div class="col-md-6">
            <div class="row">
                <!-- Table Inventory Story -->
                <div class="col-md-12 mb-4">
                    <div class="card border-1 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Inventory Summary</h5>
                            <div class="table-responsivee">
                                <table id="inventorySummaryTable" class="table table-hover">
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
            </div>
        </div>

        <!-- Column for Summary Cards and Tables (Right Side) -->
        <div class="col-md-6">
            <!-- Summary Tables -->
            <div class="row">
                <!-- Table Location Summary -->
                <div class="col-md-12">
                    <div class="card border-1 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Location Summary</h5>
                            <div class="table-responsivee">
                                <table id="mappingTable" class="table table-hover">
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
</div>
@endsection