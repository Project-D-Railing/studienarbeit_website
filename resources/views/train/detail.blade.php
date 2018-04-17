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
        <div class="row">
            <div class="col">
                <nav>
					<div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
						<a class="nav-item nav-link active" data-toggle="tabajax" data-target="#content-tab" href="/gh/gist/response.html/3843293/" role="tab">Haltestellen</a>
						<a class="nav-item nav-link" id="nav-delay-tab" data-toggle="tab" href="#nav-delay" role="tab" aria-controls="nav-delay" aria-selected="false">Verspätung</a>
						<a class="nav-item nav-link" id="nav-cancel-tab" data-toggle="tab" href="#nav-cancel" role="tab" aria-controls="nav-cancel" aria-selected="false">Ausfallstatistik</a>
						<a class="nav-item nav-link" id="nav-platform-tab" data-toggle="tab" href="#nav-platform" role="tab" aria-controls="nav-platform" aria-selected="false">Gleiswechsel</a>
                        <a class="nav-item nav-link" id="nav-strecke-tab" data-toggle="tab" href="#nav-strecke" role="tab" aria-controls="nav-strecke" aria-selected="false">Streckenwechsel</a>
                        <a class="nav-item nav-link" id="nav-history-tab" data-toggle="tab" href="#nav-history" role="tab" aria-controls="nav-history" aria-selected="false">Verlauf</a>
					</div>
				</nav>
				<div class="tab-content py-3 px-3 px-sm-0" id="nav-tabContent">
					<div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
						    @forelse($train as $traindetail)
                                <div class="page-header">
                                  <h1>{{ $traindetail->zugnummerfull }} <small>{{ $traindetail->zugklasse }}</small></h1>
                                </div>   
                                                      
                            @empty
                    
                                <h1>Kein Zug gefunden.</h1>
                            @endforelse
                            <div id="result">
        
                            </div>
                            

					</div>
					<div class="tab-pane fade" id="content-tab" role="tabpanel" aria-labelledby="nav-delay-tab">
                        Hier was über verspätungen
					</div>					
				</div>

            </div>
        </div>
        
    </div>

@endsection

@section('scripts')

@forelse($train as $traindetail)
    @if ($loop->first) 
        
    $.get("{{$traindetail->zugnummer}}/stations",
            function (data) {
                $("#result").html(data);
            });
    @endif
 @empty
                   
 @endforelse

$('[data-toggle="tabajax"]').click(function(e) {
    var $this = $(this),
        loadurl = $this.attr('href'),
        targ = $this.attr('data-target');

    $.get(loadurl, function(data) {
        $(targ).html(data);
    });

    $this.tab('show');
    return false;
});



@stop
