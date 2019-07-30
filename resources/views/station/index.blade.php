@extends('layouts.app')

@section('customjs')
<script src="{{ asset('js/typeahead.bundle.min.js') }}"></script>
<script src="{{ asset('js/moment.min.js') }}"></script>
@endsection
@section('content')

    <div class="container">
        <div class="row">
            <div class="col">
                <h1>@lang('main.station_search')</h1>
                <form class="typeahead" role="search">
                  <div class="form-group">
                    <input type="search" name="q" class="form-control search-input" placeholder="@lang('main.station_search_help')" autocomplete="off">
                  </div>
                </form>
                <p>@lang('main.station_subtext')</p>
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
                        '<div class="list-group search-results-dropdown"><div class="list-group-item">@lang('main.search_nothing_found')</div></div>'
                    ],
                    header: [
                        '<div class="list-group search-results-dropdown">'
                    ],
                    suggestion: function (data) {
                        return '<a href="station/' + data.EVA_NR + '" class="list-group-item">' + data.NAME + '</a>'
                    }
                }
            });
            $('.typeahead').on('typeahead:selected', function (e, datum) {
                window.location.href = "station/" +datum.EVA_NR
            });
        });


@stop
