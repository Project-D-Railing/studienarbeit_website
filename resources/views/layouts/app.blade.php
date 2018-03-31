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
    <link href="{{ asset('css/leaflet.css') }}" rel="stylesheet">
    <link href="{{ asset('css/MarkerCluster.css') }}" rel="stylesheet">
    <link href="{{ asset('css/MarkerCluster.Default.css') }}" rel="stylesheet">

    <link href="{{ asset('css/c3.css') }}" rel="stylesheet">


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
            <li class="nav-item"><a href="{{ route('welcome') }}" class="nav-link">Back to start</a></li>
            @else
            <li class="nav-item"><a href="{{ route('home') }}" class="nav-link">Home</a></li>
            <li class="nav-item"><a href="{{ route('toplist') }}" class="nav-link">Toplist</a></li>
            <li class="nav-item"><a href="{{ route('map') }}" class="nav-link">Map</a></li>
            <li class="nav-item"><a href="{{ route('station.index') }}" class="nav-link">Station</a></li>               
            @endif
            <li class="nav-item"><a href="{{ route('impressum') }}" class="nav-link">Impressum</a></li>
        </ul>

        <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
            <ul class="navbar-nav">
                @if (Auth::guest())
                    <li class="nav-item"><a href="{{ route('login') }}" class="nav-link">Login</a></li>
                    <li class="nav-item"><a href="{{ route('register') }}" class="nav-link">Register</a></li>
                @else
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown"
                           aria-haspopup="true" aria-expanded="false">{{ Auth::user()->name }}</a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a href="{{ route('logout') }}" class="dropdown-item"
                               onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                Logout
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
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/leaflet.js') }}"></script>
<script src="{{ asset('js/leaflet.ajax.min.js') }}"></script>
<script src="{{ asset('js/leaflet.markercluster.js') }}"></script>
<script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
<script src="{{ asset('js/jquery-ui.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.min.js') }}"></script>
<script src="{{ asset('js/moment.min.js') }}"></script>
<!-- Load d3.js and c3.js -->
<script src="{{ asset('js/d3.min.js') }}"></script>
<script src="{{ asset('js/c3.min.js') }}"></script>


<script type="text/javascript">
        @yield ('scripts')
</script>

</body>
</html>
