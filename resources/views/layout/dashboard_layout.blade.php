<!DOCTYPE html>
<html lang="en">
<head>
    @include('includes.head')
</head>
<body>
    <main>
        @include('includes.sidebar')
        @include('includes.navbar')
        @yield('dashboard')

        @include('includes.bsjs')
        <script src="{{asset('assets/js/jquery.js')}}"></script>
        <script src="{{asset('assets/js/main.js')}}"></script>

        @yield('scripts')
    </main>
</body>
</html>
