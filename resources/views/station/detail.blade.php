@extends('layouts.app')

@section('customjs')
<!-- Load d3.js and c3.js -->
<script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.min.js') }}"></script>
<script src="{{ asset('js/moment.min.js') }}"></script>

<script src="{{ asset('js/d3.min.js') }}"></script>
<script src="{{ asset('js/c3.min.js') }}"></script>


@endsection
@section('customcss')
<link href="{{ asset('css/c3.css') }}" rel="stylesheet">

@endsection
@section('content')
    <div class="container">
        @forelse($station as $stationdetail)
            <div class="page-header">
              <h1>{{ $stationdetail->NAME }} <small>{{ $stationdetail->EVA_NR }}</small></h1>
            </div>   
            <p>Please select a date:</p>
            <input type="date" id="myDate" value="2018-02-09">
        @empty
            <h1>Keine Station gefunden.</h1>
        @endforelse
        <div class="row">
            <div class="col">
                <nav>
					<div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                    @forelse($station as $stationdetail)
                      @if ($loop->first) 
                        <a class="nav-item nav-link active" data-toggle="tab" data-target="#content-tab" ref="{{ route('station.detaildate', ['id' => $stationdetail->EVA_NR, 'date' => date('Y-m-d')]) }}" href="#">Fahrplan</a>
						<a class="nav-item nav-link" data-toggle="tab" data-target="#content-tab" ref="{{ route('train.index') }}" href="#">Zugstatistiken</a>
						<a class="nav-item nav-link" data-toggle="tab" data-target="#content-tab" ref="{{ route('train.index') }}" href="#">Streckenstatistiken</a>
						<a class="nav-item nav-link" data-toggle="tab" data-target="#content-tab" ref="{{ route('train.index') }}" href="#">Gleiswechsel</a>
                        <a class="nav-item nav-link" data-toggle="tab" data-target="#content-tab2" ref="/train/ICE/3" href="#">Haltestellenstatistiken</a>

                      @endif
                    @empty
                                       
                    @endforelse
                    
					</div>
				</nav>
				<div class="tab-content py-3 px-3 px-sm-0" id="nav-tabContent">                   
					<div class="tab-pane fade show active" id="content-tab" role="tabpanel">
					</div>
                    <div class="tab-pane fade show active" id="content-tab2" role="tabpanel">
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
	    $.get("{{$stationdetail->EVA_NR}}/timetable/"+this.value,
            function (data) {
                $("#content-tab").html(data);
            });
    }
}

$('[data-toggle="tab"]').click(function(e) {
    var $this = $(this),
        loadurl = $this.attr('ref'),
        targ = $this.attr('data-target');

    $.get(loadurl, function(data) {
        $(targ).html(data);
    });
    return false;
});

$( document ).ready(function() {
    // Open up first tab by default
    $('[data-toggle="tab"]')[0].click();
});




var chart = c3.generate({
    bindto: '#chart',
    data: {   
            url: '{{ route('graph.trainstatistik', ['id' => $stationdetail->EVA_NR,'zugklasse' => $stationdetail->EVA_NR,'zugnummer' => $stationdetail->EVA_NR]) }}',
            mimeType: 'json'
        },
        line: {
  connectNull: true
}
    
});
var zugklassen = [];
@forelse($zugklassen as $zugklasse)
    zugklassen.push('{{ $zugklasse->name }}');
@empty
    console.log('Keine Zugklassen gefunden');
@endforelse
var chart2 = c3.generate({
        bindto: '#chart2',
        data: {
            url: '{{ route('graph.trainperplatform', ['id' => $stationdetail->EVA_NR]) }}',
            mimeType: 'json',
            
            keys: {
                x: 'name', // it's possible to specify 'x' when category axis
                value: zugklassen,
            },
            type: 'bar',
            groups: [ ]
        },
        axis: {
            x: {
                type: 'category',
                label: {
                    text: 'Gleis',
                    position: 'outer-center'
                }
            },
            y: {
                label: {
                    text: 'Anzahl an Zügen',
                    position: 'outer-middle'
                }
            }
        }
    });

@stop
