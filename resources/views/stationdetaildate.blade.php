<div class="row">
    <div class="col">
        
        @forelse($zuege as $zug)
                            
            <h1>{{ $zug->zugid }}</h1>
            <p>{{ $zug->arzeitsoll }}</p>            
        @empty
        
            <h1>Keine Züge gefunden.</h1>
        @endforelse
    </div>
</div>
