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
                    
            </div>
        </div>
    </div>

@endsection

@section('scripts')

@stop
