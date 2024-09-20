<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'GLOBAL SERVICE INDONESIA')</title>

    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Additional CSS -->
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/animate.css/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css" rel="stylesheet">

    <!-- Optional Bootstrap Slider -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/11.0.2/css/bootstrap-slider.min.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Chart.js and DataLabels Plugin -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>

    <!-- Custom CSS -->
    <style>
        .form-container {
            max-width: 500px;
            margin: 0 auto;
            padding: 2rem;
            border-radius: 8px;
        }

        .form-section {
            margin-bottom: 1.5rem;
        }

        .form-section:last-child {
            margin-bottom: 0;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-group label {
            font-weight: bold;
            margin-bottom: 0.5rem;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            border-radius: 4px;
            border: 1px solid #ced4da;
            padding: 0.5rem;
        }

        .form-group input[type="submit"] {
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
            padding: 0.75rem 1.5rem;
            border-radius: 4px;
        }

        .form-group input[type="submit"]:hover {
            background-color: #0056b3;
        }

        @media (max-width: 768px) {
            .form-container {
                padding: 1rem;
                max-width: 100%;
            }
        }
    </style>
</head>

<body>
    @php
        $userRole = session('user_role');
    @endphp

    <!-- Include header based on user role -->
    @if ($userRole === 'admin')
        @include('shared.header')
    @elseif ($userRole === 'user' || $userRole === 'sales')
        @include('shared.headeruser')
    @else
        @include('shared.header') <!-- Default or fallback header -->
    @endif

    @if ($userRole === 'user' || $userRole === 'sales')
        <main class="py-4">
            <div class="container form-container">
                @yield('content')
            </div>
        </main>
    @endif

    <!-- Vendor JS Files -->
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/waypoints/noframework.waypoints.js') }}"></script>
    <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/countup.js@2.0.7/dist/countUp.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">

    <!-- jQuery (make sure this is included only once) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>

    <!-- Optional Bootstrap Slider JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/11.0.2/bootstrap-slider.min.js"></script>

    <!-- Your Custom Scripts -->
    <script src="{{ asset('assets/js/main.js') }}"></script>

    <!-- Initialize DataTables for all responsive tables -->
    <script>
        $(document).ready(function () {
            $('.table-responsive').each(function () {
                $(this).find('table').DataTable({
                    paging: true,
                    searching: true,
                    ordering: true,
                    info: true,
                    lengthChange: true,
                    pageLength: 5,
                    lengthMenu: [
                        [5, 50, 100],
                        [5, 50, 100]
                    ],
                    language: {
                        search: "Search:",
                        lengthMenu: "_MENU_ entries per page",
                        info: "Showing _START_ to _END_ of _TOTAL_ entries",
                        infoEmpty: "No entries available",
                        infoFiltered: "(filtered from _MAX_ total entries)",
                        paginate: {
                            previous: "",
                            next: ""
                        }
                    },
                    dom: '<"top"f>rt<"bottom"lp><"clear">',
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
        });
    </script>


    <style>
        /* Hide the dropdown menu from lengthMenu */
        .dataTables_length select {
            -webkit-appearance: none;
            /* Remove default styles in Webkit browsers */
            -moz-appearance: none;
            /* Remove default styles in Firefox */
            appearance: none;
            /* Remove default styles in modern browsers */
            background: transparent;
            /* Make background transparent */
            border: none;
            /* Remove border */
            padding: 0;
            /* Remove padding */
            font-size: 14px;
            /* Set font size to match your design */
        }

        /* Add custom styling if needed */
        .dataTables_length select:focus {
            outline: none;
            /* Remove outline on focus */
        }

        .dataTables_length {
            display: flex;
            /* Align the element using flex */
            align-items: center;
            /* Center items vertically */
        }

        .align-middle {
            vertical-align: middle !important;
        }
    </style>


    <!-- 
    <script>
        window.Echo.channel('data-channel')
            .listen('DataUpdated', (e) => {
                console.log('Data updated:', e.data);
                const dataContainer = document.getElementById('data-container');
                if (dataContainer) {
                    dataContainer.innerHTML = JSON.stringify(e.data);
                }
            });

        function fetchData() {
            fetch('{{ url('/fetch-data') }}')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('data-container').innerHTML = JSON.stringify(data);
                });
        }

        fetchData();
    </script> -->

    @if(isset($assetData) && isset($locationData))
        <script>
            // Fetch and format asset and location data
            const assetLabels = @json($assetData->pluck('jenis_aset'));
            const assetCounts = @json($assetData->pluck('total'));

            const locationLabels = @json($locationData->pluck('lokasi'));
            const locationCounts = @json($locationData->pluck('total'));

            // Function to format labels by truncating text at the first comma
            function formatLabels(labels) {
                return labels.map(label => {
                    const commaIndex = label.indexOf(',');
                    return commaIndex !== -1 ? label.substring(0, commaIndex) : label;
                });
            }

            // Format labels for the legend
            const formattedLocationLabels = formatLabels(locationLabels);

            const commonOptions = {
                responsive: true,
                maintainAspectRatio: false, // This ensures that the chart will adjust its size on mobile
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom', // Position legend at the bottom
                        labels: {
                            boxWidth: 20,
                            padding: 15,
                            font: {
                                size: 14
                            },
                            // Custom CSS class for legend
                            usePointStyle: true,
                            pointStyle: 'rectRounded'
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function (tooltipItem) {
                                return tooltipItem.label + ': ' + tooltipItem.raw;
                            }
                        }
                    },
                    datalabels: {
                        color: '#fff',
                        display: true,
                        formatter: function (value) {
                            return value;
                        },
                        anchor: 'center',
                        align: 'center',
                        offset: 0
                    }
                }
            };

            // Initialize asset pie chart
            const ctxAsset = document.getElementById('assetPieChart').getContext('2d');
            new Chart(ctxAsset, {
                type: 'pie',
                data: {
                    labels: assetLabels,
                    datasets: [{
                        data: assetCounts,
                        backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF'],
                    }]
                },
                options: commonOptions
            });

            // Initialize location pie chart with formatted labels
            const ctxLocation = document.getElementById('locationPieChart').getContext('2d');
            new Chart(ctxLocation, {
                type: 'pie',
                data: {
                    labels: formattedLocationLabels, // Use formatted labels
                    datasets: [{
                        data: locationCounts,
                        backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF'],
                    }]
                },
                options: commonOptions
            });
        </script>

        <style>
            /* Custom styles for legend */
            .chart-container {
                position: relative;
            }

            .chart-container .chart-legend {
                display: flex;
                flex-direction: column;
                /* Arrange items in a column */
                align-items: center;
                /* Center items horizontally */
                margin-top: 40px;
                /* Increased space between chart and legend */
                /* Space between chart and legend */
            }

            .chart-container .chart-legend ul {
                list-style: none;
                padding: 0;
                margin: 0;
            }

            .chart-container .chart-legend li {
                display: flex;
                align-items: center;
                margin-bottom: 10px;
                /* Space between legend items */
            }

            .chart-container .chart-legend li span {
                display: inline-block;
                width: 20px;
                height: 20px;
                margin-right: 10px;
                border-radius: 4px;
                /* Rounded corners for color boxes */
            }

            .card {
                border: 1px solid #dee2e6;
                /* Border color */
            }

            .card-title {
                font-weight: bold;
                margin-bottom: 30px;
            }

            @media (max-width: 768px) {
                .assettotal-padding {
                    padding-top: 25px !important;
                }
            }
        </style>

    @endif

</body>

</html>