@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <nav>
					<div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
						<a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Home</a>
						<a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Zugstatistiken</a>
						<a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Streckenstatistiken</a>
						<a class="nav-item nav-link" id="nav-about-tab" data-toggle="tab" href="#nav-about" role="tab" aria-controls="nav-about" aria-selected="false">Haltestellenstatistiken</a>
					</div>
				</nav>
				<div class="tab-content py-3 px-3 px-sm-0" id="nav-tabContent">
					<div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
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
                            <div id="result">
        
                            </div>
					</div>
					<div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                        <div id="chart"></div>
                        Hier statistiken über den zug in der haltestelle zeigen, welche gleise wv. verspätung /ausfall genau hier.
					</div>
					<div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                        Hier einen Zug aus dem Fahrplan selecten lassen, diese Strecke dann zeigen mit statistiken
                    </div>
					<div class="tab-pane fade" id="nav-about" role="tabpanel" aria-labelledby="nav-about-tab">
                        Hier etwas über die Anzahl Züge pro Stunde als Grafik, Anzahl der Gesamten züge im Mining zeitraum, Schnitt pro tag, gleiswahl statistiken (welche gleise werden wie oft benutzt)
                        <div id="chart2"></div>
                    </div>
				</div>

            </div>
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

var chart = c3.generate({
    bindto: '#chart',
    data: {   
            url: '{{ route('graph.somedata', ['id' => $stationdetail->EVA_NR]) }}',
            mimeType: 'json'
        },
        line: {
  connectNull: true
}
    
});
console.log({{ $zugklassen }});
var chart2 = c3.generate({
        bindto: '#chart2',
        data: {
            json: [
                {name: 'Gleis 1', tgv: 200, ice: 200, kackzug: 400},
                {name: '2', tgv: 300, ice: 200, kackzug: 0},
                {name: '3', tgv: 500, ice: 0, kackzug: 100},
                {name: '', tgv: 0, ice: 400, kackzug: 50},
            ], 
            keys: {
                x: 'name', // it's possible to specify 'x' when category axis
                value: ['tgv', 'ice','kackzug'],
            },
            type: 'bar',
            groups: [
            ['tgv', 'ice','kackzug']
        ]
        },
        axis: {
            x: {
                type: 'category'
            }
        }
    });

@stop
