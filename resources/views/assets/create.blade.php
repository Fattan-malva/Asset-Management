@extends('layouts.app')
@section('title', 'Handover')
@section('content')
<div class="container">
    <div style="display: flex; align-items: center; justify-content: space-between; padding: 10px; margin-top: 54px;">
        <i class='bx bx-arrow-back' id="back-icon" style="cursor:pointer; background: linear-gradient(135deg, #FFFFFF, #B66DFF); height: 36px; width: 36px; border-radius: 4px; color: #fff; display: flex; align-items: center; justify-content: center; box-shadow: 0 3px 8.3px .7px rgba(163, 93, 255, .35); margin-right: auto;">
        </i>
        <h3 style="font-weight: bold; font-size: 1.125rem;">
            Handover&nbsp;&nbsp;
            <span style="background: linear-gradient(135deg, #FFFFFF, #B66DFF); height: 36px; width: 36px; border-radius: 4px; color: #fff; display: inline-flex; align-items: center; justify-content: center; box-shadow: 0 3px 8.3px .7px rgba(163, 93, 255, .35);">
                <i class="fas fa-2xs fa-list" style="font-size: 16px;"></i>
            </span>
        </h3>
    </div>
    <div class="card">
        <div class="card-body">
            @if ($assetTaggingAvailable && $namesAvailable)
                <form action="{{ route('assets.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="approval_status" value="Pending">
                    <input type="hidden" name="aksi" value="Handover">


                    <div class="form-group">
                        <label for="asset_tagging">Asset Tagging</label>
                        <select class="form-control" id="asset_tagging" name="asset_tagging[]" multiple="multiple" required>
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
                        <div class="input-group">
                            <input type="text" id="location-input" class="form-control" placeholder="Search for a location"
                                required>
                            <div class="input-group-append">
                                <button type="button" class="btn btn-primary" id="enter-location">Search</button>
                            </div>
                        </div>
                        <div id="map" style="height: 400px; width: 100%; margin-top:10px;"></div>
                        <input type="hidden" id="latitude" name="latitude">
                        <input type="hidden" id="longitude" name="longitude">
                    </div>

                    <div class="form-group">
                        <input type="text" id="lokasi" class="form-control" name="lokasi"
                            placeholder="Location details will be set here" required>
                    </div>

                    <div class="form-group">
                        <select class="form-control" id="status" name="status" hidden>
                            <option value="Operation">Operation</option>
                            <option value="Inventory">Inventory</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <select class="form-control" id="o365" name="o365" required hidden>
                            <option value="Partner License">Partner License</option>
                            <option value="Business">Business</option>
                            <option value="Business Standard">Business Standard</option>
                            <option value="No License">No License</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <select class="form-control" id="kondisi" name="kondisi" hidden>
                            <option value="New">New</option>
                            <option value="Good">Good</option>
                            <option value="Exception">Exception</option>
                            <option value="Bad">Bad</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <input type="file" class="form-control" id="documentation" name="documentation" accept="image/*"
                            capture="camera" hidden>
                        @if ($errors->has('documentation'))
                            <span class="text-danger">{{ $errors->first('documentation') }}</span>
                        @endif
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-success">Submit</button>
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
    // The rest of your JavaScript for the map and geocoding remains unchanged
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

<style>
     .form-group {
        margin-bottom: 1rem;
    }

    .list-group-item {
        cursor: pointer;
    }

    .input-group {
        display: flex;
        align-items: center;
    }

    .input-group-append {
        margin-left: -1px;
    }

    #map {
        height: 400px;
        width: 100%;
        margin-top: 10px;
    }

    .btn-primary {
        margin-top: 0;
        /* Remove extra margin if any */
    }

    .text-center {
        text-align: center;
    }

    .btn {
        margin: 0 0.5rem;
    }
    .select2-container {
        width: 100% !important; /* Ensure Select2 takes full width */
    }
</style>
@endsection