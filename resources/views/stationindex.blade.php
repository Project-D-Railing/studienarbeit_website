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
                                    
                    <p>{{ $station->NAME }}</p>
                    
                    @empty
                
                    <h1>Keine Station gefunden.</h1>
                    @endforelse
            </div>
        </div>
    </div>

@endsection

@section('scripts')

@stop
