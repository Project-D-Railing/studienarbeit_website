<div class="row">
    <div class="col">
        <h4>@lang('main.stats_header')</h4>
        <p>
              @lang('main.stats_detaildate')
        </p>
            @lang('main.stats_alltime', ['date' => $stats_start])
        <br>
        <hr>
        <p>@lang('main.station_select_date')</p>
            <input type="text" class="form-control col-3 datapicker" id="myDate" value="{{date("d.m.Y", strtotime($datum))}}" onchange="getDetailDate();">
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
            @forelse($zuege as $key => $zug)
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
$(document).ready(function () {
    $('.datapicker').datepicker({
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: false,
        format: 'dd.mm.yyyy',
        weekStart: 1,
        autoclose: true,
        zIndexOffset: 9999
    });
});

function getDetailDate() {
    var date_input = $('#myDate').val();
    date_input = date_input.split(".");

    var d = new Date(date_input[2], date_input[1], date_input[0]);
    if (!isNaN(d.getTime())) {
        $.get("{{$id}}/timetable/" + date_input[2] + date_input[1] + date_input[0],
        function (data) {
            $("#content-tab").html(data);
        });
    }
}
</script>
