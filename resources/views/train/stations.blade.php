<div class="row">
    <div class="col">
        <h4>@lang('main.stats_header')</h4>
        <p>
              @lang('main.stats_stations')
        </p>
            @lang('main.stats_alltime')
        <br>
        <hr>
        <table class="table">
          <thead>
            <tr>
              <th scope="col">StopID</th>
              <th scope="col">Name</th>
              <th scope="col">@lang('main.station_col_arzeitsoll')</th>
              <th scope="col">@lang('main.station_col_dpzeitsoll')</th>
              <th scope="col">@lang('main.station_col_gleissoll')</th>
              <th scope="col">@lang('main.station_col_show')</th>
            </tr>
          </thead>
          <tbody>
            @forelse($haltestellen as $halt)
                <tr>
                    <th scope="row">{{ $halt->stopid }} </th>
                    <td> {{ $halt->name }} </td>
                    <td> {{ $halt->arzeitsoll }}</td>
                    <td> {{ $halt->dpzeitsoll }} </td>
                    <td> {{ $halt->gleissoll }} </td>
                    <td><a href="{{ route('station.detail', ['id' => $halt->evanr]) }}" class="btn btn-primary">Show</a></td>
                </tr>
            @empty
                <tr>
                    <th scope="row"> - </th>
                    <td> Keine Haltestellen gefunden </td>
                </tr>
            @endforelse
          </tbody>
        </table>
    </div>
</div>
