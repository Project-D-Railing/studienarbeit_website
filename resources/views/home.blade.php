@extends('layouts.app')

@section('content')

    <div class="jumbotron">
        <div class="container p-5">
            <h1 class="display-1">@lang('main.dashboard_title')</h1>

            <p class="lead ml-2 text-success">
                @lang('main.dashboard_text')
            </p>
        </div>
    </div>

@endsection
