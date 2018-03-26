@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col">
                <h1>Search Station:</h1>
                <form class="typeahead" role="search">
                  <div class="form-group">
                    <input type="search" name="q" class="form-control search-input" placeholder="Search stationname" autocomplete="off">
                  </div>
                </form>
                <p>There will be all time stats somewhere later on.</p>
            </div>
        </div>
    </div>

@endsection

@section('scripts')

jQuery(document).ready(function($) {
            // Set the Options for "Bloodhound" suggestion engine
            var engine = new Bloodhound({
                remote: {
                    url: '{{ route('station.find') }}?q=%QUERY%',
                    wildcard: '%QUERY%'
                },
                datumTokenizer: Bloodhound.tokenizers.whitespace('q'),
                queryTokenizer: Bloodhound.tokenizers.whitespace
            });

            $(".search-input").typeahead({
                hint: true,
                highlight: true,
                minLength: 2
            }, {
                displayKey: 'NAME',
                source: engine.ttAdapter(),

                // This will be appended to "tt-dataset-" to form the class name of the suggestion menu.
                name: 'stationList',

                // the key from the array we want to display (name,id,email,etc...)
                templates: {
                    empty: [
                        '<div class="list-group search-results-dropdown"><div class="list-group-item">Nothing found.</div></div>'
                    ],
                    header: [
                        '<div class="list-group search-results-dropdown">'
                    ],
                    suggestion: function (data) {
                        return '<a href="/station/' + data.EVA_NR + '" class="list-group-item">' + data.NAME + '</a>'
                    }
                }
            });
            $('.typeahead').on('typeahead:selected', function (e, datum) {
                window.location.href = "station/" +datum.EVA_NR
            });
        });


@stop
