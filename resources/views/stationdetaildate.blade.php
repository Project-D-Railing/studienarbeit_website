<div class="row">
    <div class="col">
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

