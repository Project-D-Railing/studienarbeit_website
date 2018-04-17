<div class="row">
    <div class="col">
        <p>Please select a date:</p>
            <input type="date" id="myDate" value="2018-02-09">
        <table class="table">
          <thead>
            <tr>
              <th scope="col">Zugnummer</th>
              <th scope="col">Arzeitsoll</th>
              <th scope="col">Arzeitist</th>
              <th scope="col">Dpzeitsoll</th>
              <th scope="col">Dpzeitist</th>
              <th scope="col">Gleissoll</th>
              <th scope="col">Gleisist</th>
              <th scope="col">Show</th>
            </tr>
          </thead>
          <tbody>
            @forelse($zuege as $zug)
                @if ($zug->zugstatus === 'c')
                    <tr class="table-danger"> 
                @else
                    <tr>
                @endif
                    <th scope="row">{{ $zug->zugnummerfull }} </th>
                    <td> {{ $zug->arzeitsoll }} </td>
                    <td> {{ $zug->arzeitist }} </td>
                    <td> {{ $zug->dpzeitsoll }} </td>
                    <td> {{ $zug->dpzeitsoll }} </td>
                    <td> {{ $zug->gleissoll }} </td>
                    <td> {{ $zug->gleisist }} </td>
                    <td><a href="{{ route('train.detail', ['trainclass' => $zug->zugklasse,'trainnumber' => $zug->zugnummer]) }}" class="btn btn-primary">Show</a></td>
                </tr>
            @empty
                <tr>
                    <th scope="row"> - </th>
                    <td> Keine Züge gefunden </td>
                </tr>
            @endforelse
          </tbody>
        </table>
    </div>
</div>

<script type="text/javascript">
var date_input = document.getElementById('myDate');
date_input.valueAsDate = new Date();

@forelse($station as $stationdetail)
  @if ($loop->first) 
date_input.onchange = function(){
    var d = new Date(this.value);
    if(!isNaN(d.getTime())) {
	    $.get("{{$stationdetail->EVA_NR}}/timetable/"+this.value,
            function (data) {
                $("#content-tab").html(data);
            });
    }
}

  @endif
@empty
                   
@endforelse
</script>
