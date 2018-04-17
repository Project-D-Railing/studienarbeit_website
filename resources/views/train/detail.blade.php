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
        @forelse($train as $traindetail)
            <div class="page-header">
              <h1>{{ $traindetail->zugnummerfull }} <small>{{ $traindetail->zugklasse }}</small></h1>
            </div>   
                                  
        @empty

            <h1>Kein Zug gefunden.</h1>
        @endforelse
        <div class="row">
            <div class="col">
                <nav>
                    <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                    @forelse($train as $traindetail)
                      @if ($loop->first) 
                        <a class="nav-item nav-link active" data-toggle="tab" data-target="#content-tab" ref="{{ route('train.detailstations', ['trainclass' => $traindetail->zugklasse, 'trainnumber' => $traindetail->zugnummer]) }}" href="#content-tab">Haltestellen</a>
						<a class="nav-item nav-link" data-toggle="tab" data-target="#content-tab" ref="{{ route('train.index') }}" href="#content-tab">Verspätung</a>
						<a class="nav-item nav-link" data-toggle="tab" data-target="#content-tab" ref="{{ route('train.index') }}" href="#content-tab">Ausfallstatistik</a>
						<a class="nav-item nav-link" data-toggle="tab" data-target="#content-tab" ref="{{ route('train.index') }}" href="#content-tab">Gleiswechsel</a>
                        <a class="nav-item nav-link" data-toggle="tab" data-target="#content-tab" ref="/train/ICE/3" href="#content-tab">Streckenwechsel</a>
                        <a class="nav-item nav-link" data-toggle="tab" data-target="#content-tab" ref="/station/8000191" href="#content-tab">Verlauf</a>
                      @endif
                    @empty
                                       
                    @endforelse
					</div>
				</nav>
				<div class="tab-content py-3 px-3 px-sm-0" id="nav-tabContent">
					<div class="tab-pane fade show active" id="content-tab" role="tabpanel" aria-labelledby="nav-home-tab">
					</div>
				</div>

            </div>
        </div>
        
    </div>

@endsection

@section('scripts')

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

@stop
