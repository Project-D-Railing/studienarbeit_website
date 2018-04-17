<div class="row">
    <div class="col">
        <div id="chartgleis">
        </div>
    </div>
</div>




@section('scripts')

var zugklassen = [];
@forelse($zugklassen as $zugklasse)
    zugklassen.push('{{ $zugklasse->name }}');
@empty
    console.log('Keine Zugklassen gefunden');
@endforelse
var chart2 = c3.generate({
        bindto: '#chartgleis',
        data: {
            url: '{{ route('graph.trainperplatform', ['id' => $id]) }}',
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

@stop
