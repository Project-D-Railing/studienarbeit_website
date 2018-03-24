@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col">
                
                @forelse($station as $stationdetail)
                                    
                    <h1>{{ $stationdetail->NAME }}</h1>
                    <p>{{ $stationdetail->EVA_NR }}</p>
                    Insert some statistics here....
                    
                @empty
                
                    <h1>Keine Station gefunden.</h1>
                @endforelse
                    
                <input type="date" id="myDate" value="2018-02-09">
                <button onclick="fetchDate()">Try it</button>

                <p id="demo"></p>               

            </div>
        </div>
    </div>

@endsection

@section('scripts')
function fetchDate() {
    var x = document.getElementById("myDate").value;
    document.getElementById("demo").innerHTML = x;
}
@stop
