<div class="row">
    <div class="col">
        <div id="chartzug">
        </div>
    </div>
</div>



<script type="text/javascript">

@forelse($station as $stationdetail)
  @if ($loop->first) 
    var chart = c3.generate({
        bindto: '#chartzug',
        data: {
            x : 'x',
            rows: [
                ['x', 'RE', 'ICE'],
                ['Zugklassen', 50, 33],
            ],
            type: 'bar'
        },
        axis: {
            x: {
                type: 'category' // this needed to load string x value
            }
        }
    });
  @endif
@empty
                   
@endforelse

</script>
