<!DOCTYPE html>
<html lang="en">
<head>
    @include('includes.head')
</head>
<body>
    @yield('dashboard')

    @include('includes.bsjs')
    <script src="{{asset('assets/js/main.js')}}"></script>
</body>
</html>
