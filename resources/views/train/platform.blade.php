<div class="row">
    <div class="col">
        @forelse($stats as $plot)   
           @if ($loop->iteration === 2)
                @forelse($plot as $graph)   
                    <div id="chartgleis_{{$loop->iteration}}">
                    </div>  
                @empty
                    Für diesen Zug gibt es keine Statistiken
                @endforelse    
           @endif
        @empty
            Für diesen Zug gibt es keine Statistiken
        @endforelse                 
    </div>
</div>


<script type="text/javascript">

@forelse($stats as $plot)
    @if ($loop->iteration === 2)
                @forelse($plot as $graph)   
                    var columns_{{$loop->iteration}} = {!! json_encode($graph) !!};
                    var chart_{{$loop->iteration}} = c3.generate({
                        bindto: '#chartgleis_{{$loop->iteration}}',
                        data: {
                            json: columns_{{$loop->iteration}},
                            type : 'donut'
                        },
                        donut: {
                            title: columns[0][2]
                        }
                    });

                @empty
                    
                @endforelse    
           @endif

@empty
    
@endforelse


</script>
