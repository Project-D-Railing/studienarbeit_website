@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col">
                <div id="leafletmap" style="height: 800px"></div>
            </div>
        </div>
    </div>

@endsection
@section('customcss')
<link href="{{ asset('css/leaflet.css') }}" rel="stylesheet">
    <link href="{{ asset('css/MarkerCluster.css') }}" rel="stylesheet">
    <link href="{{ asset('css/MarkerCluster.Default.css') }}" rel="stylesheet">
@endsection
@section('customjs')
<script src="{{ asset('js/leaflet.js') }}"></script>
<script src="{{ asset('js/leaflet.ajax.min.js') }}"></script>
<script src="{{ asset('js/leaflet.markercluster.js') }}"></script>
@endsection
@section('scripts')


/*
 * This example shows how to add a layer list to a map where users can check and uncheck boxes to show and hide layers.
 * The code below is combined with the code to add geojson to a map, since those two things are often used together.
 * The code consists of five main parts:
 *    1. Create the basemap(s) and layer(s)
 *    2. Get geojson data and run a function to add it to a layer from step 1
 *    3. Create the function that will be run in step 2
 *    4. Create the list of layers that will appear in the control component
 *    5. Create the control component
 */

/* 1 */
// create a basemap
var map = L.map('leafletmap').setView([49.011, 8.404], 12);

let streets = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors | <a href="https://data.deutschebahn.com/dataset?groups=datasets&amp;tags=Geo">Geodaten der DB-Netz AG</a> veröffentlicht unter <a href="https://creativecommons.org/licenses/by/4.0/deed.de">CC BY 4.0</a>'
}).addTo(map);


var haltestellegroup = L.markerClusterGroup();

@foreach ($haltestellen as $haltestelle)
haltestellegroup.addLayer(L.marker([ {{ $haltestelle->BREITEDOT }} , {{ $haltestelle->LAENGEDOT }}]).bindPopup('Name: {{ $haltestelle->NAME }}<br>Verkehr: {{ $haltestelle->VERKEHR }}<br> EVANR.: {{ $haltestelle->EVA_NR }} <br> Link: <a href={{ route('station.detail', ['id' => $haltestelle->EVA_NR]) }}>Details</a>'));
@endforeach

map.addLayer(haltestellegroup);


/* 4 */
// These options will appear in the control box that users click to show and hide layers
let basemapControl = {
  "OpenStreetMap": streets, // an option to select a basemap (makes more sense if you have multiple basemaps)
}
let layerControl = {
  "Haltestellen": haltestellegroup,
}

/* 5 */
// Add the control component, a layer list with checkboxes for operational layers and radio buttons for basemaps
L.control.layers( basemapControl, layerControl ).addTo( map )
@stop
