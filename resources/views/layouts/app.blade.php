<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<!-- Include Header -->
@include('layouts.header')
<body>
<div id="app">
    <!-- Include Navbar -->
    @include('layouts.nav')

    
    @yield('content')

    <!-- Include Footer -->
    @include('layouts.footer')

</div>
<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
