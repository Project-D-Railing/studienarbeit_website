@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col">
                
                @forelse($station as $stationdetail)
                    <div class="page-header">
                      <h1>{{ $stationdetail->NAME }} <small>{{ $stationdetail->EVA_NR }}</small></h1>
                    </div>   
                        
                    
                    <p>Hier Reite einfügen siehe Bootstrap nav-tabs</p>
                    <div class="radio">
                      <label><input type="radio" name="optradio" value="1" checked="checked"> Option 1</label>
                    </div>
                    <div class="radio">
                      <label><input type="radio" name="optradio" value="2"> Option 2</label>
                    </div>
                    <p>Please select a date:</p>
                    <input type="date" id="myDate" value="2018-02-09">
                    


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
