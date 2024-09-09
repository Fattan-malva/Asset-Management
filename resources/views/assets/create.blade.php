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
                        <label for="lokasi">Location</label>
                        <input type="text" class="form-control" id="lokasi" name="lokasi" required>
                    </div>


                    <!-- <div class="form-group">
                        <label for="location">Location</label>
                        <input type="text" id="lokasi" class="form-control" >
                        <div id="map" style="height: 300px; width: 100%;"></div>
                        <input type="hidden" id="latitude" name="latitude">
                        <input type="hidden" id="longitude" name="longitude">
                    </div> -->

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
                        <input type="file" class="form-control" id="documentation" name="documentation" accept="image/*"
                            capture="camera" hidden nullable>
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
@endsection

<!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDIvvkiYPmKHviSe_toAk9SjJAvct_YBog&libraries=places"></script>
<script>
    function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: -6.200000, lng: 106.816666},
            zoom: 13
        });

        var input = document.getElementById('location-input');
        var searchBox = new google.maps.places.SearchBox(input);

        map.addListener('bounds_changed', function() {
            searchBox.setBounds(map.getBounds());
        });

        var marker = new google.maps.Marker({
            map: map,
            draggable: true
        });

        searchBox.addListener('places_changed', function() {
            var places = searchBox.getPlaces();
            if (places.length == 0) {
                return;
            }

            marker.setPosition(places[0].geometry.location);
            map.setCenter(places[0].geometry.location);
            map.setZoom(15);

            document.getElementById('latitude').value = places[0].geometry.location.lat();
            document.getElementById('longitude').value = places[0].geometry.location.lng();
        });

        google.maps.event.addListener(marker, 'dragend', function() {
            document.getElementById('latitude').value = marker.getPosition().lat();
            document.getElementById('longitude').value = marker.getPosition().lng();
        });
    }

    google.maps.event.addDomListener(window, 'load', initMap);
</script> -->