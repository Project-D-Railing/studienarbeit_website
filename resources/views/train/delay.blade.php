<div class="row">
    <div class="col">
        @forelse($stats as $plot)   
           @if ($loop->iteration === 2)
                @forelse($plot as $graph)   
                    <h2>{!! $graph[1][3] !!}</h2>
                    <div id="chartdelay_{{$loop->iteration}}">
                    </div>  
                @empty
                    @lang('main.train_no_stats')
                @endforelse    
           @endif
        @empty
            @lang('main.train_no_stats')
        @endforelse                 
    </div>
</div>


<script type="text/javascript">

@forelse($stats as $plot)
    @if ($loop->iteration === 2)
                @forelse($plot as $graph)   
                    var chart = c3.generate({
                        bindto: '#chartdelay_{{$loop->iteration}}',
                        data: {
                            x: 'x',
                            rows:  {!! json_encode($graph) !!}, 
                            type: 'bar'
                        },
                        axis: {
                            x: {
                                type: 'category' // this needed to load string x value
                            }
                        },
                        grid: {
                            y: {
                                lines: [
                                    {value: 0, text: 'Pünktlich'}
                                ]
                            }
                        }
                    });


                @empty
                    
                @endforelse    
           @endif

@empty
    
@endforelse


</script>

