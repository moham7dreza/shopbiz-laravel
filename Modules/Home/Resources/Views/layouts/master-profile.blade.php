<!DOCTYPE html>
<html lang="fa">
<head>
    @include('Home::layouts.head-tag')
    @yield('head-tag')
</head>
<body>

@include('Home::layouts.header')

@yield('content')

@include('Home::layouts.footer')

@include('Home::layouts.script')
@yield('script')
@include('sweetalert::alert')
</body>
</html>
