<div class="row">
    <div class="col">
        <table class="table">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Arzeitsoll</th>
            </tr>
          </thead>
          <tbody>
            @forelse($zuege as $zug)
                <tr>
                    <th scope="row">{{ $zug->zugid }} </th>
                    <td> {{ $zug->arzeitsoll }} </td>
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
