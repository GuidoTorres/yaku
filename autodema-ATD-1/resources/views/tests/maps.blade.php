@extends('layouts.app', ['page' => 'reports'])

@section('content')
<div class="container">
    <div class="row">

    </div>
    <div class="row justify-content-center" style="background-color: #fff">
        <div class="col-8">
            <div id="mapid"></div>

        </div>
        <div class="col-4">
            <div id="mapid"></div>

        </div>

    </div>



</div>
@endsection
@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin="" />
<style>
    #mapid {
        height: 100%;
        width: 90%
    }
</style>

@endpush
@push('scripts')
<!-- Make sure you put this AFTER Leaflet's CSS -->
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>

<script>
    $(document).ready(function() {
        var mymap = L.map('mapid').setView([-16.241205550156, -71.3387583913712], 13);
        L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=sk.eyJ1IjoiaW5vbG9vcCIsImEiOiJja3V0czJqcHY1cndnMnVvOGZnbTAxZXhsIn0.tu0myQBz0e3p0rxge6qwzQ', {
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
            maxZoom: 18,
            id: 'mapbox/streets-v11',
            tileSize: 512,
            zoomOffset: -1,
            accessToken: 'your.mapbox.access.token'
        }).addTo(mymap);

        var marker = L.marker([-16.241205550156, -71.3387583913712]).addTo(mymap);

        var popup = L.popup();

        function onMapClick(e) {
            popup
                .setLatLng(e.latlng)
                .setContent("Delta Rojo")
                .openOn(mymap);
        }

        mymap.on('click', onMapClick);

    });
</script>
@endpush