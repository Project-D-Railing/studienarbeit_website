<div class="row">
    <div class="col">
        <h4>@lang('main.stats_header')</h4>
        <p>
              @lang('main.stats_detailzug')
        </p>
            @lang('main.stats_alltime')
        <br>
        <hr>
        <div id="chartzug">
        </div>
    </div>
</div>



<script type="text/javascript">

    var chart = c3.generate({
        bindto: '#chartzug',
        data: {
            x : 'x',
            rows: {!! json_encode($stats->original) !!},
            type: 'bar'
        },
        axis: {
            x: {
                type: 'category' // this needed to load string x value
            }
        }
    });

</script>
