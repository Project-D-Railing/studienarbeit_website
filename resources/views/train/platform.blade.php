<div class="row">
    <div class="col">
        <h4>@lang('main.stats_header')</h4>
        <p>
              @lang('main.stats_platform')
        </p>
            @lang('main.stats_alltime')
        <br>
        <hr>
        @forelse($stats as $plot)   
           @if ($loop->iteration === 2)
                @forelse($plot as $graph)   
                    <div id="chartgleis_{{$loop->iteration}}">
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
                    var columns_{{$loop->iteration}} = {!! json_encode($graph) !!};
                    var chart_{{$loop->iteration}} = c3.generate({
                        bindto: '#chartgleis_{{$loop->iteration}}',
                        data: {
                            columns: columns_{{$loop->iteration}},
                            type : 'donut'
                        },
                        donut: {
                            title: columns_{{$loop->iteration}}[0][2]
                        }
                    });

                @empty
                    
                @endforelse    
           @endif

@empty
    
@endforelse


</script>
