<div class="row">
    <div class="col">
        <table class="table">
          <thead>
            <tr>
              <th scope="col">StopID</th>
              <th scope="col">Name</th>
              <th scope="col">Arzeitsoll</th>
              <th scope="col">Dpzeitsoll</th>
              <th scope="col">Gleissoll</th>
              <th scope="col">Show</th>
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