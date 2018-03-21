@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col">
                <table class="table">
                  <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">Userid</th>
                      <th scope="col">Name</th>
                      <th scope="col">Mail</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($users as $user)
                        <tr>
                            <th scope="row">{{$loop->iteration}} </th>
                            <td> {{$user->id}} </td>
                            <td> {{$user->name}} </td>
                            <td> sorry no mail </td>
                        </tr>
                    @endforeach
                  </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
