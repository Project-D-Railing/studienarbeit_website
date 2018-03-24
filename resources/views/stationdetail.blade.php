@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col">
                
                @forelse($station as $stationdetail)
                                    
                    <h1>{{ $stationdetail->NAME }}</h1>
                    <p>{{ $stationdetail->EVA_NR }}</p>
                    Insert some statistics here....
                    <input type="date" id="myDate" value="2018-02-09">

                    <p>Click the button to get the date of the date field.</p>

                @empty
                
                    <h1>Keine Station gefunden.</h1>
                @endforelse
                    
            </div>
            
        </div>
        
        <div id="result">
        
        </div>
    </div>

@endsection

@section('scripts')
console.log('hallo details');

var date_input = document.getElementById('myDate');
date_input.valueAsDate = new Date();

date_input.onchange = function(){
    var d = new Date(this.value);
    if(!isNaN(d.getTime())) {
	    $.get("{{$stationdetail->EVA_NR}}/"+this.value,
            function (data) {
                $("#result").html(data);
            });
    }
}
@stop
