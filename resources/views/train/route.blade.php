<div class="row">
    <div class="col">
        @forelse($routes as $route)   
            @forelse($route as $station)   
                {{ $station }} ,
            @empty
            @endforelse
            <br><hr><br>
        @empty
            Für diesen Zug gibt es keine Statistiken
        @endforelse            
    </div>
</div>
