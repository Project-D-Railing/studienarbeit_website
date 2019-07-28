<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    
    @yield ('customcss')
    


</head>
<body>
<div id="app">

    {{-- top bar  --}}
    <nav class="navbar navbar-expand-lg navbar-light bg-light">

        <a class="navbar-brand" href="#">{{ config('app.name', 'Laravel') }}</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <ul class="navbar-nav">
            @if (Auth::guest())
            <li class="nav-item"><a href="{{ route('welcome') }}" class="nav-link">@lang('main.navbar_back')</a></li>
            @else
            <li class="nav-item"><a href="{{ route('home') }}" class="nav-link">@lang('main.navbar_home')</a></li>
            {{-- <li class="nav-item"><a href="{{ route('toplist') }}" class="nav-link">@lang('main.navbar_toplist')</a></li> --}}
            <li class="nav-item"><a href="{{ route('map') }}" class="nav-link">@lang('main.navbar_map')</a></li>
            <li class="nav-item"><a href="{{ route('station.index') }}" class="nav-link">@lang('main.navbar_station')</a></li> 
            <li class="nav-item"><a href="{{ route('train.index') }}" class="nav-link">@lang('main.navbar_train')</a></li> 
            @endif
            <li class="nav-item"><a href="{{ route('impressum') }}" class="nav-link">@lang('main.imprint')</a></li>
        </ul>

        <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
            <ul class="navbar-nav">
                @if (Auth::guest())
                    <li class="nav-item"><a href="{{ route('login') }}" class="nav-link">@lang('main.navbar_login')</a></li>
                    <li class="nav-item"><a href="{{ route('register') }}" class="nav-link">@lang('main.navbar_register')</a></li>
                @else
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown"
                           aria-haspopup="true" aria-expanded="false">{{ Auth::user()->name }}</a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                            <a href="{{ route('logout') }}" class="dropdown-item"
                               onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                @lang('main.navbar_logout')
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                  style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </div>
                    </li>
                @endif
                    
            </ul>
        </div>

    </nav>

    @yield('content')

</div>

<!-- Scripts -->
<script src="{{ asset('js/app.min.js') }}"></script>


@yield ('customjs')

<script type="text/javascript">
        @yield ('scripts')
</script>

</body>
</html>
