@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Live Tracking Asset: {{ $asset->jenis_aset }} ({{ $asset->serial_number }})</h2>

    <!-- Display Google Map -->
    <div id="map" style="height: 500px; width: 100%;"></div>

    <script>
        function initMap() {
            // Initialize the map with the asset's latitude and longitude
            var assetLocation = { lat: parseFloat('{{ $asset->latitude }}'), lng: parseFloat('{{ $asset->longitude }}') };

            // Create a new map centered at the asset location
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 15,
                center: assetLocation
            });

            // Add a marker for the asset location
            var marker = new google.maps.Marker({
                position: assetLocation,
                map: map,
                title: '{{ $asset->jenis_aset }}'
            });
        }
    </script>

    <!-- Include Google Maps JavaScript API with your API key -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDURZBEQM0-2QV40fngUMu9u1BxxVEt3sU&callback=initMap&libraries=places" async defer></script>
</div>
@endsection
