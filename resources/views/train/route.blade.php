<div class="row">
    <div class="col">
        <br>
        @forelse($routes as $route)   
            @forelse($route as $station)
                @if($loop->last)
                    <b>{{ $station }}</b>
                @elseif ($loop->first)
                    <b>{{ $station }}</b>, 
                @else
                    {{ $station }}, 
                @endif
            @empty
            @endforelse
            <br><hr><br>
        @empty
            Für diesen Zug gibt es keine Statistiken
        @endforelse            
    </div>
</div>
