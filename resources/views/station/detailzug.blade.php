<div class="row">
    <div class="col">
        <div id="chartzug">
        </div>
    </div>
</div>



<script type="text/javascript">

    var chart = c3.generate({
        bindto: '#chartzug',
        data: {
            x : 'x',
            rows: {!! json_encode($stats) !!},
            type: 'bar'
        },
        axis: {
            x: {
                type: 'category' // this needed to load string x value
            }
        }
    });

</script>
