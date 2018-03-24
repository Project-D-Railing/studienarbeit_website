@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col">
                <h1>Station overview</h1>
                <p>Some useless strings</p>
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

@stop
