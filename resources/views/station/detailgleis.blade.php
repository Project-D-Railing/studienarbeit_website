<div class="row">
    <div class="col">
        <h4>@lang('main.stats_header')</h4>
        <p>
              @lang('main.stats_detailgleis')
        </p>
            @lang('main.stats_alltime')
        <br>
        <hr>
        <div id="chartgleis">
        </div>
    </div>
</div>



<script type="text/javascript">

var zugklassen = [];
@forelse($zugklassen as $zugklasse)
    zugklassen.push('{{ $zugklasse->name }}');
@empty
    console.log('Keine Zugklassen gefunden');
@endforelse


@forelse($station as $stationdetail)
  @if ($loop->first) 
    var chart2 = c3.generate({
        bindto: '#chartgleis',
        data: {
            url: '{{ route('graph.trainperplatform', ['id' => $stationdetail->EVA_NR]) }}',
            mimeType: 'json',
            
            keys: {
                x: 'name', // it's possible to specify 'x' when category axis
                value: zugklassen,
            },
            type: 'bar',
            groups: [ ]
        },
        axis: {
            x: {
                type: 'category',
                label: {
                    text: 'Gleis',
                    position: 'outer-center'
                }
            },
            y: {
                label: {
                    text: 'Anzahl an Zügen',
                    position: 'outer-middle'
                }
            }
        }
    });

  @endif
@empty
                   
@endforelse

</script>
