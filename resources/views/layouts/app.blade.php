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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/11.0.2/css/bootstrap-slider.min.css">

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
    @elseif ($userRole === 'user')
        @include('shared.headeruser')
    @else
        @include('shared.header') <!-- Default or fallback header -->
    @endif

    @if ($userRole === 'user')
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
                    dom: '<"top"f>rt<"bottom"lp><"clear">'
                });
            });
        });
    </script>

    <!-- Initialize Echo for real-time updates -->
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
    </script>

@if(isset($assetData) && isset($locationData))
<script>
    const assetLabels = @json($assetData->pluck('jenis_aset'));
    const assetCounts = @json($assetData->pluck('total'));

    const locationLabels = @json($locationData->pluck('lokasi'));
    const locationCounts = @json($locationData->pluck('total'));

    const commonOptions = {
        responsive: true,
        maintainAspectRatio: false, // This ensures that the chart will adjust its size on mobile
        plugins: {
            legend: {
                position: 'right',
                labels: {
                    boxWidth: 20,
                    padding: 15,
                    font: {
                        size: 14
                    }
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

    const ctxLocation = document.getElementById('locationPieChart').getContext('2d');
    new Chart(ctxLocation, {
        type: 'pie',
        data: {
            labels: locationLabels,
            datasets: [{
                data: locationCounts,
                backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF'],
            }]
        },
        options: commonOptions
    });
</script>
<style>
    @media (max-width: 768px) {
        .assettotal-padding {
            padding-top: 25px !important;
        }
    }
</style>
@endif

</body>

</html>
