@extends('layouts.app')

@section('content')
<h1 class="mt-4 text-center fw-bold display-5">Handover</h1>
<br>
<div class="container">
    <div class="card">
        <div class="card-body">
            @if ($assetTaggingAvailable && $namesAvailable)
                <form action="{{ route('assets.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="approval_status" value="Pending">
                    <input type="hidden" name="aksi" value="Handover">

                    <div class="form-group">
                        <label for="asset_tagging">Asset Tagging</label>
                        <select class="form-control" id="asset_tagging" name="asset_tagging" required>
                            @foreach($inventories as $inventory)
                                <option value="{{ $inventory->id }}">{{ $inventory->tagging }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="nama">Name</label>
                        <select class="form-control" id="nama" name="nama" required>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="location">Location</label>
                        <input type="text" id="location-input" class="form-control" placeholder="Search for a location" required>
                        <button type="button" class="btn btn-primary mt-2" id="enter-location">Enter Location</button>
                        <div id="map" style="height: 300px; width: 100%;"></div>
                        <input type="hidden" id="latitude" name="latitude">
                        <input type="hidden" id="longitude" name="longitude">
                    </div>

                    <div class="form-group">
                        <label for="lokasi">Lokasi</label>
                        <input type="text" id="lokasi" class="form-control" name="lokasi" placeholder="Lokasi will be set here" required>
                    </div>

                    <div class="form-group">
                        <select class="form-control" id="status" name="status" hidden>
                            <option value="Operation">Operation</option>
                            <option value="Inventory">Inventory</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="o365">Office 365</label>
                        <select class="form-control" id="o365" name="o365" required>
                            <option value="Partner License">Partner License</option>
                            <option value="Business">Business</option>
                            <option value="Business Standard">Business Standard</option>
                            <option value="No License">No License</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <select class="form-control" id="kondisi" name="kondisi" hidden>
                            <option value="Good">Good</option>
                            <option value="Exception">Exception</option>
                            <option value="Bad">Bad</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <input type="file" class="form-control" id="documentation" name="documentation" accept="image/*" capture="camera" hidden>
                        @if ($errors->has('documentation'))
                            <span class="text-danger">{{ $errors->first('documentation') }}</span>
                        @endif
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-success">Give</button>
                        <a href="{{ route('assets.index') }}" class="btn btn-secondary ml-3">Cancel</a>
                    </div>
                </form>
            @elseif (!$assetTaggingAvailable)
                <p class="text-center">All assets have been used</p>
            @elseif (!$namesAvailable)
                <p class="text-center">There are no more users, register users anymore</p>
            @endif
        </div>
    </div>
</div>
<br>
<br>

<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var map = L.map('map').setView([-6.2088, 106.8456], 13); // Default coordinates for Jakarta

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    var geocoder = L.Control.Geocoder.nominatim();

    function onGeocodeResult(results) {
        if (results.length > 0) {
            var result = results[0];
            var latlng = result.center;

            // Update the input fields
            document.getElementById('latitude').value = latlng.lat;
            document.getElementById('longitude').value = latlng.lng;
            document.getElementById('location-input').value = result.name;

            // Also set the lokasi field with the location name
            document.getElementById('lokasi').value = result.name;

            // Add a marker on the map
            L.marker(latlng).addTo(map)
                .bindPopup(result.name)
                .openPopup();

            // Center the map on the result
            map.setView(latlng, 13);
        } else {
            console.error('No results found');
        }
    }

    L.Control.geocoder({
        defaultMarkGeocode: false
    })
    .on('markgeocode', function (e) {
        onGeocodeResult([e.geocode]);
    })
    .addTo(map);

    var marker = L.marker([-6.2088, 106.8456], { draggable: true }).addTo(map);
    marker.on('moveend', function (e) {
        var latlng = e.target.getLatLng();
        document.getElementById('latitude').value = latlng.lat;
        document.getElementById('longitude').value = latlng.lng;
    });

    document.getElementById('enter-location').addEventListener('click', function () {
        var location = document.getElementById('location-input').value;
        geocoder.geocode(location, function (results) {
            onGeocodeResult(results);
        });
    });

    document.getElementById('location-input').addEventListener('keypress', function (e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            document.getElementById('enter-location').click();
        }
    });
});
</script>

@endsection
