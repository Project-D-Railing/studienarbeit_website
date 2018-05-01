<div class="row">
    <div class="col">
        <h4>@lang('main.stats_header')</h4>
        <p>
              @lang('main.stats_detaildate')
        </p>
            @lang('main.stats_alltime')
        <br>
        <hr>
        <p>@lang('main.station_select_date')</p>
            <input type="date" id="myDate" value="{{$datum}}">
        <table class="table">
          <thead>
            <tr>
              <th scope="col">@lang('main.station_col_zugnummer')</th>
              <th scope="col">@lang('main.station_col_arzeitsoll')</th>
              <th scope="col">@lang('main.station_col_arzeitist')</th>
              <th scope="col">@lang('main.station_col_dpzeitsoll')</th>
              <th scope="col">@lang('main.station_col_dpzeitist')</th>
              <th scope="col">@lang('main.station_col_gleissoll')</th>
              <th scope="col">@lang('main.station_col_gleisist')</th>
              <th scope="col">@lang('main.station_col_show')</th>
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
                    <td> {{ $zug->dpzeitist }} </td>
                    <td> {{ $zug->gleissoll }} </td>
                    <td> {{ $zug->gleisist }} </td>
                    <td><a href="{{ route('train.detail', ['trainclass' => $zug->zugklasse,'trainnumber' => $zug->zugnummer]) }}" class="btn btn-primary">@lang('main.station_button_show')</a></td>
                </tr>
            @empty
                <tr>
                    <th scope="row"> - </th>
                    <td>@lang('main.station_no_trains')</td>
                </tr>
            @endforelse
          </tbody>
        </table>
    </div>
</div>

<script type="text/javascript">
var date_input = document.getElementById('myDate');

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
