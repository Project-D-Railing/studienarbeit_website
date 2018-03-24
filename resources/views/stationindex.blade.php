@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col">
                <h1>Station overview</h1>
                <p>Some useless strings</p>
                Insert a search here...
                Insert ref link to line and overall statistics...
                    @forelse($route as $station)
                                    
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
                        @foreach($users as $user)
                            <tr>
                                <th scope="row">{{$station->zugid}} </th>
                                <td> {{$station->NAME}} </td>
                                <td> {{$station->arzeitsoll}} </td>
                                <td> {{$station->arzeitist}}  </td>
                            </tr>
                        @endforeach
                      </tbody>
                    </table>
                    
                    @empty
                
                    <h1>Keine Station gefunden.</h1>
                    @endforelse
            </div>
        </div>
    </div>

@endsection

@section('scripts')

@stop
