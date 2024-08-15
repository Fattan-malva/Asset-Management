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
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Optional Bootstrap Slider -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/11.0.2/css/bootstrap-slider.min.css">

    <!-- Chart.js and DataLabels Plugin -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

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

    <main class="py-4">
        @yield('content')
    </main>

    @include('shared.footer')

    <!-- Vendor JS Files -->
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/waypoints/noframework.waypoints.js') }}"></script>
    <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>

    <!-- jQuery (make sure this is included only once) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

    <!-- Optional Bootstrap Slider JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/11.0.2/bootstrap-slider.min.js"></script>

    <!-- Your Custom Scripts -->
    <script src="{{ asset('assets/js/main.js') }}"></script>

    <!-- Initialize DataTables for all responsive tables -->
    <script>
        $(document).ready(function () {
            $('.table-responsive').each(function () {
                $(this).find('table').DataTable({
                    "paging": true,
                    "searching": true,
                    "ordering": true,
                    "info": true,
                    "lengthChange": true,
                    "pageLength": 10,
                    "lengthMenu": [
                        [10, 50, 100],
                        [10, 50, 100]
                    ],
                    "language": {
                        "search": "Search:",
                        "lengthMenu": "_MENU_ entries per page",
                        "info": "Showing _START_ to _END_ of _TOTAL_ entries",
                        "infoEmpty": "No entries available",
                        "infoFiltered": "(filtered from _MAX_ total entries)",
                        "paginate": {
                            "previous": "", // Remove previous text
                            "next": "" // Remove next text
                        }
                    },
                    "dom": '<"top"f>rt<"bottom"lp><"clear">'
                });
            });
        });
    </script>
    

    @if(isset($assetData) && isset($locationData))
        <script>
            // Data for Jenis Asset Pie Chart
            const assetLabels = @json($assetData->pluck('jenis_aset'));
            const assetCounts = @json($assetData->pluck('total'));

            // Data for Lokasi Mapping Pie Chart
            const locationLabels = @json($locationData->pluck('lokasi'));
            const locationCounts = @json($locationData->pluck('total'));

            // Jenis Asset Pie Chart
            const ctxAsset = document.getElementById('assetPieChart').getContext('2d');
            const assetPieChart = new Chart(ctxAsset, {
                type: 'pie',
                data: {
                    labels: assetLabels,
                    datasets: [{
                        data: assetCounts,
                        backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF'],
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'right', // Position the legend to the right of the chart
                            labels: {
                                boxWidth: 20, // Adjust the size of the color box
                                padding: 15, // Add padding between items
                                font: {
                                    size: 14 // Font size for legend labels
                                }
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function (tooltipItem) {
                                    return tooltipItem.label + ': ' + tooltipItem.raw; // Customize tooltip label
                                }
                            }
                        },
                        datalabels: {
                            color: '#fff', // Color of the labels
                            display: true,
                            formatter: function (value) {
                                return value; // Display the value in the segment
                            },
                            anchor: 'center', // Center the label inside the segment
                            align: 'center', // Center the label inside the segment
                            offset: 0 // Position the label in the center
                        }
                    }
                }
            });

            // Lokasi Mapping Pie Chart
            const ctxLocation = document.getElementById('locationPieChart').getContext('2d');
            const locationPieChart = new Chart(ctxLocation, {
                type: 'pie',
                data: {
                    labels: locationLabels,
                    datasets: [{
                        data: locationCounts,
                        backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF'],
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'right', // Position the legend to the right of the chart
                            labels: {
                                boxWidth: 20, // Adjust the size of the color box
                                padding: 15, // Add padding between items
                                font: {
                                    size: 14 // Font size for legend labels
                                }
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function (tooltipItem) {
                                    return tooltipItem.label + ': ' + tooltipItem.raw; // Customize tooltip label
                                }
                            }
                        },
                        datalabels: {
                            color: '#fff', // Color of the labels
                            display: true,
                            formatter: function (value) {
                                return value; // Display the value in the segment
                            },
                            anchor: 'center', // Center the label inside the segment
                            align: 'center', // Center the label inside the segment
                            offset: 0 // Position the label in the center
                        }
                    }
                }
            });
        </script>
    @endif
</body>

</html>