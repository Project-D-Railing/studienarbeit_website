@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col">
                <h1>Search Station:</h1>
                <form class="typeahead" role="search">
                  <div class="form-group">
                    <input type="search" name="q" class="form-control search-input" placeholder="Search" autocomplete="off">
                  </div>
                </form>
                Insert a search here...
                Insert ref link to line and overall statistics...
                                                        
                    <table class="table">
                      <thead>
                        <tr>
                          <th scope="col">#</th>
                          <th scope="col">Stationsname</th>
                          <th scope="col">Ankunftszeit (SOLL)</th>
                          <th scope="col">Ankunftszeit (IST)</th>
                        </tr>
                      </thead>
                      <tbody>
                        @forelse($route as $station)
                            <tr>
                                <th scope="row">{{$station->zugid}} </th>
                                <td> {{$station->NAME}} </td>
                                <td> {{$station->arzeitsoll}} </td>
                                <td> {{$station->arzeitist}}  </td>
                            </tr>
                        @empty
                            <tr>
                                <th scope="row"> - </th>
                                <td> Keine Verbindung gefunden </td>
                                <td> - </td>
                                <td> - </td>
                            </tr>
                        @endforelse
                      </tbody>
                    </table>
            </div>
        </div>
    </div>

@endsection

@section('scripts')

jQuery(document).ready(function($) {
            // Set the Options for "Bloodhound" suggestion engine
            var engine = new Bloodhound({
                remote: {
                    url: '/station/find?q=%QUERY%',
                    wildcard: '%QUERY%'
                },
                datumTokenizer: Bloodhound.tokenizers.whitespace('q'),
                queryTokenizer: Bloodhound.tokenizers.whitespace
            });

            $(".search-input").typeahead({
                hint: true,
                highlight: true,
                minLength: 1
            }, {
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
                        return '<a href="' + data.profile.username + '" class="list-group-item">' + data.name + ' - @' + data.profile.username + '</a>'
              }
                }
            });
        });


@stop
