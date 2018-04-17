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
                        <a class="nav-item nav-link active" data-toggle="tabajax" data-target="#content-tab" href="{{ route('train.detailstations', ['trainclass' => '$traindetail->zugklasse', 'trainnumber' => '$traindetail->zugnummer']) }}" role="tab">Haltestellen</a>
						<a class="nav-item nav-link" data-toggle="tabajax" data-target="#content-tab" href="/gh/gist/response.html/3843293/" role="tab">Verspätung</a>
						<a class="nav-item nav-link" data-toggle="tabajax" data-target="#content-tab" href="/gh/gist/response.html/3843293/" role="tab">Ausfallstatistik</a>
						<a class="nav-item nav-link" data-toggle="tabajax" data-target="#content-tab" href="/gh/gist/response.html/3843293/" role="tab">Gleiswechsel</a>
                        <a class="nav-item nav-link" data-toggle="tabajax" data-target="#content-tab" href="/gh/gist/response.html/3843293/" role="tab">Streckenwechsel</a>
                        <a class="nav-item nav-link" data-toggle="tabajax" data-target="#content-tab" href="/gh/gist/response.html/3843293/" role="tab">Verlauf</a>
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
