<!DOCTYPE html>
<html lang="en">
<head>
    @include('Home::layouts.head-tag')
    @yield('head-tag')
</head>
<body class="authentication-bg">

<main id="main-body-one-col" class="main-body">

    @yield('content')

</main>

@include('Home::layouts.script')
@yield('script')
@include('sweetalert::alert')
</body>
</html>
