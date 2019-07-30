<div class="row">
    <div class="col">
        <h4>@lang('main.stats_header')</h4>
        <p>
              @lang('main.stats_route')
        </p>
            @lang('main.stats_alltime', ['date' => $stats_start])
        <br>
        <hr>
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
