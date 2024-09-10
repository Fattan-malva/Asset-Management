@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Tracking Asset: {{ $asset->jenis_aset }} ({{ $asset->serial_number }})</h2>

    <!-- Display Leaflet Map -->
    <div id="map" class="map-container"></div>

    <!-- Link to Open Location in Google Maps -->
    <div class="text-center mt-3">
        <a href="https://www.google.com/maps/search/?api=1&query={{ $asset->latitude }},{{ $asset->longitude }}" 
           target="_blank" 
           class="btn btn-primary">
           Open in Google Maps
        </a>
    </div>

    <!-- Leaflet and OpenStreetMap CSS/JS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Ensure the asset latitude and longitude are set
            var latitude = {{ $asset->latitude }};
            var longitude = {{ $asset->longitude }};
            
            // Initialize the map centered on the asset's location
            var map = L.map('map').setView([latitude, longitude], 15);

            // Add tile layer from OpenStreetMap
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            // Add a marker to the map at the asset's location
            var marker = L.marker([latitude, longitude]).addTo(map)
                .bindPopup('{{ $asset->jenis_aset }} - {{ $asset->serial_number }}')
                .openPopup();
        });
    </script>
</div>
@endsection

<style>
    .map-container {
        height: 500px; /* Set a fixed height for the map */
        width: 100%;   /* Full width */
        margin-top: 20px; /* Space between header and map */
        justify-content: center;
    }
</style>
